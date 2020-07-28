<?php

it('requires a lambda runtime', function () {
    config()->set('vapor-ui.region', null);

    $this->get('/vapor-ui')->assertForbidden();
});

it('has title', function () {    
    $projectName = config('vapor-ui.project-name');
    $projectEnv = config('vapor-ui.project-env');

    $this->get('/vapor-ui')->assertSee(
        "Vapor Ui - $projectName - $projectEnv"
    );
});
