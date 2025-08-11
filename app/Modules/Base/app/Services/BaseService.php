<?php

namespace App\Modules\Base\app\Services;

use App\Modules\Base\app\DTO\DTOInterface;
use App\Modules\Base\app\Models\BaseModel;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class BaseService
{

    public function __construct(protected Model $model)
    {
    }
    public function store(DtoInterface $dto): Model
    {
        return $this->model->query()->create($dto->toArray());
    }

    public function update(Model $model, DtoInterface $dto): Model
    {
        $model->update($dto->toArray());
        return $model;
    }

    public function delete(Model $model): bool
    {
        return $model->delete();
    }

    public function find(int $id): ?Model
    {
        return $this->model->query()->find($id);
    }

    public function index($query = "paginate",$request = null) : Collection|LengthAwarePaginator
    {
        $model = $this->model::query()->latest();
        return $query == "paginate" ? $model->paginate($request->per_page ?? 10) : $model->get();
    }

    public function list(): Collection
    {
<<<<<<< HEAD
<<<<<<< HEAD
        return $this->model->query()->where("is_active", 1)->latest()->get();
=======
        return $this->model->query()->get();
>>>>>>> ee0ac67 (FullFeatureCrud)
=======
        return $this->model->query()->where("is_active", 1)->latest()->get();
>>>>>>> ad9d159 (featurePlans)
    }

    public function toggleStatus(?BaseModel $model = null): void
    {
        $model->toggleActivation();
    }

}
