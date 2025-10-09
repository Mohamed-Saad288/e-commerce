<?php

namespace App\Modules\Organization\app\Http\Request\Brand;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateBrandRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $brandParam = $this->route('brand');
        $brand_id = is_object($brandParam)
            ? $brandParam->id
            : $brandParam;

        $rules = [
            'slug' => ['nullable', 'unique:brands,slug,'.$brand_id],
            'categories' => 'nullable|array',
            'categories.*' => ['required', Rule::exists('categories', 'id')->whereNull('deleted_at')],
        ];

        foreach (config('translatable.locales') as $locale) {
            $rules["$locale.name"] = 'required|string|max:255';
            $rules["$locale.description"] = 'nullable|string|max:255';
        }

        return $rules;
    }
}
