<?php

use Illuminate\Support\Facades\Route;
use Laravel\VaporUi\Http\Controllers\HomeController;
use Laravel\VaporUi\Http\Controllers\LogController;
use Laravel\VaporUi\Http\Middleware\EnsureAssets;
use Laravel\VaporUi\Http\Middleware\EnsureEnvironment;
use Laravel\VaporUi\Http\Middleware\EnsureVanityUrl;

Route::prefix('vapor-ui')
    ->middleware([
        EnsureAssets::class,
        EnsureEnvironment::class,
        EnsureVanityUrl::class,
    ])->group(function () {
        Route::get('/api/logs/{group}', [LogController::class, 'index']);
        Route::get('/api/logs/{group}/{id}', [LogController::class, 'show']);

        Route::get('/{view?}', HomeController::class)->where('view', '(.*)')->name('vapor-ui');
    });
