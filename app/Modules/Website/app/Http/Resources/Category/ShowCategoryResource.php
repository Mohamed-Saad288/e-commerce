<?php

namespace App\Modules\Website\app\Http\Resources\Category;

use App\Modules\Base\Enums\ActiveEnum;
use App\Modules\Website\app\Http\Resources\Brand\BrandResource;
use App\Modules\Website\app\Http\Resources\Product\ProductVariationResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShowCategoryResource extends JsonResource
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
            "has_sub_categories" => $this->allSubCategories->isNotEmpty(),
            "has_brands" => $this->resource->relationLoaded('brands') ? $this->brands->isNotEmpty() : false,
            "has_products" => $this->resource->relationLoaded('productVariations') ? $this->productVariations->isNotEmpty() : false,
            'slug' => $this->slug ?? null,
            'sub_categories' => CategoryResource::collection($this->whenLoaded('allSubCategories') ?? []) ?? [],
            'brands' => BrandResource::collection($this->whenLoaded('brands') ?? []) ?? [],
            'products' => ProductVariationResource::collection($this->getFinalProducts() ?? []) ?? [],
        ];
    }
}
