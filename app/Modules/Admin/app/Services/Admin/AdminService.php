<?php

namespace App\Modules\Admin\app\Services\Admin;

use App\Modules\Admin\app\Models\Admin\Admin;
use App\Modules\Base\app\DTO\DTOInterface;

class AdminService
{
    public function storeAdmin(DTOInterface $dto)
    {
        return Admin::create($dto->toArray());
    }
    public function updateAdmin($admin, DTOInterface $dto)
    {
        $admin->update($dto->toArray());
        return $admin;
    }
    public function getAdmin($id)
    {
        return Admin::find($id);
    }
    public function deleteAdmin($admin)
    {
        return $admin->delete();
    }
    public function getAdmins()
    {
        return Admin::latest()->paginate(10);
    }
}
