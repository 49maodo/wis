<?php

Route::prefix('compagny-verification')->group(function () {
    Route::post('/', [\App\Http\Controllers\CompagnyVerificationsController::class, 'store']);
    Route::get('/', [\App\Http\Controllers\CompagnyVerificationsController::class, 'index']);
    Route::get('/{companyVerifications}', [\App\Http\Controllers\CompagnyVerificationsController::class, 'show']);
})->middleware('auth');
