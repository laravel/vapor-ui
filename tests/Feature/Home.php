<?php

it('requires environment variables', function () {
    config()->set('vapor-ui.region', null);

    $this->get('vapor-ui')
        ->assertStatus(500);
});

// @todo
it('requires user is authorized');
it('requires published assets');

test('title', function () {
    $project = config('vapor-ui.project');

    $this->get('/vapor-ui')->assertSee(
        "Vapor Ui - $project"
    );
});
