<?php

namespace Laravel\VaporUi\Http\Controllers;

use Laravel\VaporUi\Http\Requests\LogRequest;
use Laravel\VaporUi\Repositories\LogsRepository;

class LogController
{
    /**
     * Gets the log results.
     * 
     * @return array
     */
    public function __invoke(LogsRepository $repository, LogRequest $request)
    {
        $group = $request->input('group');

        return $repository->search($group);
    }
}
