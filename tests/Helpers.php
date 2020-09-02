<?php

use Illuminate\Queue\Failed\FailedJobProviderInterface;
use Illuminate\Support\Carbon;

function mockFailedJobProvider()
{
    test()->failedAt = $failedAt = '2020-08-26 14:11:21';
    test()->startTime = Carbon::createFromFormat(
        'Y-m-d H:i:s',
        $failedAt
    )->subDay(1)->timestamp;

    $failedJob = (object) [
        'id' => 36,
        'connection' => 'database',
        'queue' => 'default',
        'payload' => '{}',
        'exception' => 'Illuminate\Queue\ManuallyFailedException in /',
        'failed_at' => $failedAt,
    ];

    $provider = Mockery::mock(FailedJobProviderInterface::class, [
        'all' => collect()->pad(55, $failedJob)->all(),
        'find' => $failedJob,
    ]);

    test()->instance(FailedJobProviderInterface::class, $provider);
}
