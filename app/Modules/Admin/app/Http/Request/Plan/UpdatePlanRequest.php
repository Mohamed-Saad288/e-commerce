<?php

namespace App\Modules\Admin\app\Http\Request\Plan;

use App\Modules\Admin\Enums\Plan\BillingTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class UpdatePlanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $plan = $this->route('plan');
        $rules = [
            'slug' => ['nullable', Rule::unique('features', 'slug')->whereNull('deleted_at')->ignore($plan->id)],
            'is_active' => 'nullable|boolean',
            'price' => 'nullable|numeric',
            'duration' => 'nullable|numeric',
            'trial_period' => 'nullable|numeric',
            'sort_order' => 'nullable|numeric',
            'billing_type' => ['nullable', new Enum(BillingTypeEnum::class)],
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'features' => 'required|array',
            'features.*.feature_id' => ['required', Rule::exists('features', 'id')->whereNull('deleted_at')],
            'features.*.feature_value' => ['required'],
        ];
        foreach (config('translatable.locales') as $locale) {
            $rules["$locale.name"] = 'nullable|string|max:255';
            $rules["$locale.description"] = 'nullable|string|max:255';
        }

        return $rules;
    }
}
