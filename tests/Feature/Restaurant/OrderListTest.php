<?php

use App\Models\Restaurant;
use App\Models\Order;
use App\Models\User;
use App\Enums\OrderStatus;

test('can get restaurant orders list', function () {
    $restaurant1 = Restaurant::factory()->create();
    $restaurant2 = Restaurant::factory()->create();

    $customer = User::create([
        'name' => 'Test Customer',
        'email' => 'customer@test.com',
        'password' => bcrypt('password')
    ]);

    Order::create([
        'customer_id' => $customer->id,
        'restaurant_id' => 1,
        'status' => OrderStatus::Received
    ]);
    Order::create([
        'customer_id' => $customer->id,
        'restaurant_id' => 1,
        'status' => OrderStatus::Preparing
    ]);
    Order::create([
        'customer_id' => $customer->id,
        'restaurant_id' => $restaurant2->id,
        'status' => OrderStatus::Received
    ]);

    $restaurant1->update(['id' => 1]);
    $restaurant1->save();

    $response = $this->getJson('/api/orders');

    $response->assertOk()
        ->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'customer_id',
                    'restaurant_id',
                    'status',
                    'created_at',
                    'updated_at'
                ]
            ],
            'links',
            'meta'
        ]);

    expect($response->json('data'))->toHaveCount(2);

    foreach ($response->json('data') as $order) {
        expect($order['restaurant_id'])->toBe(1);
    }
});

test('restaurant orders list is paginated', function () {
    $customer = User::create([
        'name' => 'Test Customer',
        'email' => 'customer@test.com',
        'password' => bcrypt('password')
    ]);

    for ($i = 0; $i < 20; $i++) {
        Order::create([
            'customer_id' => $customer->id,
            'restaurant_id' => 1,
            'status' => OrderStatus::Received
        ]);
    }

    $response = $this->getJson('/api/orders');

    $response->assertOk()
        ->assertJsonStructure([
            'data',
            'links' => [
                'first',
                'last',
                'next',
                'prev'
            ],
            'meta' => [
                'current_page',
                'from',
                'last_page',
                'per_page',
                'to',
                'total'
            ]
        ]);

    expect($response->json('meta.total'))->toBe(20);
});

test('returns empty list when restaurant has no orders', function () {
    $response = $this->getJson('/api/orders');

    $response->assertOk()
        ->assertJson([
            'data' => []
        ]);

    expect($response->json('meta.total'))->toBe(0);
});

test('orders include correct status values', function () {
    $customer = User::create([
        'name' => 'Test Customer',
        'email' => 'customer@test.com',
        'password' => bcrypt('password')
    ]);

    Order::create([
        'customer_id' => $customer->id,
        'restaurant_id' => 1,
        'status' => OrderStatus::Received
    ]);

    Order::create([
        'customer_id' => $customer->id,
        'restaurant_id' => 1,
        'status' => OrderStatus::Preparing
    ]);

    Order::create([
        'customer_id' => $customer->id,
        'restaurant_id' => 1,
        'status' => OrderStatus::Ready
    ]);

    Order::create([
        'customer_id' => $customer->id,
        'restaurant_id' => 1,
        'status' => OrderStatus::Delivered
    ]);

    $response = $this->getJson('/api/orders');

    $response->assertOk();

    $orders = $response->json('data');
    expect($orders)->toHaveCount(4);

    $statuses = array_column($orders, 'status');
    expect($statuses)->toContain('received');
    expect($statuses)->toContain('preparing');
    expect($statuses)->toContain('ready');
    expect($statuses)->toContain('delivered');
});
