<?php

namespace App\Modules\Website\app\Http\Controllers\HomeSection;

use App\Http\Controllers\Controller;
use App\Modules\Website\app\Http\Request\HomeSection\FetchHomeSectionDetailsRequest;
use App\Modules\Website\app\Services\HomeSection\HomeSectionService;

class HomeSectionController extends Controller
{
    public function __construct(protected HomeSectionService $service)
    {
    }

    public function fetch_home_sections()
    {
        return $this->service->fetch_home_sections()->response();
    }

    public function fetch_section_products(FetchHomeSectionDetailsRequest $request)
    {
        return $this->service->fetch_sections_products($request->validated())->response();
    }
}
