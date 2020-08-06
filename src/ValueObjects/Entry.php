<?php

namespace Laravel\VaporUi\ValueObjects;

use JsonSerializable;

class Entry implements JsonSerializable
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

        // Grabs the Aws Request Id
        if (! is_string($content['message'])) {
            $this->requestId = $content['message']['context']['aws_request_id'] ?? '';
            unset($content['message']['context']['aws_request_id']);
        }

        $this->content = $this->sanitized($content);
    }

    /**
     * Returns the sanitized content.
     *
     * @param  array $content
     *
     * @return array
     */
    public function sanitized($content)
    {
        if (is_string($content['message'])) {
            $content['message'] = trim($content['message']);
        } elseif (array_key_exists('message', $content['message'])) {
            $content['message']['message'] = trim($content['message']['message']);
        }

        return $content;
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
