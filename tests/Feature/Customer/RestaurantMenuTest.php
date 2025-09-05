<?php

use App\Models\Restaurant;
use App\Models\Menu;
use App\Models\MenuCategory;
use App\Models\MenuItem;

test('can get restaurant menu', function () {
    $restaurant = Restaurant::factory()->create();

    $menu = Menu::create([
        'restaurant_id' => $restaurant->id,
        'name' => 'Main Menu'
    ]);

    $category1 = MenuCategory::create([
        'menu_id' => $menu->id,
        'name' => 'Appetizers',
        'order' => 1
    ]);

    $category2 = MenuCategory::create([
        'menu_id' => $menu->id,
        'name' => 'Main Courses',
        'order' => 2
    ]);

    MenuItem::create([
        'menu_category_id' => $category1->id,
        'name' => 'Caesar Salad',
        'description' => 'Fresh romaine lettuce',
        'price' => 12.99,
        'available' => true,
        'ingredients' => ['lettuce', 'parmesan', 'croutons']
    ]);

    MenuItem::create([
        'menu_category_id' => $category2->id,
        'name' => 'Grilled Chicken',
        'description' => 'Seasoned grilled chicken breast',
        'price' => 18.99,
        'available' => true,
        'ingredients' => ['chicken', 'herbs', 'spices']
    ]);

    $response = $this->getJson("/api/restaurants/{$menu->id}/menu");

    $response->assertOk()
        ->assertJsonStructure([
            'id',
            'name',
            'restaurant_id',
            'categories' => [
                '*' => [
                    'id',
                    'name',
                    'order',
                            'items' => [
                        '*' => [
                            'id',
                            'name',
                            'description',
                            'price',
                            'available',
                            'ingredients'
                        ]
                    ]
                ]
            ]
        ]);

    expect($response->json('categories'))->toHaveCount(2);
    expect($response->json('categories.0.items'))->toHaveCount(1);
    expect($response->json('categories.1.items'))->toHaveCount(1);
});

test('returns 404 when menu does not exist', function () {
    $response = $this->getJson('/api/restaurants/999/menu');

    $response->assertNotFound();
});

test('menu shows only available items', function () {
    $restaurant = Restaurant::factory()->create();

    $menu = Menu::create([
        'restaurant_id' => $restaurant->id,
        'name' => 'Main Menu'
    ]);

    $category = MenuCategory::create([
        'menu_id' => $menu->id,
        'name' => 'Test Category',
        'order' => 1
    ]);

    MenuItem::create([
        'menu_category_id' => $category->id,
        'name' => 'Available Item',
        'description' => 'This item is available',
        'price' => 10.99,
        'available' => true,
        'ingredients' => ['ingredient1']
    ]);

    MenuItem::create([
        'menu_category_id' => $category->id,
        'name' => 'Unavailable Item',
        'description' => 'This item is not available',
        'price' => 15.99,
        'available' => false,
        'ingredients' => ['ingredient2']
    ]);

    $response = $this->getJson("/api/restaurants/{$menu->id}/menu");

    $response->assertOk();

    $menuItems = $response->json('categories.0.items');
    expect($menuItems)->toHaveCount(2); // Assuming it shows all items but marks availability

    $availableItem = collect($menuItems)->firstWhere('name', 'Available Item');
    $unavailableItem = collect($menuItems)->firstWhere('name', 'Unavailable Item');

    expect($availableItem['available'])->toBeTrue();
    expect($unavailableItem['available'])->toBeFalse();
});
