@extends('dashboard.master')
@section('title', isset($testimonial) ? __('keys.edit_testimonial') : __('keys.add_testimonial'))

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <strong
                            class="card-title">{{ isset($testimonial) ? __('keys.edit_testimonial') : __('keys.add_testimonial') }}</strong>
                    </div>
                    <div class="card-body">
                        @include('dashboard.testimonial.form', [
                            'route' => isset($testimonial)
                                ? route('admin.testimonials.update', ['testimonial' => $testimonial->id])
                                : route('admin.testimonials.store'),
                            'testimonial' => $testimonial ?? null,
                            'method' => isset($testimonial) ? 'PUT' : 'POST',
                        ])
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
