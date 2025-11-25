<?php

namespace App\Modules\Website\app\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use App\Modules\Organization\app\Services\Product\ProductVariationService;
use App\Modules\Website\app\Http\Request\ProductVariation\ProductOptionItemRequest;
use Illuminate\Http\Request;

class ProductVariationController extends Controller
{
    public function __construct(protected ProductVariationService $service)
    {
    }

    public function index(Request $request)
    {
        return $this->service->index($request)->response();
    }

    public function show($id)
    {
        return $this->service->find($id)->response();
    }

    public function getProductVariationByOptionItemsIds(ProductOptionItemRequest $request)
    {
        return $this->service->getProductVariationByOptionItemsIds($request->option_items_ids)->response();
    }
}
