<?php

test('cursor based', function () {
    $response = $this->json('GET', '/vapor-ui/api/logs/cli', [
        'startTime' => now()->subDay(1)->timestamp,
    ]);

    expect($cursor = $response->json('cursor'))->not->toBeEmpty();

    $id = $response['entries'][0]['id'];

    $response = $this->json('GET', '/vapor-ui/api/logs/cli', [
        'startTime' => now()->subDay(1)->timestamp,
        'cursor' => $cursor,
    ]);

    expect($response['entries'][0]['id'])->not->toBe($id);
});

test('hits per page', function () {
    $response = $this->json('GET', '/vapor-ui/api/logs/cli', [
        'startTime' => now()->subDay(1)->timestamp,
    ]);

    expect($response['entries'])->toBeIterable()->toHaveCount(50);
});
