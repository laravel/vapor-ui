<?php

namespace Laravel\VaporUi\Support;

use Illuminate\Support\Collection;
use JsonSerializable;

class SearchResult implements JsonSerializable
{
    /**
     * The cursor for pagination, if any.
     *
     * @var string|null
     */
    public $cursor;

    /**
     * The collection of entries.
     *
     * @var Collection
     */
    public $entries;

    /**
     * Creates a new search result.
     *
     * @param  Collection $entries
     * @param  string|null $cursor
     *
     * @return void
     */
    public function __construct($entries, $cursor)
    {
        $this->entries = $entries;
        $this->cursor = $cursor;
    }

    /**
     * Get the array representation of the search result.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return (array) $this;
    }
}
