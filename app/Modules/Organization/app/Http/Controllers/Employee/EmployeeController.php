<?php

namespace App\Modules\Organization\app\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Modules\Admin\app\Models\Employee\Employee;
use App\Modules\Organization\app\DTO\Employee\EmployeeDto;
use App\Modules\Organization\app\Http\Request\Employee\StoreEmployeeRequest;
use App\Modules\Organization\app\Http\Request\Employee\UpdateEmployeeRequest;
use App\Modules\Organization\app\Services\Employee\EmployeeService;
use Exception;
use Illuminate\Http\Request;

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

    public function search(Request $request)
    {
        $search = $request->get('search');

        $employees = Employee::query()
            ->where('organization_id', auth('organization_employee')->user()->organization_id)
            ->when($search, function ($query, $search) {
                $query->where(function ($sub) use ($search) {
                    $sub->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%");
                });
            })
            ->get(['id', 'name', 'email', 'phone']);

        $html = view('organization::dashboard.employees.table-rows', compact('employees'))->render();

        return response()->json(['html' => $html]);
    }
}
