<?php

uses()->group('requires-aws');

test('by id', function () {
    $filters = ['startTime' => now()->subDay(1)->timestamp];
    $response = $this->json('GET', '/vapor-ui/api/logs/cli', $filters);
    $id = $response['entries'][0]['id'];

    $response = $this->json('GET', "/vapor-ui/api/logs/cli/$id", $filters);

    expect($response['id'])->toBe($id);
});
