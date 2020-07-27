<?php

use Illuminate\Support\Facades\Route;
use Laravel\VaporUi\Http\Controllers\LogController;

Route::prefix('vapor-ui')->group(function () {
    Route::get('/logs', LogController::class)->name('vapor-ui.logs');
});
