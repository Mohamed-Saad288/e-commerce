<?php

namespace App\Modules\Base\app\Services;

use App\Modules\Base\app\DTO\DTOInterface;
use App\Modules\Base\app\Response\DataSuccess;
use App\Modules\Base\Enums\ActiveEnum;
use App\Modules\Base\Traits\Filterable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class BaseService
{
    use Filterable;

    protected bool $cacheEnabled = false;

    protected string $cacheKeyPrefix = '';
    protected ?string $resourceClass = null;
    protected string $successMessage = 'messages.data_retrieved_successfully';

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
    public function find(int $id): Model|DataSuccess|null
    {
        $result = $this->model->query()->with($this->withRelations())->find($id);
        if ($this->resourceClass) {
            $resource = ($this->resourceClass)::make($result);
            return new DataSuccess(
                data: $resource,
                status: true,
                message: __($this->successMessage)
            );
        }
        return $result;
    }

    /**
     * Get records with optional pagination and filtering via Pipeline
     */
    public function index($request = null, bool $paginate = false): Collection|LengthAwarePaginator|DataSuccess
    {
        $cacheKey = $this->cacheKeyPrefix . 'index:' . md5(json_encode($request?->all()));

        if ($this->cacheEnabled && Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }
        $query = $this->baseQuery($request);

        $query = $this->applyFilters($query, $this->filters($request));

        if (!$this->isDashboardRequest()) {
            $query->where('is_active', ActiveEnum::ACTIVE->value);
        }

        $result = $paginate || (isset($request) && $request->has('with_pagination') && filled(
                $request->with_pagination
            ))
            ? $query->paginate($request->per_page ?? 10)
            : $query->get();

        if ($this->cacheEnabled) {
            Cache::put($cacheKey, $result, now()->addMinutes(10));
        }

        if ($this->resourceClass) {
            $resource = $paginate || filled($request?->with_pagination)
                ? ($this->resourceClass)::collection($result)->response()->getData(true)
                : ($this->resourceClass)::collection($result);

            return new DataSuccess(
                data: $resource,
                status: true,
                message: __($this->successMessage)
            );
        }

        return $result;
    }

    /**
     * List only active records
     */
    public function list($request = null): Collection
    {
        $query = $this->model::query()
            ->where('is_active', ActiveEnum::ACTIVE->value)
            ->latest()
            ->with($this->withRelations());
        if (filled($request->limit)) {
            $query->limit($request->limit);
        }

        $query = $this->applyFilters($query, $this->filters());

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

    /**
     * تحديد العلاقات اللي يتم تحميلها مع الـ Query
     */
    protected function withRelations(): array
    {
        return [];
    }

    protected function isDashboardRequest(): bool
    {
        return request()->is('admin/*') || request()->routeIs('organization.*');
    }

    protected function baseQuery($request = null)
    {
        return $this->model::query()
            ->latest()
            ->with($this->withRelations());
    }
}
