<?php

namespace App\Modules\Website\app\Http\Controllers\Brand;

use App\Http\Controllers\Controller;
use App\Modules\Base\app\Http\Resources\SimpleTitleResource;
use App\Modules\Base\app\Response\DataSuccess;
use App\Modules\Organization\app\Services\Brand\BrandService;
use App\Modules\Website\app\Http\Request\Brand\BrandRequest;
use App\Modules\Website\app\Http\Resources\Brand\BrandResource;

class BrandController extends Controller
{
    public function __construct(protected BrandService $service)
    {
    }

    public function list(BrandRequest $request)
    {
        $brands = $this->service->list($request);

        return (new DataSuccess(
            data: SimpleTitleResource::collection($brands),
            status: true,
            message: __('messages.data_retrieved_successfully')
        ))->response();
    }

    public function index(BrandRequest $request)
    {
        $brands = $this->service->index($request);

        return (new DataSuccess(
            data: BrandResource::collection($brands),
            status: true,
            message: __('messages.data_retrieved_successfully')
        ))->response();
    }

    public function show($id)
    {
        $brand = $this->service->find($id);

        return (new DataSuccess(
            data: new BrandResource($brand),
            status: true,
            message: __('messages.data_retrieved_successfully')
        ))->response();
    }
}
