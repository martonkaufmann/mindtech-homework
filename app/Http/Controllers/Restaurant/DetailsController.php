<?php

namespace App\Http\Controllers\Restaurant;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use Illuminate\Http\JsonResponse;

class DetailsController extends Controller
{
    public function __invoke(int $id): JsonResponse
    {
        $restaurant = Restaurant::findOrFail($id);

        return response()->json($restaurant);
    }
}
