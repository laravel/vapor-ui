<?php

use Laravel\VaporUi\Repositories\LogsRepository;

it('can be instanciated', function () {
    expect(resolve(LogsRepository::class))->toBeInstanceOf(LogsRepository::class);
});

it('has search', function () {
    $logs = resolve(LogsRepository::class);

    $response = $logs->search('cli');

    $expectedKeys = ['logStreamName', 'timestamp', 'message', 'ingestionTime', 'eventId'];
    foreach ($expectedKeys as $key) {
        expect($response['events'][0])->toHaveKey($key);
    }

    expect($response)->toBeIterable();
});

it('search can be paginated', function () {
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
