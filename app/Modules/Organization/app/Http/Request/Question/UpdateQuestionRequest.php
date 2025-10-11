<?php

namespace App\Modules\Organization\app\Http\Request\Question;

use Illuminate\Foundation\Http\FormRequest;

class UpdateQuestionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [];

        foreach (config('translatable.locales') as $locale) {
            $rules["$locale.question"] = 'nullable|string';
            $rules["$locale.answer"] = 'nullable|string';
        }

        return $rules;
    }
}
