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
    public function updateAdmin(DTOInterface $dto)
    {
        $admin = Admin::find($dto->id);
        $admin->update($dto->toArray());
        return $admin;
    }
    public function getAdmin($id)
    {
        return Admin::find($id);
    }
    public function deleteAdmin($id)
    {
        return Admin::find($id)->delete();
    }
    public function getAdmins()
    {
        return Admin::latest()->paginate(10);
    }
}
