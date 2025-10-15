<?php

namespace App\Modules\Website\app\Http\Resources\Category;

use App\Modules\Base\Enums\ActiveEnum;
use App\Modules\Website\app\Http\Resources\Brand\BrandResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "slug" => $this->slug,
            "description" => $this->description,
            "image" => $this->getImage() ?? null,
            "parent_name" => $this->parent?->name ?? null,
            "is_active" => $this->is_active ?? ActiveEnum::INACTIVE->value,
            "created_at" => $this->created_at ?? null,
            "brands" => BrandResource::collection($this->whenLoaded('brands') ?? []) ?? [],
        ];
    }
}
