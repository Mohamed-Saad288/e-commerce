<?php

namespace App\Modules\Admin\app\Http\Controllers\Plans;

use App\Http\Controllers\Controller;
use App\Modules\Admin\app\DTO\Plans\FeatureDto;
use App\Modules\Admin\app\Http\Request\Admin\UpdateAdminRequest;
use App\Modules\Admin\app\Http\Request\Feature\StoreFeatureRequest;
use App\Modules\Admin\app\Http\Request\Feature\UpdateFeatureRequest;
use App\Modules\Admin\app\Models\Feature\Feature;
use App\Modules\Admin\app\Services\Plans\FeatureService;
use App\Modules\Admin\Enums\Feature\FeatureTypeEnum;
use Exception;

class FeaturesController extends Controller
{
    public function __construct(protected FeatureService $service){}

    public function index()
    {
        $features = $this->service->index();
        return view('admin::dashboard.features.index', get_defined_vars());
    }
    public function create()
    {
        $types = FeatureTypeEnum::cases();
        return view('admin::dashboard.features.single',get_defined_vars());
    }
    public function store(StoreFeatureRequest $request)
    {
         $this->service->store(FeatureDto::fromArray($request));
        return to_route('admin.features.index')->with(array(
            'message' => __("messages.success"),
            'alert-type' => 'success'
        ));
    }
    public function edit(Feature $feature)
    {
        $types = FeatureTypeEnum::cases();

        return view('admin::dashboard.features.single', get_defined_vars());
    }
    public function update(UpdateFeatureRequest $request , Feature $feature)
    {
        $this->service->update(model: $feature, dto: FeatureDto::fromArray($request));
    }
    public function destroy(Feature $feature)
    {
        try {
            $this->service->delete(model: $feature);
            return response()->json([
                'success' => true,
                'message' => __('keys.faq_deleted_successfully')
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('keys.something_wrong')
            ], 500);
        }
    }

    public function changeStatus(Feature $feature)
    {
        $this->service->toggleStatus($feature);

        return response()->json([
            'success' => true,
            'message' => __('keys.status_updated')
        ]);
    }


}
