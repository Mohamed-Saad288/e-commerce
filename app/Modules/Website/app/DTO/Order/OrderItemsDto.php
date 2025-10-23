<?php

namespace App\Modules\Website\app\DTO\Order;

use App\Modules\Organization\app\Models\ProductVariation\ProductVariation;

class OrderItemsDto
{
    public function __construct(
        public ?int $product_id = null,
        public ?int $quantity = null,
        public ?int $product_variation_id = null,
        public ?float $price = 0.0,
        public ?float $sub_total = 0.0,
        public ?float $discount_amount = 0.0,
        public ?float $tax_amount = 0.0,
        public ?int $tax_type = null,
        public ?float $total_amount = 0.0,
        public ?int $organization_id = null,
        public ?int $order_id = null
    ) {}

    public static function fromArray(array $item): OrderItemsDto
    {
        return new self(
            product_id: $item['product_id'] ?? (isset($item['product_variation_id']) ? self::getProduct($item['product_variation_id']) : null),
            quantity: $item['quantity'] ?? 1,
            product_variation_id: $item['product_variation_id'] ?? null,
            price: $item['price'] ?? 0.0,
            sub_total: $item['sub_total'] ?? 0.0,
            discount_amount: $item['discount_amount'] ?? 0.0,
            tax_amount: $item['tax_amount'] ?? 0.0,
            tax_type: $item['tax_type'] ?? null,
            total_amount: $item['total_amount'] ?? 0.0,
            organization_id: auth()->user()->organization_id ?? null,
            order_id: $item['order_id'] ?? null
        );
    }

    private static function getProduct(int $variant_id): ?int
    {
        return ProductVariation::query()->where('id', $variant_id)->value('product_id');
    }

    public function toArray(): array
    {
        return [
            'product_id' => $this->product_id,
            'quantity' => $this->quantity,
            'product_variation_id' => $this->product_variation_id,
            'price' => $this->price,
            'sub_total' => $this->sub_total,
            'discount_amount' => $this->discount_amount,
            'tax_amount' => $this->tax_amount,
            'tax_type' => $this->tax_type,
            'total_amount' => $this->total_amount,
            'organization_id' => $this->organization_id,
            'order_id' => $this->order_id,
        ];
    }
}
