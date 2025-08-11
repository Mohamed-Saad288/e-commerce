<?php

namespace App\Modules\Admin\app\Http\Request\Plan;

use App\Modules\Admin\Enums\Plan\BillingTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class StorePlanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            "slug" => ["nullable", Rule::unique("features", "slug")->whereNull("deleted_at")],
            "is_active" => "required|boolean",
            "price" => "required|numeric",
            "duration" => "required|numeric",
            "trial_period" => "required|numeric",
            "sort_order" => "required|numeric",
            "billing_type" => ["required", new Enum(BillingTypeEnum::class)],
            "image" => "required|image|mimes:jpeg,png,jpg,gif,svg|max:2048",
            "features" => "required|array",
            "features.*.feature_id" => ["required", Rule::exists("features", "id")->whereNull("deleted_at")],
            "features.*.feature_value" => ["required"],
        ];

        foreach (config('translatable.locales') as $locale) {
            $rules["$locale.name"] = 'required|string|max:255';
            $rules["$locale.description"] = 'required|string|max:255';
        }

        return $rules;
    }
}
