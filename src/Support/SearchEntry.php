<?php

namespace Laravel\VaporUi\Support;

use JsonSerializable;

class SearchEntry implements JsonSerializable
{
    /**
     * The entry's primary key.
     *
     * @var string
     */
    public $id;

    /**
     * The entry's filters.
     *
     * @var array
     */
    public $filters;

    /**
     * The entry's type.
     *
     * @var string
     */
    public $type;

    /**
     * The entry's group.
     *
     * @var string
     */
    public $group;

    /**
     * The entry's content.
     *
     * @var array|string
     */
    public $content;

    /**
     * The entry's request id.
     *
     * @var string|null
     */
    public $requestId;

    /**
     * Creates a new entry.
     *
     * @param  string $id
     * @param  string $group
     * @param  array $content
     *
     * @return void
     */
    public function __construct($id, $group, $filters, $content)
    {
        $this->id = $id;
        $this->group = $group;
        $this->filters = $filters;
        $this->content = $content;

        $this->pullRequestId()
             ->pullType();
    }

    /**
     * Pulls the request id from the content.
     *
     * @return $this
     */
    protected function pullRequestId()
    {
        if (! is_string($this->content['message'])) {
            $this->requestId = $this->content['message']['context']['aws_request_id'] ?? '';
            unset($this->content['message']['context']['aws_request_id']);
        }

        return $this;
    }

    /**
     * Pulls the type from the content.
     *
     * @return $this
     */
    protected function pullType()
    {
        if (is_string($this->content['message']) && preg_match('/Task timed out after/', $this->content['message']) > 0) {
            $this->type = 'TIMEOUT';
        } else {
            $this->type = strtoupper($this->content['message']['level_name'] ?? 'RAW');
        }

        return $this;
    }

    /**
     * Get the array representation of the entry.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return (array) $this;
    }
}
