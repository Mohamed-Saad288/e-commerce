<?php

namespace App\Modules\Website\app\Http\Controllers\FavouriteProduct;

use App\Http\Controllers\Controller;
use App\Modules\Website\app\Http\Controllers\HomeSection\FetchFavouriteRequest;
use App\Modules\Website\app\Http\Request\FavouriteProduct\FavouriteProductRequest;
use App\Modules\Website\app\Http\Request\HomeSection\FetchHomeSectionDetailsRequest;
use App\Modules\Website\app\Services\FavouriteProduct\FavouriteProductService;
use App\Modules\Website\app\Services\HomeSection\HomeSectionService;

class FavouriteProductController extends Controller
{
    public function __construct(protected FavouriteProductService $service) {}

    public function toggle_favourite(FavouriteProductRequest $request)
    {
        return $this->service->toggleFavouriteProduct($request->validated())->response();
    }

    public function fetch_my_favourites(FetchFavouriteRequest $request)
    {
        return $this->service->fetchMyFavourite($request->validated())->response();
    }
}
