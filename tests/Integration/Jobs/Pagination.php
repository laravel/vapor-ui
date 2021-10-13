<?php

beforeEach(function () {
    mockFailedJobProvider();
});

test('cursor based', function () {
    $response = $this->json('GET', '/vapor-ui/api/jobs/failed', [
        'startTime' => $this->startTime,
        'queue' => $_ENV['SQS_QUEUE'],
    ]);

    expect($response['entries'])->toBeIterable()->toHaveCount(50);

    expect($cursor = $response['cursor'])->toBe('50');

    $response = $this->json('GET', '/vapor-ui/api/jobs/failed', [
        'startTime' => $this->startTime,
        'cursor' => '50',
    ]);

    expect($response['entries'])->toBeIterable()->toHaveCount(5);

    expect($cursor = $response['cursor'])->toBeNull();
});

test('hits per page', function () {
    $response = $this->json('GET', '/vapor-ui/api/jobs/cli', [
        'startTime' => $this->startTime,
        'queue' => $_ENV['SQS_QUEUE'],
    ]);

    expect($response['entries'][0])->toEqual([
        'content' => [
            'id' => 36,
            'connection' => 'database',
            'queue' => 'default',
            'payload' => [],
            'exception' => "Illuminate\Queue\ManuallyFailedException in /",
            'failed_at' => '2020-08-26 14:11:21',
        ],
        'group' => 'cli',
        'filters' => [
            'startTime' => $this->startTime,
        ],
        'id' => 36,
        'timestamp' => 1598451081000,
        'exception' => "Illuminate\Queue\ManuallyFailedException",
        'message' => 'Manually failed',
    ]);
});
