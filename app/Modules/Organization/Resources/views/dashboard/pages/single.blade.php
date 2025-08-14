@extends('dashboard.master')
@section('title', $page->exists ? __('Page.edit_page') : __('Page.add_page'))

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <strong class="card-title">{{ $page->exists ? __('Page.edit_page') : __('Page.add_page') }}</strong>
                    </div>
                    <div class="card-body">
                        <form
                            action="{{ $page->exists ? route('admin.pages.update', $page->id) : route('admin.pages.store') }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            @if ($page->exists)
                                @method('PUT')
                            @endif
                            @include('dashboard.pages.form')
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
