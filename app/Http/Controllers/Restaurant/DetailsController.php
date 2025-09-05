<?php

declare(strict_types=1);

namespace App\Http\Controllers\Restaurant;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use Illuminate\Http\JsonResponse;

class DetailsController extends Controller
{
    public function __invoke(Restaurant $restaurant): JsonResponse
    {
        return response()->json($restaurant);
    }
}
