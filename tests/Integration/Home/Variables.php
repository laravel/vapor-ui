<?php

it('has queues names', function () {
    $types = $this->get('/vapor-ui')
        ->original
        ->gatherData()['queues'];

    $project = $_ENV['VAPOR_PROJECT'];
    $environment = $_ENV['VAPOR_ENVIRONMENT'];

    expect($types)->toBeArray()->toContain(
        "$project-$environment", // default queue...
    );
});
