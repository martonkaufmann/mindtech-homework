<?php

use App\Http\Controllers\Restaurant\DetailsController;
use App\Http\Controllers\Restaurant\ListController;
use App\Http\Controllers\Restaurant\MenuController;
use Illuminate\Support\Facades\Route;

Route::prefix('restaurants')->group(function () {
    Route::get('/', ListController::class);
    Route::get('/{restaurant}', DetailsController::class);
    Route::get('/{menu}/menu', MenuController::class);
});
