<?php

use App\Http\Controllers\Order\ListController;
use App\Http\Controllers\Order\StoreController;
use App\Http\Controllers\Order\UpdateOrderStatusController;
use Illuminate\Support\Facades\Route;

Route::prefix('orders')->group(function () {
    Route::post('/', StoreController::class);
    Route::get('/', ListController::class);
    Route::patch('/{order}', UpdateOrderStatusController::class);
});
