<?php

namespace App\Modules\Organization\app\Http\Controllers\Category;

use App\Http\Controllers\Controller;

use App\Modules\Base\app\Services\BaseService;
use App\Modules\Organization\app\DTO\CategoryDto;
use App\Modules\Organization\app\Http\Request\Category\StoreCategoryRequest;
use App\Modules\Organization\app\Http\Request\Category\UpdateCategoryRequest;
use App\Modules\Organization\app\Models\Category\Category;
use Exception;

class CategoryController extends Controller
{
    public function __construct(protected BaseService $service){}

    public function index()
    {
        $categories = $this->service->index();
        return view('organization::dashboard.categories.index', get_defined_vars());
    }
    public function create()
    {
        return view('organization::dashboard.categories.single',get_defined_vars());
    }
    public function store(StoreCategoryRequest $request)
    {
         $this->service->store(CategoryDto::fromArray($request));
        return to_route('organization.categories.index')->with(array(
            'message' => __("messages.success"),
            'alert-type' => 'success'
        ));
    }
    public function edit(Category $brand)
    {

        return view('organization::dashboard.categories.single', get_defined_vars());
    }
    public function update(UpdateCategoryRequest $request , Category $brand)
    {
        $this->service->update(model: $brand, dto: CategoryDto::fromArray($request));

        return to_route('organization.categories.index')->with(array(
            'message' => __("messages.updated"),
            'alert-type' => 'success'
        ));
    }
    public function destroy(Category $brand)
    {
        try {
            $this->service->delete(model: $brand);
            return response()->json([
                'success' => true,
                'message' => __('messages.deleted')
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('messages.something_wrong')
            ], 500);
        }
    }


}
