<?php

namespace App\Modules\Organization\app\Http\Request\Category;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $categoryParam = $this->route('category');
        $category_id = is_object($categoryParam)
            ? $categoryParam->id
            : $categoryParam;

        $rules = [
            'slug' => ['nullable', 'unique:categories,slug,'.$category_id],
            'parent_id' => ['nullable', Rule::exists('categories', 'id')->whereNull('deleted_at')],
            'sort_order' => 'nullable|numeric',
            'image' => 'nullable|image',
        ];

        foreach (config('translatable.locales') as $locale) {
            $rules["$locale.name"] = 'required|string|max:255';
            $rules["$locale.description"] = 'nullable|string|max:255';
        }

        return $rules;
    }
}
