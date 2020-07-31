<?php

namespace Laravel\VaporUi\Repositories;

use Illuminate\Support\Collection;
use Laravel\VaporUi\Support\SearchResult;
use Laravel\VaporUi\ValueObjects\Entry;
use Aws\CloudWatchLogs\CloudWatchLogsClient;

class LogsRepository
{
    /**
     * The cloud watch logs client.
     * 
     * @var CloudWatchLogsClient
     */
    protected $client;

    /**
     * Creates a new instance of the logs repository.
     *
     * @return void
     */
    public function __construct(CloudWatchLogsClient $client)
    {
        $this->client = $client;
    }

    /**
     * Search for the logs.
     *
     * @param  array $filters
     * 
     * @return SearchResult
     */
    public function search($filters = [])
    {
        $response = $this->client->filterLogEvents(array_filter([
            'logGroupName' => $this->logGroupName($filters),
            'limit' => $this->limit($filters),
            'nextToken' => $this->nextToken($filters),
            'startTime' => $this->startTime($filters),
            'endTime' => $this->endTime($filters),
            'filterPattern' =>  $this->filterPattern($filters),
            // 'logStreamNames' => $filters['logStreamNames']
        ]))->toArray();

        $entries = (new Collection($response['events']))
            ->map(function ($event) {
                return new Entry($event['eventId'], Entry::TYPE_LOG, $event);
            })
            ->all();

        return new SearchResult($entries, array_filter($filters), $response['nextToken'] ?? null);
    }

    /**
     * Returns the log group name from the given $group.
     * 
     * @param  array $filters
     *
     * @return string
     */
    protected function logGroupName($filters)
    {
        $group = isset($filters['group']) ? (string) $filters['group'] : '';

        return sprintf(
            '/aws/lambda/vapor-%s%s',
            config('vapor-ui.project'),
            in_array($group, ['cli', 'queue']) ? "-$group" : ''
        );
    }

    /**
     * Gets the limit from the given $filters.
     * 
     * @return int
     */
    protected function limit($filters)
    {
        return isset($filters['limit']) ? (int) $filters['limit'] : 10;
    }

    /**
     * Gets the next token from the given $filters.
     * 
     * @return string|null
     */
    protected function nextToken($filters)
    {
        return isset($filters['cursor']) ? (string) $filters['cursor'] : null;
    }

    /**
     * Gets the start time from the given $filters.
     * 
     * @return int|null
     */
    protected function startTime($filters)
    {
        return isset($filters['startTime']) ? (int) $filters['startTime'] : null;
    }

    /**
     * Gets the end time from the given $filters.
     * 
     * @return int|null
     */
    protected function endTime($filters)
    {
        return isset($filters['endTime']) ? (int) $filters['endTime'] : null;
    }

    /**
     * Gets the end time from the given $filters.
     * 
     * @return string|null
     */
    protected function filterPattern($filters)
    {
        $include = '';
        $query = $filters['query'] ?? '';
        $exclude = '- "REPORT RequestId" - "START RequestId" - "END RequestId" - "Executing warming requests"';

        $filterPattern = empty($query)
            ? ''
            : collect(explode(' ', $query))
                ->map(function ($term) {
                    return '"'.str_replace('"', '', $term).'"';
                })->implode(' ');

        return $include.$filterPattern.' '.$exclude;
    }
}
