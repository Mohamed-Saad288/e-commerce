<?php

namespace App\Modules\Website\app\Http\Resources\HomeSection;

use App\Modules\Organization\app\Models\FavouriteProduct\FavouriteProduct;
use App\Modules\Website\app\Traits\WebsiteLink\WebsiteLinkTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HomeSectionProductResource extends JsonResource
{
    use WebsiteLinkTrait;

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $user = auth('sanctum')->user();
        $organization = $this->getOrganization();
        if (isset($user))
        {
            $favouriteVariation = FavouriteProduct::where('user_id', $user->id)
                ->where('organization_id', $organization->id)
                ->where('product_variation_id', $this->id)->exists();
        }


        $data = [
            'name' => $this->name ?? $this->product?->name ?? null,
            'slug' => $this->slug ??$this->product?->slug ?? null,
            'description' => $this->product?->description ?? null,
            'short_description' => $this->product?->short_description ?? null,
            'sku' => $this->sku ?? null,
            'barcode' => $this->barcode ?? null,
            'type' => $this->product?->type ?? null,
            'cost_price' => $this->cost_price ?? null,
            'selling_price' => $this->selling_price ?? null,
            'total_price' => $this->total_price ?? null,
            'tax_type' => $this->tax_type ?? null,
            'tax_amount' => $this->tax_amount ?? null,
            'discount' => $this->discount ?? null,
            'is_favourite' =>  false,
            'main_image' => $this->getImages('main_images') ?? null,
        ];
        if (isset($favouriteVariation))
        {
            $data['is_favourite'] = (bool) $favouriteVariation;
        }
        return  $data;
    }
}
