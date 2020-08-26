<?php

namespace Laravel\VaporUi\Http\Controllers;

use Laravel\VaporUi\Http\Requests\JobRequest;
use Laravel\VaporUi\Repositories\JobsRepository;
use Laravel\VaporUi\ValueObjects\Job;
use Laravel\VaporUi\ValueObjects\SearchResult;

class JobController
{
    /**
     * Holds an instance of the job repository.
     *
     * @var JobsRepository
     */
    protected $repository;

    /**
     * Creates a new instance of the job controller.
     *
     * @param JobsRepository $repository
     *
     * @return void
     */
    public function __construct(JobsRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Gets the job results by the given request filters.
     *
     * @param string $group
     * @param JobRequest $request
     *
     * @return SearchResult
     */
    public function index($group, JobRequest $request)
    {
        return $this->repository->search($group, $request->validated());
    }

    /**
     * Gets a job by the given request filters.
     *
     * @param string $group
     * @param string $id
     * @param JobRequest $request
     *
     * @return Job|null
     */
    public function show($group, $id, JobRequest $request)
    {
        return $this->repository->get($group, $id, $request->validated());
    }
}
