<?php

namespace App\Modules\Website\app\Http\Request\Cart;

use Illuminate\Foundation\Http\FormRequest;

class CartCouponCodeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'cart_id' => ['required', 'integer', 'exists:carts,id'],
            'coupon_code' => ['required', 'string', 'exists:coupons,code'],
        ];
    }
}
