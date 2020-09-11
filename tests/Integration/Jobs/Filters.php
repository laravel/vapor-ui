<?php

beforeEach()->mockFailedJobProvider();

test('query', function () {
    $response = $this->json('GET', '/vapor-ui/api/jobs/failed', [
        'startTime' => $this->startTime,
        'query' => 'This query do not exist for sure',
    ]);

    expect($response['entries'])->toHaveCount(0);

    $response = $this->json('GET', '/vapor-ui/api/jobs/failed', [
        'startTime' => $this->startTime,
        'query' => 'ManuallyFailedException',
    ]);

    expect($response['entries'])->toHaveCount(50);
});

test('start date', function () {
    $startTime = now()->addDays(1)->timestamp * 1000;

    $response = $this->json('GET', '/vapor-ui/api/jobs/failed', [
        'startTime' => $startTime,
    ]);

    expect($response['entries'])->toHaveCount(0);
});
