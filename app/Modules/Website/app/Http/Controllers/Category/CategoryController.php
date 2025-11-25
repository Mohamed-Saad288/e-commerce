<?php

namespace App\Modules\Website\app\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\Modules\Base\app\Response\DataSuccess;
use App\Modules\Organization\app\Services\Category\CategoryService;
use App\Modules\Website\app\Http\Resources\Category\CategoryResource;
use App\Modules\Website\app\Http\Resources\Category\ShowCategoryResource;
use App\Modules\Website\app\Http\Resources\Category\SimpleCategoryResource;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct(protected CategoryService $service) {}

    public function list(Request $request)
    {
        $categories = $this->service->list($request);

        return (new DataSuccess(
            data: SimpleCategoryResource::collection($categories),
            status: true,
            message: __('messages.data_retrieved_successfully')
        ))->response();
    }

    public function index()
    {
        $categories = $this->service->index();

        return (new DataSuccess(
            data: CategoryResource::collection($categories),
            status: true,
            message: __('messages.data_retrieved_successfully')
        ))->response();
    }

    public function show($id)
    {
        $category = $this->service->find($id);

        return (new DataSuccess(
            data: new ShowCategoryResource($category),
            status: true,
            message: __('messages.data_retrieved_successfully')
        ))->response();
    }
}
