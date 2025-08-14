@extends("dashboard.master")
@section('title', isset($employee) ? __('keys.edit_supervisor') : __('keys.add_supervisor'))

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <strong
                            class="card-title">{{ isset($employee) ? __('keys.edit_supervisor') : __('keys.add_supervisor') }}</strong>
                    </div>
                    <div class="card-body">
                        @include('dashboard.employees.form', [
                            "route" => isset($employee) ? route("admin.employees.update" , ["employee" => $employee->id ]) :
                            route('admin.employees.store'),
                            "employee" => $employee ?? null,
                            "method" => isset($employee) ? "PUT" : "POST",
                            "fields" => $fields
                        ])
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
