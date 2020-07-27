<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Lorem ipsum dolor
    |--------------------------------------------------------------------------
    |
    | Consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore
    | et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exerci
    | tation ullamco laboris nisi ut aliquip ex ea commodo consequat du
    |
    */

    'region' => env('AWS_REGION', ''),

    /*
    |--------------------------------------------------------------------------
    | Lorem ipsum dolor
    |--------------------------------------------------------------------------
    |
    | Consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore
    | et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exerci
    | tation ullamco laboris nisi ut aliquip ex ea commodo consequat du
    |
    */

    'credentials' => [
        'key' => env('AWS_ACCESS_KEY_ID', ''),
        'secret' => env('AWS_SECRET_ACCESS_KEY', ''),
    ],
];
