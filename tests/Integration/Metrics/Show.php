<?php

beforeEach()->mockFailedJobProvider();

test('structure', function () {
    $response = $this->json('GET', '/vapor-ui/api/jobs/metrics');

    expect($response['pending'])->toBeInt();
    collect(['timeseries', 'pastHour', 'averagePast24Hours'])->each(function ($key) use ($response) {
        expect($response['processed'])->toHaveKey($key);
        expect($response['failed'])->toHaveKey($key);
    });
});
