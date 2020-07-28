<?php

use Illuminate\Validation\ValidationException;

it('does not require any argument by default')->call('GET', '/vapor-ui/logs')->assertOk();

it('requires a valid group')->call('GET', '/vapor-ui/logs', ['group' => 'foo'])->assertSessionHasErrors();
