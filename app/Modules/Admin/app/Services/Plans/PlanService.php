<?php

namespace App\Modules\Admin\app\Services\Plans;

use App\Modules\Admin\app\Models\Plans\FeaturePlan;
use App\Modules\Admin\app\Models\Plans\Plan;
use App\Modules\Base\app\DTO\DTOInterface;
use App\Modules\Base\app\Services\BaseService;
use Illuminate\Support\Facades\DB;

class PlanService extends BaseService
{

    public function __construct()
    {
        parent::__construct(resolve(Plan::class));
    }

    /**
     * @throws \Throwable
     */
    public function store(DtoInterface $dto): \Illuminate\Database\Eloquent\Model
    {
        DB::beginTransaction();
        $plan =  parent::store($dto);

        $data = $dto->toArray();
        $plan->features()->sync($data["features"]);
//        foreach ($dto["features"] as $feature) {
//            FeaturePlan::query()->create([
//                'plan_id' => $plan->id,
//                'feature_id' => $feature["feature_id"],
//                "feature_value" => $feature["value"]
//            ]);
//        }
        $plan->storeImages(media: $dto->image ?? null);
        DB::commit();
        return $plan;
    }
}
