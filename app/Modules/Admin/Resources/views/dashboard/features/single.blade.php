@extends('admin::dashboard.master')
@section('title', isset($feature) ? __('keys.edit_feature') : __('keys.add_feature'))

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <strong class="card-title">{{ isset($feature) ? __('keys.edit_feature') : __('keys.add_feature') }}</strong>
                    </div>
                    <div class="card-body">
                        @include('admin::dashboard.features.form', [
                            "route" => isset($feature) ?  route('admin.features.update', ['feature' => $feature->id]) : route('admin.features.store') ,
                            "feature" => $feature ?? null,
                            "method" => isset($feature) ? "PUT" : "POST"
                        ])
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
