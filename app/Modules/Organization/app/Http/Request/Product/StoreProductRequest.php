<?php

namespace App\Modules\Organization\app\Http\Request\Product;

use App\Modules\Organization\Enums\Product\ProductTypeEnum;
use App\Modules\Organization\Enums\Product\TaxTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'brand_id' => [
                'nullable',
                Rule::exists('brands', 'id')->whereNull('deleted_at')
                    ->where('organization_id', auth('organization_employee')->user()->organization_id),
            ],
            'category_id' => [
                'required',
                Rule::exists('categories', 'id')->whereNull('deleted_at')
                    ->where('organization_id', auth('organization_employee')->user()->organization_id),
            ],
            'slug' => [
                'nullable',
                Rule::unique('products', 'slug')->whereNull('deleted_at')->where(
                    'organization_id',
                    auth('organization_employee')->user()->organization_id
                ),
            ],
            'sku' => [
                'nullable',
                Rule::unique('product_variations', 'sku')->whereNull('deleted_at')->where(
                    'organization_id',
                    auth('organization_employee')->user()->organization_id
                ),
            ],
            'barcode' => [
                'nullable',
                Rule::unique('product_variations', 'barcode')->whereNull('deleted_at')->where(
                    'organization_id',
                    auth('organization_employee')->user()->organization_id
                ),
            ],
//            'type' => ['required', new Enum(ProductTypeEnum::class)],
            'stock_quantity' => ['required', 'numeric'],
            'low_stock_threshold' => ['required', 'numeric'],
            'requires_shipping' => ['nullable', 'boolean'],
//            'is_featured' => ['nullable', 'boolean'],
            'is_taxable' => ['nullable', 'boolean'],
            'tax_type' => ['nullable', new Enum(TaxTypeEnum::class)],
            'tax_amount' => ['nullable', 'numeric'],
            'discount' => ['nullable', 'numeric'],
            'cost_price' => [
                Rule::requiredIf(fn () => empty($this->variations)),
                'numeric',
                'gt:0',
            ],

            'selling_price' => [
                Rule::requiredIf(fn () => empty($this->variations)),
                'numeric',
                'gt:0',
            ],
            'sort_order' => ['required', 'numeric'],
            'featured_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'main_images' => ['nullable', 'array'],
            'main_images.*' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],

            'additional_images' => ['nullable', 'array'],
            'additional_images.*' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'variations' => ['nullable', 'array'],
            'variations.*.sku' => [
                'required',
                Rule::unique('product_variations', 'sku')->whereNull('deleted_at')->where(
                    'organization_id',
                    auth('organization_employee')->user()->organization_id
                ),
            ],

            'variations.*.option_items' => ['required', 'array'],
            'variations.*.option_items.*' => [
                'required',
                Rule::exists('option_items', 'id')->whereNull('deleted_at')->where(
                    'organization_id',
                    auth('organization_employee')->user()->organization_id
                ),
            ],
            'variations.*.sort_order' => ['required', 'numeric'],
            'variations.*.stock_quantity' => ['required', 'numeric'],
            'variations.*.cost_price' => [Rule::requiredIf(fn () => ! empty($this->variations)), 'numeric', 'gt:0'],
            'variations.*.selling_price' => [Rule::requiredIf(fn () => ! empty($this->variations)), 'numeric', 'gt:0'],
            'variations.*.is_taxable' => ['nullable', 'boolean'],
            'variations.*.tax_type' => ['nullable', new Enum(TaxTypeEnum::class)],
            'variations.*.tax_amount' => ['nullable', 'numeric'],
            'variations.*.discount' => ['nullable', 'numeric'],
            'variations.*.additional_images' => ['nullable', 'array'],
            'variations.*.additional_images.*' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],

            'variations.*.main_images' => ['nullable', 'array'],
            'variations.*.main_images.*' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
        ];

        foreach (config('translatable.locales') as $locale) {
            $rules["$locale.name"] = 'required|string|max:255';
            $rules["$locale.short_description"] = 'nullable|string|max:255';
            $rules["$locale.description"] = 'nullable|string';
        }

        return $rules;
    }
}
