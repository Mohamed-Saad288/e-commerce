<?php

namespace App\Modules\Organization\app\Services\Product;

use App\Modules\Base\app\Filters\SearchFilter;
use App\Modules\Base\app\Services\BaseService;
use App\Modules\Organization\app\Models\ProductVariation\ProductVariation;

class ProductVariationService extends BaseService
{

    public function __construct()
    {
        parent::__construct(resolve(ProductVariation::class));
    }

    public function filters($request = null): array
    {
        return [
            (new SearchFilter($request))->setSearchable(["name"])->setRelations(["product" => ["description" , "short_description"]]),
        ];
    }
}
