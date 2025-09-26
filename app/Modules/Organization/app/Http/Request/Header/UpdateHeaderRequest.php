<?php

namespace App\Modules\Organization\app\Http\Request\Header;

use App\Modules\Admin\Enums\Feature\FeatureTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class UpdateHeaderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'images' => 'nullable|array',
            'images.*' => 'nullable|image|max:2048',
        ];

        foreach (config('translatable.locales') as $locale) {
            $rules["$locale.name"] = 'nullable|string|max:255';
            $rules["$locale.description"] = 'nullable|string|max:255';
        }

        return $rules;
    }
}
