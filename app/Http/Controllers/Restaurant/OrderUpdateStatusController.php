<?php

declare(strict_types=1);

namespace App\Http\Controllers\Restaurant;

use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\OrderUpdateStatusRequest;
use App\Models\Order;
use Illuminate\Http\JsonResponse;

class OrderUpdateStatusController extends Controller
{
    public function __invoke(OrderUpdateStatusRequest $request, Order $order): JsonResponse
    {
        $order->status = OrderStatus::from($request->status);
        $order->save();

        return response()->json();
    }
}
