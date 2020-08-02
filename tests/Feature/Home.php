<?php

it('requires lambda runtime', function () {
    config()->set('vapor-ui.region', null);

    $this->get('/vapor-ui')->assertForbidden();
});

// @todo
it('requires vanity url');

it('has title', function () {
    $project = config('vapor-ui.project');

    $this->get('/vapor-ui')->assertSee(
        "Vapor Ui - $project"
    );
});
