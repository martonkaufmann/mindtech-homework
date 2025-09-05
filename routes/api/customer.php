<?php

use App\Http\Controllers\Customer\PlaceOrderController;
use App\Http\Controllers\Customer\RestaurantDetailsController;
use App\Http\Controllers\Customer\RestaurantListController;
use App\Http\Controllers\Customer\RestaurantMenuController;
use Illuminate\Support\Facades\Route;

Route::prefix('restaurants')->group(function () {
    Route::get('/', RestaurantListController::class);
    Route::get('/{restaurant}', RestaurantDetailsController::class);
    Route::get('/{menu}/menu', RestaurantMenuController::class);
});

Route::prefix('orders')->group(function () {
    Route::post('/', PlaceOrderController::class);
});
