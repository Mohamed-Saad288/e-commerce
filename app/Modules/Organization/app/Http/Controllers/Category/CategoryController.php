<?php

namespace App\Modules\Organization\app\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\Modules\Organization\app\DTO\Category\CategoryDto;
use App\Modules\Organization\app\Http\Request\Category\StoreCategoryRequest;
use App\Modules\Organization\app\Http\Request\Category\UpdateCategoryRequest;
use App\Modules\Organization\app\Models\Category\Category;
use App\Modules\Organization\app\Models\Option\Option;
use App\Modules\Organization\app\Services\Category\CategoryService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function __construct(protected CategoryService $service) {}

    public function index(Request $request)
    {
        $query = Category::query()
            ->whereNull('parent_id')
            ->where('organization_id', auth('organization_employee')->user()->organization_id);

        if ($request->filled('search')) {
            $query->whereTranslationLike('name', '%'.$request->search.'%');
        }

        $categories = $query->latest()->paginate(10);

        if ($request->ajax()) {
            return view('organization::dashboard.categories.partials._table', compact('categories'))->render();
        }

        return view('organization::dashboard.categories.index', compact('categories'));
    }

    public function create(Request $request)
    {

        $parent_id = $request->get('parent_id');
        if (isset($parent_id)) {
            $parents = Category::where('organization_id', auth('organization_employee')->user()->organization_id)
                ->get();
        } else {
            $parents = Category::whereNull('parent_id')
                ->where('organization_id', auth('organization_employee')->user()->organization_id)
                ->get();
        }

        return view('organization::dashboard.categories.single', compact('parents', 'parent_id'));
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
        $parents = Category::where('organization_id', auth('organization_employee')->user()->organization_id)
            ->where('id', '!=', $category->id)->get();
        $parent_id = $category->parent_id;

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

    public function subcategories(Request $request, $parentId)
    {
        $parent = Category::findOrFail($parentId);

        $query = Category::where('parent_id', $parentId)
            ->where('organization_id', auth('organization_employee')->user()->organization_id)
            ->with('translations');

        if ($request->has('search') && ! empty($request->search)) {
            $search = $request->search;
            $query->whereTranslationLike('name', "%{$search}%");
        }

        $subCategories = $query->latest()->paginate(10)->appends(['search' => $request->search]);

        if ($request->ajax()) {
            return view('organization::dashboard.categories.partials._sub_table', compact('subCategories'))->render();
        }

        return view('organization::dashboard.categories.subcategories', compact('parent', 'subCategories'));
    }


    // في CategoryController
    public function getChildren($id)
    {
        $children = Category::where('parent_id', $id)
            ->withCount('children') // مهم جداً
            ->get();

        return response()->json($children);
    }

    public function getRoots()
    {
        $categories = Category::whereNull('parent_id')
            ->withCount('children')
            ->get();

        return response()->json($categories);
    }

    public function getCategoryPath($id)
    {
        $category = Category::find($id);
        if (!$category) {
            return response()->json([]);
        }

        $path = [];
        $current = $category;

        // Build path from child to parent
        while ($current) {
            array_unshift($path, [
                'id' => $current->id,
                'name' => $current->name
            ]);
            $current = $current->parent;
        }

        return response()->json($path);
    }


    public function getCategoryOptions($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json(['option_ids' => []]);
        }

        // جلب التصنيف الحالي + كل الأبناء والأحفاد
        $categoryIds = [$id];
        $categoryIds = array_merge($categoryIds, $category->allSubCategories()->pluck('id')->toArray());

        // جلب الـ Options (مش الـ Items) المرتبطة بالتصنيفات دي
        $optionIds = Option::query()
            ->whereIn('category_id', $categoryIds)
            ->pluck('id')
            ->unique()
            ->toArray();

        return response()->json([
            'option_ids' => $optionIds,
            'category_ids' => $categoryIds
        ]);
    }
}
