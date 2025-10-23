@extends('organization::dashboard.master')
@section('title', __('messages.coupons'))

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">

                    {{-- 🔹 Header --}}
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">{{ __('organizations.coupons') }}</h4>
                        <a href="{{ route('organization.coupons.create') }}" class="btn btn-primary">
                            <i class="fe fe-plus-circle me-1"></i>{{ __('organizations.add_coupon') }}
                        </a>
                    </div>

                    {{-- 🔹 Filters --}}
                    <div class="card-body">
                        <div class="row mb-4 align-items-center">

                            {{-- 🔍 البحث --}}
                            <div class="col-md-5">
                                <label class="form-label small text-muted mb-1">{{ __('messages.search') }}</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="fe fe-search text-muted"></i>
                                    </span>
                                    <input type="text" class="form-control border-start-0 ps-0" id="search-input"
                                           placeholder="{{ __('messages.search_by_code_or_discount') }}...">
                                    <button class="btn btn-outline-secondary" type="button" id="clear-search" title="{{ __('messages.clear') }}">
                                        <i class="fe fe-x"></i>
                                    </button>
                                </div>
                            </div>

                            {{-- 🔽 فلتر الحالة بشكل أزرار --}}
                            <div class="col-md-5">
                                <label class="form-label small text-muted mb-1">{{ __('messages.filter_by_status') }}</label>
                                <div class="btn-group w-100" role="group" id="status-filter-group">
                                    <input type="radio" class="btn-check" name="status-filter" id="status-all" value="" checked>
                                    <label class="btn btn-outline-primary" for="status-all">
                                        <i class="fe fe-list me-1"></i>{{ __('messages.all') }}
                                    </label>

                                    <input type="radio" class="btn-check" name="status-filter" id="status-active" value="active">
                                    <label class="btn btn-outline-success" for="status-active">
                                        <i class="fe fe-check-circle me-1"></i>{{ __('messages.active') }}
                                    </label>

                                    <input type="radio" class="btn-check" name="status-filter" id="status-inactive" value="inactive">
                                    <label class="btn btn-outline-secondary" for="status-inactive">
                                        <i class="fe fe-x-circle me-1"></i>{{ __('messages.inactive') }}
                                    </label>
                                </div>
                            </div>

                            {{-- 📊 عداد النتائج --}}
                            <div class="col-md-2 text-end">
                                <label class="form-label small text-muted mb-1">{{ __('messages.results') }}</label>
                                <div class="badge bg-primary fs-6 py-2 px-3 w-100" id="results-count">0</div>
                            </div>

                        </div>

                        {{-- 📋 جدول الكوبونات --}}
                        <div id="coupons-table-container">
                            @include('organization::dashboard.coupons.partials._table')
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
            let searchTimeout;

            // Update results count on page load
            updateResultsCount();

            // 🟡 البحث الحي
            $('#search-input').on('keyup', function () {
                clearTimeout(searchTimeout);
                let query = $(this).val();
                let status = $('input[name="status-filter"]:checked').val();
                searchTimeout = setTimeout(() => searchCoupons(query, status), 400);
            });

            // 🔘 فلتر الحالة بالأزرار
            $('input[name="status-filter"]').on('change', function () {
                let query = $('#search-input').val();
                let status = $(this).val();
                searchCoupons(query, status);
            });

            // ❌ مسح البحث
            $('#clear-search').on('click', function () {
                $('#search-input').val('');
                let status = $('input[name="status-filter"]:checked').val();
                searchCoupons('', status);
            });

            // 📡 البحث والفلاتر بالـ AJAX
            function searchCoupons(query = '', status = '', pageUrl = "{{ route('organization.coupons.index') }}") {
                $.ajax({
                    url: pageUrl,
                    type: "GET",
                    data: { search: query, status: status },
                    beforeSend: function () {
                        $('#coupons-table-container').html(`
                            <div class="text-center py-5">
                                <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
                                    <span class="visually-hidden">{{ __('messages.loading') }}...</span>
                                </div>
                                <p class="mt-3 text-muted">{{ __('messages.loading') }}...</p>
                            </div>
                        `);
                    },
                    success: function (response) {
                        $('#coupons-table-container').html(response);
                        updateResultsCount();
                    },
                    error: function () {
                        Swal.fire("{{ __('messages.error') }}", "{{ __('messages.error_occurred') }}", "error");
                    }
                });
            }

            // 📊 تحديث عداد النتائج
            function updateResultsCount() {
                let rowsCount = $('#coupons-table-container tbody tr').not(':has(.no-data)').length;
                $('#results-count').text(rowsCount);
            }

            // 📄 التعامل مع الصفحات
            $(document).on('click', '.pagination a', function (e) {
                e.preventDefault();
                let pageUrl = $(this).attr('href');
                let query = $('#search-input').val();
                let status = $('input[name="status-filter"]:checked').val();
                searchCoupons(query, status, pageUrl);
            });

            // 🗑️ حذف الكوبون
            $(document).on('click', '.delete-coupon', function (e) {
                e.preventDefault();
                let couponId = $(this).data('id');
                let deleteUrl = "{{ route('organization.coupons.destroy', ':id') }}".replace(':id', couponId);
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
                                    Swal.fire({
                                        icon: 'success',
                                        title: "{{ __('messages.deleted') }}",
                                        text: response.message,
                                        showConfirmButton: false,
                                        timer: 1500
                                    });
                                    row.fadeOut(500, function () {
                                        $(this).remove();
                                        updateResultsCount();
                                    });
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

            // 🔁 تغيير الحالة
// 🔁 تغيير الحالة
            $(document).off('click', '.toggle-status').on('click', '.toggle-status', function (e) {
                e.preventDefault();
                let button = $(this);
                let couponId = button.data('id');
                let url = "{{ route('organization.coupons.toggleStatus', ':id') }}".replace(':id', couponId);
                let row = button.closest('tr');

                $.ajax({
                    url: url,
                    type: "POST",
                    data: { _token: "{{ csrf_token() }}" },
                    beforeSend: function() {
                        button.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span>...');
                    },
                    success: function (response) {
                        if (response.success) {
                            let activeFilter = $('input[name="status-filter"]:checked').val();

                            if ((activeFilter == 'active' && !response.status) ||
                                (activeFilter == 'inactive' && response.status)) {
                                row.fadeOut(500, function() {
                                    $(this).remove();
                                    updateResultsCount();
                                });
                            } else {
                                if (response.status) {
                                    button
                                        .removeClass('btn-secondary')
                                        .addClass('btn-success')
                                        .html('<i class="fe fe-check-circle me-1"></i>{{ __("messages.active") }}');
                                } else {
                                    button
                                        .removeClass('btn-success')
                                        .addClass('btn-secondary')
                                        .html('<i class="fe fe-x-circle me-1"></i>{{ __("messages.inactive") }}');
                                }
                                button.prop('disabled', false);
                            }

                            Swal.fire({
                                icon: 'success',
                                title: response.message,
                                showConfirmButton: false,
                                timer: 1000,
                                toast: true,
                                position: 'top-end'
                            });
                        }
                    },
                    error: function () {
                        Swal.fire({
                            icon: 'error',
                            title: "{{ __('messages.error_occurred') }}",
                            showConfirmButton: false,
                            timer: 1500
                        });
                        button.prop('disabled', false);
                    }
                });
            });
        });
    </script>

    {{-- 🎨 Custom CSS للتحسينات --}}
    <style>
        <style>
            /* تحسين شكل الـ input group */
        .input-group-text {
            background-color: #f8f9fa;
            border-right: 0;
        }

        .form-control:focus {
            border-color: #80bdff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        /* تحسين أزرار الفلتر */
        .btn-check:checked + .btn-outline-primary {
            background-color: #3d8bfd !important;
            border-color: #3d8bfd !important;
            color: #fff !important;
        }

        .btn-check:checked + .btn-outline-success {
            background-color: #44c08a !important;
            border-color: #44c08a !important;
            color: #fff !important;
        }

        .btn-check:checked + .btn-outline-secondary {
            background-color: #9ca3af !important;
            border-color: #9ca3af !important;
            color: #fff !important;
        }

        /* تحسين عداد النتائج */
        #results-count {
            background-color: #0d6efd;
            color: #fff;
            font-size: 1.25rem; /* أكبر شوية */
            font-weight: 700; /* Bold */
            letter-spacing: 1px;
            border-radius: 0.5rem;
            text-align: center;
        }

        /* تحسين شكل الـ Loading */
        .spinner-border {
            border-width: 3px;
        }

        /* تحسين شكل الأزرار في الجدول */
        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
        }

        /* Smooth transitions */
        .btn, .badge, .form-control {
            transition: all 0.3s ease;
        }

        /* تأثير خفيف عند الضغط على الزر */
        .btn:active {
            transform: scale(0.96);
            opacity: 0.85;
        }
    </style>
@endsection
