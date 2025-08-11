<?php

namespace App\Modules\Admin\app\Http\Controllers\Plans;

use App\Http\Controllers\Controller;
use App\Modules\Admin\app\DTO\Plans\PlanDto;
use App\Modules\Admin\app\Http\Request\Plan\StorePlanRequest;
use App\Modules\Admin\app\Http\Request\Plan\UpdatePlanRequest;
use App\Modules\Admin\app\Models\Plans\Plan;
use App\Modules\Admin\app\Services\Plans\FeatureService;
use App\Modules\Admin\app\Services\Plans\PlanService;
use App\Modules\Admin\Enums\Plan\BillingTypeEnum;
use Exception;
use Illuminate\Http\Request;

class PlansController extends Controller
{
    public function __construct(protected PlanService $service)
    {
    }

    public function index()
    {
        $plans = $this->service->index();
        return view('admin::dashboard.plans.index', get_defined_vars());
    }

    public function create()
    {
        $types = BillingTypeEnum::cases();
        $features = (new FeatureService())->list();

        return view('admin::dashboard.plans.single', get_defined_vars());
    }

    public function store(StorePlanRequest $request)
    {
        $this->service->store(PlanDto::fromArray($request));
        return to_route('admin.plans.index')->with(array(
            'message' => __("messages.success"),
            'alert-type' => 'success'
        ));
    }

    public function edit(Plan $plan)
    {
        $types = BillingTypeEnum::cases();

        return view('admin::dashboard.plans.single', get_defined_vars());
    }

    public function update(UpdatePlanRequest $request, Plan $plan)
    {
        $this->service->update(model: $plan, dto: PlanDto::fromArray($request));

        return to_route('admin.plans.index')->with(array(
            'message' => __("messages.updated"),
            'alert-type' => 'success'
        ));
    }

    public function destroy(Plan $plan)
    {
        try {
            $this->service->delete(model: $plan);
            return response()->json([
                'success' => true,
                'message' => __('keys.deleted')
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('keys.something_wrong')
            ], 500);
        }
    }

    public function changeStatus(Plan $plan)
    {
        $this->service->toggleStatus($plan);

        return response()->json([
            'success' => true,
            'message' => __('messages.status_updated')
        ]);
    }
}
