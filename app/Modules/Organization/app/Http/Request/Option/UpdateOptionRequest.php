<?php

namespace App\Modules\Organization\app\Http\Request\Option;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateOptionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [];
        foreach (config('translatable.locales') as $locale) {
            $rules["$locale.name"] = 'required|string|max:255';
        }

        $rules['category_id'] = ['sometimes', Rule::exists('categories', 'id')->where(function ($query) {
            $query->whereNull('deleted_at')->where('organization_id', auth('organization_employee')->user()->organization_id);
        })];

        return $rules;
    }
}
