@extends('dashboard.master')
@section('title', isset($country) ? __('keys.edit_country') : __('keys.add_country'))

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <strong
                            class="card-title">{{ isset($country) ? __('keys.edit_country') : __('keys.add_country') }}</strong>
                    </div>
                    <div class="card-body">
                        @include('dashboard.country.form', [
                            'route' => isset($country)
                                ? url("admin/countries/$country->id")
                                : route('admin.countries.store'),
                            'country' => $country ?? null,
                            'method' => isset($country) ? 'PUT' : 'POST',
                        ])
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
