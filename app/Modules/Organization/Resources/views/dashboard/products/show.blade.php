@extends('organization::dashboard.master')

@section('title', __('organizations.product_details'))

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                @include('organization::dashboard.products.partials._header')
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">

                        @include('organization::dashboard.products.partials._actions')

                        <div class="row">
                            <!-- Left Column -->
                            <div class="col-lg-8">
                                @include('organization::dashboard.products.partials._info')
                                @include('organization::dashboard.products.partials._description')
                            </div>

                            <!-- Right Sidebar -->
                            <div class="col-lg-4">
                                @include('organization::dashboard.products.partials._gallery')
                                @include('organization::dashboard.products.partials._stats')
                            </div>
                        </div>

                        @include('organization::dashboard.products.partials._pricing')

                        @include('organization::dashboard.products.partials._variations')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section("styles")
<style>
    .card { transition: all 0.2s; }
    .card:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(0,0,0,0.1) !important; }
    .badge { font-weight: 500; }
    .prose img { max-width: 100%; border-radius: 8px; }
</style>
@endsection
