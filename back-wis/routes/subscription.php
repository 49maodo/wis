<?php

use App\Http\Controllers\SubscriptionController;

Route::prefix('subscriptions')->group(function () {
    Route::get('/offers', [SubscriptionController::class, 'offers']);
    Route::get('/current', [SubscriptionController::class, 'current']);
    Route::get('/', [SubscriptionController::class, 'index']);
    Route::post('/', [SubscriptionController::class, 'store']);
    Route::post('/{subscription}/renew', [SubscriptionController::class, 'renew']);
    Route::post('/{subscription}/suspend', [SubscriptionController::class, 'suspend']);
    Route::post('/{subscription}/cancel', [SubscriptionController::class, 'cancel']);
    Route::get('/{subscription}/validity', [SubscriptionController::class, 'checkValidity']);
})->middleware('auth:sanctum');
