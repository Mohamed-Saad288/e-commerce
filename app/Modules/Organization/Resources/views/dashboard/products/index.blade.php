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
                            <a href="{{ route('organization.products.create') }}" class="btn btn-primary ms-2">
                                {{ __('organizations.add_product') }}
                            </a>
                        </div>
                    </div>

                    <!-- Filter Section -->
                    <div class="card-body border-bottom">
                        <form id="filterForm" method="GET" action="{{ route('organization.products.index') }}">
                            <!-- Search and Results Row -->
                            <div class="row mb-3 align-items-end">
                                <div class="col-md-6">
                                    <label class="form-label small text-muted mb-1">{{ __('messages.search') }}</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="fe fe-search text-muted"></i>
                                        </span>
                                        <input type="text" class="form-control border-start-0 ps-0" id="search-input"
                                               placeholder="{{ __('messages.search') }}..." value="{{ request('search') }}">
                                        <button class="btn btn-outline-secondary" type="button" id="clear-search"
                                                title="{{ __('messages.clear') }}">
                                            <i class="fe fe-x"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-2 ms-auto text-end">
                                    <label class="form-label small text-muted mb-1">{{ __('messages.results') }}</label>
                                    <div class="badge bg-primary fs-6 py-2 px-3 w-100" id="results-count">0</div>
                                </div>
                            </div>

                            <!-- Filters Row -->
                            <div class="row mb-4 align-items-end">
                                <!-- Category Filter -->
                                <div class="col-md-3">
                                    <label class="form-label small text-muted mb-1">{{ __('organizations.category') }}</label>
                                    <select name="category" id="category" class="form-control filter-select">
                                        <option value="">{{ __('organizations.all_categories') }}</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Brand Filter -->
                                <div class="col-md-3">
                                    <label class="form-label small text-muted mb-1">{{ __('organizations.brand') }}</label>
                                    <select name="brand" id="brand" class="form-control filter-select">
                                        <option value="">{{ __('organizations.all_brands') }}</option>
                                        @foreach($brands as $brand)
                                            <option value="{{ $brand->id }}" {{ request('brand') == $brand->id ? 'selected' : '' }}>
                                                {{ $brand->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Stock Status Filter -->
                                <div class="col-md-3">
                                    <label class="form-label small text-muted mb-1">{{ __('organizations.stock_status') }}</label>
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

                                <!-- Status Filter -->
                                <div class="col-md-3">
                                    <label class="form-label small text-muted mb-1">{{ __('messages.status') }}</label>
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

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center mt-4" id="paginationContainer">
                            @if($products->hasPages())
                                {{ $products->appends(request()->query())->links('pagination::bootstrap-5') }}
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('after_script')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function () {
            // تهيئة Select2 لجميع القوائم المنسدلة
            $('.filter-select').each(function () {
                $(this).select2({
                    placeholder: $(this).find('option[value=""]').text(),
                    allowClear: true,
                    width: '100%',
                    language: "{{ app()->getLocale() }}",
                    theme: 'bootstrap-5',
                    dropdownCssClass: 'custom-select2-dropdown',
                    minimumResultsForSearch: 10 // إخفاء البحث إذا كان عدد الخيارات أقل من 10
                });
            });

            let searchTimeout;

            // تحديث عداد النتائج عند التحميل
            updateResultsCount();

            // 🔍 البحث الحي
            $('#search-input').on('keyup', function () {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => applyFilters(), 400);
            });

            // 🔽 فلتر بالقوائم المنسدلة
            $('.filter-select').on('change', function () {
                applyFilters();
            });

            // ❌ مسح البحث والفلاتر
            $('#clear-search').on('click', function () {
                $('#search-input').val('');
                $('.filter-select').val('').trigger('change');
                applyFilters();
            });

            // 🖱️ إعادة تعيين الفلاتر عند اختيار "الكل"
            $('.filter-select').on('select2:clear', function () {
                applyFilters();
            });

            // 📄 Pagination AJAX
            $(document).on('click', '#paginationContainer .pagination a', function (e) {
                e.preventDefault();
                let pageUrl = $(this).attr('href');
                applyFilters(pageUrl);
            });

            // 🧠 دالة تطبيق الفلاتر والبحث
            function applyFilters(pageUrl = "{{ route('organization.products.index') }}") {
                let formData = $('#filterForm').serialize();
                if ($('#search-input').val()) {
                    formData += '&search=' + encodeURIComponent($('#search-input').val());
                }

                $.ajax({
                    url: pageUrl,
                    type: "GET",
                    data: formData,
                    beforeSend: function () {
                        $('#productsTableBody').html(`
                            <tr>
                                <td colspan="10" class="text-center">
                                    <div class="spinner-border text-primary" style="width:3rem;height:3rem;" role="status">
                                        <span class="visually-hidden">{{ __("messages.loading") }}</span>
                                    </div>
                                </td>
                            </tr>
                        `);
                    },
                    success: function (response) {
                        $('#productsTableBody').html(response.products_rows);
                        $('#paginationContainer').html(response.pagination);
                        updateResultsCount();
                    },
                    error: function () {
                        $('#productsTableBody').html(`
                            <tr>
                                <td colspan="10" class="text-center text-danger">{{ __("messages.error_loading_data") }}</td>
                            </tr>
                        `);
                    }
                });
            }

            // 🔢 تحديث عداد النتائج
            function updateResultsCount() {
                let rowsCount = $('#productsTableBody tr').not(':has(.no-data)').length;
                $('#results-count').text(rowsCount);
            }

            // تصدير البيانات
            $('.export-btn').click(function (e) {
                e.preventDefault();
                const exportType = $(this).data('type');
                let formData = $('#filterForm').serialize();
                if ($('#search-input').val()) {
                    formData += '&search=' + encodeURIComponent($('#search-input').val());
                }
                const url = "{{ route('organization.products.export') }}?type=" + exportType + "&" + formData;
                window.location.href = url;
            });

            // تبديل الحالة
            $(document).on('change', '.toggle-status', function () {
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
                            applyFilters();
                        } else {
                            toastr.error("{{ __('messages.something_wrong') }}");
                        }
                    },
                    error: function () {
                        toastr.error("{{ __('messages.error_occurred') }}");
                    }
                });
            });

            // حذف منتج
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
                                    Swal.fire("{{ __('messages.deleted') }}", response.message, "success");
                                    applyFilters();
                                } else {
                                    Swal.fire("{{ __('messages.error') }}", "{{ __('messages.something_wrong') }}", "error");
                                }
                            },
                            error: function () {
                                Swal.fire("{{ __('messages.error') }}", "{{ __('messages.error_occurred') }}", "error");
                            }
                        });
                    }
                });
            });

            // 🖮 دعم اختصارات لوحة المفاتيح
            $(document).on('keydown', function (e) {
                if (e.key === 'Escape') {
                    $('#search-input').val('');
                    $('.filter-select').val('').trigger('change');
                    applyFilters();
                }
            });
        });
    </script>

    <style>
        /* تحسين مظهر Select2 */
        .select2-container--bootstrap-5 .select2-selection {
            border-radius: 0.5rem;
            border: 1px solid #ced4da;
            height: 40px;
            padding: 0.375rem 0.75rem;
            display: flex;
            align-items: center;
        }
        .select2-container--bootstrap-5 .select2-selection--single .select2-selection__rendered {
            line-height: 1.5;
            color: #495057;
        }
        .select2-container--bootstrap-5 .select2-selection--single .select2-selection__arrow {
            height: 100%;
        }
        .select2-container--bootstrap-5 .select2-results__option--highlighted {
            background-color: #0d6efd !important;
            color: #fff !important;
        }
        .custom-select2-dropdown {
            border-radius: 0.5rem;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }
        .select2-container--bootstrap-5 .select2-selection__clear {
            color: #dc3545;
            font-size: 1.2rem;
            cursor: pointer;
        }
        /* تحسين تأثير التحميل */
        .spinner-border {
            border-width: 0.3rem;
            animation: spin 0.8s linear infinite;
        }
        /* تحسين مظهر مربع البحث */
        .input-group-text {
            background-color: #f8f9fa;
            border-right: 0;
        }
        .form-control:focus {
            border-color: #80bdff;
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
        }
        #results-count {
            background-color: #0d6efd;
            color: #fff;
            font-size: 1.25rem;
            font-weight: 700;
            border-radius: 0.5rem;
            text-align: center;
        }
        #clear-search:hover {
            background-color: #dc3545;
            color: #fff;
            border-color: #dc3545;
        }
        .btn:active {
            transform: scale(0.97);
            opacity: 0.85;
        }
        /* ضمان محاذاة العناصر في سطر واحد */
        .row.align-items-end {
            display: flex;
            align-items: flex-end;
        }
    </style>
@endsection
