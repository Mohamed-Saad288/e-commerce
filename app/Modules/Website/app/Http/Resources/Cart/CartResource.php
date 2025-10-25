<?php

namespace App\Modules\Website\app\Http\Resources\Cart;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
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
            'total' => $this->total ?? 0,
            'coupon_code' => $this->coupon ? $this->coupon->code : null,
            'items' => CartItemsResource::collection($this->items ?? []) ?? [],
        ];
    }
}
