<?php

beforeEach(function () {
    mockFailedJobProvider();
});

test('by id', function () {
    $filters = ['startTime' => $this->startTime, 'queue' => $_ENV['SQS_QUEUE']];
    $response = $this->json('GET', '/vapor-ui/api/jobs/failed', $filters);
    $id = $response['entries'][0]['id'];

    $response = $this->json('GET', "/vapor-ui/api/jobs/failed/$id", $filters);

    expect($response['id'])->toBe($id);
});
