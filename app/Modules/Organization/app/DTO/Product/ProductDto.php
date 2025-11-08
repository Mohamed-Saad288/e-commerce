<?php

namespace App\Modules\Organization\app\DTO\Product;

use App\Modules\Base\app\DTO\DTOInterface;
use App\Modules\Organization\app\Enum\ProductTypeEnum;
use App\Modules\Organization\app\Models\OptionItem\OptionItem;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class ProductDto implements DTOInterface
{
    public ?array $translations = [];

    public ?int $brand_id = null;

    public ?int $category_id = null;

    public ?int $organization_id = null;

    public ?int $employee_id = null;

    public ?string $slug = null;

    public ?int $type = null;

    public ?int $low_stock_threshold = null;

    public ?bool $requires_shipping = true;

    public ?int $stock_quantity = 0;

    public ?array $variations = [];

    public function __construct(
        ?array $translations = [],
        ?int $brand_id = null,
        ?int $category_id = null,
        ?int $organization_id = null,
        ?int $employee_id = null,
        ?string $slug = null,
        ?int $type = null,
        ?int $low_stock_threshold = null,
        ?bool $requires_shipping = null,
        ?int $stock_quantity = 0,
        ?array $variations = []

    ) {
        $this->translations = $translations;
        $this->brand_id = $brand_id;
        $this->category_id = $category_id;
        $this->organization_id = $organization_id;
        $this->employee_id = $employee_id;
        $this->slug = $slug;
        $this->type = $type;
        $this->low_stock_threshold = $low_stock_threshold;
        $this->requires_shipping = $requires_shipping;
        $this->stock_quantity = $stock_quantity;
        $this->variations = $variations;
    }

    public static function fromArray(FormRequest|array $data): DTOInterface
    {
        $arrayData = $data instanceof FormRequest ? $data->validated() : $data;

        // Generate default variation if no variations provided
        $arrayData = self::generateDefaultVariation($arrayData);

        // Prepare variations with translations
        $arrayData = self::prepareVariationTranslation($arrayData);

        // Prepare translations for main product
        $translations = [];
        foreach (config('translatable.locales') as $locale) {
            $translations[$locale] = [
                'name' => $arrayData[$locale]['name'] ?? null,
                'description' => $arrayData[$locale]['description'] ?? null,
                'short_description' => $arrayData[$locale]['short_description'] ?? null,
            ];
        }

        // Prepare variations
        $variations = [];
        if (array_key_exists('variations', $arrayData) && is_array($arrayData['variations']) && count($arrayData['variations']) > 0) {
            foreach ($arrayData['variations'] as $variant) {
                $variations[] = VariationDto::fromArray($variant);
            }
        }

        return new self(
            translations: $translations,
            brand_id: $arrayData['brand_id'],
            category_id: $arrayData['category_id'],
            organization_id: auth()->user()->organization_id ?? null,
            employee_id: auth()->user()->id,
            slug: $arrayData['slug'] ?? Str::slug(($arrayData[config('translatable.fallback_locale')]['name'] ?? '')),
            type: $arrayData['type'] ?? ProductTypeEnum::PHYSICAL->value,
            low_stock_threshold: $arrayData['low_stock_threshold'] ?? 0,
            requires_shipping: $arrayData['requires_shipping'] ?? true,
            variations: $variations
        );
    }

    public function toArray(): array
    {
        return array_merge(
            $this->translations,
            [
                'brand_id' => $this->brand_id,
                'category_id' => $this->category_id,
                'organization_id' => $this->organization_id,
                'employee_id' => $this->employee_id,
                'slug' => $this->slug,
                'type' => $this->type,
                'low_stock_threshold' => $this->low_stock_threshold,
                'requires_shipping' => $this->requires_shipping,
                //                'variations' => array_map(fn($variant) => $variant->toArray(), $this->variations ?? []),
                'variations' => $this->variations,
            ]
        );
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
}
