<?php

use App\Http\Controllers\ApplicationController;

Route::prefix('application')->group(function () {
    Route::get('/', [ApplicationController::class, 'index']);
    Route::get('/{application}', [ApplicationController::class, 'show']);
    Route::get('/job/{job}', [ApplicationController::class, 'showByJob']);
    Route::post('/', [ApplicationController::class, 'store']);
    Route::post('/{application}', [ApplicationController::class, 'update']);
    Route::delete('/{application}', [ApplicationController::class, 'destroy']);
})->middleware('auth');
