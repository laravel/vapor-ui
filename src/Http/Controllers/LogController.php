<?php

namespace Laravel\VaporUi\Http\Controllers;

use Laravel\VaporUi\Exceptions\EntryNotFound;
use Laravel\VaporUi\Http\Requests\LogRequest;
use Laravel\VaporUi\Repositories\LogsRepository;

class LogController
{
    /**
     * Holds an instance of the log repository.
     *
     * @var \Laravel\VaporUi\Repositories\LogsRepository
     */
    protected $repository;

    /**
     * Creates a new instance of the log controller.
     *
     * @param  \Laravel\VaporUi\Repositories\LogsRepository $repository
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
     * @param  \Laravel\VaporUi\Http\Requests\LogRequest $request
     * @param  string $group
     *
     * @return \Laravel\VaporUi\Support\SearchResult
     */
    public function index(LogRequest $request, $group)
    {
        return $this->repository->search($group, $request->validated());
    }

    /**
     * Gets the log result of the given $group lambda and $id.
     *
     * @param  \Laravel\VaporUi\Http\Requests\LogRequest $request
     * @param  string $group
     * @param  string $id
     *
     * @return \Laravel\VaporUi\ValueObjects\Entry
     */
    public function show(LogRequest $request, $group, $id)
    {
        try {
            return $this->repository->get($id, $group, $request->validated());
        } catch (EntryNotFound $e) {
            abort(404);
        }
    }
}
