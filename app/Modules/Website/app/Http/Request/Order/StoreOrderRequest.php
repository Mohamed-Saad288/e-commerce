<?php

namespace App\Modules\Website\app\Http\Request\Order;

use App\Modules\Base\Enums\ActiveEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
//            'product_variations' => ['required_without:cart_id', 'array'],
//
//            'product_variations.*.product_variation_id' => [
//                'required_without:cart_id',
//                Rule::exists('product_variations', 'id')->whereNull('deleted_at')->where('organization_id', auth()->user()->organization_id)->where('is_active', ActiveEnum::ACTIVE->value),
//            ],
//
//            'product_variations.*.quantity' => ['required_without:cart_id', 'numeric', 'min:1'],
//
//            'cart_id' => [
//                'required_without:product_variations',
//                Rule::exists('carts', 'id')->whereNull('deleted_at'),
//            ],

            'payment_method_id' => [
                'required',
                'integer',
                Rule::exists('payment_methods', 'id')->where('is_active', ActiveEnum::ACTIVE->value),
            ],

            'coupon_id' => [
                'nullable',
                'integer',
                Rule::exists('coupons', 'id')->where('organization_id', auth()->user()->organization_id)->where('is_active', ActiveEnum::ACTIVE->value),
            ],

            'notes' => ['nullable', 'string'],
            'tracking_number' => ['nullable', 'string'],

            // Shipping Address
            'shipping_address_id' => ['nullable', 'integer', 'exists:addresses,id'],
            'shipping_address' => ['nullable', 'array'],
            'shipping_address.phone' => ['required_without:shipping_address_id', 'string', 'max:20'],
            'shipping_address.city_id' => ['required_without:shipping_address_id', 'integer', Rule::exists('cities', 'id')->whereNull('deleted_at')],
//            'shipping_address.country_id' => ['required_without:shipping_address_id', 'integer', Rule::exists('countries', 'id')->whereNull('deleted_at')],
            'shipping_address.address2' => ['nullable', 'string', 'max:100'],
            'shipping_address.address1' => ['nullable', 'string', 'max:255'],
            'shipping_address.postal_code' => ['nullable', 'string', 'max:255'],

            // Billing Address
            'billing_same_as_shipping' => ['boolean'],
            'billing_address_id' => ['nullable', 'integer', 'exists:addresses,id'],
            'billing_address' => ['nullable', 'array'],
            'billing_address.phone' => ['required_without_all:billing_same_as_shipping,billing_address_id', 'string', 'max:20'],
            'billing_address.city_id' => ['required_without_all:billing_same_as_shipping,billing_address_id', 'integer', Rule::exists('cities', 'id')->whereNull('deleted_at')],
            'billing_address.country_id' => ['required_without_all:billing_same_as_shipping,billing_address_id', 'integer', Rule::exists('countries', 'id')->whereNull('deleted_at')],
            'billing_address.address2' => ['nullable', 'string', 'max:100'],
            'billing_address.address1' => ['nullable', 'string', 'max:255'],
            'billing_address.postal_code' => ['nullable', 'string', 'max:255'],

        ];
    }
}
