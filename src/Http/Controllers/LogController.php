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
        $group = $request->input('group', 'http');
        $query = $request->input('query');
        $limit = $request->input('limit');

        return $repository->search($group, [
            'query' => $query,
            'limit' => $limit
        ]);
    }
}
