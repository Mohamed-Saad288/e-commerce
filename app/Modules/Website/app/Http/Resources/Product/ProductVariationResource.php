<?php

namespace App\Modules\Website\app\Http\Resources\Product;

use App\Modules\Website\app\Http\Resources\Category\SimpleCategoryResource;
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
            'base_image' => $this->getImages('main_images')[0] ?? null,
            'hover_image' => $this->getImages('main_images')[1] ?? null,
            'description' => $this->product?->description ?? null,
            'short_description' => $this->product?->short_description ?? null,
            'sku' => $this->sku ?? null,
            'barcode' => $this->barcode ?? null,
            'is_favourite' => $this->is_favorite(),
            'requires_shipping' => $this->product?->requires_shipping ?? null,
            'cost_price' => $this->cost_price ?? null,
            'selling_price' => $this->selling_price ?? null,
            'discount' => $this->discount ?? 0,
            'price_after_discount' => getPriceAfterDiscount($this->selling_price, $this->discount) ?? null,
            'total_price' => $this->total_price ?? null,
            'stock_quantity' => $this->stock_quantity ?? null,
            'in_stock' => $this->in_stock ?? null,
            'in_offer' => $this->in_offer() ?? false,
            'is_active' => $this->is_active ?? null,
            'main_image' => $this->getImages('main_images') ?? null,
            'additional_images' => $this->getImages('additional_images') ?? [],

            'category' => new SimpleCategoryResource($this->product?->category ?? null) ?? null,
            'brand' => $this->product?->category?->name ?? null,
            //            'tax_amount' => $this->tax_amount ?? null,
            //            'tax_type' => $this->tax_type ?? null,
            //            'low_stock_threshold' => $this->product?->low_stock_threshold ?? null,
            //            'type' => $this->product?->type ?? null,
            //            'is_taxable' => $this->is_taxable ?? null,
            //            'is_featured' => $this->is_featured ?? null,
            'created_at' => $this->created_at ?? null,
        ];
    }
}
