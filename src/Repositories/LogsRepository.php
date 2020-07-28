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
     * 
     * @return array
     */
    public function search($group)
    {
        return $this->client->filterLogEvents([
            'logGroupName' => $this->logGroupName($group),
            'limit' => 20
        ])->get('events');
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
            '/aws/lambda/vapor-%s-%s-%s',
            config('vapor-ui.project-name'),
            $_ENV['APP_ENV'],
            $group
        );
    }
}
