<?php

namespace Laravel\VaporUi\Http\Controllers;

use Illuminate\Support\Carbon;
use Laravel\VaporUi\Http\Requests\LogRequest;
use Laravel\VaporUi\Repositories\LogsRepository;

class LogController
{
    /**
     * Gets the log results.
     * 
     * @return \Laravel\VaporUi\Support\SearchResult
     */
    public function __invoke(LogsRepository $repository, LogRequest $request)
    {
        return $repository->search($request->validated());
    }
}
