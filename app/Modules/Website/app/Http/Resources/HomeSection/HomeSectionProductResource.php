<?php

namespace App\Modules\Website\app\Http\Resources\HomeSection;

use App\Modules\Website\app\Http\Resources\Image\ImageResource;
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
           'id' => $this->id ?? null ,
            "name" => $this->name ?? null,
           'slug' => $this->slug ?? null,
           ''
       ];
    }
}
