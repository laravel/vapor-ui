<?php

namespace Laravel\VaporUi\Repositories;

use Aws\Sqs\SqsClient;

class QueuesRepository
{
    /**
     * The sqs client.
     *
     * @var SqsClient
     */
    protected $sqs;

    /**
     * Creates a new instance of the queues repository.
     *
     * @param SqsClient $sqs
     *
     * @return void
     */
    public function __construct(SqsClient $sqs)
    {
        $this->sqs = $sqs;
    }

    /**
     * @return array
     */
    public function all()
    {
        $prefix = config('vapor-ui.queue.prefix');

        if (empty($prefix)) {
            return [];
        }

        return collect([config('vapor-ui.queue.name')])
            ->merge($this->sqs->listQueues(collect([
                'NextToken' =>  $nextToken ?? null,
            ])->filter()->all())['QueueUrls'])->map(function ($queue) use ($prefix) {
                return str_replace("$prefix/", '', $queue);
            })->unique()->values()->toArray();
    }
}
