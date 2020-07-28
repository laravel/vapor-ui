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
        expect($response[0])->toHaveKey($key);
    }

    expect($response)->toBeIterable();
});
