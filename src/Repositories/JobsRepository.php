<?php

namespace Laravel\VaporUi\Repositories;

use Illuminate\Queue\Failed\FailedJobProviderInterface;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Laravel\VaporUi\ValueObjects\Job;
use Laravel\VaporUi\ValueObjects\SearchResult;

class JobsRepository
{
    /**
     * The failed job provider.
     *
     * @var FailedJobProviderInterface
     */
    protected $provider;

    /**
     * Creates a new instance of the jobs repository.
     *
     * @param FailedJobProviderInterface $provider
     *
     * @return void
     */
    public function __construct(FailedJobProviderInterface $provider)
    {
        $this->provider = $provider;
    }

    /**
     * Gets the job by the given id.
     *
     * @param string $group
     * @param string $id
     * @param array $filters
     *
     * @return Job|null
     */
    public function get($group, $id, $filters = [])
    {
        $content = $this->provider->find($id);

        return new Job((array) $content, $group, $filters);
    }

    /**
     * Search for the jobs by the given filters.
     *
     * @param string $group
     * @param array $filters
     *
     * @return SearchResult
     */
    public function search($group, $filters)
    {
        $limit = 50;
        $offset = $this->offset($filters);
        $startTime = $this->startTime($filters);
        $queryTerms = $this->queryTerms($filters);

        $all = collect($this->provider->all());

        $entries = $all
            ->reverse()
            ->filter(function ($content) use ($queryTerms, $startTime) {
                foreach ($queryTerms as $term) {
                    if (! Str::contains(json_encode($content), $term)) {
                        return false;
                    }
                }

                return $startTime < Carbon::createFromFormat(
                    'Y-m-d H:i:s',
                    $content->failed_at,
                )->timestamp * 1000;
            })->slice($offset, $limit)
            ->map(function ($content) use ($group, $filters) {
                return new Job((array) $content, $group, $filters);
            })->values();

        return new SearchResult(
            $entries,
            (max($offset, 1) * $limit) < $all->count()
                ? (string) ($offset + $limit)
                : null
        );
    }

    /**
     * Gets the start time from the given $filters.
     *
     * @param array $filters
     *
     * @return int|null
     */
    protected function startTime($filters)
    {
        return isset($filters['startTime']) ? (int) $filters['startTime'] * 1000 : null;
    }

    /**
     * Gets the query from the given $filters.
     *
     * @param array $filters
     *
     * @return array
     */
    protected function queryTerms($filters)
    {
        return isset($filters['query']) ? explode(' ', $filters['query']) : [];
    }

    /**
     * Gets the offset from the given $filters.
     *
     * @param array $filters
     *
     * @return int|null
     */
    protected function offset($filters)
    {
        return isset($filters['cursor']) ? (int) $filters['cursor'] : 0;
    }
}
