@extends('organization::dashboard.master')
@section('title', __('organizations.option_items'))

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">{{ __('organizations.option_items') }}</h4>
                        <a href="{{ route('organization.option_items.create') }}" class="btn btn-primary">
                            <i class="fe fe-plus-circle me-1"></i>{{ __('organizations.add_option_item') }}
                        </a>
                    </div>

                    <div class="card-body">
                        {{-- 🔍 مربع البحث والفلاتر --}}
                        <div class="row mb-4 align-items-end">
                            <div class="col-md-6">
                                <label class="form-label small text-muted mb-1">{{ __('messages.search') }}</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="fe fe-search text-muted"></i>
                                    </span>
                                    <input type="text" class="form-control border-start-0 ps-0" id="search-input"
                                           placeholder="{{ __('messages.search') }}...">
                                    <button class="btn btn-outline-secondary" type="button" id="clear-search"
                                            title="{{ __('messages.clear') }}">
                                        <i class="fe fe-x"></i>
                                    </button>
                                </div>
                            </div>

                            {{-- 🧮 فلتر بالأوبشن --}}
                            <div class="col-md-4">
                                <label class="form-label small text-muted mb-1">{{ __('organizations.option') }}</label>
                                <select class="form-select" id="filter-option" data-bs-toggle="tooltip" title="{{ __('messages.select_option') }}">
                                    <option value="">{{ __('messages.all') }}</option>
                                    @foreach($options as $option)
                                        <option value="{{ $option->id }}">{{ $option->translate(app()->getLocale())->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- 📊 عداد النتائج --}}
                            <div class="col-md-2 text-end">
                                <label class="form-label small text-muted mb-1">{{ __('messages.results') }}</label>
                                <div class="badge bg-primary fs-6 py-2 px-3 w-100" id="results-count">0</div>
                            </div>
                        </div>

                        {{-- 📋 جدول --}}
                        <div id="option-items-table-container">
                            @include('organization::dashboard.option_items.partials._table', ['option_items' => $option_items])
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
            // تهيئة Select2 لفلتر الأوبشن (اختيار واحد)
            $('#filter-option').select2({
                placeholder: "{{ __('messages.all') }}",
                allowClear: true,
                width: '100%',
                language: "{{ app()->getLocale() }}",
                theme: 'bootstrap-5',
                dropdownCssClass: 'custom-select2-dropdown',
                minimumResultsForSearch: 10, // إظهار البحث إذا كان هناك أكثر من 10 خيارات
                templateResult: formatOption, // تنسيق مخصص للعناصر
                templateSelection: formatOption // تنسيق مخصص للعنصر المحدد
            });

            // دالة تنسيق العناصر في القائمة المنسدلة
            function formatOption(option) {
                if (!option.id) {
                    return option.text; // لخيار "الكل"
                }
                return $('<span><i class="fe fe-tag me-2"></i>' + option.text + '</span>');
            }

            let searchTimeout;

            updateResultsCount();

            // 🔍 البحث الحي
            $('#search-input').on('keyup', function () {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => fetchOptionItems(), 400);
            });

            // 🔽 فلتر بالأوبشن
            $('#filter-option').on('change', function () {
                fetchOptionItems();
            });

            // ❌ مسح البحث
            $('#clear-search').on('click', function () {
                $('#search-input').val('');
                $('#filter-option').val('').trigger('change');
                fetchOptionItems();
            });

            // 🖱️ إعادة تعيين الفلتر عند اختيار "الكل"
            $('#filter-option').on('select2:clear', function () {
                fetchOptionItems();
            });

            // 📄 Pagination AJAX
            $(document).on('click', '.pagination a', function (e) {
                e.preventDefault();
                let pageUrl = $(this).attr('href');
                fetchOptionItems(pageUrl);
            });

            // 🧠 دالة جلب النتائج
            function fetchOptionItems(pageUrl = "{{ route('organization.option_items.index') }}") {
                let search = $('#search-input').val();
                let option_id = $('#filter-option').val() || '';

                $.ajax({
                    url: pageUrl,
                    type: "GET",
                    data: { search, option_id },
                    beforeSend: function () {
                        $('#option-items-table-container').html(`
                            <div class="text-center py-5">
                                <div class="spinner-border text-primary" style="width:3rem;height:3rem;" role="status">
                                    <span class="visually-hidden">{{ __('messages.loading') }}</span>
                                </div>
                                <p class="mt-3 text-muted">{{ __('messages.loading') }}...</p>
                            </div>
                        `);
                    },
                    success: function (response) {
                        $('#option-items-table-container').html(response);
                        updateResultsCount();
                    },
                    error: function () {
                        Swal.fire("{{ __('messages.error') }}", "{{ __('messages.error_occurred') }}", "error");
                    }
                });
            }

            // 🔢 تحديث عداد النتائج
            function updateResultsCount() {
                let rowsCount = $('#option-items-table-container tbody tr').not(':has(.no-data)').length;
                $('#results-count').text(rowsCount);
            }

            // 🗑️ حذف
            $(document).on('click', '.delete-option_item', function (e) {
                e.preventDefault();
                let id = $(this).data('id');
                let deleteUrl = "{{ route('organization.option_items.destroy', ':id') }}".replace(':id', id);
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
                            data: { _token: "{{ csrf_token() }}", _method: "DELETE" },
                            success: function (response) {
                                if (response.success) {
                                    Swal.fire("{{ __('messages.deleted') }}", response.message, "success");
                                    row.fadeOut(400, function () {
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

            // 🖮 دعم اختصارات لوحة المفاتيح
            $(document).on('keydown', function (e) {
                if (e.key === 'Escape') {
                    $('#search-input').val('');
                    $('#filter-option').val('').trigger('change');
                    fetchOptionItems();
                }
            });
        });
    </script>

    <style>
        .select2-container--bootstrap-5 .select2-selection {
            border-radius: 0.5rem;
            border: 1px solid #ced4da;
            height: 40px;
            padding: 0.375rem 0.75rem;
            display: flex;
            align-items: center;
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
    </style>
@endsection
