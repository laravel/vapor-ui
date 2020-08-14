<?php

uses()->group('requires-aws');

test('group', function () {
    $response = $this->json('GET', '/vapor-ui/api/logs/cli', [
        'startTime' => now()->subDay(1)->timestamp,
    ]);

    expect($entries = $response['entries'])->toBeIterable();
    $content = $entries[0]['content'];
    $expectedKeys = ['logStreamName', 'timestamp', 'message', 'ingestionTime', 'eventId'];
    foreach ($expectedKeys as $key) {
        expect($content)->toHaveKey($key);
    }
});

test('query', function () {
    $response = $this->json('GET', '/vapor-ui/api/logs/cli', [
        'startTime' => now()->subDay(1)->timestamp,
        'query' => 'This query do not exist for sure',
    ]);

    expect($response['entries'])->toHaveCount(0);
});

test('start date', function () {
    $startTime = now()->addDays(1)->timestamp * 1000;

    $response = $this->json('GET', '/vapor-ui/api/logs/cli', [
        'startTime' => $startTime,
    ]);

    expect($response['entries'])->toHaveCount(0);
});
