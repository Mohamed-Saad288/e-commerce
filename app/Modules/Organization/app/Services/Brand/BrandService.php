<?php

namespace App\Modules\Organization\app\Services\Brand;

use App\Modules\Base\app\DTO\DTOInterface;
use App\Modules\Base\app\Filters\RelationFilter;
use App\Modules\Base\app\Filters\SearchFilter;
use App\Modules\Base\app\Services\BaseService;
use App\Modules\Organization\app\Models\Brand\Brand;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BrandService extends BaseService
{
    public function __construct()
    {
        parent::__construct(resolve(Brand::class));
    }

    public function store(DtoInterface $dto): Model
    {
        return DB::transaction(function () use ($dto) {
            $data = $dto->toArray();
            if (! empty($dto->image)) {
                $data['image'] = $dto->image->store('brands', 'public');
            }
            $model = $this->model->query()->create($data);

            if (! empty($dto->image)) {
                $model->storeImages(media: $dto->image);
            }
            if (! empty($dto->categories)) {
                $model->categories()->sync($dto->categories);
            }

            return $model;
        });
    }

    public function update(Model $model, DtoInterface $dto): Model
    {
        return DB::transaction(function () use ($model, $dto) {
            $data = $dto->toArray();

            if (! empty($dto->image)) {
                $model->storeImages(media: $dto->image, update: true);
            }
            if (! empty($dto->image)) {
                if (! empty($model->image) && Storage::disk('public')->exists($model->image)) {
                    Storage::disk('public')->delete($model->image);
                }

                $data['image'] = $dto->image->store('brands', 'public');
            }

            $model->update($data);

            if (! empty($dto->categories)) {
                $model->categories()->sync($dto->categories);
            }

            return $model;
        });
    }

    public function withRelations(): array
    {
        return ['productVariations'];
    }

    public function filters($request = null): array
    {
        return [
            (new SearchFilter($request))->setSearchable(['name', 'description', 'slug']),
            (new RelationFilter($request))->setRelations(['categories' => ['key' => 'category_id', 'column' => 'categories.id', 'operator' => '=']]),
        ];
    }
}
