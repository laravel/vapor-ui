<?php

namespace Laravel\VaporUi\Http\Controllers;

use Laravel\VaporUi\Http\Requests\JobMetricRequest;
use Laravel\VaporUi\Repositories\JobsMetricsRepository;

class JobMetricController
{
    /**
     * Holds an instance of the jobs metrics repository.
     *
     * @var JobsMetricsRepository
     */
    protected $metrics;

    /**
     * Creates a new instance of the job metric controller.
     *
     * @param  JobsMetricsRepository  $metrics
     * @return void
     */
    public function __construct(JobsMetricsRepository $metrics)
    {
        $this->metrics = $metrics;
    }

    /**
     * Gets multiple metrics about jobs.
     *
     * @return array
     */
    public function index(JobMetricRequest $request)
    {
        tap($request->get('queue'), function ($queue) {
            if ($queue) {
                $this->metrics->resolveQueueUsing(function () use ($queue) {
                    return $queue;
                });
            }
        });

        return [
            'failed' => [
                'timeseries' => $this->metrics->failedTimeseries(),
                'pastHour' => $this->metrics->failedSumByHoursAgo(1),
                'averagePast24Hours' => $this->metrics->failedAverageByHoursAgo(25, 1),
            ],
            'processed' => [
                'timeseries' => $this->metrics->processedTimeseries(),
                'pastHour' => $this->metrics->processedSumByHoursAgo(1),
                'averagePast24Hours' => $this->metrics->processedAverageByHoursAgo(25, 1),
            ],
            'pending' => $this->metrics->pending(),
        ];
    }
}
