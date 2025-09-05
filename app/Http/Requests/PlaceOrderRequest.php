<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Rules\ItemBelongsToRestaurant;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PlaceOrderRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            // TODO: Add note that this allows for customers to place order for others,
            // and that would allow for abuse
            /* 'customerId' => ['required', 'integer', 'exists:users,id'], */
            'restaurantId' => [
                'required',
                Rule::exists('restaurants', 'id')
            ],
            'items' => ['required', 'array', 'min:1'],
            'items.*.itemId' => [
                'bail',
                'required',
                Rule::exists('menu_items', 'id')->where('available', true),
                new ItemBelongsToRestaurant(),
            ],
            'items.*.quantity' => ['required', 'integer', 'min:1', 'max:10'],
            'items.*.instructions' => ['nullable', 'string', 'max:1024'],
        ];
    }
}
