@if (count($products) > 0)
    @foreach ($products as $variation)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>
                @php
                    $mainImage = $variation->getFirstMedia('main_images');
                @endphp
                @if ($mainImage)
                    <img src="{{ $mainImage->getUrl() }}" alt="{{ $variation->sku }}" class="img-thumbnail"
                        style="width: 60px; height: 60px; object-fit: cover;">
                @else
                    <div class="bg-light d-flex align-items-center justify-content-center"
                        style="width: 60px; height: 60px; border-radius: 4px;">
                        <i class="fe fe-image text-muted"></i>
                    </div>
                @endif
            </td>
            <td>
                <div class="d-flex flex-column">
                    <span class="fw-bold">{{ $variation->name ?? $variation?->product?->name ?? '-' }}</span>
                    <small class="text-muted">SKU: {{ $variation->sku ?? '-' }}</small>
                </div>
            </td>
            <td>
                @if ($variation->option_items && $variation->option_items->count() > 0)
                    @foreach ($variation->option_items as $optionItem)
                        <span class="badge bg-info text-white me-1">
                            {{ $optionItem?->option?->name ?? '-' }}: {{ $optionItem?->name ?? '-' }}
                        </span>
                    @endforeach
                @else
                    <span class="text-muted">-</span>
                @endif
            </td>
            <td>{{ $variation->product->category?->name ?? '-' }}</td>
            <td>{{ $variation->product->brand?->name ?? '-' }}</td>
            <td>
                <div class="d-flex flex-column">
                    <span
                        class="fw-bold">{{ number_format($variation->total_price ?? $variation->selling_price, 2) }}</span>
                    <small class="text-muted">Cost: {{ number_format($variation->cost_price, 2) }}</small>
                </div>
            </td>
            <td>
                @if ($variation->stock_quantity > 10)
                    <span class="badge badge-success">{{ __('organizations.in_stock') }}
                        ({{ $variation->stock_quantity }})
                    </span>
                @elseif($variation->stock_quantity > 0)
                    <span class="badge badge-warning">{{ __('organizations.low_stock') }}
                        ({{ $variation->stock_quantity }})</span>
                @else
                    <span class="badge badge-danger">{{ __('organizations.out_of_stock') }}</span>
                @endif
            </td>

            <td>
                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input toggle-status"
                        id="toggleStatus{{ $variation->product_id }}" data-id="{{ $variation->product_id }}"
                        {{ $variation?->product?->is_active ? 'checked' : '' }}>
                    <label class="custom-control-label" for="toggleStatus{{ $variation->product_id }}"></label>
                </div>
            </td>
            <td>
                <div class="btn-group" role="group">
                    {{-- View Product Details --}}
                    <a href="{{ route('organization.products.show', $variation->product_id) }}"
                        class="btn btn-sm btn-outline-info" title="{{ __('messages.view_details') }}">
                        <i class='fe fe-eye'></i>
                    </a>

                    {{-- Quick Edit: Edit this variation only in modal --}}
                    <button type="button" class="btn btn-sm btn-outline-primary quick-edit-variation"
                        data-variation-id="{{ $variation->id }}" data-bs-toggle="modal"
                        data-bs-target="#quickEditModal" title="{{ __('messages.quick_edit_variation') }}">
                        <i class='fe fe-edit'></i>
                    </button>

                    {{-- Full Edit: Edit entire product with all variations --}}
                    <a href="{{ route('organization.products.edit', $variation->product_id) }}"
                        class="btn btn-outline-success btn-sm" title="{{ __('messages.edit_product') }}">
                        <i class='fe fe-edit-2'></i>
                    </a>

                    {{-- Delete this variation --}}
                    <button class="btn btn-outline-danger btn-sm delete-faq" data-id="{{ $variation->id }}"
                        data-type="variation" title="{{ __('messages.delete_variation') }}">
                        <i class="fe fe-trash-2"></i>
                    </button>
                </div>
            </td>
        </tr>
    @endforeach
@else
    <tr>
        <td colspan="100%">
            <div class="no-data">
                <img src="{{ asset('no-data.png') }}" alt="No Data Found">
                <p>{{ __('messages.no_data') }}</p>
            </div>
        </td>
    </tr>
@endif
