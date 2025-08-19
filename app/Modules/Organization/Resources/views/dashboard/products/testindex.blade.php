<!-- resources/views/organization/products/index.blade.php -->
<x-app-layout>
    <div class="container mt-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0">{{ __('messages.products') }}</h4>
                <a href="{{ route('organization.products.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> {{ __('messages.add_product') }}
                </a>
            </div>
            <div class="card-body">
                <!-- Filters and Search -->
                <form method="GET" action="{{ route('organization.products.index') }}" class="mb-4">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">{{ __('messages.search') }}</label>
                            <input type="text" name="search" class="form-control" value="{{ request('search') }}"
                                   placeholder="{{ __('messages.search_by_name_or_sku') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">{{ __('messages.category') }}</label>
                            <select name="category_id" class="form-select">
                                <option value="">{{ __('messages.all_categories') }}</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">{{ __('messages.brand') }}</label>
                            <select name="brand_id" class="form-select">
                                <option value="">{{ __('messages.all_brands') }}</option>
                                @foreach($brands as $brand)
                                    <option value="{{ $brand->id }}" {{ request('brand_id') == $brand->id ? 'selected' : '' }}>
                                        {{ $brand->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">{{ __('messages.stock_status') }}</label>
                            <select name="stock_status" class="form-select">
                                <option value="">{{ __('messages.all') }}</option>
                                <option value="in_stock" {{ request('stock_status') == 'in_stock' ? 'selected' : '' }}>
                                    {{ __('messages.in_stock') }}
                                </option>
                                <option value="low_stock" {{ request('stock_status') == 'low_stock' ? 'selected' : '' }}>
                                    {{ __('messages.low_stock') }}
                                </option>
                                <option value="out_of_stock" {{ request('stock_status') == 'out_of_stock' ? 'selected' : '' }}>
                                    {{ __('messages.out_of_stock') }}
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary btn-sm">{{ __('messages.filter') }}</button>
                        <a href="{{ route('organization.products.index') }}" class="btn btn-secondary btn-sm">
                            {{ __('messages.clear') }}
                        </a>
                    </div>
                </form>

                <!-- Products Table -->
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>
                                <a href="{{ route('organization.products.index', array_merge(request()->all(), ['sort' => 'name', 'order' => request('order', 'asc') == 'asc' ? 'desc' : 'asc'])) }}">
                                    {{ __('messages.name') }}
                                    @if(request('sort') == 'name')
                                        <i class="fas fa-sort-{{ request('order', 'asc') == 'asc' ? 'up' : 'down' }}"></i>
                                    @endif
                                </a>
                            </th>
                            <th>{{ __('messages.sku') }}</th>
                            <th>{{ __('messages.category') }}</th>
                            <th>{{ __('messages.brand') }}</th>
                            <th>
                                <a href="{{ route('organization.products.index', array_merge(request()->all(), ['sort' => 'stock_quantity', 'order' => request('order', 'asc') == 'asc' ? 'desc' : 'asc'])) }}">
                                    {{ __('messages.stock') }}
                                    @if(request('sort') == 'stock_quantity')
                                        <i class="fas fa-sort-{{ request('order', 'asc') == 'asc' ? 'up' : 'down' }}"></i>
                                    @endif
                                </a>
                            </th>
                            <th>
                                <a href="{{ route('organization.products.index', array_merge(request()->all(), ['sort' => 'total_price', 'order' => request('order', 'asc') == 'asc' ? 'desc' : 'asc'])) }}">
                                    {{ __('messages.price') }}
                                    @if(request('sort') == 'total_price')
                                        <i class="fas fa-sort-{{ request('order', 'asc') == 'asc' ? 'up' : 'down' }}</i>
                                        @endif
                                    </a>
                                </th>
                                <th>{{ __('messages.variations') }}</th>
                                <th>{{ __('messages.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($products as $product)
                                <tr data-bs-toggle="collapse" data-bs-target="#variations-{{ $product->id }}" class="accordion-toggle">
                                        <td>{{ $product->name }}</td>
                                        <td>{{ $product->sku ?? '-' }}</td>
                                        <td>{{ $product->category?->name ?? '-' }}</td>
                                        <td>{{ $product->brand?->name ?? '-' }}</td>
                                        <td>
                                            @if($product->variations->isNotEmpty())
                                                {{ $product->variations->sum('stock_quantity') }}
                                                @if($product->variations->sum('stock_quantity') <= $product->low_stock_threshold)
                                                    <span class="badge bg-warning">{{ __('messages.low_stock') }}</span>
                                                @endif
                                            @else
                                                {{ $product->stock_quantity }}
                                                @if($product->stock_quantity <= $product->low_stock_threshold)
                                                    <span class="badge bg-warning">{{ __('messages.low_stock') }}</span>
                                                @endif
                                            @endif
                                        </td>
                                        <td>
                                            @if($product->variations->isNotEmpty())
                                                {{ number_format($product->variations->min('total_price'), 2) }} -
                                                {{ number_format($product->variations->max('total_price'), 2) }}
                                            @else
                                                {{ number_format($product->total_price, 2) }}
                                            @endif
                                        </td>
                                        <td>
                                            @if($product->variations->isNotEmpty())
                                                <span class="badge bg-info">{{ $product->variations->count() }} {{ __('messages.variations') }}</span>
                                            @else
                                                {{ __('messages.none') }}
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('organization.products.edit', $product->id) }}" class="btn btn-sm btn-primary">
                                                <i class="fas fa-edit"></i> {{ __('messages.edit') }}
                                            </a>
                                            <form action="{{ route('organization.products.destroy', $product->id) }}" method="POST" class="d-inline"
                                                  onsubmit="return confirm('{{ __('messages.confirm_delete') }}');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="fas fa-trash"></i> {{ __('messages.delete') }}
                                                </button>
                                            </form>
                                        </td>
                        </tr>
                        @if($product->variations->isNotEmpty())
                            <tr>
                                <td colspan="8" class="p-0">
                                    <div class="collapse" id="variations-{{ $product->id }}">
                                        <div class="card card-body border-0">
                                            <h6>{{ __('messages.variations') }}</h6>
                                            <table class="table table-sm">
                                                <thead>
                                                <tr>
                                                    <th>{{ __('messages.name') }}</th>
                                                    <th>{{ __('messages.sku') }}</th>
                                                    <th>{{ __('messages.options') }}</th>
                                                    <th>{{ __('messages.stock') }}</th>
                                                    <th>{{ __('messages.price') }}</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($product->variations as $variation)
                                                    <tr>
                                                        <td>{{ $variation->name }}</td>
                                                        <td>{{ $variation->sku ?? '-' }}</td>
                                                        <td>
                                                            @foreach($variation->optionItems as $item)
                                                                {{ $item->option->name }}: {{ $item->name }}<br>
                                                            @endforeach
                                                        </td>
                                                        <td>{{ $variation->stock_quantity }}</td>
                                                        <td>{{ number_format($variation->total_price, 2) }}</td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endif
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">{{ __('messages.no_products_found') }}</td>
                            </tr>
                            @endforelse
                            </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-end">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>

    <style>
        .table-responsive {
            overflow-x: auto;
        }

        .table th, .table td {
            vertical-align: middle;
        }

        .table th a {
            color: #212529;
            text-decoration: none;
        }

        .table th a:hover {
            color: #0d6efd;
        }

        .badge {
            font-size: 0.85em;
        }

        .accordion-toggle {
            cursor: pointer;
        }

        .collapse .card-body {
            padding: 1rem;
        }

        @media (max-width: 768px) {
            .card-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.5rem;
            }
            .table {
                font-size: 0.9em;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Handle filter form submission on change for select inputs
            const filterForm = document.querySelector('form');
            const selects = filterForm.querySelectorAll('select');
            selects.forEach(select => {
                select.addEventListener('change', () => filterForm.submit());
            });

            // Auto-clear search input
            const searchInput = filterForm.querySelector('input[name="search"]');
            searchInput.addEventListener('input', function () {
                if (!this.value) filterForm.submit();
            });
        });
    </script>
</x-app-layout>
