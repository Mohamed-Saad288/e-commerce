<?php

namespace App\Modules\Website\app\Http\Resources\HomeSection;

use App\Modules\Website\app\Http\Resources\Image\ImageResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HomeSectionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
       return [
           'id' => $this->id ?? null,
            "title" => $this->title ?? null,
           "description" => $this->description ?? null,
           'type' => $this->type ?? null,
           'template_type' => $this->template_type ?? null,
           'start_date' => $this->start_date ?? null,
           'end_date' => $this->end_date ?? null,
       ];
    }
}
