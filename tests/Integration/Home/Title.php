<?php

test('content', function () {
    File::put(base_path('vapor.yml'), '');

    $project = $_ENV['VAPOR_PROJECT'];
    $environment = $_ENV['VAPOR_ENVIRONMENT'];

    $this->get('/vapor-ui')->assertSee(
        "Vapor UI - $project - $environment"
    );
});

test('content with custom manifest', function () {
    File::put(base_path('deploy/production/vapor.yml'), '');

    $project = $_ENV['VAPOR_PROJECT'];
    $environment = $_ENV['VAPOR_ENVIRONMENT'];

    $this->get('/vapor-ui')->assertSee(
        "Vapor UI - $project - $environment"
    );
});
