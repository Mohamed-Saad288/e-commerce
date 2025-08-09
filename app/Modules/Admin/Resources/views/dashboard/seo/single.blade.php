@extends('dashboard.master')
@section('title', isset($seo) ? __('seo.edit_seo') : __('seo.add_seo'))

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <strong class="card-title">{{ isset($seo) ? __('seo.edit_seo') : __('seo.add_seo') }}</strong>
                    </div>
                    <div class="card-body">
                        @include('dashboard.seo.form', [
                            'route' => isset($seo)
                                ? route('admin.seo.update', ['seo' => $seo->id])
                                : route('admin.seo.store'),
                            'seo' => $seo ?? null,
                            'method' => isset($seo) ? 'PUT' : 'POST',
                        ])
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
