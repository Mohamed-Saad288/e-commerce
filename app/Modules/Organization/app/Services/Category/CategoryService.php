<?php

namespace App\Modules\Organization\app\Services\Category;

use App\Modules\Base\app\DTO\DTOInterface;
use App\Modules\Base\app\Filters\RelationFilter;
use App\Modules\Base\app\Filters\SearchFilter;
use App\Modules\Base\app\Services\BaseService;
use App\Modules\Organization\app\Models\Category\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CategoryService extends BaseService
{
    public function __construct()
    {
        parent::__construct(resolve(Category::class));
    }

    public function withRelations(): array
    {
        return ['subCategories', 'parent', 'brands', 'allSubCategories', 'productVariations'];
    }

    public function store(DtoInterface $dto): Model
    {
        return DB::transaction(function () use ($dto) {
            $data = $dto->toArray();
            if (! empty($dto->image)) {
                $data['image'] = $dto->image->store('brands', 'public');
            }
            $model = $this->model->query()->create($data);

            return $model;
        });
    }

    public function update(Model $model, DtoInterface $dto): Model
    {
        return DB::transaction(function () use ($model, $dto) {
            $data = $dto->toArray();

            if (! empty($dto->image)) {
                $data['image'] = $dto->image->store('brands', 'public');
            }
            $model->update($data);

            return $model;
        });
    }

    public function filters($request = null): array
    {
        return [
            (new SearchFilter($request))->setSearchable(['name', 'description', 'slug']),
            (new RelationFilter($request))->setRelations(['parent' => ['key' => 'parent_id', 'column' => 'categories.parent_id', 'operator' => '=']]),
        ];
    }
}
