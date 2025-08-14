@extends('admin::dashboard.master')
@section('title', isset($plan) ? __('messages.edit_plan') : __('messages.add_plan'))

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <strong class="card-title">{{ isset($plan) ? __('messages.edit_plan') : __('messages.add_plan') }}</strong>
                    </div>
                    <div class="card-body">
                        @include('admin::dashboard.plans.form', [
                            "route" => isset($plan) ?  route('admin.plans.update', ['plan' => $plan->id]) : route('admin.plans.store') ,
                            "plan" => $plan ?? null,
                            "method" => isset($plan) ? "PUT" : "POST"
                        ])
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
