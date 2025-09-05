<?php

declare(strict_types=1);

namespace App\Http\Controllers\Restaurant;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\JsonResponse;

class OrderDetailsController extends Controller
{
    public function __invoke(Order $order): JsonResponse
    {
        return response()->json(
            $order->with(['customer:id,name' ,'items.menuItem:id,name'])->get()
        );
    }
}
