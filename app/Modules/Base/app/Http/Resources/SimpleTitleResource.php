<?php

namespace App\Modules\Base\app\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SimpleTitleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = [
            'id' => $this->id ?? null,
            'name' => $this->name ?? $this->title ?? null,
        ];
        if ($this->getImage()) {
            $data['image'] = $this->getImage();
        }

        return $data;
    }
}
