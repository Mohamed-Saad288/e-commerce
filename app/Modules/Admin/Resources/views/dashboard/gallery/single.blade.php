@extends('dashboard.master')
@section('title', isset($employee) ? __('keys.edit_Gallery') : __('keys.add_Gallery'))

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <strong
                            class="card-title">{{ isset($Gallery) ? __('keys.edit_Gallery') : __('keys.add_Gallery') }}</strong>
                    </div>
                    <div class="card-body">
                        @include('dashboard.gallery.form', [
                            'route' => isset($Gallery)
                                ? route('admin.galleries.update', ['gallery' => $Gallery->id])
                                : route('admin.galleries.store'),
                            'gallery' => $Gallery ?? null,
                            'method' => isset($Gallery) ? 'PUT' : 'POST',
                        ])
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
