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
    | Vapor UI Domain
    |--------------------------------------------------------------------------
    |
    | This is the subdomain where Vapor UI will be accessible from. If this
    | setting is null, Vapor UI will reside under the same domain as the
    | application. Otherwise this value should serve as the subdomain.
    |
    */

    'domain' => env('VAPOR_UI_DOMAIN', null),

    /*
    |--------------------------------------------------------------------------
    | Vapor UI Path
    |--------------------------------------------------------------------------
    |
    | This is the URI path where Vapor UI will be accessible from. Feel free
    | to change the path to anything you like. Note that the URI will not
    | affect the paths of its internal API that isn't exposed to users.
    |
    */

    'path' => env('VAPOR_UI_PATH', 'vapor-ui'),

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

    /*
    |--------------------------------------------------------------------------
    | Vapor Manifest file
    |--------------------------------------------------------------------------
    |
    | This is where you will set the path of your custom manifest file.
    | By default, Vapor-ui reads the vapor.yml file, but if in your application
    | you need a custom file, you define the path and name of the file here
    |
    */

    'manifest_file' => env('VAPOR_MANIFEST_FILE', base_path('vapor.yml')),

];
