<?php

namespace App\Modules\Website\app\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use App\Modules\Base\app\Response\DataSuccess;
use App\Modules\Organization\app\Services\Product\ProductVariationService;
use App\Modules\Website\app\Http\Resources\Product\ProductVariationResource;
use Illuminate\Http\Request;

class ProductVariationController extends Controller
{
    public function __construct(protected ProductVariationService $service) {}

    public function index(Request $request)
    {
       return $this->service->index($request)->response();
    }

    public function show($id)
    {
        $productVariation = $this->service->find($id);

        return (new DataSuccess(
            data: ProductVariationResource::make($productVariation),
            status: true,
            message: __('messages.data_retrieved_successfully')
        ))->response();
    }
}
