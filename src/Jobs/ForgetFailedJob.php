<?php

namespace Laravel\VaporUi\Jobs;

use Illuminate\Queue\Failed\FailedJobProviderInterface;

class ForgetFailedJob
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
     * @param FailedJobProviderInterface $provider
     *
     * @return void
     */
    public function handle(FailedJobProviderInterface $provider)
    {
        if ($job = $provider->find($this->id)) {
            $provider->forget($this->id);
        }
    }
}
