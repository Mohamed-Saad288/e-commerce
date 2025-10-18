<?php

namespace App\Modules\Website\app\Http\Resources\HomeSection;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HomeSectionProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name ?? null,
            'slug' => $this->slug ?? null,
            'description' => $this->product?->description ?? null,
            'short_description' => $this->product?->short_description ?? null,
            'sku' => $this->sku ?? null,
            'barcode' => $this->barcode ?? null,
            'type' => $this->product?->type ?? null,
            'cost_price' => $this->cost_price ?? null,
            'selling_price' => $this->selling_price ?? null,
            'total_price' => $this->total_price ?? null,
            'tax_type' => $this->tax_type ?? null,
            'tax_amount' => $this->tax_amount ?? null,
            'discount' => $this->discount ?? null,
            'main_image' => $this->getImages('main_images') ?? null,
        ];
    }
}
