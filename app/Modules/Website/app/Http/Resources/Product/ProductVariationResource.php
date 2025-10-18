<?php

namespace App\Modules\Website\app\Http\Resources\Product;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductVariationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name ?? null,
            'slug' => $this->slug ?? null,
            'description' => $this->product?->description ?? null,
            'short_description' => $this->product?->short_description ?? null,
            'sku' => $this->sku ?? null,
            'barcode' => $this->barcode ?? null,
            'type' => $this->product?->type ?? null,
            'requires_shipping' => $this->product?->requires_shipping ?? null,
            'low_stock_threshold' => $this->product?->low_stock_threshold ?? null,
            'cost_price' => $this->cost_price ?? null,
            'selling_price' => $this->selling_price ?? null,
            'total_price' => $this->total_price ?? null,
            'tax_type' => $this->tax_type ?? null,
            'tax_amount' => $this->tax_amount ?? null,
            'discount' => $this->discount ?? null,
            'is_taxable' => $this->is_taxable ?? null,
            'stock_quantity' => $this->stock_quantity ?? null,
            'in_stock' => $this->in_stock ?? null,
            'is_active' => $this->is_active ?? null,
            'is_featured' => $this->is_featured ?? null,
            'main_image' => $this->getImages('main_images') ?? null,
            'additional_images' => $this->getImages('additional_images') ?? [],
            'category' => $this->product?->category?->name ?? null,
            'brand' => $this->product?->category?->name ?? null,
            'created_at' => $this->created_at ?? null,
        ];
    }
}
