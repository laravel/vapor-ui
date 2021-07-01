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
   | Queue names will be automatically guessed from your vapor.yml config but
   | you can specify any additional vapor queues in the array below to be
   | monitored.
   |
   */

    'queues' => [

    ],
];
