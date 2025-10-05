<?php


use App\Http\Controllers\ProfileController;

Route::prefix('profile')->group(function () {
    Route::get('/', [ProfileController::class, 'index']);
    Route::get('/{profile}', [ProfileController::class, 'showBySlug']);
    Route::post('/', [ProfileController::class, 'store'])->middleware('auth');
    Route::post('/{profile}', [ProfileController::class, 'update'])->middleware('auth');
    Route::delete('/{profile}', [ProfileController::class, 'destroy'])->middleware('auth');
});
