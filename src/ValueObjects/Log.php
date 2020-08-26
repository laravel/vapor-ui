<?php

namespace Laravel\VaporUi\ValueObjects;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use JsonSerializable;

class Log implements JsonSerializable
{
    /**
     * The log content.
     *
     * @var array
     */
    public $content;

    /**
     * The log group.
     *
     * @var string
     */
    public $group;

    /**
     * The log filters.
     *
     * @var array
     */
    public $filters;

    /**
     * The log id.
     *
     * @var string
     */
    public $id;

    /**
     * The log type.
     *
     * @var string
     */
    public $type;

    /**
     * The log location, if any.
     *
     * @var string|null
     */
    public $location;

    /**
     * The log request id, if any.
     *
     * @var string|null
     */
    public $requestId;

    /**
     * Creates a new log.
     *
     * @param string $group
     * @param array $filters
     * @param array $content
     *
     * @return void
     */
    public function __construct($content, $group, $filters)
    {
        $this->content = $content;
        $this->group = $group;
        $this->filters = $filters;

        $this->pullId()
            ->pullRequestId()
            ->pullType()
            ->pullLocation();
    }

    /**
     * Pulls the id from the content.
     *
     * @return $this
     */
    protected function pullId()
    {
        $this->id = $this->content['eventId'];

        return $this;
    }

    /**
     * Pulls the request id from the content.
     *
     * @return $this
     */
    protected function pullRequestId()
    {
        $this->requestId = Arr::get($this->content, 'message.context.aws_request_id');

        Arr::forget($this->content, 'message.context.aws_request_id');

        return $this;
    }

    /**
     * Pulls the location from the content.
     *
     * @return $this
     */
    protected function pullLocation()
    {
        $this->location = Str::replaceFirst(
            '/var/task/',
            '',
            Arr::get($this->content, 'message.context.exception.file')
        );

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
            $this->type = Arr::get($this->content, 'message.level_name', 'RAW');
        }

        return $this;
    }

    /**
     * Get the array representation of the log.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return (array) $this;
    }
}
