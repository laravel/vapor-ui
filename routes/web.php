<?php

use Illuminate\Support\Facades\Route;
use Laravel\VaporUi\Http\Controllers\CommandsController;
use Laravel\VaporUi\Http\Controllers\HomeController;
use Laravel\VaporUi\Http\Controllers\JobsController;
use Laravel\VaporUi\Http\Controllers\RequestsController;
use Laravel\VaporUi\Http\Middleware\EnsureAssets;
use Laravel\VaporUi\Http\Middleware\EnsureLambdaRuntime;
use Laravel\VaporUi\Http\Middleware\EnsureVanityUrl;

Route::prefix('vapor-ui')
    ->middleware([
        EnsureAssets::class,
        EnsureLambdaRuntime::class,
        EnsureVanityUrl::class,
    ])->group(function () {
        Route::get('/api/requests', RequestsController::class)->name('vapor-ui.requests');
        Route::get('/api/commands', CommandsController::class)->name('vapor-ui.commands');
        Route::get('/api/jobs', JobsController::class)->name('vapor-ui.jobs');

        Route::get('/{view?}', HomeController::class)->where('view', '(.*)')->name('vapor-ui');
    });
