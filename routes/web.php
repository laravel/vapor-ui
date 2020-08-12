<?php

use Illuminate\Support\Facades\Route;
use Laravel\VaporUi\Http\Controllers\HomeController;
use Laravel\VaporUi\Http\Controllers\LogController;
use Laravel\VaporUi\Http\Middleware\EnsureEnvironmentVariables;
use Laravel\VaporUi\Http\Middleware\EnsureUpToDateAssets;
use Laravel\VaporUi\Http\Middleware\EnsureUserIsAuthorized;

Route::prefix('vapor-ui')
    ->middleware([
        EnsureUserIsAuthorized::class,
        EnsureEnvironmentVariables::class,
        EnsureUpToDateAssets::class,
    ])->group(function () {
        Route::get('/api/logs/{group}', [LogController::class, 'index']);
        Route::get('/api/logs/{group}/{id}', [LogController::class, 'show']);

        Route::get('/{view?}', HomeController::class)->where('view', '(.*)')->name('vapor-ui');
    });
