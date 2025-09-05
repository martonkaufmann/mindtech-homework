<?php

declare(strict_types=1);

namespace App\Rules;

use App\Models\MenuItem;
use Closure;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\ValidationRule;

class ItemBelongsToRestaurant implements ValidationRule, DataAwareRule
{
    protected $data = [];

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $menuItem = MenuItem::with('category.menu.restaurant')->where('id', $value)->first();

        if ($menuItem->category->menu->restaurant->id !== $this->data['restaurantId']) {
            $fail('The restaurant does not have the item on menu');
        }
    }

    public function setData(array $data): static
    {
        $this->data = $data;

        return $this;
    }
}
