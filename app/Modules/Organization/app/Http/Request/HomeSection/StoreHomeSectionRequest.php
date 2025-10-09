<?php

namespace App\Modules\Organization\app\Http\Request\HomeSection;

use App\Modules\Admin\Enums\Feature\FeatureTypeEnum;
use App\Modules\Organization\Enums\HomeSection\HomeSectionTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class StoreHomeSectionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'products' => 'required|array|exists:products,id',
            'type' => [
                'required',
                new Enum(HomeSectionTypeEnum::class),
                Rule::unique('home_sections', 'type')
                    ->where(fn ($query) => $query->where('organization_id', auth()->user()->organization_id)),
            ],
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
