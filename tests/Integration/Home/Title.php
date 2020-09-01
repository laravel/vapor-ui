<?php

test('content', function () {
    $project = $_ENV['VAPOR_PROJECT'];
    $environment = $_ENV['VAPOR_ENVIRONMENT'];

    $this->get('/vapor-ui')->assertSee(
        "Vapor UI - $project - $environment"
    );
});
