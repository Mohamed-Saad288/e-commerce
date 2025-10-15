<?php

namespace App\Modules\Organization\app\Services\Category;

use App\Modules\Base\app\Filters\SearchFilter;
use App\Modules\Base\app\Services\BaseService;
use App\Modules\Organization\app\Models\Category\Category;

class CategoryService extends BaseService
{
    public function __construct()
    {
        parent::__construct(resolve(Category::class));
    }

    public function withRelations(): array
    {
        return ["subCategories" , "parent" , "brands" , "allSubCategories" ];
    }

    public function filters($request = null): array
    {
        return [
            (new SearchFilter($request))->setSearchable(['name','description','slug']),
        ];
    }
}
