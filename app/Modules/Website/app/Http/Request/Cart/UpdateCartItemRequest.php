<?php

namespace App\Modules\Website\app\Http\Request\Cart;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCartItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'cart_item_id' => ['required', 'integer', 'exists:cart_item,id'],
            'product_id' => ['nullable', 'integer', 'exists:product_variations,id'],
            'quantity' => ['nullable', 'integer', 'min:1'],
            'coupon_code' => ['nullable','integer','exists:coupons,code']
        ];
    }
}
