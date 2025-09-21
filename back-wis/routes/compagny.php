<?php

use App\Http\Controllers\CompagnyController;

Route::prefix('compagny')->group(function () {
    Route::get('/', [CompagnyController::class, 'index']);
    Route::get('/{compagny}', [CompagnyController::class, 'show']);
    Route::post('/', [CompagnyController::class, 'store'])->middleware('auth');
    Route::post('/{compagny}', [CompagnyController::class, 'update'])->middleware('auth');
    Route::delete('/{compagny}', [CompagnyController::class, 'destroy'])->middleware('auth');
});
