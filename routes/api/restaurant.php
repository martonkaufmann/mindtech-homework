<?php

use App\Http\Controllers\Restaurant\DetailsController;
use App\Http\Controllers\Restaurant\ListController;
use Illuminate\Support\Facades\Route;

Route::prefix('restaurants')->group(function () {
    Route::get('/', ListController::class);
    Route::get('/{restaurant}', DetailsController::class);
});
