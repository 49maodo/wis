<?php

Route::prefix('codelists')->group(function () {
    Route::get('/', [App\Http\Controllers\CodeListController::class, 'index']);
    Route::get('/{type}', [App\Http\Controllers\CodeListController::class, 'getByType']);
});
