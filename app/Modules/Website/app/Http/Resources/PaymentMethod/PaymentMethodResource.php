<?php

namespace App\Modules\Website\app\Http\Resources\PaymentMethod;

use App\Modules\Base\app\Http\Resources\SimpleTitleResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentMethodResource extends JsonResource
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
            'name' => $this->name ?? null,
            'description' => $this->description ?? null,
            'icon' => $this->icon ?? null,
        ];
    }
}
