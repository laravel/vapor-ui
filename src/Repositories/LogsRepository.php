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
     * @return array
     */
    public function search()
    {
        return $this->client->filterLogEvents([
            'limit' => 20
        ])->getIterator();
    }
}
