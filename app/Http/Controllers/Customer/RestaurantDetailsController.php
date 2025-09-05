<?php

declare(strict_types=1);

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use Illuminate\Http\JsonResponse;

class RestaurantDetailsController extends Controller
{
    public function __invoke(Restaurant $restaurant): JsonResponse
    {
        return response()->json($restaurant);
    }
}
