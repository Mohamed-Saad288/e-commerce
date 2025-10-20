<?php

namespace App\Modules\Website\app\Http\Request\Cart;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCartRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'cart_id' => ['required', 'integer', 'exists:carts,id'],
            'product_id' => ['nullable', 'integer', 'exists:product_variations,id'],
            'quantity' => ['nullable', 'integer', 'min:1'],
        ];
    }
}
