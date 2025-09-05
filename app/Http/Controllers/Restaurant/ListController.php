<?php

namespace App\Http\Controllers\Restaurant;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use Illuminate\Http\JsonResponse;

class ListController extends Controller
{
    public function __invoke(): JsonResponse
    {
        return response()->json(Restaurant::select(['id', 'name'])->paginate());
    }
}
