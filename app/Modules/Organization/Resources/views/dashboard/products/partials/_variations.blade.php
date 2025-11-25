{{-- resources/views/organization/products/partials/_variations.blade.php --}}
<div class="card border-0 shadow-sm">
    <div class="card-header bg-light d-flex justify-content-between align-items-center">
        <h5 class="mb-0 font-size-15 text-primary">
            <i class="fas fa-layer-group mr-2"></i>
            {{ __('organizations.variations') }}
            <span class="badge badge-pill badge-primary ml-1">{{ $product->variations->count() }}</span>
        </h5>
        @if ($product->variations->count() > 1)
            <small class="text-muted">{{ __('messages.multiple_variations') }}</small>
        @else
            <small class="text-muted">{{ __('messages.default_variation') }}</small>
        @endif
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover table-centered mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="text-muted small">#</th>
                        <th class="text-muted small">{{ __('messages.name') }}</th>
                        <th class="text-muted small">{{ __('messages.sku') }}</th>
                        <th class="text-muted small">{{ __('messages.images') }}</th>
                        <th class="text-muted small">{{ __('organizations.stock') }}</th>
                        <th class="text-muted small">{{ __('messages.pricing_details') }}</th>
                        <th class="text-muted small text-center">{{ __('messages.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($product->variations as $variation)
                        <tr>
                            <td class="small">{{ $loop->iteration }}</td>
                            <td>
                                <div class="font-weight-medium">{{ $variation->name }}</div>
                                @if ($variation->option_items->count() > 0)
                                    <div class="mt-1">
                                        @foreach ($variation->option_items as $option)
                                            <span class="badge badge-soft-secondary badge-pill font-size-11 mr-1">
                                                {{ $option->name }}
                                            </span>
                                        @endforeach
                                    </div>
                                @else
                                    <small class="text-muted">{{ __('messages.default_variation') }}</small>
                                @endif
                            </td>
                            <td><code class="small">{{ $variation->sku ?? '-' }}</code></td>
                            <td>
                                @php
                                    $mainImages = $variation->getMedia('main_images');
                                    $additionalImages = $variation->getMedia('additional_images');
                                    $totalImages = $mainImages->count() + $additionalImages->count();
                                @endphp
                                @if ($totalImages > 0)
                                    <div class="d-flex align-items-center">
                                        @if ($mainImages->count() > 0)
                                            <img src="{{ $mainImages->first()->getUrl() }}" class="rounded"
                                                style="width: 40px; height: 40px; object-fit: cover;">
                                        @elseif($additionalImages->count() > 0)
                                            <img src="{{ $additionalImages->first()->getUrl() }}" class="rounded"
                                                style="width: 40px; height: 40px; object-fit: cover;">
                                        @endif
                                        @if ($totalImages > 1)
                                            <span class="badge badge-soft-info badge-pill ml-2 small">
                                                +{{ $totalImages - 1 }}
                                            </span>
                                        @endif
                                    </div>
                                @else
                                    <span class="text-muted small">
                                        <i class="fas fa-image"></i> -
                                    </span>
                                @endif
                            </td>
                            <td>
                                @if ($variation->stock_quantity > 10)
                                    <span
                                        class="badge badge-soft-success badge-pill small">{{ $variation->stock_quantity }}</span>
                                @elseif($variation->stock_quantity > 0)
                                    <span
                                        class="badge badge-soft-warning badge-pill small">{{ $variation->stock_quantity }}</span>
                                @else
                                    <span class="badge badge-soft-danger badge-pill small">0</span>
                                @endif
                            </td>
                            <td>
                                <div class="small">
                                    <div class="text-primary font-weight-bold">
                                        {{ __('messages.final') }}: {{ format_price($variation->total_price) }}
                                    </div>
                                    <div class="text-muted">
                                        {{ __('messages.selling') }}: {{ format_price($variation->selling_price) }}
                                    </div>
                                    @if ($variation->discount > 0)
                                        <div class="text-danger">
                                            {{ __('messages.discount') }}: -{{ format_price($variation->discount) }}
                                        </div>
                                    @endif
                                    @php
                                        $profit = $variation->total_price - $variation->cost_price;
                                    @endphp
                                    <div class="text-{{ $profit >= 0 ? 'success' : 'danger' }}">
                                        {{ __('messages.profit') }}: {{ format_price($profit) }}
                                    </div>
                                </div>
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-outline-info btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#variationModal{{ $variation->id }}">
                                    <i class='fe fe-eye'></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
