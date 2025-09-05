<?php

declare(strict_types=1);

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderRequest;
use App\Models\Order;
use Illuminate\Http\JsonResponse;

class StoreController extends Controller
{
    public function __invoke(StoreOrderRequest $request): JsonResponse
    {
        $items = array_map(fn (array $item) => [
            'quantity' => $item['quantity'],
            'menu_item_id' => $item['itemId'],
        ], $request->items);

        $order = new Order();
        $order->customer_id = 1; // TODO: Remove hard coding
        $order->restaurant_id = $request->restaurantId;
        $order->save();
        $order->items()->createMany($items);

        return response()->json([], 201);
    }
}
