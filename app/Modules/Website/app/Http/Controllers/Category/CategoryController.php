<?php

namespace App\Modules\Website\app\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\Modules\Base\app\Http\Resources\SimpleTitleResource;
use App\Modules\Base\app\Response\DataSuccess;
use App\Modules\Organization\app\Services\Category\CategoryService;

class CategoryController extends Controller
{
    public function __construct(protected CategoryService $service) {}

    public function list()
    {
        $categories = $this->service->list();

        return (new DataSuccess(
            data: SimpleTitleResource::collection($categories), status: true,
            message: __('website.category_list')
        ))->response();
    }
}
