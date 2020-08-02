<?php

use Laravel\VaporUi\Repositories\LogsRepository;

it('has pagination', function () {
    $logs = resolve(LogsRepository::class);

    $result = $logs->search('http');
    $eventId1 = $result->entries[0]->content['eventId'];
    $cursor = $result->cursor;
    expect($result->cursor)->not->toBeEmpty();

    $result = $logs->search('http', [
        'nextToken' => $cursor,
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
        'limit' => 50,
    ]);

    expect($result->entries)->toHaveCount(50);

    $result = resolve(LogsRepository::class)->search('cli', [
        'limit' => 10,
    ]);

    expect($result->entries)->toHaveCount(10);
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
        'query' => 'No scheduled commands',
    ]);

    expect($result->entries)->toHaveCount(10);

    $result->entries->each(function ($entry) {
        expect($entry->content['message'])->toContain('No scheduled commands are ready to run.');
    });
});

it('has filter by start date', function () {
    $logs = resolve(LogsRepository::class);

    $startTime = now()->subDays(1)->timestamp * 1000;

    $result = $logs->search('cli', [
        'startTime' => $startTime,
    ]);

    $eventTimestamp = $result->entries[0]->content['timestamp'];

    expect($eventTimestamp)->toBeGreaterThan($startTime);
});

it('has filter by end date', function () {
    $logs = resolve(LogsRepository::class);

    $endTime = now()->subDays(1)->timestamp * 1000;

    $result = $logs->search('cli', [
        'endTime' => $endTime,
    ]);

    $eventTimestamp = $result->entries[0]->content['timestamp'];

    expect($eventTimestamp)->toBeLessThan($endTime);
});
