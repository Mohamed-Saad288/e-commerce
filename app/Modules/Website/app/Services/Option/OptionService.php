<?php

namespace App\Modules\Website\app\Services\Option;

use App\Modules\Base\app\Filters\RelationFilter;
use App\Modules\Base\app\Services\BaseService;
use App\Modules\Organization\app\Models\Option\Option;
use Illuminate\Database\Eloquent\Model;

class OptionService extends BaseService
{
    public function __construct()
    {
        parent::__construct(resolve(Option::class));
    }

    public function withRelations(): array
    {
        return ["items"];
    }


    public function filters($request = null): array
    {
        return [
            (new RelationFilter($request))->setRelations(['category' => ['key' => 'category_id', 'column' => 'categories.id']])
        ];
    }
}
