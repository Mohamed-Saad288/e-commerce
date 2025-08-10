<?php

namespace App\Modules\Admin\app\Http\Controllers\Plans;

use App\Http\Controllers\Controller;
use App\Modules\Admin\app\DTO\Admin\AdminDto;
use App\Modules\Admin\app\Http\Request\Admin\StoreAdminRequest;
use App\Modules\Admin\app\Http\Request\Admin\UpdateAdminRequest;
use App\Modules\Admin\app\Services\Admin\AdminService;

class PlansController extends Controller
{
    public function __construct(protected AdminService $service){}
    public function index()
    {
        $admins = $this->service->getAdmins();
        return view('admin::dashboard.admins.index', compact('admins'));
    }
    public function create()
    {
        return view('admin::dashboard.admins.create');
    }
    public function store(StoreAdminRequest $request)
    {
        $admin = $this->service->storeAdmin(AdminDTO::fromArray($request->validated()));
    }
    public function edit($id)
    {
        $admin = $this->service->getAdmin($id);
    }
    public function update(UpdateAdminRequest $request)
    {
        $admin = $this->service->updateAdmin(AdminDTO::fromArray($request->validated()));
    }
    public function destroy($id)
    {
        $admin = $this->service->deleteAdmin($id);
    }

    public function dashboard()
    {
        return view('admin::dashboard.index');
    }
}
