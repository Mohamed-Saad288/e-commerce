<?php

namespace App\Modules\Admin\app\Http\Request\Feature;

use App\Modules\Admin\Enums\Feature\FeatureTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class StoreFeatureRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'slug' => ['nullable', Rule::unique('features', 'slug')->whereNull('deleted_at')],
            'type' => ['nullable', new Enum(FeatureTypeEnum::class)],
            'is_active' => 'required|boolean',
        ];

        foreach (config('translatable.locales') as $locale) {
            $rules["$locale.name"] = 'required|string|max:255';
            $rules["$locale.description"] = 'required|string|max:255';
        }

        return $rules;
    }
}
