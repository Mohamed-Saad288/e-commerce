@extends('dashboard.master')
@section('title', isset($category) ? __('keys.edit_category') : __('keys.add_category'))

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <strong
                            class="card-title">{{ isset($category) ? __('keys.edit_category') : __('keys.add_category') }}</strong>
                    </div>
                    <div class="card-body">
                        <form action="{{ $category->exists ? route('admin.categories.update', $category->id) :
                                route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @if($category->exists)
                                @method('PUT')
                            @endif
                            @include('dashboard.category.form')
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
