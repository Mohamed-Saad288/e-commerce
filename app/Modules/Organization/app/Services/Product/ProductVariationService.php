<?php

namespace App\Modules\Organization\app\Services\Product;

use App\Modules\Base\app\Filters\ArithmeticFilter;
use App\Modules\Base\app\Filters\BooleanFilter;
use App\Modules\Base\app\Filters\RelationFilter;
use App\Modules\Base\app\Filters\SearchFilter;
use App\Modules\Base\app\Response\DataSuccess;
use App\Modules\Base\app\Services\BaseService;
use App\Modules\Organization\app\Models\ProductVariation\ProductVariation;
use App\Modules\Website\app\Http\Resources\Product\ProductVariationResource;

class ProductVariationService extends BaseService
{
    public function __construct()
    {
        parent::__construct(resolve(ProductVariation::class));
    }

    public function index($request = null, bool $paginate = false): DataSuccess
    {
        $result = parent::index($request, $paginate);

        $results = $paginate || filled($request->with_pagination)
            ? ProductVariationResource::collection($result)->response()->getData(true)
            : ProductVariationResource::collection($result);

        return new DataSuccess(
            data: $results,
            status: true,
            message: __('messages.data_retrieved_successfully')
        );
    }

    public function filters($request = null): array
    {
        return [
            (new SearchFilter($request))->setSearchable(['name'])->setRelations(['product' => ['description', 'short_description']]),
            (new RelationFilter($request))->setRelations(['category' => ['key' => 'category_id', 'column' => 'categories.id'], 'brand' => ['key' => 'brand_id', 'column' => 'brands.id']]),
            (new BooleanFilter($request))->setFilters(['sale' => ['column' => 'discount', 'true_condition' => ['>', 0], 'false_condition' => ['=', 0]], 'is_featured' => ['column' => 'is_featured']]),
            (new ArithmeticFilter($request))->setFilters(['min_price' => ['column' => 'total_price', 'operator' => '>=', 'range' => false], 'max_price' => ['column' => 'total_price', 'operator' => '<=', 'range' => false],
                'price_range' => ['column' => 'total_price', 'range' => true]]),
            (new RelationFilter($request))->setRelations(['HomeSections' => ['key' => 'home_section_id', 'column' => 'home_sections.id']]),
            (new RelationFilter($request))->setRelations(['brand' => ['key' => 'brand_id', 'column' => 'brands.id']]),
        ];
    }
}
