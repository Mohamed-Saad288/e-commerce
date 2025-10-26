<?php

namespace App\Modules\Organization\app\Http\Controllers\Brand;

use App\Http\Controllers\Controller;
use App\Modules\Organization\app\DTO\Brand\BrandDto;
use App\Modules\Organization\app\Http\Request\Brand\StoreBrandRequest;
use App\Modules\Organization\app\Http\Request\Brand\UpdateBrandRequest;
use App\Modules\Organization\app\Models\Brand\Brand;
use App\Modules\Organization\app\Models\Category\Category;
use App\Modules\Organization\app\Services\Brand\BrandService;
use Exception;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function __construct(protected BrandService $service) {}

    public function index(Request $request)
    {
        $query = Brand::whereOrganizationId(auth('organization_employee')->user()->organization_id);
        if ($request->filled('search')) {
            $query->whereTranslationLike('name', '%'.$request->search.'%');
        }

        $brands = $query->latest()->paginate(10);

        if ($request->ajax()) {
            return view('organization::dashboard.brands.partials.table', compact('brands'))->render();
        }

        return view('organization::dashboard.brands.index', compact('brands'));
    }

    public function create()
    {
        $categories = Category::whereOrganizationId(auth()->user()->organization_id)->get();

        return view('organization::dashboard.brands.single', get_defined_vars());
    }

    public function store(StoreBrandRequest $request)
    {
        $this->service->store(BrandDto::fromArray($request));

        return to_route('organization.brands.index')->with([
            'message' => __('messages.success'),
            'alert-type' => 'success',
        ]);
    }

    public function edit(Brand $brand)
    {
        $categories = Category::whereOrganizationId(auth()->user()->organization_id)->get();

        return view('organization::dashboard.brands.single', get_defined_vars());
    }

    public function update(UpdateBrandRequest $request, Brand $brand)
    {
        $dto = BrandDto::fromArray($request);
        $brand = $this->service->update(model: $brand, dto: $dto);

        return to_route('organization.brands.index')->with([
            'message' => __('messages.updated'),
            'alert-type' => 'success',
        ]);
    }

    public function destroy(Brand $brand)
    {
        try {
            $this->service->delete(model: $brand);

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
