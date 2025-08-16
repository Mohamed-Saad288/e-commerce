@extends('organization::dashboard.master')
@section('title', isset($option_item) ? __('organizations.edit_option_item') : __('organizations.add_option_item'))

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <strong
                            class="card-title">{{ isset($option_item) ? __('organizations.edit_option_item') : __('organizations.add_option_item') }}</strong>
                    </div>
                    <div class="card-body">
                        <form action="{{ isset($option_item) ? route('organization.option_items.update', $option_item->id) :
                                route('organization.option_items.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @if(isset($option_item))
                                @method('PUT')
                            @endif
                            @include('organization::dashboard.option_items.form')
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
