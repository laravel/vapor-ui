<?php

namespace Laravel\VaporUi\ValueObjects;

use JsonSerializable;

class Log implements JsonSerializable
{
    /**
     * The log id.
     *
     * @var string
     */
    public $id;

    /**
     * The log filters.
     *
     * @var array
     */
    public $filters;

    /**
     * The log type.
     *
     * @var string
     */
    public $type;

    /**
     * The log group.
     *
     * @var string
     */
    public $group;

    /**
     * The log content.
     *
     * @var array
     */
    public $content;

    /**
     * The log request id, if any.
     *
     * @var string|null
     */
    public $requestId;

    /**
     * Creates a new log.
     *
     * @param string $id
     * @param string $group
     * @param array $filters
     * @param array $content
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
