<?php

use App\Models\Restaurant;
use App\Models\Menu;
use App\Models\MenuCategory;
use App\Models\MenuItem;
use App\Models\Order;
use App\Enums\OrderStatus;

test('can place a valid order', function () {
    $restaurant = Restaurant::factory()->create();

    $menu = Menu::create([
        'restaurant_id' => $restaurant->id,
        'name' => 'Main Menu'
    ]);

    $category = MenuCategory::create([
        'menu_id' => $menu->id,
        'name' => 'Main Courses',
        'order' => 1
    ]);

    $menuItem1 = MenuItem::create([
        'menu_category_id' => $category->id,
        'name' => 'Pasta',
        'description' => 'Delicious pasta',
        'price' => 15.99,
        'available' => true,
        'ingredients' => ['pasta', 'sauce']
    ]);

    $menuItem2 = MenuItem::create([
        'menu_category_id' => $category->id,
        'name' => 'Pizza',
        'description' => 'Tasty pizza',
        'price' => 18.99,
        'available' => true,
        'ingredients' => ['dough', 'cheese', 'tomato']
    ]);

    $orderData = [
        'restaurantId' => $restaurant->id,
        'items' => [
            [
                'itemId' => $menuItem1->id,
                'quantity' => 2,
                'instructions' => 'Extra sauce please'
            ],
            [
                'itemId' => $menuItem2->id,
                'quantity' => 1
            ]
        ]
    ];

    $response = $this->postJson('/api/orders', $orderData);

    $response->assertCreated()
        ->assertJson([]);

    $order = Order::latest()->first();
    expect($order)->not->toBeNull();
    expect($order->restaurant_id)->toBe($restaurant->id);
    expect($order->customer_id)->toBe(1); // Hard-coded in controller
    expect($order->status)->toBe(OrderStatus::Received);

    expect($order->items)->toHaveCount(2);

    $orderItem1 = $order->items->where('menu_item_id', $menuItem1->id)->first();
    expect($orderItem1->quantity)->toBe(2);
    expect($orderItem1->instructions)->toBe('Extra sauce please');

    $orderItem2 = $order->items->where('menu_item_id', $menuItem2->id)->first();
    expect($orderItem2->quantity)->toBe(1);
    expect($orderItem2->instructions)->toBeNull();
});

test('cannot place order with invalid restaurant id', function () {
    $orderData = [
        'restaurantId' => 999,
        'items' => [
            [
                'itemId' => 1,
                'quantity' => 1
            ]
        ]
    ];

    $response = $this->postJson('/api/orders', $orderData);

    $response->assertUnprocessable()
        ->assertJsonValidationErrors(['restaurantId']);
});

test('cannot place order with empty items array', function () {
    $restaurant = Restaurant::factory()->create();

    $orderData = [
        'restaurantId' => $restaurant->id,
        'items' => []
    ];

    $response = $this->postJson('/api/orders', $orderData);

    $response->assertUnprocessable()
        ->assertJsonValidationErrors(['items']);
});

test('cannot place order with non-existent menu item', function () {
    $restaurant = Restaurant::factory()->create();

    $orderData = [
        'restaurantId' => $restaurant->id,
        'items' => [
            [
                'itemId' => 999,
                'quantity' => 1
            ]
        ]
    ];

    $response = $this->postJson('/api/orders', $orderData);

    $response->assertUnprocessable()
        ->assertJsonValidationErrors(['items.0.itemId']);
});

test('cannot place order with unavailable menu item', function () {
    $restaurant = Restaurant::factory()->create();

    $menu = Menu::create([
        'restaurant_id' => $restaurant->id,
        'name' => 'Main Menu'
    ]);

    $category = MenuCategory::create([
        'menu_id' => $menu->id,
        'name' => 'Main Courses',
        'order' => 1
    ]);

    $menuItem = MenuItem::create([
        'menu_category_id' => $category->id,
        'name' => 'Unavailable Item',
        'description' => 'This item is not available',
        'price' => 15.99,
        'available' => false,
        'ingredients' => ['ingredient']
    ]);

    $orderData = [
        'restaurantId' => $restaurant->id,
        'items' => [
            [
                'itemId' => $menuItem->id,
                'quantity' => 1
            ]
        ]
    ];

    $response = $this->postJson('/api/orders', $orderData);

    $response->assertUnprocessable()
        ->assertJsonValidationErrors(['items.0.itemId']);
});

test('cannot place order with invalid quantity', function () {
    $restaurant = Restaurant::factory()->create();

    $menu = Menu::create([
        'restaurant_id' => $restaurant->id,
        'name' => 'Main Menu'
    ]);

    $category = MenuCategory::create([
        'menu_id' => $menu->id,
        'name' => 'Main Courses',
        'order' => 1
    ]);

    $menuItem = MenuItem::create([
        'menu_category_id' => $category->id,
        'name' => 'Test Item',
        'description' => 'Test description',
        'price' => 15.99,
        'available' => true,
        'ingredients' => ['ingredient']
    ]);

    $orderData = [
        'restaurantId' => $restaurant->id,
        'items' => [
            [
                'itemId' => $menuItem->id,
                'quantity' => 0
            ]
        ]
    ];

    $response = $this->postJson('/api/orders', $orderData);
    $response->assertUnprocessable()
        ->assertJsonValidationErrors(['items.0.quantity']);

    $orderData['items'][0]['quantity'] = 15;

    $response = $this->postJson('/api/orders', $orderData);
    $response->assertUnprocessable()
        ->assertJsonValidationErrors(['items.0.quantity']);
});

test('can place order with valid instructions', function () {
    $restaurant = Restaurant::factory()->create();

    $menu = Menu::create([
        'restaurant_id' => $restaurant->id,
        'name' => 'Main Menu'
    ]);

    $category = MenuCategory::create([
        'menu_id' => $menu->id,
        'name' => 'Main Courses',
        'order' => 1
    ]);

    $menuItem = MenuItem::create([
        'menu_category_id' => $category->id,
        'name' => 'Test Item',
        'description' => 'Test description',
        'price' => 15.99,
        'available' => true,
        'ingredients' => ['ingredient']
    ]);

    $orderData = [
        'restaurantId' => $restaurant->id,
        'items' => [
            [
                'itemId' => $menuItem->id,
                'quantity' => 1,
                'instructions' => 'Make it spicy'
            ]
        ]
    ];

    $response = $this->postJson('/api/orders', $orderData);

    $response->assertCreated();

    $order = Order::latest()->first();
    $orderItem = $order->items->first();
    expect($orderItem->instructions)->toBe('Make it spicy');
});

test('cannot place order with instructions too long', function () {
    $restaurant = Restaurant::factory()->create();

    $menu = Menu::create([
        'restaurant_id' => $restaurant->id,
        'name' => 'Main Menu'
    ]);

    $category = MenuCategory::create([
        'menu_id' => $menu->id,
        'name' => 'Main Courses',
        'order' => 1
    ]);

    $menuItem = MenuItem::create([
        'menu_category_id' => $category->id,
        'name' => 'Test Item',
        'description' => 'Test description',
        'price' => 15.99,
        'available' => true,
        'ingredients' => ['ingredient']
    ]);

    $orderData = [
        'restaurantId' => $restaurant->id,
        'items' => [
            [
                'itemId' => $menuItem->id,
                'quantity' => 1,
                'instructions' => str_repeat('a', 1025)
            ]
        ]
    ];

    $response = $this->postJson('/api/orders', $orderData);

    $response->assertUnprocessable()
        ->assertJsonValidationErrors(['items.0.instructions']);
});
