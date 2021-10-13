<?php

namespace Laravel\VaporUi\ValueObjects;

use Illuminate\Queue\ManuallyFailedException;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use JsonSerializable;

class Job implements JsonSerializable
{
    /**
     * The job content.
     *
     * @var array
     */
    public $content;

    /**
     * The job group.
     *
     * @var string
     */
    public $group;

    /**
     * The job filters.
     *
     * @var array
     */
    public $filters;

    /**
     * The job id.
     *
     * @var string
     */
    public $id;

    /**
     * The job timestamp.
     *
     * @var int
     */
    public $timestamp;

    /**
     * The job message.
     *
     * @var string
     */
    public $message;

    /**
     * The job exception, if any.
     *
     * @var string|null
     */
    public $exception;

    /**
     * Creates a new job.
     *
     * @param  string  $group
     * @param  array  $filters
     * @param  array  $content
     * @return void
     */
    public function __construct($content, $group, $filters)
    {
        $this->content = $content;
        $this->group = $group;
        $this->filters = $filters;

        $this->pullId()
            ->pullTimestamp()
            ->pullException()
            ->pullMessage()
            ->normalizePayload();
    }

    /**
     * Pulls the id from the content.
     *
     * @return $this
     */
    protected function pullId()
    {
        $this->id = $this->content['id'];

        return $this;
    }

    /**
     * Pulls the timestamp from the content.
     *
     * @return $this
     */
    protected function pullTimestamp()
    {
        $this->timestamp = Carbon::parse(
            $this->content['failed_at']
        )->timestamp * 1000;

        return $this;
    }

    /**
     * Pulls the queue exception from the content.
     *
     * @return $this
     */
    protected function pullException()
    {
        if (Str::startsWith($this->content['exception'], ManuallyFailedException::class)) {
            $exception = ManuallyFailedException::class;
        } else {
            [$exception] = explode(':', $this->content['exception']);
        }

        if (! empty($exception)) {
            $this->exception = $exception;
        }

        return $this;
    }

    /**
     * Pulls the queue message from the content.
     *
     * @return $this
     */
    protected function pullMessage()
    {
        if (Str::startsWith($this->content['exception'], ManuallyFailedException::class)) {
            $message = 'Manually failed';
        } else {
            [$_, $message] = explode(':', $this->content['exception']);
            [$message] = explode(' in /', $message);
            [$message] = explode(' in closure', $message);
        }

        if (! empty($message)) {
            $this->message = trim($message);
        }

        return $this;
    }

    /**
     * Normalize the payload.
     *
     * @return $this
     */
    protected function normalizePayload()
    {
        $this->content['payload'] = json_decode($this->content['payload'], true);

        return $this;
    }

    /**
     * Get the array representation of the job.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return (array) $this;
    }
}
