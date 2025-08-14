@extends("dashboard.master")
@section('title', isset($setting) ? __('setting.edit_setting') : __('setting.add_setting'))

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <strong
                            class="card-title">{{ isset($setting) ? __('setting.edit_setting') : __('seo.add_setting') }}</strong>
                    </div>
                    <div class="card-body">
                        @include('dashboard.settings.form', [
                            "route" => isset($setting) ? route("admin.settings.update" , ["setting" =>$setting->id ]) : route('admin.settings.store'),
                            "setting" => $setting ?? null,
                            "method" => isset($setting) ? "PUT" : "POST",
                            "fields" => $fields
                        ])
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
