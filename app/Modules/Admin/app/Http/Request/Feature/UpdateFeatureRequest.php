<?php

namespace App\Modules\Admin\app\Http\Request\Feature;

use App\Modules\Admin\Enums\Feature\FeatureTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class UpdateFeatureRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $feature = $this->route('feature');
        $rules = [
            "slug" => ["nullable", Rule::unique("features", "slug")->whereNull("deleted_at")->ignore($feature->id)],
            "type" => ["nullable", new Enum(FeatureTypeEnum::class)],
            "is_active" => "nullable|boolean"
        ];

        foreach (config('translatable.locales') as $locale) {
            $rules["$locale.name"] = 'nullable|string|max:255';
            $rules["$locale.description"] = 'nullable|string|max:255';
        }

        return $rules;
    }
}
