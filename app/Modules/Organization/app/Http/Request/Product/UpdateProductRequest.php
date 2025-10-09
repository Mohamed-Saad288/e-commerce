<?php

namespace App\Modules\Organization\app\Http\Request\Product;

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
        $productId = $this->route('product')?->id ?? $this->product;

        $rules = [
            'brand_id' => [
                'required',
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
                Rule::unique('products', 'slug')
                    ->whereNull('deleted_at')
                    ->where('organization_id', auth('organization_employee')->user()->organization_id)
                    ->ignore($productId),
            ],
            'sku' => [
                'nullable',
                Rule::unique('products', 'sku')
                    ->whereNull('deleted_at')
                    ->where('organization_id', auth('organization_employee')->user()->organization_id)
                    ->ignore($productId),
            ],
            'barcode' => [
                'nullable',
                Rule::unique('products', 'barcode')
                    ->whereNull('deleted_at')
                    ->where('organization_id', auth('organization_employee')->user()->organization_id)
                    ->ignore($productId),
            ],
            'type' => ['required', new Enum(ProductTypeEnum::class)],
            'stock_quantity' => ['required', 'numeric'],
            'low_stock_threshold' => ['required', 'numeric'],
            'requires_shipping' => ['nullable', 'boolean'],
            'is_featured' => ['nullable', 'boolean'],
            'is_taxable' => ['nullable', 'boolean'],
            'tax_type' => ['nullable', new Enum(TaxTypeEnum::class)],
            'tax_amount' => ['nullable', 'numeric'],
            'discount' => ['nullable', 'numeric'],
            'cost_price' => [Rule::requiredIf(fn () => empty($this->variations)), 'numeric', 'gt:0'],
            'selling_price' => [Rule::requiredIf(fn () => empty($this->variations)), 'numeric', 'gt:0'],
            'sort_order' => ['nullable', 'numeric'],
            'featured_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'images' => ['nullable', 'array'],
            'images.*' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'variations' => ['nullable', 'array'],
        ];

        if ($this->has('variations')) {
            foreach ($this->variations as $index => $variation) {
                $variationId = $variation['id'] ?? null;

                $rules["variations.{$index}.id"] = 'nullable|exists:product_variations,id,deleted_at,NULL';
                $rules["variations.{$index}.sku"] = [
                    'required',
                    Rule::unique('product_variations', 'sku')
                        ->whereNull('deleted_at')
                        ->where('organization_id', auth('organization_employee')->user()->organization_id)
                        ->ignore($variationId),
                ];
                $rules["variations.{$index}.option_items"] = ['required', 'array'];
                $rules["variations.{$index}.option_items.*"] = [
                    'required',
                    Rule::exists('option_items', 'id')->whereNull('deleted_at')
                        ->where('organization_id', auth('organization_employee')->user()->organization_id),
                ];
                $rules["variations.{$index}.sort_order"] = ['required', 'numeric'];
                $rules["variations.{$index}.stock_quantity"] = ['required', 'numeric'];
                $rules["variations.{$index}.cost_price"] = [
                    Rule::requiredIf(fn () => ! empty($this->variations)),
                    'numeric',
                    'gt:0',
                ];
                $rules["variations.{$index}.selling_price"] = [
                    Rule::requiredIf(fn () => ! empty($this->variations)),
                    'numeric',
                    'gt:0',
                ];
                $rules["variations.{$index}.is_taxable"] = ['nullable', 'boolean'];
                $rules["variations.{$index}.tax_type"] = ['nullable', new Enum(TaxTypeEnum::class)];
                $rules["variations.{$index}.tax_amount"] = ['nullable', 'numeric'];
                $rules["variations.{$index}.discount"] = ['nullable', 'numeric'];
                $rules["variations.{$index}.images"] = ['nullable', 'array'];
                $rules["variations.{$index}.images.*"] = ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'];
            }
        }

        foreach (config('translatable.locales') as $locale) {
            $rules["$locale.name"] = 'required|string|max:255';
            $rules["$locale.short_description"] = 'nullable|string|max:255';
            $rules["$locale.description"] = 'nullable|string';
        }

        return $rules;
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'brand_id.required' => __('validation.required', ['attribute' => __('messages.brand')]),
            'category_id.required' => __('validation.required', ['attribute' => __('messages.category')]),
            'variations.*.sku.unique' => __('messages.sku_already_exists'),
            'en.name.required' => __('validation.required', ['attribute' => __('messages.name')]),
        ];
    }
}
