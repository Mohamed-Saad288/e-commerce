<?php

namespace App\Modules\Website\app\Http\Resources\Brand;

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
            'image' => $this->getImage() ?? null,
            'is_active' => $this->is_active ?? null,
            'created_at' => $this->created_at?->toDateTimeString() ?? null,
            'updated_at' => $this->updated_at?->toDateTimeString() ?? null,
        ];
    }
}
