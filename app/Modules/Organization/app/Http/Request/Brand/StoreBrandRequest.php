<?php

namespace App\Modules\Organization\app\Http\Request\Brand;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreBrandRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'slug' => ['nullable', Rule::unique('brands', 'slug')->whereNull('deleted_at')],
            "categories" => "nullable|array",
            "categories.*" => ["nullable", Rule::exists("categories", "id")->whereNull("deleted_at")],
            "image" => "nullable|image"
        ];

        foreach (config('translatable.locales') as $locale) {
            $rules["$locale.name"] = 'required|string|max:255';
            $rules["$locale.description"] = 'nullable|string|max:255';
        }

        return $rules;
    }
}
