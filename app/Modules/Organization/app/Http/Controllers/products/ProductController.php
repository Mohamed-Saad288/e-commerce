<?php

namespace App\Modules\Organization\app\Http\Controllers\products;

use App\Http\Controllers\Controller;
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


    public function index()
    {
        $products = $this->service->index();
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
        dd($request->all());
//        $this->service->store(ProductDto::fromArray($request));
        return to_route('organization.products.index')->with(array(
            'message' => __("messages.success"),
            'alert-type' => 'success'
        ));
    }

    public function edit(Product $Product)
    {
        $categories = Product::whereOrganizationId(auth()->user()->organization_id)->get();
        return view('organization::dashboard.products.single', get_defined_vars());
    }

    public function update(UpdateProductRequest $request, Product $Product)
    {
        $this->service->update(model: $Product, dto: ProductDto::fromArray($request));

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
}
