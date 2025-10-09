<?php

namespace App\Modules\Organization\app\Http\Controllers\products;

use App\Exports\ProductsExport;
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
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class ProductController extends Controller
{
    public function __construct(protected ProductService $service) {}

    public function index(Request $request)
    {
        $products = Product::with(['category', 'brand'])
            ->when($request->category, function ($query) use ($request) {
                return $query->where('category_id', $request->category);
            })
            ->when($request->brand, function ($query) use ($request) {
                return $query->where('brand_id', $request->brand);
            })
            ->when($request->status !== null, function ($query) use ($request) {
                return $query->where('is_active', $request->status);
            })
            ->when($request->stock_status, function ($query) use ($request) {
                if ($request->stock_status == 'in_stock') {
                    return $query->where('stock_quantity', '>', 10);
                } elseif ($request->stock_status == 'low_stock') {
                    return $query->whereBetween('stock_quantity', [1, 10]);
                } elseif ($request->stock_status == 'out_of_stock') {
                    return $query->where('stock_quantity', '<=', 0);
                }
            })
            ->latest()
            ->paginate(10);

        if ($request->ajax()) {
            return response()->json([
                'products_rows' => view('organization::dashboard.products.products_rows', compact('products'))->render(),
                'pagination' => $products->appends(request()->query())->links()->toHtml(),
            ]);
        }

        $categories = Category::query()->get();
        $brands = Brand::query()->get();

        return view('organization::dashboard.products.index', get_defined_vars());
    }

    public function create()
    {
        $categories = Category::query()->get();
        $brands = Brand::query()->get();
        $options = Option::query()->get();

        return view('organization::dashboard.products.single', get_defined_vars());
    }

    public function store(StoreProductRequest $request)
    {
        $this->service->store(ProductDto::fromArray($request));

        return to_route('organization.products.index')->with([
            'message' => __('messages.success'),
            'alert-type' => 'success',
        ]);
    }

    public function show(Product $product)
    {
        return view('organization::dashboard.products.show', get_defined_vars());
    }

    public function edit(Product $product)
    {
        $categories = Category::query()->get();
        $brands = Brand::query()->get();
        $options = Option::query()->get();

        return view('organization::dashboard.products.single', get_defined_vars());
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $this->service->update(model: $product, dto: ProductDto::fromArray($request));

        return to_route('organization.products.index')->with([
            'message' => __('messages.updated'),
            'alert-type' => 'success',
        ]);
    }

    public function destroy(Product $Product)
    {
        try {
            $this->service->delete(model: $Product);

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

    public function changeStatus(Product $product)
    {
        $this->service->toggleStatus(model: $product);

        return response()->json([
            'success' => true,
            'message' => __('messages.status_updated'),
        ]);
    }

    public function export(Request $request)
    {
        $type = $request->get('type', 'excel');

        $products = Product::with(['category', 'brand'])
            ->when($request->category, function ($query) use ($request) {
                return $query->where('category_id', $request->category);
            })
            ->when($request->brand, function ($query) use ($request) {
                return $query->where('brand_id', $request->brand);
            })
            ->when($request->status !== null, function ($query) use ($request) {
                return $query->where('is_active', $request->status);
            })
            ->when($request->stock_status, function ($query) use ($request) {
                if ($request->stock_status == 'in_stock') {
                    return $query->where('stock_quantity', '>', 10);
                } elseif ($request->stock_status == 'low_stock') {
                    return $query->whereBetween('stock_quantity', [1, 10]);
                } elseif ($request->stock_status == 'out_of_stock') {
                    return $query->where('stock_quantity', '<=', 0);
                }
            })
            ->latest()
            ->get();

        // Check if there are products to export
        if ($products->isEmpty()) {
            return response()->json([
                'error' => __('organizations.no_data_to_export'),
            ], 404);
        }

        try {
            if ($type === 'csv') {
                return Excel::download(new ProductsExport($products), 'products.csv');
            } elseif ($type === 'pdf') {
                $pdf = PDF::loadView('organization::dashboard.products.export_pdf', compact('products'));

                return $pdf->download('products.pdf');
            } else {
                return Excel::download(new ProductsExport($products), 'products.xlsx');
            }
        } catch (\Exception $e) {
            return response()->json([
                'error' => __('organizations.export_error'),
            ], 500);
        }
    }
}
