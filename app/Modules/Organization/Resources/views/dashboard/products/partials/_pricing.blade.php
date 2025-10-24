@if($product->variations->count() > 0)
    @php
        $minPrice = $product->variations->min('total_price');
        $maxPrice = $product->variations->max('total_price');
        $avgPrice = $product->variations->avg('total_price');
    @endphp

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-light border-0">
            <h5 class="mb-0 font-size-15 text-primary">
                <i class="fas fa-tags mr-2"></i>{{ __('messages.pricing_from_variations') }}
            </h5>
        </div>
        <div class="card-body">
            <div class="row text-center">
                <div class="col-md-4">
                    <h3 class="text-success mb-1">{{ format_price($minPrice) }}</h3>
                    <p class="text-muted small">{{ __('messages.lowest_price') }}</p>
                </div>
                <div class="col-md-4 border-left border-right">
                    <h3 class="text-primary mb-1">{{ format_price($avgPrice) }}</h3>
                    <p class="text-muted small">{{ __('messages.average_price') }}</p>
                </div>
                <div class="col-md-4">
                    <h3 class="text-danger mb-1">{{ format_price($maxPrice) }}</h3>
                    <p class="text-muted small">{{ __('messages.highest_price') }}</p>
                </div>
            </div>
        </div>
    </div>
@else
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-light border-0">
            <h5 class="mb-0 font-size-15 text-primary">
                <i class="fas fa-tag mr-2"></i>{{ __('messages.product_pricing') }}
            </h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-sm table-borderless">
                        <tr><th class="text-muted">{{ __('messages.cost_price') }}:</th>
                            <td class="text-success font-weight-bold">{{ format_price($product->cost_price) }}</td>
                        </tr>
                        <tr><th class="text-muted">{{ __('messages.selling_price') }}:</th>
                            <td class="text-primary font-weight-bold">{{ format_price($product->selling_price) }}</td>
                        </tr>
                        <tr><th class="text-muted">{{ __('messages.discount') }}:</th>
                            <td>
                                @if($product->discount > 0)
                                    <span class="text-danger">-{{ format_price($product->discount) }}
                                        @if($product->tax_type == 2)({{ $product->discount }}%)@endif
                                    </span>
                                @else <span class="text-muted">-</span> @endif
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-sm table-borderless">
                        <tr><th class="text-muted">{{ __('messages.tax') }}:</th>
                            <td>
                                @if($product->is_taxable)
                                    <span class="text-info">{{ format_price($product->tax_amount) }}
                                        @if($product->tax_type == 2)({{ $product->tax_amount }}%)@endif
                                    </span>
                                @else <span class="text-muted">{{ __('messages.not_taxable') }}</span> @endif
                            </td>
                        </tr>
                        <tr><th class="text-muted">{{ __('messages.final_price') }}:</th>
                            <td><h5 class="text-primary mb-0">{{ format_price($product->total_price) }}</h5></td>
                        </tr>
                        <tr><th class="text-muted">{{ __('messages.profit') }}:</th>
                            <td>
                                @php
                                    $profit = $product->total_price - $product->cost_price;
                                    $profitPercentage = $product->cost_price > 0 ? ($profit / $product->cost_price) * 100 : 0;
                                @endphp
                                <span class="font-weight-bold text-{{ $profit >= 0 ? 'success' : 'danger' }}">
                                    {{ format_price($profit) }} ({{ number_format($profitPercentage, 1) }}%)
                                </span>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endif
