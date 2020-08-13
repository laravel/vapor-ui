<?php

use Laravel\VaporUi\Repositories\LogsRepository;

beforeEach(function () {
    $this->logs = resolve(LogsRepository::class);
});

it('has pagination', function () {
    $result = $this->logs->search('cli');
    $eventId1 = $result->entries[0]->content['eventId'];
    $cursor = $result->cursor;
    expect($result->cursor)->not->toBeEmpty();

    $result = $this->logs->search('cli', [
        'cursor' => $cursor,
    ]);

    $eventId21 = $result->entries[0]->content['eventId'];

    expect($eventId1)->not->toBe($eventId21);
});

it('resolves entries', function () {
    $logs = resolve(LogsRepository::class);

    $result = $this->logs->search('cli');

    expect($result->entries)->toBeIterable();
});

it('has limit', function () {
    $result = $this->logs->search('cli', [
        'limit' => 2,
    ]);

    expect($result->entries)->toHaveCount(2);

    $result = $this->logs->search('cli', [
        'limit' => 1,
    ]);

    expect($result->entries)->toHaveCount(1);
});

it('has filter by group', function () {
    collect(['cli', 'http'])->each(function ($group) {
        $result = $this->logs->search($group);

        expect($events = $result->entries)->toBeIterable();

        $expectedKeys = ['logStreamName', 'timestamp', 'message', 'ingestionTime', 'eventId'];
        foreach ($expectedKeys as $key) {
            expect($events[0]->content)->toHaveKey($key);
        }
    });
});

it('has filter by query', function () {
    $result = $this->logs->search('cli', [
        'query' => 'This query do not exist for sure',
    ]);

    expect($result->entries)->toHaveCount(0);
});

it('has filter by start date', function () {
    $startTime = now()->addDays(1)->timestamp * 1000;

    $result = $this->logs->search('cli', [
        'startTime' => $startTime,
    ]);

    expect($result->entries)->toHaveCount(0);
});

it('can get events by id', function () {
    $arguments = ['cli', ['limit' => 1]];

    $result = $this->logs->search(...$arguments);

    $id = $result->entries[0]->id;

    $entry = $this->logs->get($id, ...$arguments);
    expect($entry->id)->toBe($id);
});
