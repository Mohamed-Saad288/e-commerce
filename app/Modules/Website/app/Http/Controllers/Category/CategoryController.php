<?php

namespace App\Modules\Website\app\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\Modules\Base\app\Http\Resources\SimpleTitleResource;
use App\Modules\Base\app\Response\DataSuccess;
use App\Modules\Organization\app\Services\Category\CategoryService;
use App\Modules\Website\app\Http\Resources\Category\CategoryResource;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct(protected CategoryService $service) {}

    public function list(Request $request)
    {
        $categories = $this->service->list($request);

        return (new DataSuccess(
            data: SimpleTitleResource::collection($categories), status: true,
            message: __('messages.data_retrieved_successfully')
        ))->response();
    }

    public function index()
    {
        $categories = $this->service->index();

        return (new DataSuccess(
            data: CategoryResource::collection($categories), status: true,
            message: __('messages.data_retrieved_successfully')
        ))->response();
    }

    public function show($id)
    {
        $category = $this->service->find($id);

        return (new DataSuccess(
            data: new CategoryResource($category), status: true,
            message: __('messages.data_retrieved_successfully')
        ))->response();
    }
}
