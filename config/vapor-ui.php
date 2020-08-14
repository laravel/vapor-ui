<?php

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
];
