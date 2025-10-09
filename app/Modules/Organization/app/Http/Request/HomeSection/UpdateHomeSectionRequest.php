<?php

namespace App\Modules\Organization\app\Http\Request\HomeSection;

use App\Modules\Organization\Enums\HomeSection\HomeSectionTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class UpdateHomeSectionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'products' => 'nullable|array|exists:products,id',
            'type' => ['nullable', new Enum(HomeSectionTypeEnum::class)],
            'sort_order' => 'nullable|integer',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after:start_date',
        ];

        foreach (config('translatable.locales') as $locale) {
            $rules["$locale.title"] = 'nullable|string|max:255';
            $rules["$locale.description"] = 'nullable|string|max:255';
        }

        return $rules;
    }
}
