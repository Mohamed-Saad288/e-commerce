<?php

namespace App\Modules\Organization\app\DTO\Product;

use App\Modules\Base\app\DTO\DTOInterface;
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
    public ?int $sort_order = null;
    public ?string $barcode = null;
    public ?int $type = null;
    public ?int $stock_quantity = null;
    public ?int $low_stock_threshold = null;
    public ?bool $requires_shipping = null;
    public ?bool $is_featured = null;
    public ?bool $is_taxable = null;
    public ?int $tax_type = null;
    public ?float $tax_amount = null;
    public ?float $discount = null;
    public ?float $cost_price = null;
    public ?float $selling_price = null;
    public ?float $total_price = null;
    public ?array $variants = [];
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
        ?array $variants = [],
        ?array $images = []
    ){
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
        $this->variants = $variants;
        $this->images = $images;
    }
    public static function fromArray(FormRequest|array $data): DTOInterface
    {

        $translations = [];
        foreach (config('translatable.locales') as $locale) {
            $translations[$locale] = [
                'name'        => $arrayData[$locale]['name'] ?? null,
                'description' => $arrayData[$locale]['description'] ?? null,
            ];
        }
        return new self(
            translations: $translations,
            brand_id: $data['brand_id'],
            category_id: $data['category_id'],
            organization_id: auth()->user()->organization_id ?? null,
            employee_id: auth()->user()->id,
            slug: $data['slug'],
            sku: $data['sku'],
            sort_order: $data['sort_order'],
            barcode: $data['barcode'],
            type: $data['type'],
            stock_quantity: $data['stock_quantity'],
            low_stock_threshold: $data['low_stock_threshold'],
            requires_shipping: $data['requires_shipping'],
            is_featured: $data['is_featured'],
            is_taxable: $data['is_taxable'],
            tax_type: $data['tax_type'],
            tax_amount: $data['tax_amount'],
            discount: $data['discount'],
            cost_price: $data['cost_price'],
            selling_price: $data['selling_price'],
            total_price: $data['total_price'],
            variants: $data['variants'],
            images: $data['images']
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
                'variants' => $this->variants,
                'images' => $this->images
            ]
        );
    }
}
