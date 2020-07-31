<?php

namespace Laravel\VaporUi\Support;

use JsonSerializable;
use Illuminate\Support\Collection;

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
     * @var array
     */
    public $entries;

    /**
     * Creates a new search result.
     *
     * @param  Collection $entries
     * @param  array $filters
     * @param  string|null $cursor
     *
     * @return void
     */
    public function __construct($entries, $filters, $cursor)
    {
        $this->entries = $entries;
        $this->filters = $filters;

        unset($filters['cursor']);
        $this->cursor = $cursor ?: null;
    }

    /**
     * Get the array representation of the entry.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'cursor' => $this->cursor,
            'filters' => $this->filters,
            'entries' => $this->entries,
        ];
    }
}