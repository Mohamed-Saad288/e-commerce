<?php

namespace App\Modules\Website\app\Http\Resources\HomeSection;

use App\Modules\Organization\Enums\HomeSection\HomeSectionTypeEnum;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HomeSectionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        $products = $this->whenLoaded('products', function () {
            return $this->products->take(10);
        }, function () {
            return $this->products()->take(10)->get();
        });

        $data = [
            'id' => $this->id ?? null,
            'type' => $this->type ?? null,
            'start_date' => $this->start_date ?? null,
            'end_date' => $this->end_date ?? null,
            'products' => HomeSectionProductResource::collection($products),
        ];

        if ($this->type == HomeSectionTypeEnum::Custom->value) {
            $data['title'] = $this->title ?? null ;
            $data['description'] = $this->description ?? null;
            $data['template_type'] = $this->template_type ?? null;
        }

        return $data;
    }
}
