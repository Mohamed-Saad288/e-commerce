<?php

namespace App\Modules\Organization\app\Services\Category;

use App\Modules\Base\app\Filters\CategoryIdFilter;
use App\Modules\Base\app\Services\BaseService;
use App\Modules\Organization\app\Models\Category\Category;

class CategoryService extends BaseService
{
    public function __construct()
    {
        parent::__construct(resolve(Category::class));
    }
}
