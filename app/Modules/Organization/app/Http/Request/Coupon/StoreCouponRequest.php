<?php

namespace App\Modules\Organization\app\Http\Request\Coupon;

use App\Modules\Organization\Enums\Coupon\CouponTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class StoreCouponRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $organizationId = auth('organization_employee')->user()->organization_id;

        return [
            'code' => [
                'required',
                'string',
                'max:50',
                Rule::unique('coupons', 'code')
                    ->where('organization_id', $organizationId),
            ],
            'type' => ['required', new Enum(CouponTypeEnum::class)],
            'value' => ['required', 'numeric', 'min:0'],
            'min_order_amount' => ['nullable', 'numeric', 'min:0'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'usage_limit' => ['nullable', 'integer', 'min:1'],
            'is_active' => ['boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'code.required' => __('validation.code_required'),
            'code.unique' => __('validation.code_unique'),
            'type.required' => __('validation.type_required'),
            'type.enum' => __('validation.type_enum'),
            'value.required' => __('validation.value_required'),
            'value.numeric' => __('validation.value_numeric'),
            'value.min' => __('validation.value_min'),
            'min_order_amount.numeric' => __('validation.min_order_amount_numeric'),
            'start_date.required' => __('validation.start_date_required'),
            'end_date.required' => __('validation.end_date_required'),
            'end_date.after_or_equal' => __('validation.end_date_after_or_equal'),
            'usage_limit.integer' => __('validation.usage_limit_integer'),
            'usage_limit.min' => __('validation.usage_limit_min'),
            'is_active.boolean' => __('validation.is_active_boolean'),
        ];
    }
}
