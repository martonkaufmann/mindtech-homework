<?php

use App\Models\Restaurant;

test('can get restaurants list', function () {
    Restaurant::factory()->count(3)->create();

    $response = $this->getJson('/api/restaurants');

    $response->assertOk()
        ->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name'
                ]
            ],
            'links',
            'meta'
        ]);

    expect($response->json('data'))->toHaveCount(3);

    expect($response->json('data.0'))->toHaveKeys(['id', 'name']);
    expect($response->json('data.0'))->not->toHaveKey('address');
});

test('restaurants list is paginated', function () {
    Restaurant::factory()->count(20)->create();

    $response = $this->getJson('/api/restaurants');

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
    expect($response->json('meta.per_page'))->toBe(15);
});

test('returns empty list when no restaurants exist', function () {
    $response = $this->getJson('/api/restaurants');

    $response->assertOk()
        ->assertJson([
            'data' => []
        ]);
});
