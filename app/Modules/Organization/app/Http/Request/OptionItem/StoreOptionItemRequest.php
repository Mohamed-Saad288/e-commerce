<?php

namespace App\Modules\Organization\app\Http\Request\OptionItem;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreOptionItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'option_id' => ['nullable', Rule::exists('options', 'id')->whereNull('deleted_at')],
        ];
        foreach (config('translatable.locales') as $locale) {
            $rules["$locale.name"] = 'required|string|max:255';
        }

        return $rules;
    }
}
