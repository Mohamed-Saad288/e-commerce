<?php

namespace App\Modules\Organization\app\Http\Request\Privacy;

use App\Modules\Admin\Enums\Feature\FeatureTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

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
