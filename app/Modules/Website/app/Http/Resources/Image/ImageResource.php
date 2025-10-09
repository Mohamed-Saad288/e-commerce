<?php

namespace App\Modules\Website\app\Http\Resources\Image;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ImageResource extends JsonResource
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
           "image" => $this->image ? url("storage/" . $this->image) : null,

       ];
    }
}
