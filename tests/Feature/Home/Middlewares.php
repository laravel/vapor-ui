<?php

it('requires environment variables', function () {
    config()->set('vapor-ui.region', null);

    $this->get('vapor-ui')
        ->assertStatus(500);

    config()->set('vapor-ui.region', null);
});

it('requires authorized user')->markTestIncomplete();
it('requires published assets')->markTestIncomplete();
