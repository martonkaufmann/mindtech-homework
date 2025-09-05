<?php

use App\Models\Restaurant;

test('can get restaurant details', function () {
    $restaurant = Restaurant::factory()->create([
        'name' => 'Test Restaurant',
        'address' => '123 Main St',
        'telephone' => '555-1234'
    ]);

    $response = $this->getJson("/api/restaurants/{$restaurant->id}");

    $response->assertOk()
        ->assertJson([
            'id' => $restaurant->id,
            'name' => 'Test Restaurant',
            'address' => '123 Main St', 
            'telephone' => '555-1234'
        ])
        ->assertJsonStructure([
            'id',
            'name',
            'address',
            'telephone',
            'created_at',
            'updated_at'
        ]);
});

test('returns 404 when restaurant does not exist', function () {
    $response = $this->getJson('/api/restaurants/999');

    $response->assertNotFound();
});

test('returns 404 when restaurant id is not numeric', function () {
    $response = $this->getJson('/api/restaurants/invalid');

    $response->assertNotFound();
});