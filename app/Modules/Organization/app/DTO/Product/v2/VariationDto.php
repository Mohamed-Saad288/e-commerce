<?php

namespace App\Modules\Organization\app\DTO\Product\v2;

use App\Modules\Base\app\DTO\DTOInterface;
use App\Modules\Organization\app\Builder\Product\VariationBuilder;
use Illuminate\Foundation\Http\FormRequest;

class VariationDto implements DTOInterface
{
    public function __construct(
        public ?int $id = null,
        public ?int $organization_id = null,
        public ?int $employee_id = null,
        public ?string $slug = null,
        public ?string $sku = null,
        public ?int $sort_order = null,
        public ?string $barcode = null,
        public ?int $stock_quantity = null,
        public ?bool $is_featured = null,
        public ?bool $is_taxable = null,
        public ?int $tax_type = null,
        public ?float $tax_amount = null,
        public ?float $discount = null,
        public ?float $cost_price = null,
        public ?float $selling_price = null,
        public ?float $total_price = null,
        public ?array $translations = [],
        public ?array $option_items = [],
        public ?array $main_images = [],
        public ?array $additional_images = [],
    ) {}

    public static function fromArray(FormRequest|array $data): DTOInterface
    {
        return (new VariationBuilder)
            ->setData($data)
            ->setTranslation()
            ->setTotalPrice()
            ->build();
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
