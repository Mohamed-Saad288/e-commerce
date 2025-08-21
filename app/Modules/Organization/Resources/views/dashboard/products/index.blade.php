@extends('organization::dashboard.master')
@section('title', __('organizations.products'))

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">{{ __('organizations.products') }}</h4>
                        <div>
                            <div class="btn-group">
                                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-download"></i> {{ __('organizations.export') }}
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item export-btn" href="#" data-type="excel">
                                        <i class="far fa-file-excel"></i> {{ __('organizations.excel') }}
                                    </a>
                                    <a class="dropdown-item export-btn" href="#" data-type="csv">
                                        <i class="fas fa-file-csv"></i> {{ __('organizations.csv') }}
                                    </a>
                                    <a class="dropdown-item export-btn" href="#" data-type="pdf">
                                        <i class="far fa-file-pdf"></i> {{ __('organizations.pdf') }}
                                    </a>
                                </div>
                            </div>
                            <a href="{{ route('organization.products.create') }}" class="btn btn-primary ml-2">
                                {{ __('organizations.add_product') }}
                            </a>
                        </div>
                    </div>

                    <!-- Filter Section -->
                    <div class="card-body border-bottom">
                        <form id="filterForm" method="GET" action="{{ route('organization.products.index') }}">
                            <div class="row">
                                <!-- Category Filter -->
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="category">{{ __('organizations.category') }}</label>
                                        <select name="category" id="category" class="form-control filter-select">
                                            <option value="">{{ __('organizations.all_categories') }}</option>
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
                                        <label for="brand">{{ __('organizations.brand') }}</label>
                                        <select name="brand" id="brand" class="form-control filter-select">
                                            <option value="">{{ __('organizations.all_brands') }}</option>
                                            @foreach($brands as $brand)
                                                <option value="{{ $brand->id }}" {{ request('brand') == $brand->id ? 'selected' : '' }}>
                                                    {{ $brand->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- Stock Status Filter -->
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="stock_status">{{ __('organizations.stock_status') }}</label>
                                        <select name="stock_status" id="stock_status" class="form-control filter-select">
                                            <option value="">{{ __('organizations.all_stock_status') }}</option>
                                            <option value="in_stock" {{ request('stock_status') == 'in_stock' ? 'selected' : '' }}>
                                                {{ __('organizations.in_stock') }}
                                            </option>
                                            <option value="out_of_stock" {{ request('stock_status') == 'out_of_stock' ? 'selected' : '' }}>
                                                {{ __('organizations.out_of_stock') }}
                                            </option>
                                            <option value="low_stock" {{ request('stock_status') == 'low_stock' ? 'selected' : '' }}>
                                                {{ __('organizations.low_stock') }}
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Status Filter -->
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="status">{{ __('messages.status') }}</label>
                                        <select name="status" id="status" class="form-control filter-select">
                                            <option value="">{{ __('organizations.all_status') }}</option>
                                            <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>
                                                {{ __('messages.active') }}
                                            </option>
                                            <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>
                                                {{ __('messages.inactive') }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Products Table -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table datatables" id="productsTable">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('messages.name') }}</th>
                                    <th>{{ __('messages.description') }}</th>
                                    <th>{{ __('messages.short_description') }}</th>
                                    <th>{{ __('messages.slug') }}</th>
                                    <th>{{ __('messages.sku') }}</th>
                                    <th>{{ __('organizations.category') }}</th>
                                    <th>{{ __('organizations.brand') }}</th>
                                    <th>{{ __('organizations.stock') }}</th>
                                    <th>{{ __('organizations.number_of_variations') }}</th>
                                    <th>{{ __('messages.status') }}</th>
                                    <th>{{ __('messages.actions') }}</th>
                                </tr>
                                </thead>
                                <tbody id="productsTableBody">
                                @include('organization::dashboard.products.products_rows', ['products' => $products])
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination will be loaded via AJAX -->
                        <div id="paginationContainer">
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
    </div>
@endsection

@section('after_script')
    <script>
        $(document).ready(function () {
            // AJAX Filtering
            $('.filter-select').change(function() {
                applyFilters();
            });

            function applyFilters() {
                const formData = $('#filterForm').serialize();
                const url = "{{ route('organization.products.index') }}";

                $.ajax({
                    url: url,
                    type: "GET",
                    data: formData,
                    beforeSend: function() {
                        $('#productsTableBody').html('<tr><td colspan="11" class="text-center"><div class="spinner-border"></div></td></tr>');
                    },
                    success: function(response) {
                        $('#productsTableBody').html(response.products_rows);
                        $('#paginationContainer').html(response.pagination);
                    },
                    error: function() {
                        $('#productsTableBody').html('<tr><td colspan="11" class="text-center text-danger">{{ __("messages.error_loading_data") }}</td></tr>');
                    }
                });
            }

            $('.export-btn').click(function(e) {
                e.preventDefault();
                const exportType = $(this).data('type');
                const formData = $('#filterForm').serialize();
                const url = "{{ route('organization.products.export') }}?type=" + exportType + "&" + formData;
                window.location.href = url;
            });


            // Toggle status
            $(document).on('change', '.toggle-status', function() {
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
                            applyFilters(); // Refresh the table after status change
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
                                    applyFilters(); // Refresh the table after deletion
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
        });
    </script>
@endsection
