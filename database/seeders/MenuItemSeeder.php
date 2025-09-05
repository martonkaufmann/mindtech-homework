<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\MenuCategory;
use App\Models\MenuItem;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

final class MenuItemSeeder extends Seeder
{
    public const array ITEMS = [
        'Appetizers' => [
            ['name' => 'Bruschetta', 'price' => 8.99, 'description' => 'Grilled bread with tomatoes, garlic, and basil', 'ingredients' => ['Bread', 'tomatoes', 'garlic', 'basil', 'olive oil']],
            ['name' => 'Calamari Rings', 'price' => 12.99, 'description' => 'Crispy fried squid rings with marinara sauce', 'ingredients' => ['Squid', 'flour', 'spices', 'marinara sauce']],
            ['name' => 'Buffalo Wings', 'price' => 11.99, 'description' => 'Spicy chicken wings with blue cheese dip', 'ingredients' => ['Chicken wings', 'hot sauce', 'blue cheese', 'celery']],
            ['name' => 'Mozzarella Sticks', 'price' => 9.99, 'description' => 'Golden fried mozzarella with marinara sauce', 'ingredients' => ['Mozzarella cheese', 'breadcrumbs', 'marinara sauce', 'herbs']],
            ['name' => 'Stuffed Mushrooms', 'price' => 10.99, 'description' => 'Button mushrooms stuffed with herbs and cheese', 'ingredients' => ['Button mushrooms', 'cream cheese', 'herbs', 'breadcrumbs']],
        ],
        'Soups' => [
            ['name' => 'Tomato Basil Soup', 'price' => 6.99, 'description' => 'Creamy tomato soup with fresh basil', 'ingredients' => ['Tomatoes', 'cream', 'basil', 'onions', 'garlic']],
            ['name' => 'Chicken Noodle Soup', 'price' => 7.99, 'description' => 'Classic chicken soup with noodles and vegetables', 'ingredients' => ['Chicken', 'noodles', 'carrots', 'celery', 'onions']],
            ['name' => 'Mushroom Bisque', 'price' => 8.99, 'description' => 'Rich and creamy mushroom soup', 'ingredients' => ['Mushrooms', 'cream', 'sherry', 'herbs']],
            ['name' => 'French Onion Soup', 'price' => 7.99, 'description' => 'Traditional French onion soup with gruyere cheese', 'ingredients' => ['Onions', 'beef broth', 'gruyere cheese', 'croutons']],
            ['name' => 'Clam Chowder', 'price' => 9.99, 'description' => 'New England style clam chowder', 'ingredients' => ['Clams', 'potatoes', 'cream', 'celery', 'onions']],
        ],
        'Main Courses' => [
            ['name' => 'Ribeye Steak', 'price' => 32.99, 'description' => 'Premium ribeye steak cooked to your liking', 'ingredients' => ['Ribeye steak', 'garlic', 'rosemary', 'mashed potatoes']],
            ['name' => 'Chicken Parmesan', 'price' => 19.99, 'description' => 'Breaded chicken breast with marinara and mozzarella', 'ingredients' => ['Chicken breast', 'breadcrumbs', 'marinara', 'mozzarella', 'pasta']],
            ['name' => 'Roasted Lamb', 'price' => 28.99, 'description' => 'Herb-crusted leg of lamb with mint sauce', 'ingredients' => ['Lamb', 'herbs', 'mint sauce', 'roasted vegetables']],
            ['name' => 'BBQ Ribs', 'price' => 24.99, 'description' => 'Slow-cooked pork ribs with BBQ sauce', 'ingredients' => ['Pork ribs', 'BBQ sauce', 'coleslaw', 'fries']],
        ],
        'Fish' => [
            ['name' => 'Grilled Salmon', 'price' => 24.99, 'description' => 'Fresh Atlantic salmon with lemon herb butter', 'ingredients' => ['Salmon', 'lemon', 'herbs', 'butter', 'seasonal vegetables']],
            ['name' => 'Fish and Chips', 'price' => 18.99, 'description' => 'Beer-battered cod with crispy fries', 'ingredients' => ['Cod', 'beer batter', 'potatoes', 'mushy peas', 'tartar sauce']],
            ['name' => 'Pan-Seared Halibut', 'price' => 26.99, 'description' => 'Halibut with white wine reduction', 'ingredients' => ['Halibut', 'white wine', 'capers', 'asparagus', 'rice pilaf']],
            ['name' => 'Blackened Mahi-Mahi', 'price' => 22.99, 'description' => 'Cajun-spiced mahi-mahi with mango salsa', 'ingredients' => ['Mahi-mahi', 'cajun spices', 'mango', 'red peppers', 'cilantro']],
            ['name' => 'Lobster Tail', 'price' => 34.99, 'description' => 'Butter-poached lobster tail with drawn butter', 'ingredients' => ['Lobster tail', 'butter', 'garlic', 'lemon', 'vegetables']],
        ],
        'Pasta' => [
            ['name' => 'Spaghetti Carbonara', 'price' => 16.99, 'description' => 'Classic carbonara with pancetta and parmesan', 'ingredients' => ['Spaghetti', 'pancetta', 'eggs', 'parmesan', 'black pepper']],
            ['name' => 'Fettuccine Alfredo', 'price' => 15.99, 'description' => 'Creamy alfredo sauce with fettuccine pasta', 'ingredients' => ['Fettuccine', 'butter', 'cream', 'parmesan', 'garlic']],
            ['name' => 'Penne Arrabbiata', 'price' => 14.99, 'description' => 'Spicy tomato sauce with penne pasta', 'ingredients' => ['Penne pasta', 'tomatoes', 'chili peppers', 'garlic', 'basil']],
            ['name' => 'Lasagna', 'price' => 18.99, 'description' => 'Layered pasta with meat sauce and cheese', 'ingredients' => ['Pasta sheets', 'ground beef', 'ricotta', 'mozzarella', 'marinara']],
            ['name' => 'Seafood Linguine', 'price' => 22.99, 'description' => 'Linguine with mixed seafood in white wine sauce', 'ingredients' => ['Linguine', 'shrimp', 'mussels', 'clams', 'white wine', 'garlic']],
        ],
        'Vegeterian' => [
            ['name' => 'Vegetarian Pasta', 'price' => 16.99, 'description' => 'Penne pasta with seasonal vegetables in garlic oil', 'ingredients' => ['Penne pasta', 'zucchini', 'bell peppers', 'garlic', 'olive oil']],
            ['name' => 'Quinoa Buddha Bowl', 'price' => 15.99, 'description' => 'Quinoa with roasted vegetables and tahini dressing', 'ingredients' => ['Quinoa', 'roasted vegetables', 'chickpeas', 'tahini', 'greens']],
            ['name' => 'Portobello Burger', 'price' => 14.99, 'description' => 'Grilled portobello mushroom burger with avocado', 'ingredients' => ['Portobello mushroom', 'avocado', 'brioche bun', 'lettuce', 'tomato']],
            ['name' => 'Vegetable Curry', 'price' => 13.99, 'description' => 'Mixed vegetable curry with jasmine rice', 'ingredients' => ['Mixed vegetables', 'curry spices', 'coconut milk', 'jasmine rice']],
            ['name' => 'Caprese Salad', 'price' => 12.99, 'description' => 'Fresh mozzarella with tomatoes and basil', 'ingredients' => ['Fresh mozzarella', 'tomatoes', 'basil', 'balsamic glaze', 'olive oil']],
        ],
        'Desserts' => [
            ['name' => 'Tiramisu', 'price' => 7.99, 'description' => 'Classic Italian dessert with coffee and mascarpone', 'ingredients' => ['Ladyfingers', 'coffee', 'mascarpone', 'cocoa powder']],
            ['name' => 'Chocolate Lava Cake', 'price' => 8.99, 'description' => 'Warm chocolate cake with molten center', 'ingredients' => ['Dark chocolate', 'butter', 'eggs', 'flour', 'vanilla ice cream']],
            ['name' => 'Cheesecake', 'price' => 6.99, 'description' => 'New York style cheesecake with berry compote', 'ingredients' => ['Cream cheese', 'graham crackers', 'berries', 'sugar']],
            ['name' => 'Crème Brûlée', 'price' => 8.99, 'description' => 'Vanilla custard with caramelized sugar', 'ingredients' => ['Cream', 'vanilla', 'eggs', 'sugar']],
            ['name' => 'Apple Pie', 'price' => 6.99, 'description' => 'Traditional apple pie with cinnamon ice cream', 'ingredients' => ['Apples', 'pastry', 'cinnamon', 'vanilla ice cream']],
        ],
        'Beverages' => [
            ['name' => 'Fresh Juice', 'price' => 3.99, 'description' => 'Freshly squeezed orange or apple juice', 'ingredients' => ['Fresh fruits']],
            ['name' => 'Coffee', 'price' => 2.99, 'description' => 'Freshly brewed coffee', 'ingredients' => ['Coffee beans']],
            ['name' => 'Cappuccino', 'price' => 4.99, 'description' => 'Espresso with steamed milk foam', 'ingredients' => ['Espresso', 'steamed milk']],
            ['name' => 'Iced Tea', 'price' => 2.99, 'description' => 'Refreshing iced tea with lemon', 'ingredients' => ['Tea', 'ice', 'lemon']],
            ['name' => 'Smoothie', 'price' => 5.99, 'description' => 'Mixed berry smoothie with yogurt', 'ingredients' => ['Mixed berries', 'yogurt', 'honey']],
        ],
        'Alcoholic' => [
            ['name' => 'House Wine', 'price' => 6.99, 'description' => 'Red or white wine by the glass', 'ingredients' => ['Wine grapes']],
            ['name' => 'Craft Beer', 'price' => 4.99, 'description' => 'Local craft beer selection', 'ingredients' => ['Hops', 'malt', 'yeast', 'water']],
            ['name' => 'Whiskey Sour', 'price' => 9.99, 'description' => 'Classic whiskey cocktail with lemon and simple syrup', 'ingredients' => ['Whiskey', 'lemon juice', 'simple syrup', 'egg white']],
            ['name' => 'Mojito', 'price' => 8.99, 'description' => 'Cuban cocktail with rum, mint, and lime', 'ingredients' => ['White rum', 'mint', 'lime', 'sugar', 'soda water']],
            ['name' => 'Margarita', 'price' => 9.99, 'description' => 'Tequila cocktail with lime and triple sec', 'ingredients' => ['Tequila', 'lime juice', 'triple sec', 'salt rim']],
        ],
    ];

    public function run(): void
    {
        $categories = MenuCategory::all();

        foreach ($categories as $category) {
            $items = Arr::random(self::ITEMS[$category->name], rand(1, count(self::ITEMS[$category->name])));

            foreach ($items as $item) {
                MenuItem::create([
                    'menu_category_id' => $category->id,
                    'name' => $item['name'],
                    'description' => $item['description'],
                    'price' => $item['price'],
                    'ingredients' => $item['ingredients'],
                    'available' => true,
                ]);
            }
        }
    }
}
