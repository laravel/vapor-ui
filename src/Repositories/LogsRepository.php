<?php

namespace Laravel\VaporUi\Repositories;

use Aws\CloudWatchLogs\CloudWatchLogsClient;
use Aws\CloudWatchLogs\Exception\CloudWatchLogsException;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Laravel\VaporUi\Exceptions\EntryNotFound;
use Laravel\VaporUi\Support\Cloud;
use Laravel\VaporUi\Support\SearchEntry;
use Laravel\VaporUi\Support\SearchResult;

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
     * Gets the given log by its eventId.
     *
     * @param  string $eventId
     * @param  string $group
     * @param  array $filters
     *
     * @return SearchEntry
     */
    public function get($id, $group, $filters = [])
    {
        $entry = null;

        $result = $this->search($group, $filters);

        foreach ($result->entries as $entry) {
            if ($entry->id === $id) {
                return $entry;
            }
        }

        throw new EntryNotFound(sprintf(
            'Entry [%s] not found.',
            $id
        ));
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
            ->filter(function ($event) use ($filters) {
                return empty($filters['type']) || $filters['type'] === 'timeout' || @json_decode($event['message']);
            })->map(function ($event) use ($group, $filters) {
                if (array_key_exists('message', $event)) {
                    if ($message = json_decode($event['message'], true)) {
                        $event['message'] = $message;
                    }
                }

                return new SearchEntry($event['eventId'], $group, $filters, $event);
            })->values()
            ->all();

        return new SearchResult($entries, $response['nextToken'] ?? null);
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
        $vaporUi = config('vapor-ui');

        return sprintf(
            '/aws/lambda/vapor-%s-%s%s',
            $vaporUi['project'],
            $vaporUi['environment'],
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
        return isset($filters['limit']) ? (int) $filters['limit'] : 50;
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
        $include = '';

        if (array_key_exists('type', $filters)) {
            if ($filters['type'] === 'timeout') {
                $include .= '"Task timed out after" ';
            } else {
                $include .= sprintf('"message" "level_name" "%s" ', strtoupper($filters['type']));
            }
        }

        $query = $filters['query'] ?? '';
        $exclude = '- "START RequestId" - "END RequestId"';

        $filterPattern = empty($query)
            ? ''
            : collect(explode(' ', $query))
                ->map(function ($term) {
                    return '"'.str_replace('"', '', $term).'"';
                })->implode(' ');

        return $include.$filterPattern.' '.$exclude;
    }
}
