<?php

namespace App\Modules\Website\app\Http\Request\HomeSection;

use Illuminate\Foundation\Http\FormRequest;

class FetchHomeSectionDetailsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'home_section_id' => 'required|exists:home_sections,id',
            'with_pagination' => 'nullable|boolean',
            'per_page' => 'nullable|integer|min:1',
            'word' => 'nullable|string|min:1|max:255',
        ];
    }
}
