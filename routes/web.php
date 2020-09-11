<?php

use Illuminate\Support\Facades\Route;
use Laravel\VaporUi\Http\Controllers\HomeController;
use Laravel\VaporUi\Http\Controllers\JobController;
use Laravel\VaporUi\Http\Controllers\JobMetricController;
use Laravel\VaporUi\Http\Controllers\LogController;
use Laravel\VaporUi\Http\Middleware\EnsureEnvironmentVariables;
use Laravel\VaporUi\Http\Middleware\EnsureUpToDateAssets;
use Laravel\VaporUi\Http\Middleware\EnsureUserIsAuthorized;

Route::prefix('vapor-ui')
    ->middleware([
        'web',
        EnsureUserIsAuthorized::class,
        EnsureEnvironmentVariables::class,
        EnsureUpToDateAssets::class,
    ])->group(function () {
        Route::get('/api/logs/{group}', [LogController::class, 'index']);
        Route::get('/api/logs/{group}/{id}', [LogController::class, 'show']);

        Route::get('/api/jobs/metrics', [JobMetricController::class, 'index']);

        Route::get('/api/jobs/{group}', [JobController::class, 'index']);
        Route::get('/api/jobs/{group}/{id}', [JobController::class, 'show']);

        Route::post('/api/jobs/failed/retry/{id}', [JobController::class, 'retry']);
        Route::post('/api/jobs/failed/forget/{id}', [JobController::class, 'forget']);

        Route::get('/{view?}', HomeController::class)->where('view', '(.*)')->name('vapor-ui');
    });
