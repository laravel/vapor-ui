<?php

use Laravel\VaporUi\Http\Middleware\EnsureEnvironmentVariables;
use Laravel\VaporUi\Http\Middleware\EnsureUpToDateAssets;
use Laravel\VaporUi\Http\Middleware\EnsureUserIsAuthorized;
use Laravel\VaporUi\Support\Cloud;

return [
    /*
    |--------------------------------------------------------------------------
    | Vapor Project
    |--------------------------------------------------------------------------
    |
    | Consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore
    | et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exerci
    | tation ullamco laboris nisi ut aliquip ex ea commodo consequat du
    |
    */

    'project' => env('VAPOR_PROJECT', Cloud::project()),
    'environment' => env('VAPOR_ENVIRONMENT', Cloud::environment()),

    /*
    |--------------------------------------------------------------------------
    | Aws Credentials
    |--------------------------------------------------------------------------
    |
    | Consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore
    | et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exerci
    | tation ullamco laboris nisi ut aliquip ex ea commodo consequat du
    |
    */

    'key' => env('AWS_ACCESS_KEY_ID'),
    'secret' => env('AWS_SECRET_ACCESS_KEY'),
    'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),

    /*
    |--------------------------------------------------------------------------
    | SQS Queue
    |--------------------------------------------------------------------------
    |
    | Consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore
    | et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exerci
    | tation ullamco laboris nisi ut aliquip ex ea commodo consequat du
    |
    */

    'queue' => [
        'prefix' => env('SQS_PREFIX'),
        'name' => env('SQS_QUEUE'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Vapor UI Route Middleware
    |--------------------------------------------------------------------------
    |
    | These middleware will be assigned to every Vapor UI route, giving you
    | the chance to add your own middleware to this list or change any of
    | the existing middleware. Or, you can simply stick with this list.
    |
    */

    'middleware' => [
        'web',
        EnsureUserIsAuthorized::class,
        EnsureEnvironmentVariables::class,
        EnsureUpToDateAssets::class,
    ]
];
