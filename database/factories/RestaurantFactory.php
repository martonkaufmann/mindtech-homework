<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class RestaurantFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->company() . ' Restaurant',
            'address' => fake()->address(),
            'telephone' => fake()->phoneNumber(),
        ];
    }
}
