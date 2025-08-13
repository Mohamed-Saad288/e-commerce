<?php

namespace App\Modules\Organization\app\Http\Request\Category;

use App\Modules\Admin\Enums\Feature\FeatureTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class StoreCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            "slug" => ["nullable", Rule::unique("brands", "slug")->whereNull("deleted_at")],
            "parent_id" => ["nullable", Rule::exists("categories", "id")->whereNull("deleted_at")],
            'sort_order' => 'nullable|numeric',
        ];

        foreach (config('translatable.locales') as $locale) {
            $rules["$locale.name"] = 'required|string|max:255';
            $rules["$locale.description"] = 'nullable|string|max:255';
        }

        return $rules;
    }
}
