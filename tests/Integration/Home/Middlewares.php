<?php

it('requires environment variables', function () {
    config()->set('vapor-ui.region', null);

    $this->get('vapor-ui')
        ->assertStatus(500);

    config()->set('vapor-ui.region', null);
});
