@extends('admin::dashboard.master')
@section('title', isset($organization) ? __('messages.edit_admin') : __('messages.name'))

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
                        @include('admin::dashboard.organizations.form', [
                            "route" => isset($admin) ? route("admin.organizations.update" , ["organization" => $organization->id ]) :
                            route('admin.organizations.store'),
                            "organization" => $admin ?? null,
                            "method" => isset($admin) ? "PUT" : "POST",
                            "fields" => $fields
                        ])
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
