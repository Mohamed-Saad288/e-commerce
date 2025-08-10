@extends('admin::dashboard.master')
@section('title', isset($admin) ? __('messages.edit_admin') : __('messages.name'))

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <strong
                            class="card-title">{{ isset($admin) ? __('messages.edit_admin') : __('messages.add_admin') }}</strong>
                    </div>
                    <div class="card-body">
                        @include('admin::dashboard.admins.form', [
                            "route" => isset($admin) ? route("admin.admins.update" , ["admin" => $admin->id ]) :
                            route('admin.admins.store'),
                            "admin" => $admin ?? null,
                            "method" => isset($admin) ? "PUT" : "POST",
                            "fields" => $fields
                        ])
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
