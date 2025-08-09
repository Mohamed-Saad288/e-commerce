@extends("dashboard.master")
@section('title', isset($user) ? __('keys.edit_user') : __('keys.add_user'))

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <strong
                            class="card-title">{{ isset($user) ? __('keys.edit_user') : __('keys.add_user') }}</strong>
                    </div>
                    <div class="card-body">
                        @include('dashboard.user.form', [
                            "route" => isset($user) ? route("admin.users.update" , ["user" => $user->id ]) :
                            route('admin.users.store'),
                            "user" => $user ?? null,
                            "method" => isset($user) ? "PUT" : "POST",
                            "fields" => $fields
                        ])
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
