<?php

namespace App\Modules\Website\app\Http\Resources\Header;

use App\Modules\Website\app\Http\Resources\Image\ImageResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HeaderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
       return [
           "id" => $this->id ?? null,
           "name" => $this->name ?? null,
           "description" => $this->description ?? null,
            "images" => ImageResource::collection($this->images ?? [])
       ];
    }
}
