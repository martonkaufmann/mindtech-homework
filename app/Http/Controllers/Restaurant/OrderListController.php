<?php

declare(strict_types=1);

namespace App\Http\Controllers\Restaurant;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use Illuminate\Http\JsonResponse;

class OrderListController extends Controller
{
    public function __invoke(): JsonResponse
    {
        return response()->json(
            Restaurant::find(1)->orders()->paginate() // TODO: Use actual logged in restaurant id
        );
    }
}
