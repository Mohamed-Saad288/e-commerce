<?php

namespace App\Modules\Website\app\Services\FavouriteProduct;

use App\Modules\Base\app\Response\DataSuccess;
use App\Modules\Organization\app\Models\FavouriteProduct\FavouriteProduct;
use App\Modules\Organization\app\Models\ProductVariation\ProductVariation;
use App\Modules\Website\app\Http\Resources\HomeSection\HomeSectionProductResource;
use App\Modules\Website\app\Traits\WebsiteLink\WebsiteLinkTrait;

class FavouriteProductService
{
    use WebsiteLinkTrait;

    public function toggleFavouriteProduct($data)
    {
        $organization = $this->getOrganization();
        $user = auth('sanctum')->user();

        $productVariation = ProductVariation::find($data['product_id']);

        $favourite = FavouriteProduct::where('user_id', $user->id)
            ->where('product_variation_id', $productVariation->id)
            ->first();

        if ($favourite) {
            $favourite->delete();

            return new DataSuccess(status: true, message: __('messages.removed_from_favourites'));
        }

        FavouriteProduct::create([
            'user_id' => $user->id,
            'product_variation_id' => $productVariation->id,
            'organization_id' => $organization->id,
        ]);

        return new DataSuccess(status: true, message: __('messages.added_to_favourites'));
    }

    public function fetchMyFavourite($data)
    {
        $user = auth('sanctum')->user();
        $organization = $this->getOrganization();

        // Fetch all product variation IDs favourited by the user
        $favouriteVariationIds = FavouriteProduct::where('user_id', $user->id)
            ->where('organization_id', $organization->id)
            ->pluck('product_variation_id');

        // Early return if no favourites
        if ($favouriteVariationIds->isEmpty()) {
            return new DataSuccess(
                data: [],
                status: true,
                message: __('messages.no_favourites_found')
            );
        }

        $query = ProductVariation::whereIn('id', $favouriteVariationIds);

        // Check if pagination is required
        if (! empty($data['with_pagination']) && $data['with_pagination'] == 1) {
            $perPage = $data['per_page'] ?? 10;
            $paginated = $query->paginate($perPage);

            $resource = HomeSectionProductResource::collection($paginated)->response()->getData(true);
        } else {
            $products = $query->get();
            $resource = HomeSectionProductResource::collection($products);
        }

        return new DataSuccess(
            data: $resource,
            status: true,
            message: __('messages.success')
        );
    }
}
