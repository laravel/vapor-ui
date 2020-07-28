<?php

use Laravel\VaporUi\Repositories\LogsRepository;

it('has pagination', function () {
    $logs = resolve(LogsRepository::class);

    $response = $logs->search('http');
    $eventId1 = $response['events'][0]['eventId'];
    $nextToken = $response['nextToken'];
    expect($response['nextToken'])->not->toBeEmpty();

    $response = $logs->search('http', [
        'nextToken' => $nextToken
    ]);

    $eventId21 = $response['events'][0]['eventId'];
    expect($eventId1)->not->toBe($eventId21);
});

it('has filter by group', function () {
    $logs = resolve(LogsRepository::class);

    foreach (['cli', 'http', 'queue'] as $group) {
        $response = $logs->search($group);

        expect($events = $response['events'])->toBeIterable();

        $expectedKeys = ['logStreamName', 'timestamp', 'message', 'ingestionTime', 'eventId'];
        foreach ($expectedKeys as $key) {
            expect($events[0])->toHaveKey($key);
        }
    }
});

it('has filter by start date', function () {
    $logs = resolve(LogsRepository::class);

    $startTime = now()->subDays(1)->timestamp * 1000;

    $response = $logs->search('cli', [
        'startTime' => $startTime
    ]);

    $eventTimestamp = $response['events'][0]['timestamp'];

    expect($eventTimestamp)->toBeGreaterThan($startTime);
});

it('has filter by end date', function () {
    $logs = resolve(LogsRepository::class);

    $endTime = now()->subDays(1)->timestamp * 1000;

    $response = $logs->search('cli', [
        'endTime' => $endTime 
    ]);

    $eventTimestamp = $response['events'][0]['timestamp'];

    expect($eventTimestamp)->toBeLessThan($endTime);
});

