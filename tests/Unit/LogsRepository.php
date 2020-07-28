<?php

use Laravel\VaporUi\Repositories\LogsRepository;

it('can be instanciated', function () {
    expect(resolve(LogsRepository::class))->toBeInstanceOf(LogsRepository::class);
});

it('has search', function () {
    $logs = resolve(LogsRepository::class);

    $response = $logs->search('cli');

    expect($response)->toBeIterable();
});
