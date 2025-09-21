<?php

namespace App\Modules\Base\app\Services;

use App\Modules\Admin\app\Models\Admin\Admin;
use App\Modules\Admin\app\Models\Employee\Employee;
use App\Modules\Base\app\DTO\DTOInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Pipeline\Pipeline;

class BaseService
{
    public function __construct(protected Model $model)
    {
    }

    /**
     * Store new record with transaction and media handling
     */
    public function store(DtoInterface $dto): Model
    {
        return DB::transaction(function () use ($dto) {
            $data = $dto->toArray();
            $model = $this->model->query()->create($data);

            if (!empty($dto->image)) {
                $model->storeImages(media: $dto->image);
            }

            return $model;
        });
    }

    /**
     * Update record with transaction and media handling
     */
    public function update(Model $model, DtoInterface $dto): Model
    {
        return DB::transaction(function () use ($model, $dto) {
            $data = $dto->toArray();
            $model->update($data);

            if (!empty($dto->image)) {
                $model->storeImages(media: $dto->image, update: true);
            }

            return $model;
        });
    }

    /**
     * Delete record (soft or hard depending on model)
     */
    public function delete(Model $model): bool
    {
        return $model->delete();
    }

    /**
     * Find record by id
     */
    public function find(int $id): ?Model
    {
        return $this->model->query()->find($id);
    }

    /**
     * Get records with optional pagination and filtering via Pipeline
     */
    public function index($request = null, bool $paginate = true): Collection|LengthAwarePaginator
    {
        $query = app(Pipeline::class)
            ->send($this->model::query()->latest())
            ->through($this->filters())
            ->thenReturn();

        return $paginate
            ? $query->paginate($request->per_page ?? 10)
            : $query->get();
    }

    /**
     * List only active records
     */
    public function list(): Collection
    {
        $query = app(Pipeline::class)
            ->send($this->model::query()->where("is_active", 1)->latest())
            ->through($this->filters())
            ->thenReturn();
        return $query->get();
    }

    /**
     * Toggle activation status
     */
    public function toggleStatus(Model $model): void
    {
        if (method_exists($model, 'toggleActivation')) {
            $model->toggleActivation();
        }
    }

    /**
     * Define the pipeline filters for the service
     */
    protected function filters($request = null): array
    {
        return []; // Example: [\App\Filters\NameFilter::class, \App\Filters\StatusFilter::class]
    }
}
