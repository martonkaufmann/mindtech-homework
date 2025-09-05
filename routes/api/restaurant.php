<?php

use App\Http\Controllers\Restaurant\DetailsController;
use App\Http\Controllers\Restaurant\ListController;
use App\Http\Controllers\Restaurant\MenuController;
use Illuminate\Support\Facades\Route;

// TODO: Separate routes by customer/restaurant
Route::prefix('restaurants')->group(function () {
    Route::get('/', ListController::class);
    Route::get('/{restaurant}', DetailsController::class);
    Route::get('/{menu}/menu', MenuController::class);
});
