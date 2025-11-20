{{-- resources/views/organization/products/partials/_pricing.blade.php --}}
{{-- الأسعار دايماً من الـ variations --}}
@php
    $minPrice = $product->variations->min('total_price');
    $maxPrice = $product->variations->max('total_price');
    $avgPrice = $product->variations->avg('total_price');
    $minCostPrice = $product->variations->min('cost_price');
    $maxCostPrice = $product->variations->max('cost_price');

    // حساب الربح
    $totalProfit = 0;
    $totalCost = 0;
    foreach($product->variations as $var) {
        $profit = ($var->total_price - $var->cost_price) * $var->stock_quantity;
        $totalProfit += $profit;
        $totalCost += $var->cost_price * $var->stock_quantity;
    }
    $profitPercentage = $totalCost > 0 ? ($totalProfit / $totalCost) * 100 : 0;
@endphp

<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-light border-0">
        <h5 class="mb-0 font-size-15 text-primary">
            <i class="fas fa-tags mr-2"></i>{{ __('messages.pricing_summary') }}
        </h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-3 text-center border-right">
                <h6 class="text-muted small mb-2">{{ __('messages.lowest_price') }}</h6>
                <h3 class="text-success mb-0">{{ format_price($minPrice) }}</h3>
            </div>
            <div class="col-md-3 text-center border-right">
                <h6 class="text-muted small mb-2">{{ __('messages.highest_price') }}</h6>
                <h3 class="text-danger mb-0">{{ format_price($maxPrice) }}</h3>
            </div>
            <div class="col-md-3 text-center border-right">
                <h6 class="text-muted small mb-2">{{ __('messages.average_price') }}</h6>
                <h3 class="text-primary mb-0">{{ format_price($avgPrice) }}</h3>
            </div>
            <div class="col-md-3 text-center">
                <h6 class="text-muted small mb-2">{{ __('messages.total_profit') }}</h6>
                <h3 class="text-{{ $totalProfit >= 0 ? 'success' : 'danger' }} mb-0">
                    {{ format_price($totalProfit) }}
                </h3>
                <small class="text-muted">({{ number_format($profitPercentage, 1) }}%)</small>
            </div>
        </div>

        @if($product->variations->count() == 1)
            {{-- إذا كان فيه variation واحد فقط (default)، نعرض التفاصيل --}}
            @php $variation = $product->variations->first(); @endphp
            <hr class="my-3">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-sm table-borderless mb-0">
                        <tr>
                            <th class="text-muted">{{ __('messages.cost_price') }}:</th>
                            <td class="text-success font-weight-bold">{{ format_price($variation->cost_price) }}</td>
                        </tr>
                        <tr>
                            <th class="text-muted">{{ __('messages.selling_price') }}:</th>
                            <td class="text-primary font-weight-bold">{{ format_price($variation->selling_price) }}</td>
                        </tr>
                        <tr>
                            <th class="text-muted">{{ __('messages.discount') }}:</th>
                            <td>
                                @if($variation->discount > 0)
                                    <span class="text-danger">-{{ format_price($variation->discount) }}
                                        @if($variation->tax_type == 2)({{ $variation->discount }}%)@endif
                                    </span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-sm table-borderless mb-0">
                        <tr>
                            <th class="text-muted">{{ __('messages.tax') }}:</th>
                            <td>
                                @if($variation->is_taxable)
                                    <span class="text-info">{{ format_price($variation->tax_amount) }}
                                        @if($variation->tax_type == 2)({{ $variation->tax_amount }}%)@endif
                                    </span>
                                @else
                                    <span class="text-muted">{{ __('messages.not_taxable') }}</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th class="text-muted">{{ __('messages.final_price') }}:</th>
                            <td><h5 class="text-primary mb-0">{{ format_price($variation->total_price) }}</h5></td>
                        </tr>
                        <tr>
                            <th class="text-muted">{{ __('messages.profit_per_unit') }}:</th>
                            <td>
                                @php
                                    $profit = $variation->total_price - $variation->cost_price;
                                    $profitPct = $variation->cost_price > 0 ? ($profit / $variation->cost_price) * 100 : 0;
                                @endphp
                                <span class="font-weight-bold text-{{ $profit >= 0 ? 'success' : 'danger' }}">
                                    {{ format_price($profit) }} ({{ number_format($profitPct, 1) }}%)
                                </span>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        @endif
    </div>
</div>
