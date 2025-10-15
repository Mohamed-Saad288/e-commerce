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
    public function __construct(protected BrandService $service) {}

    public function list(BrandRequest $request)
    {
        $brands = $this->service->list();

        return (new DataSuccess(
            data: SimpleTitleResource::collection($brands), status: true,
            message: __('messages.data_retrieved_successfully')
        ))->response();
    }

    public function index(BrandRequest $request)
    {
        $brands = $this->service->index();

        return (new DataSuccess(
            data: BrandResource::collection($brands), status: true,
            message: __('messages.data_retrieved_successfully')
        ))->response();
    }
}
