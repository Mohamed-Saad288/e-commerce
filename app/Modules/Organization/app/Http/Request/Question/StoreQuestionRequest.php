<?php

namespace App\Modules\Organization\app\Http\Request\Question;

use Illuminate\Foundation\Http\FormRequest;

class StoreQuestionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [];

        foreach (config('translatable.locales') as $locale) {
            $rules["$locale.question"] = 'required|string';
            $rules["$locale.answer"] = 'required|string';
        }

        return $rules;
    }
}
