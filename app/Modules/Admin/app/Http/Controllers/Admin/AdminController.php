<?php

namespace App\Modules\Admin\app\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Modules\Admin\app\DTO\Admin\AdminDto;
use App\Modules\Admin\app\Http\Request\Admin\StoreAdminRequest;
use App\Modules\Admin\app\Http\Request\Admin\UpdateAdminRequest;
use App\Modules\Admin\app\Models\Admin\Admin;
use App\Modules\Admin\app\Services\Admin\AdminService;
use Exception;

class AdminController extends Controller
{
    public function __construct(protected AdminService $service)
    {
    }

    public function index()
    {
        $admins = $this->service->getAdmins();

        return view('admin::dashboard.admins.index', get_defined_vars());
    }

    public function create()
    {
        $fields = [
            'name' => 'text',
            'email' => 'email',
            'phone' => 'text',
            'password' => 'password',
        ];

        return view('admin::dashboard.admins.single', get_defined_vars());
    }

    public function store(StoreAdminRequest $request)
    {
        $this->service->storeAdmin(AdminDto::fromArray($request));

        return to_route('admin.admins.index')->with([
            'message' => __('messages.success'),
            'alert-type' => 'success',
        ]);
    }

    public function edit($id)
    {
        $admin = $this->service->getAdmin($id);
        $fields = [
            'name' => 'text',
            'email' => 'email',
            'phone' => 'text',
        ];

        return view('admin::dashboard.admins.single', get_defined_vars());

    }

    public function update(Admin $admin, UpdateAdminRequest $request)
    {
        $this->service->updateAdmin($admin, AdminDTO::fromArray($request->validated()));

        return to_route('admin.admins.index')->with([
            'message' => __('messages.success'),
            'alert-type' => 'success',
        ]);
    }

    public function destroy(Admin $admin)
    {
        try {
            $this->service->deleteAdmin(admin: $admin);

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

    public function dashboard()
    {
        return view('admin::dashboard.index');
    }
}
