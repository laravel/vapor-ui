<?php

use Illuminate\Validation\ValidationException;

it('requires a lambda runtime', function () {
    config()->set('vapor-ui.region', null);

    $this->get('/vapor-ui')->assertForbidden();
});

it('does not require any argument by default')->call('GET', '/vapor-ui')->assertOk();

it('requires a valid group')->call('GET', '/vapor-ui', ['group' => 'foo'])->assertSessionHasErrors();
