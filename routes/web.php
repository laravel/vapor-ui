<?php

use Illuminate\Support\Facades\Route;
use Laravel\VaporUi\Http\Middleware\EnsureLambdaRuntime;
use Laravel\VaporUi\Http\Controllers\LogController;

Route::prefix('vapor-ui')
    ->middleware([EnsureLambdaRuntime::class])
    ->group(function () {
        Route::get('/', LogController::class)->name('vapor-ui.logs');
    });
