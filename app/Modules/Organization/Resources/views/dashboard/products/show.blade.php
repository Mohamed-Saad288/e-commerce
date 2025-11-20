{{-- resources/views/organization/products/show.blade.php --}}
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

    {{-- Variation Details Modals --}}
    @foreach($product->variations as $variation)
        <div class="modal fade" id="variationModal{{ $variation->id }}" tabindex="-1" role="dialog" aria-labelledby="variationModalLabel{{ $variation->id }}" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-light">
                        <h5 class="modal-title" id="variationModalLabel{{ $variation->id }}">
                            <i class="fas fa-cube mr-2"></i>{{ $variation->name }}
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            {{-- Main Images --}}
                            <div class="col-md-6 mb-3">
                                <h6 class="text-muted mb-2">
                                    <i class="fas fa-images mr-1"></i>{{ __('messages.main_images') }}
                                </h6>
                                @php $mainImages = $variation->getMedia('main_images'); @endphp
                                @if($mainImages->count() > 0)
                                    <div class="row g-2">
                                        @foreach($mainImages as $image)
                                            <div class="col-4 mb-2">
                                                <img src="{{ $image->getUrl() }}"
                                                     class="img-fluid rounded shadow-sm"
                                                     style="height: 100px; width: 100%; object-fit: cover; cursor: pointer;"
                                                     onclick="window.open('{{ $image->getUrl() }}', '_blank')">
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-muted small">{{ __('messages.no_images') }}</p>
                                @endif
                            </div>

                            {{-- Additional Images --}}
                            <div class="col-md-6 mb-3">
                                <h6 class="text-muted mb-2">
                                    <i class="fas fa-images mr-1"></i>{{ __('messages.additional_images') }}
                                </h6>
                                @php $additionalImages = $variation->getMedia('additional_images'); @endphp
                                @if($additionalImages->count() > 0)
                                    <div class="row g-2">
                                        @foreach($additionalImages as $image)
                                            <div class="col-4 mb-2">
                                                <img src="{{ $image->getUrl() }}"
                                                     class="img-fluid rounded shadow-sm"
                                                     style="height: 100px; width: 100%; object-fit: cover; cursor: pointer;"
                                                     onclick="window.open('{{ $image->getUrl() }}', '_blank')">
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-muted small">{{ __('messages.no_images') }}</p>
                                @endif
                            </div>
                        </div>

                        <hr>

                        {{-- Pricing Details --}}
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-sm table-borderless">
                                    <tr>
                                        <th class="text-muted">{{ __('messages.sku') }}:</th>
                                        <td><code>{{ $variation->sku }}</code></td>
                                    </tr>
                                    <tr>
                                        <th class="text-muted">{{ __('messages.barcode') }}:</th>
                                        <td>{{ $variation->barcode ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-muted">{{ __('messages.stock_quantity') }}:</th>
                                        <td>
                                        <span class="badge badge-{{ $variation->stock_quantity > 10 ? 'success' : ($variation->stock_quantity > 0 ? 'warning' : 'danger') }}">
                                            {{ $variation->stock_quantity }}
                                        </span>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-sm table-borderless">
                                    <tr>
                                        <th class="text-muted">{{ __('messages.cost_price') }}:</th>
                                        <td class="text-success">{{ format_price($variation->cost_price) }}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-muted">{{ __('messages.selling_price') }}:</th>
                                        <td class="text-primary">{{ format_price($variation->selling_price) }}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-muted">{{ __('messages.total_price') }}:</th>
                                        <td class="font-weight-bold text-primary">{{ format_price($variation->total_price) }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        @if($variation->option_items->count() > 0)
                            <hr>
                            <h6 class="text-muted mb-2">
                                <i class="fas fa-sliders-h mr-1"></i>{{ __('messages.options') }}
                            </h6>
                            <div>
                                @foreach($variation->option_items as $option)
                                    <span class="badge badge-soft-info badge-pill mr-1 mb-1">{{ $option->name }}</span>
                                @endforeach
                            </div>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            <i class="fas fa-times mr-1"></i>{{ __('messages.close') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection

@section("styles")
    <style>
        .card { transition: all 0.2s; }
        .card:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(0,0,0,0.1) !important; }
        .badge { font-weight: 500; }
        .prose img { max-width: 100%; border-radius: 8px; }
        .modal-content { border-radius: 0.5rem; }
        .modal-header { border-bottom: 2px solid #f0f0f0; }
    </style>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            // Handle variation modal
            $('[data-toggle="modal"]').on('click', function(e) {
                e.preventDefault();
                var target = $(this).data('target');
                $(target).modal('show');
            });

            // Alternative: Direct click handler
            $('.btn-variation-view').on('click', function(e) {
                e.preventDefault();
                var variationId = $(this).data('variation-id');
                $('#variationModal' + variationId).modal('show');
            });
        });
    </script>
@endsection
