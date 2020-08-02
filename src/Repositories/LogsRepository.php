<?php

namespace Laravel\VaporUi\Repositories;

use Aws\CloudWatchLogs\CloudWatchLogsClient;
use Aws\CloudWatchLogs\Exception\CloudWatchLogsException;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Laravel\VaporUi\Support\SearchResult;
use Laravel\VaporUi\ValueObjects\Entry;

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
     * @param  string $group
     * @param  array $filters
     *
     * @return SearchResult
     */
    public function search($group, $filters = [])
    {
        try {
            $response = $this->client->filterLogEvents(array_filter([
                'logGroupName' => $this->logGroupName($group),
                'limit' => $this->limit($filters),
                'nextToken' => $this->nextToken($filters),
                'startTime' => $this->startTime($filters),
                'filterPattern' =>  $this->filterPattern($filters),
                // 'logStreamNames' => $filters['logStreamNames']
            ]))->toArray();
        } catch (CloudWatchLogsException $e) {
            $resourceNotFoundException = '"__type":"ResourceNotFoundException"';

            if (! Str::contains($e->getMessage(), $resourceNotFoundException)) {
                throw $e;
            }

            $response = [
                'events' => [],
            ];
        }

        $entries = (new Collection($response['events']))
            ->map(function ($event) {
                if (array_key_exists('message', $event)) {
                    if ($message = json_decode($event['message'])) {
                        $event['message'] = $message;
                    }
                }

                return new Entry($event['eventId'], Entry::TYPE_LOG, $event);
            });

        return new SearchResult($entries, array_filter($filters), $response['nextToken'] ?? null);
    }

    /**
     * Returns the log group name from the given $group.
     *
     * @param  string $group
     * @param  array $filters
     *
     * @return string
     */
    protected function logGroupName($group)
    {
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
        return isset($filters['startTime']) ? (int) $filters['startTime'] * 1000 : null;
    }

    /**
     * Gets the filter pattern from the given $filters.
     *
     * @return string
     */
    protected function filterPattern($filters)
    {
        $include = '"message" ';
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
