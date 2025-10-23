<?php

namespace App\Modules\Organization\app\Services\Employee;

use App\Modules\Admin\app\Models\Employee\Employee;
use App\Modules\Base\app\DTO\DTOInterface;

class EmployeeService
{
    public function storeEmployee(DTOInterface $dto)
    {
        return Employee::create($dto->toArray());
    }

    public function updateEmployee($employee, DTOInterface $dto)
    {
        $employee->update($dto->toArray());

        return $employee;
    }

    public function getEmployee($id)
    {
        return Employee::find($id);
    }

    public function deleteEmployee($employee)
    {
        return $employee->delete();
    }

    public function getEmployees()
    {
        return Employee::where('organization_id', auth()->user()->organization_id)->latest()->paginate(10);
    }

    public function searchEmployees(?string $search = null)
    {
        return Employee::query()
            ->when($search, function ($query, $search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%");
                });
            });
    }
}
