<?php

namespace App\Modules\Website\app\Http\Resources\Brand;

use App\Modules\Website\app\Http\Resources\Product\ProductVariationResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BrandResource extends JsonResource
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
            'slug' => $this->slug ?? null,
            'description' => $this->description ?? null,
            'image' => $this->image ? url("storage/".$this->image) : null,
//            'image' => $this->getImage() ?? null,
            'is_active' => $this->is_active ?? null,
            'products' => ProductVariationResource::collection($this->whenLoaded('products') ?? []) ?? [],
            'created_at' => $this->created_at,
        ];
    }
}
