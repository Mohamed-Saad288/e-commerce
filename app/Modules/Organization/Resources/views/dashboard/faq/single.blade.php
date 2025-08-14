@extends('dashboard.master')
@section('title', isset($faq) ? __('keys.edit_faq') : __('keys.add_faq'))

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <strong class="card-title">{{ isset($faq) ? __('keys.edit_faq') : __('keys.add_faq') }}</strong>
                    </div>
                    <div class="card-body">
                        @include('dashboard.faq.form', [
                            'route' => isset($faq) ? url("admin/faqs/$faq->id") : route('admin.faqs.store'),
                            'faq' => $faq ?? null,
                            'method' => isset($faq) ? 'PUT' : 'POST',
                        ])
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
