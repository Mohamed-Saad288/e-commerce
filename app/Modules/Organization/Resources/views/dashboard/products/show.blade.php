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

    {{-- Enhanced Variation Details Modals --}}
    @foreach ($product->variations as $variation)
        <div class="modal fade" id="variationModal{{ $variation->id }}" tabindex="-1"
            aria-labelledby="variationModalLabel{{ $variation->id }}" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content border-0 shadow-lg">
                    <div class="modal-header bg-gradient-primary text-white border-0">
                        <h5 class="modal-title d-flex align-items-center" id="variationModalLabel{{ $variation->id }}">
                            <i class="fe fe-package mr-2"></i>
                            <span>{{ $variation->name ?? $product->name }}</span>
                            <span class="badge badge-light text-primary ml-2">{{ $variation->sku }}</span>
                        </h5>
                        <button type="button" class="close text-white" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body p-4">
                        {{-- Options Section --}}
                        @if ($variation->option_items->count() > 0)
                            <div class="mb-4">
                                <h6 class="text-muted mb-3">
                                    <i class="fe fe-sliders mr-2"></i>{{ __('messages.options') }}
                                </h6>
                                <div class="d-flex flex-wrap gap-2">
                                    @foreach ($variation->option_items as $optionItem)
                                        <span class="badge badge-soft-primary badge-pill px-3 py-2"
                                            style="font-size: 0.9rem;">
                                            <strong>{{ $optionItem->option->name }}:</strong> {{ $optionItem->name }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <div class="row">
                            {{-- Images Section --}}
                            <div class="col-lg-6 mb-4">
                                <div class="card border-0 bg-light h-100">
                                    <div class="card-body">
                                        <h6 class="card-title text-primary mb-3">
                                            <i class="fe fe-image mr-2"></i>{{ __('messages.main_images') }}
                                        </h6>
                                        @php $mainImages = $variation->getMedia('main_images'); @endphp
                                        @if ($mainImages->count() > 0)
                                            <div class="row g-2">
                                                @foreach ($mainImages as $image)
                                                    <div class="col-4 mb-2">
                                                        <div class="position-relative overflow-hidden rounded shadow-sm"
                                                            style="height: 120px;">
                                                            <img src="{{ $image->getUrl() }}" class="w-100 h-100"
                                                                style="object-fit: cover; cursor: pointer; transition: transform 0.3s;"
                                                                onclick="window.open('{{ $image->getUrl() }}', '_blank')"
                                                                onmouseover="this.style.transform='scale(1.1)'"
                                                                onmouseout="this.style.transform='scale(1)'">
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <div class="text-center py-4">
                                                <i class="fe fe-image text-muted" style="font-size: 3rem;"></i>
                                                <p class="text-muted mt-2">{{ __('messages.no_images') }}</p>
                                            </div>
                                        @endif

                                        <h6 class="card-title text-primary mb-3 mt-4">
                                            <i class="fe fe-image mr-2"></i>{{ __('messages.additional_images') }}
                                        </h6>
                                        @php $additionalImages = $variation->getMedia('additional_images'); @endphp
                                        @if ($additionalImages->count() > 0)
                                            <div class="row g-2">
                                                @foreach ($additionalImages as $image)
                                                    <div class="col-4 mb-2">
                                                        <div class="position-relative overflow-hidden rounded shadow-sm"
                                                            style="height: 120px;">
                                                            <img src="{{ $image->getUrl() }}" class="w-100 h-100"
                                                                style="object-fit: cover; cursor: pointer; transition: transform 0.3s;"
                                                                onclick="window.open('{{ $image->getUrl() }}', '_blank')"
                                                                onmouseover="this.style.transform='scale(1.1)'"
                                                                onmouseout="this.style.transform='scale(1)'">
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <div class="text-center py-4">
                                                <i class="fe fe-image text-muted" style="font-size: 3rem;"></i>
                                                <p class="text-muted mt-2">{{ __('messages.no_images') }}</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            {{-- Details Section --}}
                            <div class="col-lg-6">
                                {{-- Stock & Identification Card --}}
                                <div class="card border-0 bg-light mb-3">
                                    <div class="card-body">
                                        <h6 class="card-title text-primary mb-3">
                                            <i class="fe fe-info mr-2"></i>{{ __('messages.product_info') }}
                                        </h6>
                                        <table class="table table-sm table-borderless mb-0">
                                            <tr>
                                                <td class="text-muted" style="width: 40%;"><i
                                                        class="fe fe-hash mr-1"></i>{{ __('messages.sku') }}</td>
                                                <td><code class="px-2 py-1 bg-white rounded">{{ $variation->sku }}</code>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted"><i
                                                        class="fe fe-bar-chart mr-1"></i>{{ __('messages.barcode') }}</td>
                                                <td><strong>{{ $variation->barcode ?? '-' }}</strong></td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted"><i
                                                        class="fe fe-package mr-1"></i>{{ __('messages.stock_quantity') }}
                                                </td>
                                                <td>
                                                    <span
                                                        class="badge badge-{{ $variation->stock_quantity > 10 ? 'success' : ($variation->stock_quantity > 0 ? 'warning' : 'danger') }} px-3 py-2">
                                                        {{ $variation->stock_quantity }} {{ __('messages.stock') }}
                                                    </span>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                                {{-- Pricing Card --}}
                                <div class="card border-0 bg-light">
                                    <div class="card-body">
                                        <h6 class="card-title text-primary mb-3">
                                            <i class="fe fe-dollar-sign mr-2"></i>{{ __('messages.pricing_details') }}
                                        </h6>
                                        <table class="table table-sm table-borderless mb-0">
                                            <tr>
                                                <td class="text-muted" style="width: 40%;"><i
                                                        class="fe fe-trending-down mr-1"></i>{{ __('messages.cost_price') }}
                                                </td>
                                                <td><span
                                                        class="text-danger font-weight-bold">{{ format_price($variation->cost_price) }}</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted"><i
                                                        class="fe fe-tag mr-1"></i>{{ __('messages.selling_price') }}</td>
                                                <td><span
                                                        class="text-info font-weight-bold">{{ format_price($variation->selling_price) }}</span>
                                                </td>
                                            </tr>
                                            @if ($variation->discount > 0)
                                                <tr>
                                                    <td class="text-muted"><i
                                                            class="fe fe-percent mr-1"></i>{{ __('messages.discount') }}
                                                    </td>
                                                    <td><span
                                                            class="text-warning font-weight-bold">-{{ format_price($variation->discount) }}</span>
                                                    </td>
                                                </tr>
                                            @endif
                                            @if ($variation->tax_amount > 0)
                                                <tr>
                                                    <td class="text-muted"><i
                                                            class="fe fe-file-text mr-1"></i>{{ __('messages.tax_amount') }}
                                                    </td>
                                                    <td><span
                                                            class="text-secondary font-weight-bold">+{{ format_price($variation->tax_amount) }}</span>
                                                    </td>
                                                </tr>
                                            @endif
                                            <tr class="border-top">
                                                <td class="text-muted font-weight-bold"><i
                                                        class="fe fe-dollar-sign mr-1"></i>{{ __('messages.total_price') }}
                                                </td>
                                                <td><span class="badge badge-success px-3 py-2"
                                                        style="font-size: 1rem;">{{ format_price($variation->total_price) }}</span>
                                                </td>
                                            </tr>
                                            @php
                                                $profit = $variation->total_price - $variation->cost_price;
                                            @endphp
                                            <tr>
                                                <td class="text-muted"><i
                                                        class="fe fe-trending-up mr-1"></i>{{ __('messages.profit') }}
                                                </td>
                                                <td><span
                                                        class="font-weight-bold {{ $profit >= 0 ? 'text-success' : 'text-danger' }}">{{ format_price($profit) }}</span>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0 bg-light">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fe fe-x mr-1"></i>{{ __('messages.close') }}
                        </button>
                        <a href="{{ route('organization.products.edit', $product->id) }}" class="btn btn-primary">
                            <i class="fe fe-edit mr-1"></i>{{ __('messages.edit_product') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection

@section('styles')
    <style>
        .card {
            transition: all 0.2s;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1) !important;
        }

        .badge {
            font-weight: 500;
        }

        .prose img {
            max-width: 100%;
            border-radius: 8px;
        }

        /* Enhanced Modal Styling */
        .modal-content {
            border-radius: 1rem;
            overflow: hidden;
        }

        .modal-header.bg-gradient-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 1.5rem;
        }

        .modal-body {
            background: #f8f9fa;
        }

        .modal-xl {
            max-width: 1200px;
        }

        /* Card Styling in Modal */
        .modal-body .card {
            border-radius: 0.75rem;
            transition: all 0.3s ease;
        }

        .modal-body .card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15) !important;
        }

        /* Image Hover Effects */
        .modal-body img {
            transition: all 0.3s ease;
        }

        /* Badge Styling */
        .badge-soft-primary {
            background-color: rgba(102, 126, 234, 0.1);
            color: #667eea;
            border: 1px solid rgba(102, 126, 234, 0.2);
        }

        /* Table Styling */
        .modal-body table tr {
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .modal-body table tr:last-child {
            border-bottom: none;
        }

        .modal-body table td,
        .modal-body table th {
            padding: 0.75rem 0.5rem;
        }

        /* Responsive Gap Utility */
        .gap-2 {
            gap: 0.5rem;
        }

        /* Stock Badge Enhancement */
        .badge-success,
        .badge-warning,
        .badge-danger {
            font-size: 0.85rem;
            padding: 0.5rem 1rem;
        }
    </style>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            // Handle variation modal with Bootstrap 5
            $('[data-toggle="modal"]').on('click', function(e) {
                e.preventDefault();
                var targetId = $(this).data('target');
                var modalElement = document.querySelector(targetId);
                if (modalElement) {
                    var modal = new bootstrap.Modal(modalElement);
                    modal.show();
                }
            });

            // Alternative: Direct button handler
            $('.btn-variation-view').on('click', function(e) {
                e.preventDefault();
                var variationId = $(this).data('variation-id');
                var modalElement = document.querySelector('#variationModal' + variationId);
                if (modalElement) {
                    var modal = new bootstrap.Modal(modalElement);
                    modal.show();
                }
            });
        });
    </script>
@endsection
