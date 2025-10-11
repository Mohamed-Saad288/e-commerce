<?php

namespace App\Modules\Website\app\Http\Resources\WebStatus;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WebStatusResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'logo' => $this->logo ? url('storage/'.$this->logo) : null,
            'primary_color' => $this->primary_color ?? null,
            'secondary_color' => $this->secondary_color ?? null,
            'facebook_link' => $this->facebook_link ?? null,
            'instagram_link' => $this->instagram_link ?? null,
            'phone' => $this->phone ?? null,
            'email' => $this->email ?? null,
            'address' => $this->address ?? null,
            'lat' => $this->lat ?? null,
            'lng' => $this->lng ?? null,
            'x_link' => $this->x_link ?? null,
            'tiktok_link' => $this->tiktok_link ?? null,
        ];
    }
}
