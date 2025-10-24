<div class="card border-0 shadow-sm">
    <div class="card-header bg-light d-flex justify-content-between align-items-center">
        <h5 class="mb-0 font-size-15 text-primary">
            <i class="fas fa-layer-group mr-2"></i>
            {{ __('organizations.variations') }}
            <span class="badge badge-pill badge-primary ml-1">{{ $product->variations->count() }}</span>
        </h5>
        <small class="text-muted">{{ __('messages.click_to_expand') }}</small>
    </div>
    <div class="card-body p-0">
        @if($product->variations->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover table-centered mb-0">
                    <thead class="bg-light">
                    <tr>
                        <th class="text-muted small">#</th>
                        <th class="text-muted small">{{ __('messages.name') }}</th>
                        <th class="text-muted small">{{ __('messages.sku') }}</th>
                        <th class="text-muted small">{{ __('organizations.stock') }}</th>
                        <th class="text-muted small">{{ __('messages.pricing_details') }}</th>
                        <th class="text-muted small">{{ __('messages.actions') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($product->variations as $variation)
                        <tr>
                            <td class="small">{{ $loop->iteration }}</td>
                            <td>
                                <div class="font-weight-medium">{{ $variation->name }}</div>
                                @if($variation->option_items->count() > 0)
                                    <div class="mt-1">
                                        @foreach($variation->option_items as $option)
                                            <span class="badge badge-soft-secondary badge-pill font-size-11 mr-1">
                                                    {{ $option->name }}
                                                </span>
                                        @endforeach
                                    </div>
                                @endif
                            </td>
                            <td><code class="small">{{ $variation->sku ?? '-' }}</code></td>
                            <td>
                                @if($variation->stock_quantity > 10)
                                    <span class="badge badge-soft-success badge-pill small">{{ $variation->stock_quantity }}</span>
                                @elseif($variation->stock_quantity > 0)
                                    <span class="badge badge-soft-warning badge-pill small">{{ $variation->stock_quantity }}</span>
                                @else
                                    <span class="badge badge-soft-danger badge-pill small">0</span>
                                @endif
                            </td>
                            <td>
                                <div class="small">
                                    <div class="text-primary font-weight-bold">{{ format_price($variation->total_price) }}</div>
                                    <div class="text-muted">بيع: {{ format_price($variation->selling_price) }}</div>
                                    @if($variation->discount > 0)
                                        <div class="text-danger">خصم: -{{ format_price($variation->discount) }}</div>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <a href="{{ route('organization.products.edit', $variation->id) }}"
                                   class="btn btn-outline-success btn-sm">
                                    <i class='fe fe-edit'></i>
                                </a>
                                <button class="btn btn-outline-danger btn-sm delete-faq"
                                        data-id="{{ $variation->id }}">
                                    <i class="fe fe-trash-2"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-5 text-muted">
                <i class="fas fa-layer-group fa-3x mb-3 text-light"></i>
                <p class="mb-0">{{ __('organizations.no_variations_found') }}</p>
            </div>
        @endif
    </div>
</div>
