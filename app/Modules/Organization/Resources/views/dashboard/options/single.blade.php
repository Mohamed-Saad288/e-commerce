@extends('organization::dashboard.master')
@section('title', isset($option) ? __('organizations.edit_option') : __('organizations.add_option'))

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <strong
                            class="card-title">{{ isset($option) ? __('organizations.edit_option') : __('organizations.add_option') }}</strong>
                    </div>
                    <div class="card-body">
                        <form action="{{ isset($option) ? route('organization.options.update', $option->id) :
                                route('organization.options.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @if(isset($option))
                                @method('PUT')
                            @endif
                            @include('organization::dashboard.options.form')
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
