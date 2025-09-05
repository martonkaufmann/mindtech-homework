<?php

use App\Http\Controllers\Order\StoreController;
use Illuminate\Support\Facades\Route;

Route::prefix('orders')->group(function () {
    Route::post('/', StoreController::class);
});
