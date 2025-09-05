<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\MenuCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

final class MenuCategorySeeder extends Seeder
{
    public const array CATEGORIES = [
        'Appetizers',
        'Soups',
        'Main Courses',
        'Fish',
        'Pasta',
        'Vegeterian',
        'Desserts',
        'Beverages',
        'Alcoholic',
    ];

    public function run(): void
    {
        $menus = Menu::all();

        foreach ($menus as $menu) {
            $categories = Arr::random(self::CATEGORIES, rand(1, count(self::CATEGORIES)));

            foreach ($categories as $category) {
                MenuCategory::create([
                    'menu_id' => $menu->id,
                    'name' => $category,
                ]);
            }
        }
    }
}
