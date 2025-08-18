@extends('organization::dashboard.master')
@section('title', __('organizations.products'))

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">{{ __('messages.products') }}</h4>
                        <a href="{{ route('organization.products.create') }}" class="btn btn-primary">
                            {{ __('messages.add_product') }}
                        </a>
                    </div>

                    <!-- Filter Section -->
                    <div class="card-body border-bottom">
                        <form id="filterForm" method="GET" action="{{ route('organization.products.index') }}">
                            <div class="row">
                                <!-- Name Filter -->
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="name">{{ __('messages.name') }}</label>
                                        <input type="text" name="name" id="name" class="form-control"
                                               value="{{ request('name') }}" placeholder="{{ __('messages.search_by_name') }}">
                                    </div>
                                </div>

                                <!-- SKU Filter -->
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="sku">{{ __('messages.sku') }}</label>
                                        <input type="text" name="sku" id="sku" class="form-control"
                                               value="{{ request('sku') }}" placeholder="{{ __('messages.search_by_sku') }}">
                                    </div>
                                </div>

                                <!-- Category Filter -->
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="category">{{ __('messages.category') }}</label>
                                        <select name="category" id="category" class="form-control">
                                            <option value="">{{ __('messages.all_categories') }}</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- Brand Filter -->
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="brand">{{ __('messages.brand') }}</label>
                                        <select name="brand" id="brand" class="form-control">
                                            <option value="">{{ __('messages.all_brands') }}</option>
                                            @foreach($brands as $brand)
                                                <option value="{{ $brand->id }}" {{ request('brand') == $brand->id ? 'selected' : '' }}>
                                                    {{ $brand->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- Status Filter -->
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="status">{{ __('messages.status') }}</label>
                                        <select name="status" id="status" class="form-control">
                                            <option value="">{{ __('messages.all_status') }}</option>
                                            <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>{{ __('messages.active') }}</option>
                                            <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>{{ __('messages.inactive') }}</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Filter Buttons -->
                                <div class="col-md-1 d-flex align-items-end">
                                    <div class="form-group w-100">
                                        <button type="submit" class="btn btn-primary w-100">
                                            <i class="fa fa-filter"></i> {{ __('messages.filter') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Products Table -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table datatables" id="dataTable-1">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('messages.name') }}</th>
                                    <th>{{ __('messages.description') }}</th>
                                    <th>{{ __('messages.short_description') }}</th>
                                    <th>{{ __('messages.slug') }}</th>
                                    <th>{{ __('messages.sku') }}</th>
                                    <th>{{ __('messages.category') }}</th>
                                    <th>{{ __('messages.brand') }}</th>
                                    <th>{{ __('messages.status') }}</th>
                                    <th>{{ __('messages.actions') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if (count($products) > 0)
                                    @foreach ($products as $product)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $product->name }}</td>
                                            <td>{{\Illuminate\Support\Str::limit($product->description ?? '-', 50)}}</td>
                                            <td>{{\Illuminate\Support\Str::limit($product->short_description ?? '-', 20)}}</td>
                                            <td>{{ $product->slug ?? '-' }}</td>
                                            <td>{{ $product->sku ?? '-' }}</td>
                                            <td>{{ $product->category?->name ?? '-' }}</td>
                                            <td>{{ $product->brand?->name ?? '-' }}</td>
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
                                                <a href="{{ route('organization.products.edit', $product->id) }}"
                                                   class="btn btn-sm btn-success">
                                                    <i class='fe fe-edit fa-2x'></i>
                                                </a>
                                                <button class="btn btn-sm btn-danger delete-faq"
                                                        data-id="{{ $product->id }}">
                                                    <i class="fe fe-trash-2 fa-2x"></i>
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
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        @if($products->hasPages())
                            <div class="card-footer">
                                {{ $products->appends(request()->query())->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('after_script')
    <script>
        $(document).ready(function () {
            // Toggle status
            $('.toggle-status').change(function () {
                let productId = $(this).data('id');
                $.ajax({
                    url: "{{ route('organization.products.change_status', ':id') }}".replace(':id', productId),
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        product_id: productId,
                    },
                    success: function (response) {
                        if (response.success) {
                            toastr.success("{{ __('messages.updated') }}");
                        } else {
                            toastr.error("{{ __('messages.something_wrong') }}");
                        }
                    },
                    error: function () {
                        toastr.error("{{ __('messages.error_occurred') }}");
                    }
                });
            });

            // Delete product
            $(document).on('click', '.delete-faq', function (e) {
                e.preventDefault();
                let productId = $(this).data('id');
                let deleteUrl = "{{ route('organization.products.destroy', ':id') }}".replace(':id', productId);
                let row = $(this).closest('tr');

                Swal.fire({
                    title: "{{ __('messages.confirm_delete') }}",
                    text: "{{ __('messages.are_you_sure') }}",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "{{ __('messages.yes_delete') }}",
                    cancelButtonText: "{{ __('messages.no_cancel') }}"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: deleteUrl,
                            type: "POST",
                            data: {
                                _token: "{{ csrf_token() }}",
                                _method: "DELETE"
                            },
                            success: function (response) {
                                if (response.success) {
                                    Swal.fire("{{ __('messages.deleted') }}",
                                        response.message,
                                        "success");
                                    row.fadeOut(500, function () {
                                        $(this).remove();
                                    });
                                } else {
                                    Swal.fire("{{ __('messages.error') }}",
                                        "{{ __('messages.something_wrong') }}",
                                        "error");
                                }
                            },
                            error: function () {
                                Swal.fire("{{ __('messages.error') }}",
                                    "{{ __('messages.error_occurred') }}", "error");
                            }
                        });
                    }
                });
            });

            // Reset filters
            $('#resetFilters').click(function() {
                $('#filterForm').find('input:text, input:password, input:file, select, textarea').val('');
                $('#filterForm').find('input:radio, input:checkbox').removeAttr('checked').removeAttr('selected');
                $('#filterForm').submit();
            });
        });
    </script>
@endsection
