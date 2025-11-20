{{-- resources/views/organization/products/partials/_info.blade.php --}}
{{-- معلومات المنتج الأساسية (بدون الأسعار) --}}
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <h5 class="card-title font-size-15 text-primary mb-3">
            <i class="fas fa-info-circle mr-2"></i>{{ __('messages.product_info') }}
        </h5>
        <div class="row">
            <div class="col-md-6">
                <table class="table table-sm table-borderless mb-0">
                    <tr>
                        <th class="text-muted w-40">{{ __('messages.name') }}:</th>
                        <td>{{ $product->name }}</td>
                    </tr>
                    <tr>
                        <th class="text-muted">{{ __('messages.slug') }}:</th>
                        <td><code>{{ $product->slug }}</code></td>
                    </tr>
                    <tr>
                        <th class="text-muted">{{ __('organizations.category') }}:</th>
                        <td>
                            <span class="badge badge-soft-info">{{ $product->category?->name ?? '-' }}</span>
                        </td>
                    </tr>
                    <tr>
                        <th class="text-muted">{{ __('organizations.brand') }}:</th>
                        <td>
                            <span class="badge badge-soft-success">{{ $product->brand?->name ?? '-' }}</span>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table table-sm table-borderless mb-0">
                    <tr>
                        <th class="text-muted w-40">{{ __('messages.status') }}:</th>
                        <td>
                            {!! $product->is_active
                                ? '<span class="badge badge-soft-success"><i class="mdi mdi-check mr-1"></i>' . __('messages.active') . '</span>'
                                : '<span class="badge badge-soft-danger"><i class="mdi mdi-close mr-1"></i>' . __('messages.inactive') . '</span>' !!}
                        </td>
                    </tr>
                    <tr>
                        <th class="text-muted">{{ __('organizations.stock') }}:</th>
                        <td>
                            {!! $product->stock_quantity > 10
                                ? '<span class="badge badge-soft-success"><i class="fas fa-check mr-1"></i>' . __('organizations.in_stock') . " ($product->stock_quantity)</span>"
                                : ($product->stock_quantity > 0
                                    ? '<span class="badge badge-soft-warning"><i class="fas fa-exclamation mr-1"></i>' . __('organizations.low_stock') . " ($product->stock_quantity)</span>"
                                    : '<span class="badge badge-soft-danger"><i class="fas fa-times mr-1"></i>' . __('organizations.out_of_stock') . '</span>') !!}
                        </td>
                    </tr>
                    <tr>
                        <th class="text-muted">{{ __('messages.type') }}:</th>
                        <td>
                            @switch($product->type)
                                @case(1) <span class="badge badge-soft-primary">{{ __('organizations.physical') }}</span> @break
                                @case(2) <span class="badge badge-soft-info">{{ __('organizations.digital') }}</span> @break
                                @case(3) <span class="badge badge-soft-warning">{{ __('organizations.service') }}</span> @break
                            @endswitch
                        </td>
                    </tr>
                    <tr>
                        <th class="text-muted">{{ __('messages.requires_shipping') }}:</th>
                        <td>
                            {!! $product->requires_shipping
                                ? '<span class="badge badge-soft-success">' . __('messages.yes') . '</span>'
                                : '<span class="badge badge-soft-secondary">' . __('messages.no') . '</span>' !!}
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
