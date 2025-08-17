<?php

namespace App\Modules\Organization\app\DTO\Product;

use App\Modules\Base\app\DTO\DTOInterface;
use Illuminate\Foundation\Http\FormRequest;

class VariationDto implements DTOInterface
{
    public ?string $slug = null;
    public ?string $sku = null;
    public ?int $sort_order = null;
    public ?string $barcode = null;
    public ?int $stock_quantity = null;
    public ?bool $requires_shipping = null;
    public ?bool $is_featured = null;
    public ?bool $is_taxable = null;
    public ?int $tax_type = null;
    public ?float $tax_amount = null;
    public ?float $discount = null;
    public ?float $cost_price = null;
    public ?float $selling_price = null;
    public ?float $total_price = null;
    public ?array $translations = [];


    public function __construct(
        ?string $slug = null,
        ?string $sku = null,
        ?int $sort_order = null,
        ?string $barcode = null,
        ?int $stock_quantity = null,
        ?bool $requires_shipping = null,
        ?bool $is_featured = null,
        ?bool $is_taxable = null,
        ?int $tax_type = null,
        ?float $tax_amount = null,
        ?float $discount = null,
        ?float $cost_price = null,
        ?float $selling_price = null,
        ?float $total_price = null,
        ?array $translations = [],

    ){
        $this->slug = $slug;
        $this->sku = $sku;
        $this->sort_order = $sort_order;
        $this->barcode = $barcode;
        $this->stock_quantity = $stock_quantity;
        $this->requires_shipping = $requires_shipping;
        $this->is_featured = $is_featured;
        $this->is_taxable = $is_taxable;
        $this->tax_type = $tax_type;
        $this->tax_amount = $tax_amount;
        $this->discount = $discount;
        $this->cost_price = $cost_price;
        $this->selling_price = $selling_price;
        $this->total_price = $total_price;
        $this->translations = $translations;
    }



    public static function fromArray(FormRequest|array $data): DTOInterface
    {
        return new self(
            slug: $data['slug'],
            sku: $data['sku'],
            sort_order: $data['sort_order'],
            barcode: $data['barcode'],
            stock_quantity: $data['stock_quantity'],
            requires_shipping: $data['requires_shipping'],
            is_featured: $data['is_featured'],
            is_taxable: $data['is_taxable'],
            tax_type: $data['tax_type'],
            tax_amount: $data['tax_amount'],
            discount: $data['discount'],
            cost_price: $data['cost_price'],
            selling_price: $data['selling_price'],
            total_price: $data['total_price'],
            translations: $data['translations'],
        );
    }

    public function toArray(): array
    {
       return array_merge(
            $this->translations,
            [
                'slug' => $this->slug,
                'sku' => $this->sku,
                'sort_order' => $this->sort_order,
                'barcode' => $this->barcode,
                'stock_quantity' => $this->stock_quantity,
                'requires_shipping' => $this->requires_shipping,
                'is_featured' => $this->is_featured,
                'is_taxable' => $this->is_taxable,
                'tax_type' => $this->tax_type,
                'tax_amount' => $this->tax_amount,
                'discount' => $this->discount,
                'cost_price' => $this->cost_price,
                'selling_price' => $this->selling_price,
                'total_price' => $this->total_price,
            ]
        );
    }
}
