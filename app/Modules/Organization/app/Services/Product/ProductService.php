<?php

namespace App\Modules\Organization\app\Services\Product;

use App\Modules\Base\app\Services\BaseService;
use App\Modules\Organization\app\Models\Product\Product;

class ProductService extends BaseService
{

    public function __construct()
    {
        parent::__construct(resolve(Product::class));
    }
}
