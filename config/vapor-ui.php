<?php

use Laravel\VaporUi\Http\Middleware\EnsureEnvironmentVariables;
use Laravel\VaporUi\Http\Middleware\EnsureUpToDateAssets;
use Laravel\VaporUi\Http\Middleware\EnsureUserIsAuthorized;

return [

    /*
    |--------------------------------------------------------------------------
    | Vapor UI Route Middleware
    |--------------------------------------------------------------------------
    |
    | These middleware will be assigned to every Vapor UI route - giving you
    | the chance to add your own middleware to this list or change any of
    | the existing middleware. Or, you can simply stick with this list.
    |
    */

    'middleware' => [
        'web',
        EnsureUserIsAuthorized::class,
        EnsureEnvironmentVariables::class,
        EnsureUpToDateAssets::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Vapor UI Queues
    |--------------------------------------------------------------------------
    |
    | Typically, queues that should be monitored will be determined for you
    | by Vapor UI. However, you are free to add additional queues to the
    | list below in order to monitor queues that Vapor doesn't manage.
    |
    */

    'queues' => [

    ],

];
