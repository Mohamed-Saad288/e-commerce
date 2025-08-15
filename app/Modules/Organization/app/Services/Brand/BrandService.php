<?php

namespace App\Modules\Organization\app\Services\Brand;

use App\Modules\Base\app\DTO\DTOInterface;
use App\Modules\Base\app\Services\BaseService;
use App\Modules\Organization\app\Models\Brand\Brand;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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
            $model = $this->model->query()->create($data);

            if (!empty($dto->image)) {
                $model->storeImages(media: $dto->image);
            }
            if (!empty($dto->categories)) {
                $model->categories()->sync($dto->categories);
            }

            return $model;
        });
    }
    public function update(Model $model, DtoInterface $dto): Model
    {
        return DB::transaction(function () use ($model, $dto) {
            $data = $dto->toArray();
            $model->update($data);

            if (!empty($dto->image)) {
                $model->storeImages(media: $dto->image, update: true);
            }
            if (!empty($dto->categories)) {
                $model->categories()->sync($dto->categories);
            }

            return $model;
        });
    }
}
