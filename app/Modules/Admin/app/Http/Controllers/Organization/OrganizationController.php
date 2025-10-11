<?php

namespace App\Modules\Admin\app\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use App\Modules\Admin\app\DTO\Organization\OrganizationDto;
use App\Modules\Admin\app\Http\Request\Orgnization\StoreOrganizationRequest;
use App\Modules\Admin\app\Http\Request\Orgnization\UpdateOrganizationRequest;
use App\Modules\Admin\app\Models\Organization\Organization;
use App\Modules\Admin\app\Services\Organization\OrganizationService;
use Exception;

class OrganizationController extends Controller
{
    public function __construct(protected OrganizationService $service) {}

    public function index()
    {
        $organizations = $this->service->getOrganizations();

        return view('admin::dashboard.organizations.index', get_defined_vars());
    }

    public function create()
    {
        $fields = [
            'name' => 'text',
            'email' => 'email',
            'phone' => 'text',
            'address' => 'text',
            'website_link' => 'text',
        ];

        return view('admin::dashboard.organizations.single', get_defined_vars());
    }

    public function store(StoreOrganizationRequest $request)
    {
        $this->service->storeOrganization(OrganizationDto::fromArray($request));

        return to_route('admin.organizations.index')->with([
            'message' => __('messages.success'),
            'alert-type' => 'success',
        ]);
    }

    public function edit($id)
    {
        $admin = $this->service->getOrganization($id);
        $fields = [
            'name' => 'text',
            'email' => 'email',
            'phone' => 'text',
            'address' => 'text',
            'website_link' => 'text',
        ];

        return view('admin::dashboard.organizations.single', get_defined_vars());

    }

    public function update(Organization $organization, UpdateOrganizationRequest $request)
    {
        $this->service->updateOrganization($organization, OrganizationDto::fromArray($request->validated()));

        return to_route('admin.organizations.index')->with([
            'message' => __('messages.success'),
            'alert-type' => 'success',
        ]);
    }

    public function destroy(Organization $organization)
    {
        try {
            $this->service->deleteOrganization(organization: $organization);

            return response()->json([
                'success' => true,
                'message' => __('messages.admin_deleted_successfully'),
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('messages.something_wrong'),
            ], 500);
        }
    }
}
