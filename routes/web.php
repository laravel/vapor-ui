<?php

use Illuminate\Support\Facades\Route;
use Laravel\VaporUi\Http\Middleware\EnsureAssets;
use Laravel\VaporUi\Http\Middleware\EnsureLambdaRuntime;
use Laravel\VaporUi\Http\Middleware\EnsureVanityUrl;
use Laravel\VaporUi\Http\Controllers\HomeController;
use Laravel\VaporUi\Http\Controllers\LogController;

Route::prefix('vapor-ui')
    ->middleware([
        EnsureAssets::class,
        EnsureLambdaRuntime::class,
        EnsureVanityUrl::class,
    ])->group(function () {
        Route::get('/api/logs', LogController::class)->name('vapor-ui.logs');

        Route::get('/{view?}', HomeController::class)->where('view', '(.*)')->name('vapor-ui');
    });

