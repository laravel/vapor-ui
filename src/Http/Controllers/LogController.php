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
     * @param LogsRepository $repository
     *
     * @return void
     */
    public function __construct(LogsRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Gets the log results of the given $group lambda.
     *
     * @param LogRequest $request
     * @param string $group
     *
     * @return SearchResult
     */
    public function index(LogRequest $request, $group)
    {
        return $this->repository->search($group, $request->validated());
    }

    /**
     * Gets the log result of the given $group lambda and $id.
     *
     * @param LogRequest $request
     * @param string $group
     * @param string $id
     *
     * @return Log|null
     */
    public function show(LogRequest $request, $group, $id)
    {
        return $this->repository->get($id, $group, $request->validated());
    }
}
