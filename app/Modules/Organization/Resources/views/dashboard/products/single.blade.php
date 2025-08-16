@extends('organization::dashboard.master')
@section('title', isset($product) ? __('messages.edit_product') : __('messages.add_product'))

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <strong class="card-title">{{ isset($feature) ? __('messages.edit_product') : __('messages.add_product') }}</strong>
                    </div>
                    <div class="card-body">
                        @include('organization::dashboard.products.form', [
                            "route" => isset($product) ?  route('organization.products.update', ['product' => $product->id]) : route('organization.brands.store') ,
                            "product" => $product ?? null,
                            "method" => isset($product) ? "PUT" : "POST"
                        ])
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
