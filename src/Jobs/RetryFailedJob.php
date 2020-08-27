<?php

namespace Laravel\VaporUi\Jobs;

use Illuminate\Contracts\Queue\Factory;
use Illuminate\Queue\Failed\FailedJobProviderInterface;

class RetryFailedJob
{
    /**
     * The job ID.
     *
     * @var string
     */
    public $id;

    /**
     * Create a new job instance.
     *
     * @param  string  $id
     * @return void
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * Execute the job.
     *
     * @param Factory $queueFactory
     * @param FailedJobProviderInterface $provider
     *
     * @return void
     */
    public function handle(Factory $queueFactory, FailedJobProviderInterface $provider)
    {
        if ($job = $provider->find($this->id)) {
            $queueFactory->connection($job->connection)->pushRaw(
                $this->resetAttempts($job->payload), $job->queue
            );

            $provider->forget($this->id);
        }
    }

    /**
     * Reset the payload attempts.
     *
     * Applicable to Redis jobs which store attempts in their payload.
     *
     * @param  string  $payload
     * @return string
     */
    protected function resetAttempts($payload)
    {
        $payload = json_decode($payload, true);

        if (isset($payload['attempts'])) {
            $payload['attempts'] = 0;
        }

        return json_encode($payload);
    }
}
