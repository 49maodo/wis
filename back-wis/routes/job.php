<?php

use App\Http\Controllers\JobController;

Route::prefix('job')->group(function () {
    Route::get('/', [JobController::class, 'index']);
    Route::get('/{job}', [JobController::class, 'show']);
    Route::post('/', [JobController::class, 'store'])->middleware('auth');
    Route::post('/{job}', [JobController::class, 'update'])->middleware('auth');
    Route::delete('/{job}', [JobController::class, 'destroy'])->middleware('auth');
});
