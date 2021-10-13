<?php

namespace Laravel\VaporUi\Http\Controllers;

use Laravel\VaporUi\Http\Requests\LogRequest;
use Laravel\VaporUi\Repositories\LogsRepository;
use Laravel\VaporUi\ValueObjects\Log;
use Laravel\VaporUi\ValueObjects\SearchResult;

class LogController
{
    /**
     * Holds an instance of the log repository.
     *
     * @var LogsRepository
     */
    protected $repository;

    /**
     * Creates a new instance of the log controller.
     *
     * @param  LogsRepository  $repository
     * @return void
     */
    public function __construct(LogsRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Gets the log results by the given request filters.
     *
     * @param  string  $group
     * @param  LogRequest  $request
     * @return SearchResult
     */
    public function index($group, LogRequest $request)
    {
        return $this->repository->search($group, $request->validated());
    }

    /**
     * Gets a log by the given request filters.
     *
     * @param  string  $group
     * @param  string  $id
     * @param  LogRequest  $request
     * @return Log|null
     */
    public function show($group, $id, LogRequest $request)
    {
        return $this->repository->get($group, $id, $request->validated());
    }
}
