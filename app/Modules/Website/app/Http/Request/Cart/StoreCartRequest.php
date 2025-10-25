<?php

namespace App\Modules\Website\app\Http\Request\Cart;

use Illuminate\Foundation\Http\FormRequest;

class StoreCartRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'product_id' => ['required', 'integer', 'exists:product_variations,id'],
            'quantity' => ['required', 'integer', 'min:1'],
            'coupon_code' => ['nullable', 'integer', 'exists:coupons,code'],
        ];
    }
}
