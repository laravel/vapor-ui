<?php

namespace Laravel\VaporUi\ValueObjects;

use Illuminate\Support\Collection;
use JsonSerializable;

class SearchResult implements JsonSerializable
{
    /**
     * The search result entries.
     *
     * @var Collection
     */
    public $entries;

    /**
     * The search result cursor, if any.
     *
     * @var string|null
     */
    public $cursor;

    /**
     * Creates a new search result.
     *
     * @param  Collection  $entries
     * @param  string|null  $cursor
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
    #[\\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return (array) $this;
    }
}
