@extends('organization::dashboard.master')
@section('title', isset($category) ? __('organizations.edit_category') : __('organizations.add_category'))

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <strong
                            class="card-title">{{ isset($category) ? __('organizations.edit_category') : __('organizations.add_category') }}</strong>
                    </div>
                    <div class="card-body">
                        <form action="{{ isset($category) ? route('organization.categories.update', $category->id) :
                                route('organization.categories.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @if(isset($category))
                                @method('PUT')
                            @endif
                            @include('organization::dashboard.categories.form')
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
