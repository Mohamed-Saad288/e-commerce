<?php

namespace App\Modules\Organization\app\Http\Request\Term;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTermRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [];

        foreach (config('translatable.locales') as $locale) {
            $rules["$locale.description"] = 'nullable|string|max:255';
        }

        return $rules;
    }
}
