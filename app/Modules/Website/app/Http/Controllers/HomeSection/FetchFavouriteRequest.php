<?php

namespace App\Modules\Website\app\Http\Controllers\HomeSection;

use Illuminate\Foundation\Http\FormRequest;

class FetchFavouriteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'with_pagination' => 'nullable|boolean',
            'per_page' => 'nullable|integer|min:1',
            'word' => 'nullable|string|min:1|max:255',
        ];
    }
}
