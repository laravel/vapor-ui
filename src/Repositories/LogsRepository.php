<?php

namespace Laravel\VaporUi\Repositories;

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
     * @return array
     */
    public function search($group, $arguments = [])
    {
        return $this->client->filterLogEvents(array_filter([
            'logGroupName' => $this->logGroupName($group),
            'limit' => $arguments['limit'] ?? 20,
            'nextToken' => $arguments['nextToken'] ?? null,
        ]))->toArray();
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
            '/aws/lambda/vapor-%s-%s%s',
            config('vapor-ui.project-name'),
            config('vapor-ui.project-env'),
            in_array($group, ['cli', 'queue']) ? "-$group" : ''
        );
    }
}
