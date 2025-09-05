<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Restaurant\ListController;

Route::prefix('restaurants')->group(function () {
    Route::get('/', ListController::class);
});
