<?php

use Illuminate\Validation\ValidationException;

it('supports empty searchs')->call('GET', '/vapor-ui/logs')->assertOk();

it('validates groups')->call('GET', '/vapor-ui/logs', ['group' => 'foo'])->assertSessionHasErrors();
