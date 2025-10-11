<?php

namespace App\Modules\Organization\app\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Modules\Admin\app\Models\Employee\Employee;
use App\Modules\Organization\app\DTO\Employee\EmployeeDto;
use App\Modules\Organization\app\Http\Request\Employee\StoreEmployeeRequest;
use App\Modules\Organization\app\Http\Request\Employee\UpdateEmployeeRequest;
use App\Modules\Organization\app\Services\Employee\EmployeeService;
use Exception;

class EmployeeController extends Controller
{
    public function __construct(protected EmployeeService $service) {}

    public function index()
    {
        $employees = $this->service->getEmployees();

        return view('organization::dashboard.employees.index', get_defined_vars());
    }

    public function create()
    {
        $fields = [
            'name' => 'text',
            'email' => 'email',
            'phone' => 'text',
            'password' => 'password',
        ];

        return view('organization::dashboard.employees.single', get_defined_vars());
    }

    public function store(StoreEmployeeRequest $request)
    {
        $this->service->storeEmployee(EmployeeDto::fromArray($request));

        return to_route('organization.employees.index')->with([
            'message' => __('messages.success'),
            'alert-type' => 'success',
        ]);
    }

    public function edit($id)
    {
        $employee = $this->service->getEmployee($id);
        $fields = [
            'name' => 'text',
            'email' => 'email',
            'phone' => 'text',
        ];

        return view('organization::dashboard.employees.single', get_defined_vars());

    }

    public function update(Employee $employee, UpdateEmployeeRequest $request)
    {
        $this->service->updateEmployee($employee, EmployeeDTO::fromArray($request->validated()));

        return to_route('organization.employees.index')->with([
            'message' => __('messages.success'),
            'alert-type' => 'success',
        ]);
    }

    public function destroy(Employee $employee)
    {
        try {
            $this->service->deleteEmployee(employee: $employee);

            return response()->json([
                'success' => true,
                'message' => __('messages.employee_deleted_successfully'),
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('messages.something_wrong'),
            ], 500);
        }
    }
}
