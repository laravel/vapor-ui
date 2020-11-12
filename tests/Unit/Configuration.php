<?php

test('runtime', function () {
    expect(config('vapor-ui'))->toHaveKeys([
        'key',
        'secret',
        'region',
        'project',
        'environment',
        'queue',
    ]);
});

test('middleware', function () {
    expect(config('vapor-ui.middleware'))->toBeArray();
});

test('path', function () {
    expect(config('vapor-ui.path'))->toBeString();
});
