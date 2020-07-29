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
     * @param  string $group
     * @param  array $arguments
     * 
     * @return CursorCollection
     */
    public function search($group, $arguments = [])
    {
        $response = $this->client->filterLogEvents(array_filter([
            'logGroupName' => $this->logGroupName($group),
            'limit' => $this->limit($arguments),
            'nextToken' => $this->nextToken($arguments),
            'startTime' => $this->startTime($arguments),
            'endTime' => $this->endTime($arguments),
            'filterPattern' =>  $this->filterPattern($arguments),
            // 'logStreamNames' 
        ]))->toArray();

        $entries = (new Collection($response['events']))
            ->map(function ($event) {
                return new Entry($event['eventId'], Entry::TYPE_LOG, $event);
            });

        return new SearchResult($entries, $response['nextToken']);
    }

    /**
     * Returns the log group name from the given $group.
     * 
     * @param  string $group
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
     * Gets the limit from the given $arguments.
     * 
     * @return int
     */
    protected function limit($arguments)
    {
        return isset($arguments['limit']) ? (int) $arguments['limit'] : 10;
    }

    /**
     * Gets the next token from the given $arguments.
     * 
     * @return string|null
     */
    protected function nextToken($arguments)
    {
        return isset($arguments['nextToken']) ? (string) $arguments['nextToken'] : null;
    }

    /**
     * Gets the start time from the given $arguments.
     * 
     * @return int|null
     */
    protected function startTime($arguments)
    {
        return isset($arguments['startTime']) ? (int) $arguments['startTime'] : null;
    }

    /**
     * Gets the end time from the given $arguments.
     * 
     * @return int|null
     */
    protected function endTime($arguments)
    {
        return isset($arguments['endTime']) ? (int) $arguments['endTime'] : null;
    }

    /**
     * Gets the end time from the given $arguments.
     * 
     * @return string|null
     */
    protected function filterPattern($arguments)
    {
        $include = '"message" ';
        $query = $arguments['query'] ?? '';
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
