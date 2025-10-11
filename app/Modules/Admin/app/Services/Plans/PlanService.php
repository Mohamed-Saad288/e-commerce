<?php

namespace App\Modules\Admin\app\Services\Plans;

use App\Modules\Admin\app\Models\Plans\Plan;
use App\Modules\Base\app\DTO\DTOInterface;
use App\Modules\Base\app\Services\BaseService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PlanService extends BaseService
{
    public function __construct()
    {
        parent::__construct(resolve(Plan::class));
    }

    public function store(DTOInterface $dto): Model
    {
        return DB::transaction(function () use ($dto) {
            /** @var Plan $plan */
            $plan = parent::store($dto);

            $features = $dto->toArray()['features'] ?? [];
            if (! empty($features)) {
                $plan->features()->sync($features);
            }

            return $plan;
        });
    }

    /**
     * Update plan with features inside a transaction
     */
    public function update(Model $model, DTOInterface $dto): Model
    {
        return DB::transaction(function () use ($model, $dto) {
            /** @var Plan $model */
            $model = parent::update($model, $dto);

            $features = $dto->toArray()['features'] ?? [];
            $model->features()->sync($features);

            return $model;
        });
    }

    public function delete(Model $model): bool
    {
        /** @var Plan $model */
        $model->features()->detach();

        return parent::delete($model);
    }
}
