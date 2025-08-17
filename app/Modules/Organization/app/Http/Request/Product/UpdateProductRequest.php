<?php

namespace App\Modules\Organization\app\Http\Request\Product;

use App\Modules\Admin\Enums\Feature\FeatureTypeEnum;
use App\Modules\Organization\Enums\Product\ProductTypeEnum;
use App\Modules\Organization\Enums\Product\TaxTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class UpdateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            "brand_id" => [
                "required",
                Rule::exists("brands", "id")->whereNull("deleted_at")
                    ->where("organization_id", auth("organization_employee")->user()->organization_id)
            ],
            "category_id" => [
                "required",
                Rule::exists("categories", "id")->whereNull("deleted_at")
                    ->where("organization_id", auth("organization_employee")->user()->organization_id)
            ],
            "slug" => [
                "nullable",
                Rule::unique("products", "slug")->whereNull("deleted_at")->where(
                    "organization_id",
                    auth("organization_employee")->user()->organization_id
                )
            ],
            "sku" => [
                "nullable",
                Rule::unique("products", "sku")->whereNull("deleted_at")->where(
                    "organization_id",
                    auth("organization_employee")->user()->organization_id
                )
            ],
            "type" => ["required", new Enum(ProductTypeEnum::class)],
            "stock_quantity" => ["required", "numeric"],
            "low_stock_threshold" => ["required", "numeric"],
            "requires_shipping" => ["required", "boolean"],
            "is_featured" => ["required", "boolean"],
            "is_taxable" => ["required", "boolean"],
            "tax_type" => ["required", new Enum(TaxTypeEnum::class)],
            "tax_amount" => ["required", "numeric"],
            "discount" => ["required", "numeric"],
            "cost_price" => ["required", "numeric"],
            "selling_price" => ["required", "numeric"],
            "variations" => ["nullable", "array"],
            "variations.*.sku" => [
                "required",
                Rule::unique("product_variations", "sku")->whereNull("deleted_at")->where(
                    "organization_id",
                    auth("organization_employee")->user()->organization_id
                )
            ],
            "variations.*.price" => ["required", "numeric"],
            "variations.*.stock_quantity" => ["required", "numeric"],
            "variations.*.cost_price" => ["required", "boolean"],
            "variations.*.selling_price" => ["required", "boolean"],
            "variations.*.is_taxable" => ["required", "boolean"],
            "variations.*.tax_type" => ["required", new Enum(TaxTypeEnum::class)],
            "variations.*.tax_amount" => ["required", "numeric"],
            "variations.*.discount" => ["required", "numeric"],
            "variations.*.image" => ["nullable", "image|mimes:jpeg,png,jpg,gif,svg|max:2048"],
        ];

        foreach (config('translatable.locales') as $locale) {
            $rules["$locale.name"] = 'required|string|max:255';
            $rules["$locale.short_description"] = 'nullable|string|max:255';
            $rules["$locale.description"] = 'nullable|string|max:255';
        }

        return $rules;
    }
}
