<?php

declare(strict_types=1);

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use Illuminate\Http\JsonResponse;

class ListController extends Controller
{
    public function __invoke(): JsonResponse
    {
        // TODO: Only return order and not all the details.
        $orders = Restaurant::find(1)->orders() // TODO: Use actual logged in restaurant id
            ->with(['customer:id,name' ,'items.menuItem:id,name'])
            ->where('restaurant_id', 1)
            ->orderBy('created_at', 'desc')
            ->paginate();

        return response()->json($orders);
    }
}
