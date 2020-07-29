<?php

use Illuminate\Validation\ValidationException;

it('supports empty searchs')->call('GET', '/vapor-ui/api/logs')->assertOk();

it('validates groups')->call('GET', '/vapor-ui/api/logs', ['group' => 'foo'])->assertSessionHasErrors();
