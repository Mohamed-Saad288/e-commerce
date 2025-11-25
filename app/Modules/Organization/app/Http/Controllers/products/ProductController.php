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
use App\Modules\Organization\app\Models\ProductVariation\ProductVariation;
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
        // Query ProductVariation instead of Product
        $query = ProductVariation::whereOrganizationId(auth('organization_employee')->user()->organization_id);

        // Search: Search variation name and SKU only (not parent product)
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->whereTranslationLike('name', '%'.$request->search.'%')
                    ->orWhere('sku', 'like', '%'.$request->search.'%')
                    ->orWhere('barcode', 'like', '%'.$request->search.'%');
            });
        }

        // Category filter: Filter by parent product's category
        if ($request->filled('category')) {
            $query->whereHas('product', function ($q) use ($request) {
                $q->where('category_id', $request->category);
            });
        }

        // Brand filter: Filter by parent product's brand
        if ($request->filled('brand')) {
            $query->whereHas('product', function ($q) use ($request) {
                $q->where('brand_id', $request->brand);
            });
        }

        // Stock status filter: Filter by variation's stock_quantity
        if ($request->filled('stock_status')) {
            if ($request->stock_status == 'in_stock') {
                $query->where('stock_quantity', '>', 10);
            } elseif ($request->stock_status == 'out_of_stock') {
                $query->where('stock_quantity', '<=', 0);
            } elseif ($request->stock_status == 'low_stock') {
                $query->where('stock_quantity', '>=', 1)->where('stock_quantity', '<=', 10);
            }
        }

        // Status filter: Filter by parent product's is_active status
        if ($request->filled('status')) {
            $query->whereHas('product', function ($q) use ($request) {
                $q->where('is_active', $request->status);
            });
        }

        // Eager load relationships
        $query->with(['product.category', 'product.brand', 'option_items.option']);

        // AJAX response for filters
        if ($request->ajax()) {
            $variations = $query->latest()->paginate(10);

            return [
                'products_rows' => view('organization::dashboard.products.products_rows', ['products' => $variations])->render(),
                'pagination' => $variations->appends($request->query())->links()->toHtml(),
            ];
        }

        // Regular page load
        $categories = Category::whereOrganizationId(auth('organization_employee')->user()->organization_id)->get();
        $brands = Brand::whereOrganizationId(auth('organization_employee')->user()->organization_id)->get();
        $products = $query->latest()->paginate(10);

        return view('organization::dashboard.products.index', compact('products', 'categories', 'brands'));
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
        $product->load(['variations.option_items', 'category', 'brand']);

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

        // Query ProductVariation with same filters as index
        $variations = ProductVariation::with(['product.category', 'product.brand', 'option_items.option'])
            ->when($request->search, function ($query) use ($request) {
                return $query->where(function ($q) use ($request) {
                    $q->whereTranslationLike('name', '%'.$request->search.'%')
                        ->orWhere('sku', 'like', '%'.$request->search.'%')
                        ->orWhere('barcode', 'like', '%'.$request->search.'%');
                });
            })
            ->when($request->category, function ($query) use ($request) {
                return $query->whereHas('product', function ($q) use ($request) {
                    $q->where('category_id', $request->category);
                });
            })
            ->when($request->brand, function ($query) use ($request) {
                return $query->whereHas('product', function ($q) use ($request) {
                    $q->where('brand_id', $request->brand);
                });
            })
            ->when($request->status !== null, function ($query) use ($request) {
                return $query->whereHas('product', function ($q) use ($request) {
                    $q->where('is_active', $request->status);
                });
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

        // Check if there are variations to export
        if ($variations->isEmpty()) {
            return response()->json([
                'error' => __('organizations.no_data_to_export'),
            ], 404);
        }

        try {
            if ($type === 'csv') {
                return Excel::download(new ProductsExport($variations), 'product_variations.csv');
            } elseif ($type === 'pdf') {
                $pdf = PDF::loadView('organization::dashboard.products.export_pdf', ['products' => $variations]);

                return $pdf->download('product_variations.pdf');
            } else {
                return Excel::download(new ProductsExport($variations), 'product_variations.xlsx');
            }
        } catch (\Exception $e) {
            return response()->json([
                'error' => __('organizations.export_error'),
            ], 500);
        }
    }
}
