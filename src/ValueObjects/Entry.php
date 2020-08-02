<?php

namespace Laravel\VaporUi\ValueObjects;

class Entry
{
    const TYPE_LOG = 'log';

    /**
     * The entry's primary key.
     *
     * @var string
     */
    public $id;

    /**
     * The entry's type.
     *
     * @var string
     */
    public $type;

    /**
     * The entry's content.
     *
     * @var array
     */
    public $content;

    /**
     * Creates a new entry.
     *
     * @param  string $id
     * @param  string $type
     * @param  array $content
     *
     * @return void
     */
    public function __construct($id, $type, $content)
    {
        $this->id = $id;
        $this->type = $type;
        $this->content = $content;
    }
}
