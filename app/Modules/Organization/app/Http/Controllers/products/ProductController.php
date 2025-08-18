<?php

namespace App\Modules\Organization\app\Http\Controllers\products;

use App\Http\Controllers\Controller;
use App\Modules\Organization\app\DTO\Product\ProductDto;
use App\Modules\Organization\app\Http\Request\Product\StoreProductRequest;
use App\Modules\Organization\app\Http\Request\Product\UpdateProductRequest;
use App\Modules\Organization\app\Models\Brand\Brand;
use App\Modules\Organization\app\Models\Category\Category;
use App\Modules\Organization\app\Models\Option\Option;
use App\Modules\Organization\app\Models\Product\Product;
use App\Modules\Organization\app\Services\Product\ProductService;
use Exception;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function __construct(protected ProductService $service)
    {
    }

    public function index(Request $request)
    {
        $categories = Category::where('organization_id', auth('organization_employee')->id())
            ->get();
        $brands = Brand::where('organization_id', auth('organization_employee')->id())
            ->get();
//        $products = $this->service->index();

        $products = Product::query()
            ->when($request->name, function($query, $name) {
                $query->where('name', 'like', "%{$name}%");
            })
            ->when($request->sku, function($query, $sku) {
                $query->where('sku', 'like', "%{$sku}%");
            })
            ->when($request->category, function($query, $categoryId) {
                $query->where('category_id', $categoryId);
            })
            ->when($request->brand, function($query, $brandId) {
                $query->where('brand_id', $brandId);
            })
            ->when(isset($request->status), function($query) use ($request) {
                $query->where('is_active', $request->status);
            })
            ->paginate(10);
        return view('organization::dashboard.products.index', get_defined_vars());
    }

    public function create()
    {
        $categories = Category::whereOrganizationId(auth()->user()->organization_id)->get();
        $brands = Brand::whereOrganizationId(auth()->user()->organization_id)->get();
        $options = Option::whereOrganizationId(auth()->user()->organization_id)->get();

        return view('organization::dashboard.products.single', get_defined_vars());
    }

    public function store(StoreProductRequest $request)
    {
        $this->service->store(ProductDto::fromArray($request));
        return to_route('organization.products.index')->with(array(
            'message' => __("messages.success"),
            'alert-type' => 'success'
        ));
    }


    public function show(Product $Product)
    {
        return view('organization::dashboard.products.show', compact('Product'));
    }

    public function edit(Product $product)
    {
        $categories = Category::whereOrganizationId(auth()->user()->organization_id)->get();
        $brands = Brand::whereOrganizationId(auth()->user()->organization_id)->get();
        $options = Option::whereOrganizationId(auth()->user()->organization_id)->get();
        return view('organization::dashboard.products.single', get_defined_vars());
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $this->service->update(model: $product, dto: ProductDto::fromArray($request));

        return to_route('organization.products.index')->with(array(
            'message' => __("messages.updated"),
            'alert-type' => 'success'
        ));
    }

    public function destroy(Product $Product)
    {
        try {
            $this->service->delete(model: $Product);
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


    public function changeStatus(Product $product)
    {
        $this->service->toggleStatus(model: $product);
        return response()->json([
            'success' => true,
            'message' => __('messages.status_updated')
        ]);
    }

}
