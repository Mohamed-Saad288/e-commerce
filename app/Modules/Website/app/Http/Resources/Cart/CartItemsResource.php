<?php

namespace App\Modules\Website\app\Http\Resources\Cart;

use App\Modules\Website\app\Http\Resources\Product\ProductVariationResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartItemsResource extends JsonResource
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
            'quantity' => $this->quantity ?? 0,
            'price' => $this->price ?? 0,
            'product' => new ProductVariationResource($this->productVariation ?? null)
        ];
    }
}
