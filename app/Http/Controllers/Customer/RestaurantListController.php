<?php

declare(strict_types=1);

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use Illuminate\Http\JsonResponse;

class RestaurantListController extends Controller
{
    public function __invoke(): JsonResponse
    {
        return response()->json(Restaurant::select(['id', 'name'])->paginate());
    }
}
