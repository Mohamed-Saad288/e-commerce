@extends('dashboard.master')
@section('title', isset($about) ? __('about.edit_about') : __('about.add_about'))

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <strong
                            class="card-title">{{ isset($about) ? __('about.edit_about') : __('about.add_about') }}</strong>
                    </div>
                    <div class="card-body">
                        @include('dashboard.about.form', [
                            'route' => isset($about)
                                ? route('admin.abouts.update', ['about' => $about->id])
                                : route('admin.abouts.store'),
                            'about' => $about ?? null,
                            'method' => isset($about) ? 'PUT' : 'POST',
                            "type" => $type
                        ])
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
