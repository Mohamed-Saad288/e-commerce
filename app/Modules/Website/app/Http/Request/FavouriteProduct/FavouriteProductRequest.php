<?php

namespace App\Modules\Website\app\Http\Request\FavouriteProduct;

use Illuminate\Foundation\Http\FormRequest;

class FavouriteProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'product_id' => ['required', 'integer', 'exists:product_variations,id'],
        ];
    }
}
