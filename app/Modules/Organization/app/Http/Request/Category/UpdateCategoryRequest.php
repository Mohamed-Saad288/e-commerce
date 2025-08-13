<?php

namespace App\Modules\Organization\app\Http\Request\Category;

use App\Modules\Admin\Enums\Feature\FeatureTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class UpdateCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $category_id = $this->route('category') ?? $this->route('category')->id;
        $rules = [
            "slug" => ["nullable", "unique:categories,slug," . $category_id],
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
