<?php

use App\Models\Restaurant;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Models\Menu;
use App\Models\MenuCategory;
use App\Models\MenuItem;
use App\Enums\OrderStatus;

test('can get order details', function () {
    $restaurant = Restaurant::factory()->create();

    $customer = User::create([
        'name' => 'John Doe',
        'email' => 'john@test.com',
        'password' => bcrypt('password')
    ]);

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
        'name' => 'Grilled Chicken',
        'description' => 'Seasoned grilled chicken breast',
        'price' => 18.99,
        'available' => true,
        'ingredients' => ['chicken', 'herbs']
    ]);

    $order = Order::create([
        'customer_id' => $customer->id,
        'restaurant_id' => $restaurant->id,
        'status' => OrderStatus::Preparing
    ]);

    OrderItem::create([
        'order_id' => $order->id,
        'menu_item_id' => $menuItem->id,
        'quantity' => 2,
        'instructions' => 'Make it spicy'
    ]);

    $response = $this->getJson("/api/orders/{$order->id}");

    $response->assertOk()
        ->assertJsonStructure([
            '*' => [
                'id',
                'customer_id',
                'restaurant_id',
                'status',
                'created_at',
                'updated_at',
                'customer' => [
                    'id',
                    'name'
                ],
                'items' => [
                    '*' => [
                        'menu_item' => [
                            'id',
                            'name'
                        ]
                    ]
                ]
            ]
        ]);

    $orderData = $response->json('0');
    expect($orderData['id'])->toBe($order->id);
    expect($orderData['customer_id'])->toBe($customer->id);
    expect($orderData['restaurant_id'])->toBe($restaurant->id);
    expect($orderData['status'])->toBe('preparing');

    expect($orderData['customer']['name'])->toBe('John Doe');
    expect($orderData['customer'])->toHaveKey('id');
    expect($orderData['customer'])->not->toHaveKey('email');

    expect($orderData['items'])->toHaveCount(1);
    expect($orderData['items'][0]['menu_item']['name'])->toBe('Grilled Chicken');
    expect($orderData['items'][0]['menu_item'])->toHaveKey('id');
    expect($orderData['items'][0]['menu_item'])->not->toHaveKey('description');
});

test('returns 404 when order does not exist', function () {
    $response = $this->getJson('/api/orders/999');

    $response->assertNotFound();
});

test('order details include multiple items', function () {
    $restaurant = Restaurant::factory()->create();

    $customer = User::create([
        'name' => 'Jane Doe',
        'email' => 'jane@test.com',
        'password' => bcrypt('password')
    ]);

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
        'ingredients' => ['dough', 'cheese']
    ]);

    $order = Order::create([
        'customer_id' => $customer->id,
        'restaurant_id' => $restaurant->id,
        'status' => OrderStatus::Ready
    ]);

    OrderItem::create([
        'order_id' => $order->id,
        'menu_item_id' => $menuItem1->id,
        'quantity' => 1,
        'instructions' => 'Extra sauce'
    ]);

    OrderItem::create([
        'order_id' => $order->id,
        'menu_item_id' => $menuItem2->id,
        'quantity' => 2,
        'instructions' => null
    ]);

    $response = $this->getJson("/api/orders/{$order->id}");

    $response->assertOk();

    $orderData = $response->json('0');
    expect($orderData['items'])->toHaveCount(2);

    $items = $orderData['items'];
    $pastaItem = collect($items)->firstWhere('menu_item.name', 'Pasta');
    $pizzaItem = collect($items)->firstWhere('menu_item.name', 'Pizza');

    expect($pastaItem['menu_item']['name'])->toBe('Pasta');
    expect($pizzaItem['menu_item']['name'])->toBe('Pizza');
});

test('order details show correct status enum values', function () {
    $restaurant = Restaurant::factory()->create();

    $customer = User::create([
        'name' => 'Test Customer',
        'email' => 'test@test.com',
        'password' => bcrypt('password')
    ]);

    foreach (OrderStatus::cases() as $status) {
        $order = Order::create([
            'customer_id' => $customer->id,
            'restaurant_id' => $restaurant->id,
            'status' => $status
        ]);

        $response = $this->getJson("/api/orders/{$order->id}");

        $response->assertOk()
            ->assertJson([
                [
                    'status' => $status->value
                ]
            ]);
    }
});
