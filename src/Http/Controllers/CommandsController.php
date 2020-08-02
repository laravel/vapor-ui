<?php

namespace Laravel\VaporUi\Http\Controllers;

use Laravel\VaporUi\Http\Requests\LogRequest;
use Laravel\VaporUi\Repositories\LogsRepository;

class CommandsController
{
    /**
     * Gets the logs results in the cli lambda.
     *
     * @return \Laravel\VaporUi\Support\SearchResult
     */
    public function __invoke(LogsRepository $repository, LogRequest $request)
    {
        return $repository->search('cli', $request->validated());
    }
}
