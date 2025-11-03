<?php

namespace App\Modules\Website\app\Http\Request\ProductVariation;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductOptionItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'option_items_ids' => 'required|array',
            'option_items_ids.*' => ['required', 'integer', Rule::exists('option_items', 'id')
                ->whereNull('deleted_at'),
            ],
        ];
    }
}
