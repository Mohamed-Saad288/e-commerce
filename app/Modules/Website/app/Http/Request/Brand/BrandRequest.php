<?php

namespace App\Modules\Website\app\Http\Request\Brand;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BrandRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "category_id" => ["nullable", Rule::exists("categories", "id")->whereNull("deleted_at")],
        ];
    }
}
