<?php

namespace App\Modules\Admin\app\Services\Organization;

use App\Modules\Admin\app\Models\Employee\Employee;
use App\Modules\Admin\app\Models\Organization\Organization;
use App\Modules\Base\app\DTO\DTOInterface;

class OrganizationService
{
    public function storeOrganization(DTOInterface $dto)
    {
        $organization = Organization::create($dto->toArray());
        Employee::create([
            'name' => $organization->name ?? null,
            'email' => $organization->email ?? null,
            'password' => $organization->phone ?? null,
            'phone' => $organization->phone ?? null,
            'organization_id' => $organization->id,
            'is_master' => true,
        ]);

        return $organization;
    }

    public function updateOrganization($organization, DTOInterface $dto)
    {
        $organization->update($dto->toArray());

        return $organization;
    }

    public function getOrganization($id)
    {
        return Organization::find($id);
    }

    public function deleteOrganization($organization)
    {
        return $organization->delete();
    }

    public function getOrganizations()
    {
        return Organization::latest()->paginate(10);
    }
}
