<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Restaurant\ListController;
use App\Http\Controllers\Restaurant\DetailsController;

Route::prefix('restaurants')->group(function () {
    Route::get('/', ListController::class);
    Route::get('/{id}', DetailsController::class)->where('id', '[0-9]+');
});
