<?php

namespace App\Modules\Website\app\Http\Resources\Category;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SimpleCategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name ?? null,
            'has_sub_categories' => $this->allSubCategories->isNotEmpty(),
            'has_brands' => $this->resource->relationLoaded('brands') ? $this->brands->isNotEmpty() : false,
            'has_products' => $this->resource->relationLoaded('productVariations') ? $this->productVariations->isNotEmpty() : false,
        ];
    }
}
