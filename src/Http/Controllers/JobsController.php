<?php

namespace Laravel\VaporUi\Http\Controllers;

use Laravel\VaporUi\Http\Requests\LogRequest;
use Laravel\VaporUi\Repositories\LogsRepository;

class JobsController
{
    /**
     * Gets the logs results in the queue lambda.
     *
     * @return \Laravel\VaporUi\Support\SearchResult
     */
    public function __invoke(LogsRepository $repository, LogRequest $request)
    {
        return $repository->search('queue', $request->validated());
    }
}
