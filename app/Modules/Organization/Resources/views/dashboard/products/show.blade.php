@extends('organization::dashboard.master')
@section('title', __('organizations.product_details'))

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0">{{ __('organizations.product_details') }}</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('organization.products.index') }}">{{ __('organizations.products') }}</a>
                            </li>
                            <li class="breadcrumb-item active">{{ $product->name }}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <!-- Header with Actions -->
                        <div class="row mb-4">
                            <div class="col-lg-8">
                                <h4 class="card-title mb-2">{{ $product->name }}</h4>
                                <p class="text-muted mb-0">{{ $product->short_description ?? __('messages.no_description') }}</p>
                            </div>
                            <div class="col-lg-4 text-lg-right">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('organization.products.edit', $product->id) }}"
                                       class="btn btn-outline-primary waves-effect waves-light">
                                        <i class="fas fa-edit mr-1"></i> {{ __('messages.edit') }}
                                    </a>
                                    <a href="{{ route('organization.products.index') }}"
                                       class="btn btn-outline-secondary waves-effect">
                                        <i class="fas fa-arrow-left mr-1"></i> {{ __('messages.back') }}
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Main Content Row -->
                        <div class="row">
                            <!-- Product Info Section -->
                            <div class="col-lg-8">
                                <div class="card border shadow-none">
                                    <div class="card-body">
                                        <h5 class="font-size-14 mb-3">
                                            <i class="fas fa-info-circle text-primary mr-1"></i>
                                            {{ __('messages.product_info') }}
                                        </h5>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <table class="table table-nowrap mb-0">
                                                    <tbody>
                                                    <tr>
                                                        <th scope="row" class="w-40">{{ __('messages.name') }}:</th>
                                                        <td>{{ $product->name }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">{{ __('messages.slug') }}:</th>
                                                        <td><span class="badge badge-light">{{ $product->slug }}</span></td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">{{ __('messages.sku') }}:</th>
                                                        <td>{{ $product->sku ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">{{ __('messages.barcode') }}:</th>
                                                        <td>{{ $product->barcode ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">{{ __('organizations.category') }}:</th>
                                                        <td>
                                                            <span class="badge badge-pill badge-soft-info font-size-12">
                                                                {{ $product->category?->name ?? '-' }}
                                                            </span>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="col-md-6">
                                                <table class="table table-nowrap mb-0">
                                                    <tbody>
                                                    <tr>
                                                        <th scope="row" class="w-40">{{ __('organizations.brand') }}:</th>
                                                        <td>
                                                            <span class="badge badge-pill badge-soft-success font-size-12">
                                                                {{ $product->brand?->name ?? '-' }}
                                                            </span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">{{ __('messages.status') }}:</th>
                                                        <td>
                                                            @if($product->is_active)
                                                                <span class="badge badge-soft-success font-size-12">
                                                                    <i class="mdi mdi-check-circle-outline mr-1"></i>
                                                                    {{ __('messages.active') }}
                                                                </span>
                                                            @else
                                                                <span class="badge badge-soft-danger font-size-12">
                                                                    <i class="mdi mdi-close-circle-outline mr-1"></i>
                                                                    {{ __('messages.inactive') }}
                                                                </span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">{{ __('organizations.stock') }}:</th>
                                                        <td>
                                                            @if($product->stock_quantity > 10)
                                                                <span class="badge badge-soft-success font-size-12">
                                                                    <i class="fas fa-check-circle mr-1"></i>
                                                                    {{ __('organizations.in_stock') }} ({{ $product->stock_quantity }})
                                                                </span>
                                                            @elseif($product->stock_quantity > 0)
                                                                <span class="badge badge-soft-warning font-size-12">
                                                                    <i class="fas fa-exclamation-triangle mr-1"></i>
                                                                    {{ __('organizations.low_stock') }} ({{ $product->stock_quantity }})
                                                                </span>
                                                            @else
                                                                <span class="badge badge-soft-danger font-size-12">
                                                                    <i class="fas fa-times-circle mr-1"></i>
                                                                    {{ __('organizations.out_of_stock') }}
                                                                </span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">{{ __('messages.type') }}:</th>
                                                        <td>
                                                            @switch($product->type)
                                                                @case(1)
                                                                    <span class="badge badge-soft-primary">{{ __('organizations.physical') }}</span>
                                                                    @break
                                                                @case(2)
                                                                    <span class="badge badge-soft-info">{{ __('organizations.digital') }}</span>
                                                                    @break
                                                                @case(3)
                                                                    <span class="badge badge-soft-warning">{{ __('organizations.service') }}</span>
                                                                    @break
                                                            @endswitch
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">{{ __('messages.requires_shipping') }}:</th>
                                                        <td>
                                                            @if($product->requires_shipping)
                                                                <span class="badge badge-soft-success">{{ __('messages.yes') }}</span>
                                                            @else
                                                                <span class="badge badge-soft-secondary">{{ __('messages.no') }}</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Description Card -->
                                <div class="card border shadow-none">
                                    <div class="card-body">
                                        <h5 class="font-size-14 mb-3">
                                            <i class="fas fa-align-left text-primary mr-1"></i>
                                            {{ __('messages.description') }}
                                        </h5>
                                        <div class="text-muted">
                                            {!! $product->description ?? '<p class="mb-0">' . __('messages.no_description') . '</p>' !!}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Right Sidebar -->
                            <div class="col-lg-4">
                                <!-- Gallery Card -->
                                <div class="card border shadow-none">
                                    <div class="card-body">
                                        <h5 class="font-size-14 mb-3">
                                            <i class="fas fa-images text-primary mr-1"></i>
                                            {{ __('messages.product_images') }}
                                        </h5>

                                        @if($product->images && count($product->images) > 0)
                                            <div class="row">
                                                @foreach($product->images as $image)
                                                    <div class="col-6 mb-2">
                                                        <div class="card border mb-0">
                                                            <img src="{{ asset($image->path) }}"
                                                                 alt="{{ $product->name }}"
                                                                 class="card-img-top"
                                                                 style="height: 100px; object-fit: cover;">
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <div class="text-center py-3">
                                                <div class="avatar-sm mx-auto mb-2">
                                                    <div class="avatar-title bg-light rounded-circle text-primary">
                                                        <i class="fas fa-image font-size-16"></i>
                                                    </div>
                                                </div>
                                                <small class="text-muted">{{ __('messages.no_images') }}</small>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Quick Stats Card -->
                                <div class="card border shadow-none">
                                    <div class="card-body">
                                        <h5 class="font-size-14 mb-3">
                                            <i class="fas fa-chart-pie text-primary mr-1"></i>
                                            {{ __('messages.quick_stats') }}
                                        </h5>

                                        <div class="text-center">
                                            <div class="row">
                                                <div class="col-6 border-right">
                                                    <div class="py-2">
                                                        <h4 class="mb-1">{{ $product->variations->count() }}</h4>
                                                        <p class="text-muted mb-0">{{ __('organizations.variations') }}</p>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="py-2">
                                                        <h4 class="mb-1">{{ $product->stock_quantity }}</h4>
                                                        <p class="text-muted mb-0">{{ __('organizations.stock') }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pricing Information Section -->
                        @if($product->variations->count() > 0)
                            <div class="row mt-4">
                                <div class="col-12">
                                    <div class="card border shadow-none">
                                        <div class="card-header bg-transparent border-bottom">
                                            <h5 class="font-size-14 mb-0">
                                                <i class="fas fa-tags text-primary mr-1"></i>
                                                {{ __('messages.pricing_from_variations') }}
                                            </h5>
                                        </div>
                                        <div class="card-body">
                                            @php
                                                $minPrice = $product->variations->min('total_price');
                                                $maxPrice = $product->variations->max('total_price');
                                                $avgPrice = $product->variations->avg('total_price');
                                            @endphp

                                            <div class="row text-center">
                                                <div class="col-md-4">
                                                    <div class="py-3">
                                                        <h2 class="text-success mb-1">{{ format_price($minPrice) }}</h2>
                                                        <p class="text-muted mb-0">{{ __('messages.lowest_price') }}</p>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 border-left border-right">
                                                    <div class="py-3">
                                                        <h2 class="text-primary mb-1">{{ format_price($avgPrice) }}</h2>
                                                        <p class="text-muted mb-0">{{ __('messages.average_price') }}</p>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="py-3">
                                                        <h2 class="text-danger mb-1">{{ format_price($maxPrice) }}</h2>
                                                        <p class="text-muted mb-0">{{ __('messages.highest_price') }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="row mt-4">
                                <div class="col-12">
                                    <div class="card border shadow-none">
                                        <div class="card-header bg-transparent border-bottom">
                                            <h5 class="font-size-14 mb-0">
                                                <i class="fas fa-tag text-primary mr-1"></i>
                                                {{ __('messages.product_pricing') }}
                                            </h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <table class="table table-nowrap mb-0">
                                                        <tbody>
                                                        <tr>
                                                            <th scope="row" class="w-50">{{ __('messages.cost_price') }}:</th>
                                                            <td class="text-success font-weight-bold">{{ format_price($product->cost_price) }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">{{ __('messages.selling_price') }}:</th>
                                                            <td class="text-primary font-weight-bold">{{ format_price($product->selling_price) }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">{{ __('messages.discount') }}:</th>
                                                            <td>
                                                                @if($product->discount > 0)
                                                                    <span class="text-danger font-weight-bold">
                                                                        -{{ format_price($product->discount) }}
                                                                        @if($product->tax_type == 2)
                                                                            ({{ $product->discount }}%)
                                                                        @endif
                                                                    </span>
                                                                @else
                                                                    <span class="text-muted">-</span>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="col-md-6">
                                                    <table class="table table-nowrap mb-0">
                                                        <tbody>
                                                        <tr>
                                                            <th scope="row" class="w-50">{{ __('messages.tax') }}:</th>
                                                            <td>
                                                                @if($product->is_taxable)
                                                                    <span class="text-info">
                                                                        {{ format_price($product->tax_amount) }}
                                                                        @if($product->tax_type == 2)
                                                                            ({{ $product->tax_amount }}%)
                                                                        @endif
                                                                    </span>
                                                                @else
                                                                    <span class="text-muted">{{ __('messages.not_taxable') }}</span>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">{{ __('messages.final_price') }}:</th>
                                                            <td>
                                                                <h4 class="text-primary mb-0">{{ format_price($product->total_price) }}</h4>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">{{ __('messages.profit') }}:</th>
                                                            <td>
                                                                @php
                                                                    $profit = $product->total_price - $product->cost_price;
                                                                    $profitPercentage = $product->cost_price > 0 ? ($profit / $product->cost_price) * 100 : 0;
                                                                @endphp
                                                                <span class="text-{{ $profit >= 0 ? 'success' : 'danger' }} font-weight-bold">
                                                                    {{ format_price($profit) }}
                                                                    ({{ number_format($profitPercentage, 2) }}%)
                                                                </span>
                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Variations Section -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="card border shadow-none">
                                    <div class="card-header bg-transparent border-bottom d-flex justify-content-between align-items-center">
                                        <h5 class="font-size-14 mb-0">
                                            <i class="fas fa-layer-group text-primary mr-1"></i>
                                            {{ __('organizations.variations') }}
                                            <span class="badge badge-soft-primary ml-1">{{ $product->variations->count() }}</span>
                                        </h5>
                                        <div class="text-muted font-size-12">
                                            {{ __('messages.click_to_expand') }}
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        @if($product->variations->count() > 0)
                                            <div class="table-responsive">
                                                <table class="table table-centered table-nowrap mb-0">
                                                    <thead class="thead-light">
                                                    <tr>
                                                        <th>#</th>
                                                        <th>{{ __('messages.name') }}</th>
                                                        <th>{{ __('messages.sku') }}</th>
                                                        <th>{{ __('organizations.stock') }}</th>
                                                        <th>{{ __('messages.pricing_details') }}</th>
                                                        <th>{{ __('messages.actions') }}</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($product->variations as $variation)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>
                                                                <h5 class="font-size-14 mb-1">{{ $variation->name }}</h5>
                                                                @if($variation->option_items->count() > 0)
                                                                    <small class="text-muted">
                                                                        @foreach($variation->option_items as $option)
                                                                            <span class="badge badge-soft-secondary mr-1">
                                                                                {{ $option->name }}
                                                                            </span>
                                                                        @endforeach
                                                                    </small>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <span class="badge badge-soft-secondary">{{ $variation->sku ?? '-' }}</span>
                                                            </td>
                                                            <td>
                                                                @if($variation->stock_quantity > 10)
                                                                    <span class="badge badge-soft-success font-size-11">
                                                                        {{ __('organizations.in_stock') }} ({{ $variation->stock_quantity }})
                                                                    </span>
                                                                @elseif($variation->stock_quantity > 0)
                                                                    <span class="badge badge-soft-warning font-size-11">
                                                                        {{ __('organizations.low_stock') }} ({{ $variation->stock_quantity }})
                                                                    </span>
                                                                @else
                                                                    <span class="badge badge-soft-danger font-size-11">
                                                                        {{ __('organizations.out_of_stock') }}
                                                                    </span>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <div class="pricing-details">
                                                                    <h5 class="font-size-14 mb-1 text-primary">
                                                                        {{ format_price($variation->total_price) }}
                                                                    </h5>
                                                                    <small class="text-muted d-block">
                                                                        {{ __('messages.selling_price') }}: {{ format_price($variation->selling_price) }}
                                                                    </small>
                                                                    @if($variation->discount > 0)
                                                                        <small class="text-danger d-block">
                                                                            {{ __('messages.discount') }}: -{{ format_price($variation->discount) }}
                                                                            @if($variation->tax_type == 2)
                                                                                ({{ $variation->discount }}%)
                                                                            @endif
                                                                        </small>
                                                                    @endif
                                                                    @if($variation->is_taxable && $variation->tax_amount > 0)
                                                                        <small class="text-info d-block">
                                                                            {{ __('messages.tax') }}: {{ format_price($variation->tax_amount) }}
                                                                            @if($variation->tax_type == 2)
                                                                                ({{ $variation->tax_amount }}%)
                                                                            @endif
                                                                        </small>
                                                                    @endif
                                                                    @if($variation->cost_price > 0)
                                                                        <small class="text-success d-block">
                                                                            {{ __('messages.cost_price') }}: {{ format_price($variation->cost_price) }}
                                                                        </small>
                                                                    @endif
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="btn-group" role="group">
                                                                    <a href="#" class="btn btn-outline-primary btn-sm">
                                                                        <i class="fas fa-edit"></i>
                                                                    </a>
                                                                    <button type="button" class="btn btn-outline-danger btn-sm">
                                                                        <i class="fas fa-trash-alt"></i>
                                                                    </button>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @else
                                            <div class="text-center py-5">
                                                <div class="avatar-md mx-auto mb-4">
                                                    <div class="avatar-title bg-light rounded-circle text-primary">
                                                        <i class="fas fa-layer-group font-size-24"></i>
                                                    </div>
                                                </div>
                                                <h5 class="text-muted">{{ __('messages.no_data') }}</h5>
                                                <p class="text-muted mb-0">{{ __('organizations.no_variations_found') }}</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('after_script')
    <script>
        $(document).ready(function() {
            // يمكنك إضافة أي سكريبت إضافي هنا إذا لزم الأمر
        });
    </script>
@endsection
