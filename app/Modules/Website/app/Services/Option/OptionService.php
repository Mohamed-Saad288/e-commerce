<?php

namespace App\Modules\Website\app\Services\Option;

use App\Modules\Base\app\Filters\RelationFilter;
use App\Modules\Base\app\Response\DataSuccess;
use App\Modules\Base\app\Services\BaseService;
use App\Modules\Base\Enums\ActiveEnum;
use App\Modules\Organization\app\Models\Option\Option;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class OptionService extends BaseService
{
    public function __construct()
    {
        parent::__construct(resolve(Option::class));
    }

    public function withRelations(): array
    {
        return ['items'];
    }

    protected function baseQuery($request = null)
    {
        return parent::baseQuery($request)
            ->whereHas('items.productVariation');
    }

    public function filters($request = null): array
    {
        return [
            (new RelationFilter($request))->setRelations(['category' => ['key' => 'category_id', 'column' => 'categories.id']]),
        ];
    }
}
