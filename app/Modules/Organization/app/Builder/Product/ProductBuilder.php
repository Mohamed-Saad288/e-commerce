<?php

namespace App\Modules\Organization\app\Builder\Product;

use App\Modules\Organization\app\DTO\Product\v2\ProductDto;
use App\Modules\Organization\app\Models\OptionItem\OptionItem;
use Illuminate\Foundation\Http\FormRequest;

class ProductBuilder
{
    public function __construct(
        protected array $data = [],
        protected array $translation = [],
        protected array $variations = []
    ) {}

    public function setData(FormRequest|array $data): ProductBuilder
    {
        $this->data = $data instanceof FormRequest ? $data->validated() : $data;

        return $this;
    }

    public function setTranslation(): ProductBuilder
    {
        $arrayData = $this->data;
        $translations = [];
        foreach (config('translatable.locales') as $locale) {
            $translations[$locale] = [
                'name' => $arrayData[$locale]['name'] ?? null,
                'description' => $arrayData[$locale]['description'] ?? null,
                'short_description' => $arrayData[$locale]['short_description'] ?? null,
            ];
        }
        $this->translation = $translations;

        return $this;
    }

    public function setDefaultVariation(): ProductBuilder
    {
        $this->data = self::generateDefaultVariation($this->data);

        return $this;
    }

    public function setVariationTranslation(): ProductBuilder
    {
        $this->data = self::prepareVariationTranslation($this->data);

        return $this;
    }

    public function setVariations(): ProductBuilder
    {
        $variations = [];
        if (array_key_exists('variations', $this->data) && is_array($this->data['variations']) && count(
            $this->data['variations']
        ) > 0) {
            foreach ($this->data['variations'] as $variant) {
                $variations[] = (new VariationBuilder)
                    ->setData($variant)
                    ->setTranslation()
                    ->setTotalPrice()
                    ->build();
            }
        }

        $this->variations = $variations;

        return $this;
    }

    public function build(): ProductDto
    {
        return new ProductDto(
            translations: $this->translation,
            brand_id: $this->data['brand_id'] ?? null,
            category_id: $this->data['category_id'] ?? null,
            organization_id: $this->data['organization_id'] ?? null,
            employee_id: $this->data['employee_id'] ?? null,
            slug: $this->data['slug'] ?? null,
            type: $this->data['type'] ?? null,
            low_stock_threshold: $this->data['low_stock_threshold'] ?? null,
            requires_shipping: $this->data['requires_shipping'] ?? null,
            stock_quantity: $this->data['stock_quantity'] ?? 0,
            variations: $this->variations
        );
    }

    private static function generateDefaultVariation(array $data): array
    {
        if (! isset($data['variations']) || ! is_array($data['variations']) || count($data['variations']) === 0) {
            $defaultVariation = [
                'sku' => $data['sku'] ?? null,
                'barcode' => $data['barcode'] ?? null,
                'sort_order' => 0,
                'is_featured' => $data['is_featured'] ?? 0,
                'cost_price' => $data['cost_price'] ?? 0,
                'selling_price' => $data['selling_price'] ?? 0,
                'total_price' => calculateTotalPrice($data),
                'discount' => $data['discount'] ?? 0,
                'tax_type' => $data['tax_type'] ?? 1,
                'tax_amount' => $data['tax_amount'] ?? 0,
                'stock_quantity' => $data['stock_quantity'] ?? 0,
                'is_taxable' => $data['is_taxable'] ?? 0,
                'option_items' => [],
                'main_images' => $data['main_images'] ?? [],
                'additional_images' => $data['additional_images'] ?? [],
            ];

            // Prepare translations for the default variation

            foreach (config('translatable.locales') as $locale) {
                $defaultVariation[$locale] = [
                    'name' => $data[$locale]['name'] ?? null,
                ];
            }
            $data['variations'] = [$defaultVariation];

            return $data;
        }

        return $data;
    }

    public static function prepareVariationTranslation(array $data): array
    {
        // If no variations, return as is
        if (! isset($data['variations']) || ! is_array($data['variations']) || count($data['variations']) === 0) {
            return $data;
        }

        // Reset tax and discount for variations
        $data['tax_amount'] = 0;
        $data['discount'] = 0;

        // Collect all option item IDs from variations
        $allOptionItemIds = collect($data['variations'])
            ->pluck('option_items')
            ->flatten()
            ->filter()
            ->unique()
            ->toArray();

        // Load option items if there are any
        $optionItems = collect();
        if (! empty($allOptionItemIds)) {
            $optionItems = OptionItem::query()
                ->whereIn('id', $allOptionItemIds)
                ->get()
                ->keyBy('id');
        }

        // Prepare variation names for each locale
        foreach (config('translatable.locales') as $locale) {
            $productName = $data[$locale]['name'] ?? '';

            foreach ($data['variations'] as $key => $variant) {
                $variationName = $productName;

                // Append option item names to the variation name
                if (is_array($variant['option_items']) && ! empty($variant['option_items'])) {
                    $optionNames = [];
                    foreach ($variant['option_items'] as $itemId) {
                        if ($optionItems->has($itemId)) {
                            $translatedName = $optionItems[$itemId]->getTranslation('name', $locale);
                            if (isset($translatedName['name'])) {
                                $optionNames[] = $translatedName['name'];
                            }
                        }
                    }

                    if (! empty($optionNames)) {
                        $variationName .= ' - '.implode(' - ', $optionNames);
                    }
                }
                $data['variations'][$key][$locale]['name'] = $variationName;
            }
        }

        return $data;
    }
}
