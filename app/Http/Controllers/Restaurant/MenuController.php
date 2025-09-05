<?php

declare(strict_types=1);

namespace App\Http\Controllers\Restaurant;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\JsonResponse;

class MenuController extends Controller
{
    public function __invoke(Menu $menu): JsonResponse
    {
        return response()->json($menu->categories->load('items'));
    }
}
