<?php

namespace App\Modules\Organization\app\Builder\Product;

use App\Modules\Organization\app\DTO\Product\v2\VariationDto;
use Illuminate\Foundation\Http\FormRequest;

class VariationBuilder
{

    public function __construct(protected $data = [] , protected $translation = [] ){}

    public function setData(FormRequest|array $data): VariationBuilder
    {
        $this->data = $data instanceof FormRequest ? $data->validated() : $data;
        return $this;
    }

    public function setTranslation(): VariationBuilder
    {
        $arrayData = $this->data;
        $translations = [];
        foreach (config('translatable.locales') as $locale) {
            $translations[$locale] = [
                'name' => $arrayData[$locale]['name'] ?? null,
            ];
        }
        $this->translation = $translations;
        return $this;
    }

    public function setTotalPrice(): VariationBuilder
    {
        $this->data['total_price'] = calculateTotalPrice($this->data);
        return $this;
    }

    public function build():VariationDto
    {
        return new VariationDto(
            id: $this->data['id'] ?? null,
            organization_id: auth()->user()->organization_id ?? null,
            employee_id: auth()->user()->id,
            slug: $this->data['slug'] ?? null,
            sku: $this->data['sku'] ?? null,
            sort_order: $this->data['sort_order'] ?? 0,
            barcode: $this->data['barcode'] ?? null,
            stock_quantity: $this->data['stock_quantity'] ?? null,
            is_featured: $this->data['is_featured'] ?? 0,
            is_taxable: $this->data['is_taxable'] ?? 0,
            tax_type: $this->data['tax_type'] ?? 1,
            tax_amount: $this->data['tax_amount'] ?? 0,
            discount: $this->data['discount'] ?? 0,
            cost_price: $this->data['cost_price'] ?? 0,
            selling_price: $this->data['selling_price'] ?? 0,
            total_price: calculateTotalPrice($this->data),
            translations: $this->translation,
            option_items: $this->data['option_items'] ?? [],
            main_images: $this->data['main_images'] ?? [],
            additional_images: $this->data['additional_images'] ?? [],
        );
    }
}
