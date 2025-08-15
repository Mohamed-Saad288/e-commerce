@extends('organization::dashboard.master')
@section('title', isset($brand) ? __('organizations.edit_brand') : __('organizations.add_brand'))

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <strong
                            class="card-title">{{ isset($brand) ? __('organizations.edit_brand') : __('organizations.add_brand') }}</strong>
                    </div>
                    <div class="card-body">
                        <form action="{{ isset($brand) ? route('organization.brands.update', $brand->id) :
                                route('organization.brands.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @if(isset($brand))
                                @method('PUT')
                            @endif
                            @include('organization::dashboard.brands.form')
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
