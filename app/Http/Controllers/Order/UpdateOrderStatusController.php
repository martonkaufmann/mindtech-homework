<?php

declare(strict_types=1);

namespace App\Http\Controllers\Order;

use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateOrderStatusRequest;
use App\Models\Order;
use Illuminate\Http\JsonResponse;

class UpdateOrderStatusController extends Controller
{
    public function __invoke(UpdateOrderStatusRequest $request, Order $order): JsonResponse
    {
        $order->status = OrderStatus::from($request->status);
        $order->save();

        return response()->json();
    }
}
