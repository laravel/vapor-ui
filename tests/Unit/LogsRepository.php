<?php

use Laravel\VaporUi\Repositories\LogsRepository;

it('has pagination', function () {
    $logs = resolve(LogsRepository::class);

    $result = $logs->search('http');
    $eventId1 = $result->entries[0]->content['eventId'];
    $cursor = $result->cursor;
    expect($result->cursor)->not->toBeEmpty();

    $result = $logs->search('http', [
        'cursor' => $cursor,
    ]);

    $eventId21 = $result->entries[0]->content['eventId'];

    expect($eventId1)->not->toBe($eventId21);
});

it('resolves entries', function () {
    $logs = resolve(LogsRepository::class);

    $result = $logs->search('http');

    expect($result->entries)->toBeIterable();
});

it('has limit', function () {
    $result = resolve(LogsRepository::class)->search('cli', [
        'limit' => 2,
    ]);

    expect($result->entries)->toHaveCount(2);

    $result = resolve(LogsRepository::class)->search('cli', [
        'limit' => 1,
    ]);

    expect($result->entries)->toHaveCount(1);
});

it('has filter by group', function () {
    $logs = resolve(LogsRepository::class);

    foreach (['cli', 'http'] as $group) {
        $result = $logs->search($group);

        expect($events = $result->entries)->toBeIterable();

        $expectedKeys = ['logStreamName', 'timestamp', 'message', 'ingestionTime', 'eventId'];
        foreach ($expectedKeys as $key) {
            expect($events[0]->content)->toHaveKey($key);
        }
    }
});

it('has filter by query', function () {
    $logs = resolve(LogsRepository::class);

    $result = $logs->search('cli', [
        'query' => 'This query do not exist for sure',
    ]);

    expect($result->entries)->toHaveCount(0);
});

it('has filter by start date', function () {
    $logs = resolve(LogsRepository::class);

    $startTime = now()->addDays(1)->timestamp * 1000;

    $result = $logs->search('cli', [
        'startTime' => $startTime,
    ]);

    expect($result->entries)->toHaveCount(0);
});

it('can get events by id', function () {
    $logs = resolve(LogsRepository::class);
    $arguments = ['cli', ['limit' => 1]];

    $result = $logs->search(...$arguments);

    $id = $result->entries[0]->id;
    $cursor = null;

    $entry = $logs->get($id, ...$arguments);

    expect($entry->id)->toBe($id);
});
