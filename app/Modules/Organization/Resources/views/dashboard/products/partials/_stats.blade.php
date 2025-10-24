<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <h5 class="card-title font-size-15 text-primary mb-3">
            <i class="fas fa-chart-pie mr-2"></i>{{ __('messages.quick_stats') }}
        </h5>
        <div class="row text-center">
            <div class="col-6 border-right">
                <h4 class="mb-1 text-primary">{{ $product->variations->count() }}</h4>
                <p class="text-muted small mb-0">{{ __('organizations.variations') }}</p>
            </div>
            <div class="col-6">
                <h4 class="mb-1 text-success">{{ $product->stock_quantity }}</h4>
                <p class="text-muted small mb-0">{{ __('organizations.stock') }}</p>
            </div>
        </div>
    </div>
</div>
