<?php

namespace App\Modules\Organization\app\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\Modules\Organization\app\DTO\Category\CategoryDto;
use App\Modules\Organization\app\Http\Request\Category\StoreCategoryRequest;
use App\Modules\Organization\app\Http\Request\Category\UpdateCategoryRequest;
use App\Modules\Organization\app\Models\Category\Category;
use App\Modules\Organization\app\Services\Category\CategoryService;
use Exception;

class CategoryController extends Controller
{
    public function __construct(protected CategoryService $service) {}

    public function index()
    {
        $categories = $this->service->index();

        return view('organization::dashboard.categories.index', get_defined_vars());
    }

    public function create()
    {
        $categories = Category::whereNull('parent_id')->query()->get();

        return view('organization::dashboard.categories.single', get_defined_vars());
    }

    public function store(StoreCategoryRequest $request)
    {
        $this->service->store(CategoryDto::fromArray($request));

        return to_route('organization.categories.index')->with([
            'message' => __('messages.success'),
            'alert-type' => 'success',
        ]);
    }

    public function edit(Category $category)
    {
        $categories = Category::query()->whereNull('parent_id')->where('id', '!=', $category->id)->get();

        return view('organization::dashboard.categories.single', get_defined_vars());
    }

    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $this->service->update(model: $category, dto: CategoryDto::fromArray($request));

        return to_route('organization.categories.index')->with([
            'message' => __('messages.updated'),
            'alert-type' => 'success',
        ]);
    }

    public function destroy(Category $category)
    {
        try {
            $this->service->delete(model: $category);

            return response()->json([
                'success' => true,
                'message' => __('messages.deleted'),
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('messages.something_wrong'),
            ], 500);
        }
    }
}
