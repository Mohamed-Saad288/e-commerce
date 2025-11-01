@extends('organization::dashboard.master')
@section('title', __('organizations.options'))

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">{{ __('organizations.options') }}</h4>
                        <a href="{{ route('organization.options.create') }}" class="btn btn-primary">
                            <i class="fe fe-plus-circle me-1"></i>{{ __('organizations.add_option') }}
                        </a>
                    </div>

                    <div class="card-body">
                        {{-- 🔍 مربع البحث والفلترة --}}
                        <div class="row mb-4">
                            {{-- البحث النصي --}}
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

                            {{-- فلتر التصنيف الديناميكي --}}
                            <div class="col-md-4">
                                <label class="form-label small text-muted mb-1">
                                    <i class="fe fe-filter"></i> {{ __('messages.filter_by_category') }}
                                </label>
                                <div id="category-filter-container"></div>
                            </div>

                            {{-- عداد النتائج --}}
                            <div class="col-md-2 text-end">
                                <label class="form-label small text-muted mb-1">{{ __('messages.results') }}</label>
                                <div class="badge bg-primary fs-6 py-2 px-3 w-100" id="results-count">0</div>
                            </div>
                        </div>

                        {{-- عرض الفلاتر النشطة --}}
                        <div id="active-filters" class="mb-3" style="display: none;">
                            <div class="d-flex align-items-center flex-wrap gap-2">
                                <small class="text-muted">{{ __('messages.active_filters') }}:</small>
                                <div id="filter-badges"></div>
                                <button type="button" class="btn btn-sm btn-outline-danger" id="clear-all-filters">
                                    <i class="fe fe-x"></i> {{ __('messages.clear_all') }}
                                </button>
                            </div>
                        </div>

                        {{-- 📋 جدول --}}
                        <div id="options-table-container">
                            @include('organization::dashboard.options.partials._table', ['options' => $options])
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
            let selectedCategories = []; // Array to store selected category path
            let categorySelectsCount = 0; // Track number of category selects

            updateResultsCount();
            initializeCategoryFilter();

            // 🏗️ تهيئة فلتر التصنيفات
            function initializeCategoryFilter() {
                loadCategoryLevel(null, 0);
            }

            // 📥 تحميل مستوى تصنيف
            function loadCategoryLevel(parentId, level) {
                const url = parentId
                    ? `/organizations/categories/${parentId}/children`
                    : '/organizations/categories/roots';

                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(categories) {
                        if (categories.length > 0) {
                            createCategorySelect(categories, level, parentId);
                        } else if (level === 0) {
                            $('#category-filter-container').html(
                                '<p class="text-muted small mb-0">{{ __('messages.no_categories') }}</p>'
                            );
                        }
                    },
                    error: function() {
                        console.error('Error loading categories');
                    }
                });
            }

            // 🎨 إنشاء select للتصنيف
            function createCategorySelect(categories, level, parentId) {
                // Remove all selects after this level
                $(`#category-filter-container .category-select-wrapper[data-level="${level}"]`).nextAll().remove();
                $(`#category-filter-container .category-select-wrapper[data-level="${level}"]`).remove();

                // Trim selectedCategories array
                selectedCategories = selectedCategories.slice(0, level);

                const wrapper = $('<div>', {
                    class: 'category-select-wrapper mb-2',
                    'data-level': level,
                    css: { animation: 'slideIn 0.3s ease-out' }
                });

                const select = $('<select>', {
                    class: 'form-control form-control-sm category-filter-select',
                    'data-level': level
                });

                const defaultOption = $('<option>', {
                    value: '',
                    text: level === 0
                        ? '{{ __('messages.all_categories') }}'
                        : '{{ __('messages.select_or_keep_parent') }}'
                });

                select.append(defaultOption);

                categories.forEach(cat => {
                    const option = $('<option>', {
                        value: cat.id,
                        text: cat.name,
                        'data-has-children': cat.children_count > 0 ? '1' : '0'
                    });
                    select.append(option);
                });

                wrapper.append(select);
                $('#category-filter-container').append(wrapper);

                categorySelectsCount++;

                // Event handler
                select.on('change', function() {
                    const selectedId = $(this).val();
                    const selectedName = $(this).find('option:selected').text();
                    const hasChildren = $(this).find('option:selected').data('has-children');

                    if (selectedId) {
                        selectedCategories[level] = {
                            id: selectedId,
                            name: selectedName
                        };

                        if (hasChildren) {
                            loadCategoryLevel(selectedId, level + 1);
                        } else {
                            // Remove any selects after this
                            $(this).closest('.category-select-wrapper').nextAll().remove();
                            selectedCategories = selectedCategories.slice(0, level + 1);
                        }

                        updateActiveFilters();
                        performSearch();
                    } else {
                        // Clear selection at this level
                        $(this).closest('.category-select-wrapper').nextAll().remove();
                        selectedCategories = selectedCategories.slice(0, level);

                        if (selectedCategories.length === 0) {
                            $('#active-filters').hide();
                        } else {
                            updateActiveFilters();
                        }

                        performSearch();
                    }
                });
            }

            // 🏷️ تحديث عرض الفلاتر النشطة
            function updateActiveFilters() {
                const filterBadges = $('#filter-badges');
                filterBadges.empty();

                if (selectedCategories.length > 0) {
                    $('#active-filters').show();

                    const categoryPath = selectedCategories.map(cat => cat.name).join(' → ');
                    const badge = $('<span>', {
                        class: 'badge bg-info text-white px-3 py-2',
                        html: `<i class="fe fe-tag me-1"></i>${categoryPath}`
                    });

                    filterBadges.append(badge);
                } else {
                    $('#active-filters').hide();
                }
            }

            // 🗑️ مسح كل الفلاتر
            $('#clear-all-filters').on('click', function() {
                selectedCategories = [];
                $('#category-filter-container').empty();
                $('#active-filters').hide();
                initializeCategoryFilter();
                performSearch();
            });

            // 🔍 البحث الحي
            $('#search-input').on('keyup', function () {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => performSearch(), 400);
            });

            // ❌ زر مسح البحث
            $('#clear-search').on('click', function () {
                $('#search-input').val('');
                performSearch();
            });

            // 📄 Pagination AJAX
            $(document).on('click', '.pagination a', function (e) {
                e.preventDefault();
                let pageUrl = $(this).attr('href');
                performSearch(pageUrl);
            });

            // 🧠 دالة البحث المركزية
            function performSearch(pageUrl = "{{ route('organization.options.index') }}") {
                const query = $('#search-input').val();
                const categoryId = selectedCategories.length > 0
                    ? selectedCategories[selectedCategories.length - 1].id
                    : '';

                $.ajax({
                    url: pageUrl,
                    type: "GET",
                    data: {
                        search: query,
                        category_id: categoryId
                    },
                    beforeSend: function () {
                        $('#options-table-container').html(`
                            <div class="text-center py-5">
                                <div class="spinner-border text-primary" style="width:3rem;height:3rem;" role="status">
                                    <span class="visually-hidden">{{ __('messages.loading') }}</span>
                                </div>
                                <p class="mt-3 text-muted">{{ __('messages.loading') }}...</p>
                            </div>
                        `);
                    },
                    success: function (response) {
                        $('#options-table-container').html(response);
                        updateResultsCount();
                    },
                    error: function () {
                        Swal.fire("{{ __('messages.error') }}", "{{ __('messages.error_occurred') }}", "error");
                    }
                });
            }

            // 🔢 تحديث عداد النتائج
            function updateResultsCount() {
                let rowsCount = $('#options-table-container tbody tr').not(':has(.no-data)').length;
                $('#results-count').text(rowsCount);
            }

            // 🗑️ حذف أوبشن
            $(document).on('click', '.delete-option', function (e) {
                e.preventDefault();
                let optionId = $(this).data('id');
                let deleteUrl = "{{ route('organization.options.destroy', ':id') }}".replace(':id', optionId);
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
        });
    </script>

    <style>
        /* 🔍 تصميم البحث */
        .input-group-text {
            background-color: #f8f9fa;
            border-right: 0;
        }
        .form-control:focus {
            border-color: #80bdff;
            box-shadow: 0 0 0 0.2rem rgba(13,110,253,0.25);
        }

        /* 🔢 عداد النتائج */
        #results-count {
            background-color: #0d6efd;
            color: #fff;
            font-size: 1.25rem;
            font-weight: 700;
            letter-spacing: 1px;
            border-radius: 0.5rem;
            text-align: center;
        }

        /* 🎨 تصميم فلتر التصنيفات */
        .category-select-wrapper {
            position: relative;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .category-filter-select {
            font-size: 0.875rem;
        }

        #active-filters {
            background: #f8f9fa;
            padding: 10px 15px;
            border-radius: 6px;
            border: 1px dashed #dee2e6;
        }

        #filter-badges .badge {
            font-size: 0.875rem;
            font-weight: 500;
        }

        /* تأثير الضغط */
        .btn:active {
            transform: scale(0.97);
            opacity: 0.85;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .col-md-6, .col-md-4, .col-md-2 {
                margin-bottom: 15px;
            }
        }
    </style>
@endsection
