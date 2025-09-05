<?php

use App\Models\Restaurant;
use App\Models\Order;
use App\Models\User;
use App\Enums\OrderStatus;

test('can update order status', function () {
    $restaurant = Restaurant::factory()->create();

    $customer = User::create([
        'name' => 'Test Customer',
        'email' => 'customer@test.com',
        'password' => bcrypt('password')
    ]);

    $order = Order::create([
        'customer_id' => $customer->id,
        'restaurant_id' => $restaurant->id,
        'status' => OrderStatus::Received
    ]);

    $response = $this->patchJson("/api/orders/{$order->id}", [
        'status' => 'preparing'
    ]);

    $response->assertOk();

    $order->refresh();
    expect($order->status)->toBe(OrderStatus::Preparing);
});

test('can update order to all valid statuses', function () {
    $restaurant = Restaurant::factory()->create();

    $customer = User::create([
        'name' => 'Test Customer',
        'email' => 'customer@test.com',
        'password' => bcrypt('password')
    ]);

    $validStatuses = ['received', 'preparing', 'ready', 'delivered'];

    foreach ($validStatuses as $status) {
        $order = Order::create([
            'customer_id' => $customer->id,
            'restaurant_id' => $restaurant->id,
            'status' => OrderStatus::Received
        ]);

        $response = $this->patchJson("/api/orders/{$order->id}", [
            'status' => $status
        ]);

        $response->assertOk();

        $order->refresh();
        expect($order->status->value)->toBe($status);
    }
});

test('returns 404 when updating non-existent order', function () {
    $response = $this->patchJson('/api/orders/999', [
        'status' => 'preparing'
    ]);

    $response->assertNotFound();
});

test('validates status field is required', function () {
    $restaurant = Restaurant::factory()->create();

    $customer = User::create([
        'name' => 'Test Customer',
        'email' => 'customer@test.com',
        'password' => bcrypt('password')
    ]);

    $order = Order::create([
        'customer_id' => $customer->id,
        'restaurant_id' => $restaurant->id,
        'status' => OrderStatus::Received
    ]);

    $response = $this->patchJson("/api/orders/{$order->id}", []);

    $response->assertUnprocessable()
        ->assertJsonValidationErrors(['status']);
});

test('validates status field accepts only valid enum values', function () {
    $restaurant = Restaurant::factory()->create();

    $customer = User::create([
        'name' => 'Test Customer',
        'email' => 'customer@test.com',
        'password' => bcrypt('password')
    ]);

    $order = Order::create([
        'customer_id' => $customer->id,
        'restaurant_id' => $restaurant->id,
        'status' => OrderStatus::Received
    ]);

    $response = $this->patchJson("/api/orders/{$order->id}", [
        'status' => 'invalid_status'
    ]);

    $response->assertUnprocessable()
        ->assertJsonValidationErrors(['status']);

    $order->refresh();
    expect($order->status)->toBe(OrderStatus::Received);
});

test('can update order status multiple times', function () {
    $restaurant = Restaurant::factory()->create();

    $customer = User::create([
        'name' => 'Test Customer',
        'email' => 'customer@test.com',
        'password' => bcrypt('password')
    ]);

    $order = Order::create([
        'customer_id' => $customer->id,
        'restaurant_id' => $restaurant->id,
        'status' => OrderStatus::Received
    ]);

    $response = $this->patchJson("/api/orders/{$order->id}", [
        'status' => 'preparing'
    ]);
    $response->assertOk();

    $order->refresh();
    expect($order->status)->toBe(OrderStatus::Preparing);

    $response = $this->patchJson("/api/orders/{$order->id}", [
        'status' => 'ready'
    ]);
    $response->assertOk();

    $order->refresh();
    expect($order->status)->toBe(OrderStatus::Ready);

    $response = $this->patchJson("/api/orders/{$order->id}", [
        'status' => 'delivered'
    ]);
    $response->assertOk();

    $order->refresh();
    expect($order->status)->toBe(OrderStatus::Delivered);
});

test('returns updated order data after successful update', function () {
    $restaurant = Restaurant::factory()->create();

    $customer = User::create([
        'name' => 'Test Customer',
        'email' => 'customer@test.com',
        'password' => bcrypt('password')
    ]);

    $order = Order::create([
        'customer_id' => $customer->id,
        'restaurant_id' => $restaurant->id,
        'status' => OrderStatus::Received
    ]);

    $response = $this->patchJson("/api/orders/{$order->id}", [
        'status' => 'preparing'
    ]);

    $response->assertOk()
        ->assertJson([]);

    $order->refresh();
    expect($order->status)->toBe(OrderStatus::Preparing);
});
