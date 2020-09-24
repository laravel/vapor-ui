<?php

use Laravel\VaporUi\Support\Cloud;

return [
    // Aws Credentials
    'key' => env('AWS_ACCESS_KEY_ID'),
    'secret' => env('AWS_SECRET_ACCESS_KEY'),
    'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),

    // Vapor Project / CloudWatch Log Group
    'project' => env('VAPOR_PROJECT', Cloud::project()),
    'environment' => env('VAPOR_ENVIRONMENT', Cloud::environment()),

    // SQS Queue
    'queue' => [
        'prefix' => env('SQS_PREFIX'),
        'name' => env('SQS_QUEUE'),
    ],
];
