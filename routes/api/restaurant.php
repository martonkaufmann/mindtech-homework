<?php

use App\Http\Controllers\Restaurant\OrderListController;
use App\Http\Controllers\Restaurant\OrderUpdateStatusController;
use Illuminate\Support\Facades\Route;

Route::prefix('orders')->group(function () {
    Route::get('/', OrderListController::class);
    Route::patch('/{order}', OrderUpdateStatusController::class);
});
