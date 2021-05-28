<?php

namespace Laravel\VaporUi\Repositories;

use Aws\CloudWatch\CloudWatchClient;
use Aws\Sqs\SqsClient;
use Illuminate\Database\QueryException;
use Illuminate\Queue\Failed\FailedJobProviderInterface;
use Illuminate\Support\Carbon;
use Laravel\VaporUi\Support\Cloud;

class JobsMetricsRepository
{
    /**
     * The cloud watch client.
     *
     * @var CloudWatchClient
     */
    protected $cloudWatch;

    /**
     * The sqs client.
     *
     * @var SqsClient
     */
    protected $sqs;

    /**
     * The failed job provider.
     *
     * @var FailedJobProviderInterface
     */
    protected $failedJobs;

    /**
     * Memoizes the collection of failed jobs.
     *
     * @var \Illuminate\Support\Collection
     */
    protected $failedJobsCollection;

    /**
     * The queue name resolver.
     *
     * @var callable|null
     */
    protected $queueResolver;

    /**
     * Creates a new instance of the metrics repository.
     *
     * @param CloudWatchClient $cloudWatch
     * @param FailedJobProviderInterface $failedJobs
     * @param SqsClient $sqs
     *
     * @return void
     */
    public function __construct(CloudWatchClient $cloudWatch, FailedJobProviderInterface $failedJobs, SqsClient $sqs)
    {
        $this->cloudWatch = $cloudWatch;
        $this->failedJobs = $failedJobs;
        $this->sqs = $sqs;

        $this->queueResolver = function () {
            return config('vapor-ui.queue.name');
        };
    }

    /**
     * The total of pending jobs.
     *
     * @return int
     */
    public function pending()
    {
        $prefix = config('vapor-ui.queue.prefix');

        if (empty($prefix)) {
            return 0;
        }

        $queue = $this->queueResolver->__invoke();

        return collect($this->sqs->getQueueAttributes([
            'AttributeNames' => [
                'ApproximateNumberOfMessages',
                'ApproximateNumberOfMessagesNotVisible',
                'ApproximateNumberOfMessagesDelayed',
            ],
            'QueueUrl' => "$prefix/$queue",
        ])['Attributes'])->sum();
    }

    /**
     * The timeseries of the failed jobs in past 24 hours.
     *
     * @return array
     */
    public function failedTimeseries()
    {
        $dayAgo = now()->subHours(23)->setMinute(0);

        return $this->failedJobs()->map(function ($job) {
            return Carbon::parse($job->failed_at)
                ->setMinute(0)
                ->setSecond(0)
                ->timestamp;
        })->filter(function ($timestamp) use ($dayAgo) {
            return Carbon::parse($timestamp)->greaterThan($dayAgo);
        })->groupBy(function ($timestamp) {
            return $timestamp;
        })->union(collect(range(0, 23))->mapWithKeys(function ($hourAgo) {
            $hourAgo = now()
                ->subHours($hourAgo)
                ->setMinute(0)
                ->setSecond(0)
                ->timestamp;

            return [$hourAgo => collect()];
        }))->map(function ($group) {
            return $group->count();
        })->map(function ($count, $timestamp) {
            return [
                'timestamp' => $timestamp,
                'value' => $count,
            ];
        })->sortBy('timestamp')->values()->all();
    }

    /**
     * The total of failed jobs in past given hours ago.
     *
     * @param  int $hoursAgo
     *
     * @return int
     */
    public function failedSumByHoursAgo($hoursAgo)
    {
        $hoursAgo = now()->subHours($hoursAgo);

        return $this->failedJobs()->filter(function ($job) use ($hoursAgo) {
            return Carbon::parse($job->failed_at)->greaterThan($hoursAgo);
        })->count();
    }

