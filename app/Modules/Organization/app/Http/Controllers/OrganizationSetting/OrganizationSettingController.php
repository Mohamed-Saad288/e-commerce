<?php

namespace App\Modules\Organization\app\Http\Controllers\OrganizationSetting;

use App\Http\Controllers\Controller;
use App\Modules\Organization\app\DTO\OrganizationSetting\OrganizationSettingDto;
use App\Modules\Organization\app\Http\Request\OrganizationSetting\UpdateOrganizationSettingRequest;
use App\Modules\Organization\app\Models\OrganizationSetting\OrganizationSetting;
use App\Modules\Organization\app\Services\OrganizationSetting\OrganizationSettingService;

class OrganizationSettingController extends Controller
{
    public function __construct(protected OrganizationSettingService $service)
    {
    }

    public function edit()
    {
        $organization_setting = OrganizationSetting::where('organization_id', auth()->user()->organization_id)->first(); // أو by organization_id

        return view('organization::dashboard.organization_settings.single', compact('organization_setting'));
    }

    public function update(UpdateOrganizationSettingRequest $request)
    {
        $this->service->updateOrCreateByOrganization(
            dto: OrganizationSettingDto::fromArray($request)
        );

        return to_route('organization.organization_settings.edit')->with([
            'message' => __('messages.updated'),
            'alert-type' => 'success',
        ]);
    }
}
