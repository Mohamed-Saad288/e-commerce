<?php

namespace App\Modules\Organization\app\DTO\Product;

use App\Modules\Base\app\DTO\DTOInterface;
use Illuminate\Foundation\Http\FormRequest;

class VariationDto implements DTOInterface
{
    public ?int $id = null;

    public ?int $organization_id = null;

    public ?int $employee_id = null;

    public ?string $slug = null;

    public ?string $barcode = null;

    public ?string $sku = null;

    public ?int $sort_order = null;

    public ?int $stock_quantity = null;

    public ?bool $is_featured = null;

    public ?bool $is_taxable = null;

    public ?int $tax_type = null;

    public ?float $tax_amount = null;

    public ?float $discount = null;

    public ?float $cost_price = null;

    public ?float $selling_price = null;

    public ?float $total_price = null;

    public ?array $translations = [];

    public ?array $option_items = [];

    public ?array $main_images = [];

    public ?array $additional_images = [];

    public function __construct(
        ?int $id = null,
        ?int $organization_id = null,
        ?int $employee_id = null,
        ?string $slug = null,
        ?string $sku = null,
        ?int $sort_order = null,
        ?string $barcode = null,
        ?int $stock_quantity = null,
        ?bool $is_featured = null,
        ?bool $is_taxable = null,
        ?int $tax_type = null,
        ?float $tax_amount = null,
        ?float $discount = null,
        ?float $cost_price = null,
        ?float $selling_price = null,
        ?float $total_price = null,
        ?array $translations = [],
        ?array $option_items = [],
        ?array $main_images = [],
        ?array $additional_images = []

    ) {
        $this->organization_id = $organization_id;
        $this->employee_id = $employee_id;
        $this->slug = $slug;
        $this->sku = $sku;
        $this->sort_order = $sort_order;
        $this->barcode = $barcode;
        $this->stock_quantity = $stock_quantity;
        $this->is_featured = $is_featured;
        $this->is_taxable = $is_taxable;
        $this->tax_type = $tax_type;
        $this->tax_amount = $tax_amount;
        $this->discount = $discount;
        $this->cost_price = $cost_price;
        $this->selling_price = $selling_price;
        $this->total_price = $total_price;
        $this->translations = $translations;
        $this->option_items = $option_items;
        $this->id = $id;
        $this->main_images = $main_images;
        $this->additional_images = $additional_images;
    }

    public static function fromArray(FormRequest|array $data): DTOInterface
    {
        $total_price = calculateTotalPrice($data);

        $translations = [];
        foreach (config('translatable.locales') as $locale) {
            $translations[$locale] = [
                'name' => $data[$locale]['name'] ?? null,
            ];
        }

        return new self(
            id: $data['id'] ?? null,
            organization_id: auth()->user()->organization_id ?? null,
            employee_id: auth()->user()->id,
            slug: $data['slug'] ?? null,
            sku: $data['sku'] ?? null,
            sort_order: $data['sort_order'] ?? 0,
            barcode: $data['barcode'] ?? null,
            stock_quantity: $data['stock_quantity'] ?? null,
            is_featured: $data['is_featured'] ?? 0,
            is_taxable: $data['is_taxable'] ?? 0,
            tax_type: $data['tax_type'] ?? 1,
            tax_amount: $data['tax_amount'] ?? 0,
            discount: $data['discount'] ?? 0,
            cost_price: $data['cost_price'] ?? 0,
            selling_price: $data['selling_price'] ?? 0,
            total_price: $total_price,
            translations: $translations,
            option_items: $data['option_items'] ?? [],
            main_images: $data['main_images'] ?? [],
            additional_images: $data['additional_images'] ?? []
        );
    }

    public function toArray(): array
    {
        return array_merge(
            $this->translations,
            [
                'id' => $this->id,
                'organization_id' => $this->organization_id,
                'employee_id' => $this->employee_id,
                'slug' => $this->slug,
                'sku' => $this->sku,
                'sort_order' => $this->sort_order,
                'barcode' => $this->barcode,
                'stock_quantity' => $this->stock_quantity,
                'is_featured' => $this->is_featured,
                'is_taxable' => $this->is_taxable,
                'tax_type' => $this->tax_type,
                'tax_amount' => $this->tax_amount,
                'discount' => $this->discount,
                'cost_price' => $this->cost_price,
                'selling_price' => $this->selling_price,
                'total_price' => $this->total_price,
                'option_items' => $this->option_items,
                'main_images' => $this->main_images,
                'additional_images' => $this->additional_images,
            ]
        );
    }
}