    /**
     * Gets the average of failed jobs from the given period.
     *
     * @param  int $fromHoursAgo
     * @param  int $untilHoursAgo
     *
     * @return int
     */
    public function failedAverageByHoursAgo($fromHoursAgo, $untilHoursAgo)
    {
        $from = now()->subHours($fromHoursAgo);
        $until = now()->subHours($untilHoursAgo);

        return (int) ($this->failedJobs()->filter(function ($job) use ($from, $until) {
            $failedAt = Carbon::parse($job->failed_at);

            return $failedAt->greaterThanOrEqualTo($from) && $failedAt->lessThan($until);
        })->count() / ($fromHoursAgo - $untilHoursAgo));
    }

    /**
     * The timeseries of the processed jobs in past 24 hours.
     *
     * @return array
     */
    public function processedTimeseries()
    {
        return collect($this->logs([
            'StartTime' => now()->subHours(23)->setMinute(0)->format('Y-m-d H:i:s'),
            'Period' => 60 * 60,
            'EndTime' => now()->addDays(1)->format('Y-m-d H:i:s'),
            'MetricName' => 'NumberOfMessagesReceived',
            'Statistics' => ['Sum'],
        ])['Datapoints'])->map(function ($result, $key) {
            return [
                'timestamp' => $result['Timestamp']->getTimestamp(),
                'value' => $result['Sum'],
            ];
        })->sortBy('timestamp')->values()->all();
    }

    /**
     * The total of processed jobs in past given hours ago.
     *
     * @param  int $hoursAgo
     *
     * @return int
     */
    public function processedSumByHoursAgo($hoursAgo)
    {
        return (int) collect($this->logs([
            'StartTime' => now()->subHours($hoursAgo)->format('Y-m-d H:i:s'),
            'Period' => 60 * 60 * $hoursAgo,
            'EndTime' => now()->addDays(1)->format('Y-m-d H:i:s'),
            'MetricName' => 'NumberOfMessagesReceived',
            'Statistics' => ['Sum'],
        ])['Datapoints'])->pluck('Sum')->sum();
    }

    /**
     * Gets the average of processed jobs from the given period.
     *
     * @param  int $fromHoursAgo
     * @param  int $untilHoursAgo
     *
     * @return int
     */
    public function processedAverageByHoursAgo($fromHoursAgo, $untilHoursAgo)
    {
        return (int) (collect($this->logs([
            'StartTime' => now()->subHours($fromHoursAgo)->format('Y-m-d H:i:s'),
            'EndTime' => now()->subHours($untilHoursAgo)->format('Y-m-d H:i:s'),
            'Period' => 60 * 60 * $fromHoursAgo,
            'MetricName' => 'NumberOfMessagesReceived',
            'Statistics' => ['Sum'],
        ])['Datapoints'])->pluck('Sum')->sum() / ($fromHoursAgo - $untilHoursAgo));
    }

    /**
     * Sets the queue resolver.
     *
     * @param  callable $callback
     * @return void
     */
    public function resolveQueueUsing($callback)
    {
        $this->queueResolver = $callback;
    }

    /**
     * Gets the failed jobs.
     *
     * It memoizes the the `all` call to failed jobs provider.
     *
     * @return \Illuminate\Support\Collection
     */
    protected function failedJobs()
    {
        if ($this->failedJobsCollection === null) {
            try {
                $this->failedJobsCollection = collect($this->failedJobs->all())
                    ->filter(function ($content) {
                        return $this->queueResolver->__invoke() == ((array) $content)['queue'];
                    });
            } catch (QueryException $e) {
                $this->failedJobsCollection = collect();
            }
        }

        return $this->failedJobsCollection;
    }

    /**
     * Performs a request to the Cloud Watch Logs API.
     *
     * @param  array  $payload
     *
     * @return array
     */
    protected function logs($payload)
    {
        return $this->cloudWatch->getMetricStatistics(array_merge_recursive([
            'Dimensions' => [[
                'Name' => 'QueueName', 'Value' => $this->queueResolver->__invoke(),
            ]],
            'Namespace' => 'AWS/SQS',
        ], $payload))->toArray();
    }
}
