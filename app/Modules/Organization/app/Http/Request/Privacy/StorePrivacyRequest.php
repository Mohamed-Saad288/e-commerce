<?php

namespace App\Modules\Organization\app\Http\Request\Privacy;

use Illuminate\Foundation\Http\FormRequest;

class StorePrivacyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [];

        foreach (config('translatable.locales') as $locale) {
            $rules["$locale.description"] = 'required|string';
        }

        return $rules;
    }
}
