<?php

use Illuminate\Support\Facades\Route;
use Laravel\VaporUi\Http\Middleware\EnsureLambdaRuntime;
use Laravel\VaporUi\Http\Middleware\EnsureVanityUrl;
use Laravel\VaporUi\Http\Controllers\HomeController;
use Laravel\VaporUi\Http\Controllers\LogController;

Route::prefix('vapor-ui')
    ->middleware([
        EnsureLambdaRuntime::class,
        EnsureVanityUrl::class
    ])->group(function () {
        Route::get('/', HomeController::class)->name('vapor-ui');
        Route::get('/logs', LogController::class)->name('vapor-ui.logs');
    });
