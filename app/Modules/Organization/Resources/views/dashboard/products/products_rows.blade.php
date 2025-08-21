@if (count($products) > 0)
    @foreach ($products as $product)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $product->name ?? '-' }}</td>
            <td>{{\Illuminate\Support\Str::limit($product->description ?? '-', 50)}}</td>
            <td>{{\Illuminate\Support\Str::limit($product->short_description ?? '-', 20)}}</td>
            <td>{{ $product->slug ?? '-' }}</td>
            <td>{{ $product->sku ?? '-' }}</td>
            <td>{{ $product->category?->name ?? '-' }}</td>
            <td>{{ $product->brand?->name ?? '-' }}</td>
            <td>
                @if($product->stock_quantity > 10)
                    <span class="badge badge-success">{{ __('organizations.in_stock') }}</span>
                @elseif($product->stock_quantity > 0)
                    <span class="badge badge-warning">{{ __('organizations.low_stock') }}</span>
                @else
                    <span class="badge badge-danger">{{ __('organizations.out_of_stock') }}</span>
                @endif
            </td>
            <td>{{$product->variations?->count() ?? 0}}</td>

            <td>
                <div class="custom-control custom-switch">
                    <input type="checkbox"
                           class="custom-control-input toggle-status"
                           id="toggleStatus{{ $product->id }}"
                           data-id="{{ $product->id }}"
                        {{ $product->is_active ? 'checked' : '' }}>
                    <label class="custom-control-label"
                           for="toggleStatus{{ $product->id }}"></label>
                </div>
            </td>
            <td>
                <a href="{{ route('organization.products.show', $product->id) }}"
                   class="btn btn-sm btn-info">
                    <i class='fe fe-eye fa-2x'></i>
                </a>
                <a href="{{ route('organization.products.edit', $product->id) }}"
                   class="btn btn-sm btn-success">
                    <i class='fe fe-edit'></i>
                </a>
                <button class="btn btn-sm btn-danger delete-faq"
                        data-id="{{ $product->id }}">
                    <i class="fe fe-trash-2"></i>
                </button>
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
