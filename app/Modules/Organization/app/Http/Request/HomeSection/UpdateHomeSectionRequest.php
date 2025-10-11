<?php

namespace App\Modules\Organization\app\Http\Request\HomeSection;

use App\Modules\Organization\Enums\HomeSection\HomeSectionTemplateTypeEnum;
use App\Modules\Organization\Enums\HomeSection\HomeSectionTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class UpdateHomeSectionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $home_section = $this->route('home_section');

        $rules = [
            'products' => 'nullable|array|exists:products,id',
            'type' => [
                'required',
                new Enum(HomeSectionTypeEnum::class),
                Rule::unique('home_sections', 'type')
                    ->where(fn ($query) => $query->where('organization_id', auth()->user()->organization_id))
                    ->ignore($home_section->id)
                    ->whereNull('deleted_at'),
            ],
            'sort_order' => 'nullable|integer',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after:start_date',
            'template_type' => [
                Rule::requiredIf(fn () => $this->type === HomeSectionTypeEnum::Custom->value),
                new Enum(HomeSectionTemplateTypeEnum::class),
            ],
        ];

        foreach (config('translatable.locales') as $locale) {
            $rules["$locale.title"] = 'nullable|string|max:255';
            $rules["$locale.description"] = 'nullable|string|max:255';
        }

        return $rules;
    }
}
