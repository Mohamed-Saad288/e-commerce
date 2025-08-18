<?php

namespace App\Modules\Organization\app\DTO\Product;

use App\Modules\Base\app\DTO\DTOInterface;
use App\Modules\Organization\app\Models\OptionItem\OptionItem;
use Illuminate\Foundation\Http\FormRequest;

class ProductDto implements DTOInterface
{
    public ?array $translations = [];
    public ?int $brand_id = null;
    public ?int $category_id = null;
    public ?int $organization_id = null;
    public ?int $employee_id = null;
    public ?string $slug = null;
    public ?string $sku = null;
    public ?int $sort_order = 0;
    public ?string $barcode = null;
    public ?int $type = null;
    public ?int $stock_quantity = 0;
    public ?int $low_stock_threshold = null;
    public ?bool $requires_shipping = true;
    public ?bool $is_featured = false;
    public ?bool $is_taxable = false;
    public ?int $tax_type = null;
    public ?float $tax_amount = 0;
    public ?float $discount = 0;
    public ?float $cost_price = 0;
    public ?float $selling_price = 0;
    public ?float $total_price = 0;
    public ?array $variations = [];
    public ?array $images = [];

    public function __construct(
        ?array $translations = [],
        ?int $brand_id = null,
        ?int $category_id = null,
        ?int $organization_id = null,
        ?int $employee_id = null,
        ?string $slug = null,
        ?string $sku = null,
        ?int $sort_order = null,
        ?string $barcode = null,
        ?int $type = null,
        ?int $stock_quantity = null,
        ?int $low_stock_threshold = null,
        ?bool $requires_shipping = null,
        ?bool $is_featured = null,
        ?bool $is_taxable = null,
        ?int $tax_type = null,
        ?float $tax_amount = null,
        ?float $discount = null,
        ?float $cost_price = null,
        ?float $selling_price = null,
        ?float $total_price = null,
        ?array $variations = [],
        ?array $images = []
    ) {
        $this->translations = $translations;
        $this->brand_id = $brand_id;
        $this->category_id = $category_id;
        $this->organization_id = $organization_id;
        $this->employee_id = $employee_id;
        $this->slug = $slug;
        $this->sku = $sku;
        $this->sort_order = $sort_order;
        $this->barcode = $barcode;
        $this->type = $type;
        $this->stock_quantity = $stock_quantity;
        $this->low_stock_threshold = $low_stock_threshold;
        $this->requires_shipping = $requires_shipping;
        $this->is_featured = $is_featured;
        $this->is_taxable = $is_taxable;
        $this->tax_type = $tax_type;
        $this->tax_amount = $tax_amount;
        $this->discount = $discount;
        $this->cost_price = $cost_price;
        $this->selling_price = $selling_price;
        $this->total_price = $total_price;
        $this->variations = $variations;
        $this->images = $images;
    }

    public static function fromArray(FormRequest|array $data): DTOInterface
    {
        $arrayData = $data instanceof FormRequest ? $data->validated() : $data;
        $arrayData = self::prepareVariationTranslation($arrayData);


        $translations = [];
        foreach (config('translatable.locales') as $locale) {
            $translations[$locale] = [
                'name' => $arrayData[$locale]['name'] ?? null,
                'description' => $arrayData[$locale]['description'] ?? null,
                "short_description" => $arrayData[$locale]['short_description'] ?? null
            ];
        }
        $variations = [];
        if (array_key_exists('variations', $arrayData) && is_array($arrayData['variations']) && count($arrayData['variations']) > 0) {
            foreach ($arrayData['variations'] as $variant) {
                $variations[] = VariationDto::fromArray($variant);
            }
        }
        $total_price = calculateTotalPrice($arrayData);
        return new self(
            translations: $translations,
            brand_id: $arrayData['brand_id'],
            category_id: $arrayData['category_id'],
            organization_id: auth()->user()->organization_id ?? null,
            employee_id: auth()->user()->id,
            slug: $arrayData['slug'] ?? null,
            sku: $arrayData['sku'] ?? null,
            sort_order: $arrayData['sort_order'] ?? 0,
            barcode: $arrayData['barcode'] ?? null,
            type: $arrayData['type'] ?? null,
            stock_quantity: $arrayData['stock_quantity'] ?? 0,
            low_stock_threshold: $arrayData['low_stock_threshold'] ?? 0,
            requires_shipping: $arrayData['requires_shipping'] ?? true,
            is_featured: $arrayData['is_featured'] ?? 0,
            is_taxable: $arrayData['is_taxable'] ?? 0,
            tax_type: $arrayData['tax_type'] ?? 1,
            tax_amount: $arrayData['tax_amount'] ?? 0,
            discount: $arrayData['discount'] ?? 0,
            cost_price: $arrayData['cost_price'] ?? 0,
            selling_price: $arrayData['selling_price'] ?? 0,
            total_price: $total_price,
            variations: $variations,
            images: $arrayData['images'] ?? []
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
                'sku' => $this->sku,
                'sort_order' => $this->sort_order,
                'barcode' => $this->barcode,
                'type' => $this->type,
                'stock_quantity' => $this->stock_quantity,
                'low_stock_threshold' => $this->low_stock_threshold,
                'requires_shipping' => $this->requires_shipping,
                'is_featured' => $this->is_featured,
                'is_taxable' => $this->is_taxable,
                'tax_type' => $this->tax_type,
                'tax_amount' => $this->tax_amount,
                'discount' => $this->discount,
                'cost_price' => $this->cost_price,
                'selling_price' => $this->selling_price,
                'total_price' => $this->total_price,
                'variations' => $this->variations,
                'images' => $this->images
            ]
        );
    }

    public static function prepareVariationTranslation(array $data): array
    {
        if (!isset($data['variations']) || !is_array($data['variations'])) {
            return $data;
        }
        $data["tax_amount"] = 0;
        $data["discount"] = 0;

        $allOptionItemIds = collect($data['variations'])
            ->pluck('option_items')
            ->flatten()
            ->unique()
            ->toArray();

        $optionItems = OptionItem::query()
            ->whereIn('id', $allOptionItemIds)
            ->get()
            ->keyBy('id');

        foreach (config('translatable.locales') as $locale) {
            foreach ($data['variations'] as $key => $variant) {
                if (!isset($variant['option_items'])) {
                    continue;
                }

                $optionNames = [];
                foreach ($variant['option_items'] as $itemId) {
                    if ($optionItems->has($itemId)) {
                        $optionNames[] = $optionItems[$itemId]->getTranslation('name', $locale)["name"];
                    }
                }
                $suffix = $optionNames ? ' ' . implode('-', $optionNames) : '';
                $data['variations'][$key][$locale]['name'] = $data[$locale]['name'] . $suffix;
            }
        }

        return $data;
    }


}
