@extends('organization::dashboard.master')
@section('title', __('organizations.subcategories'))

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">
                            {{ __('organizations.subcategories_for') }}:
                            <span class="text-primary">{{ $parent->translate(app()->getLocale())->name }}</span>
                        </h4>
                        <a href="{{ route('organization.categories.create', ['parent_id' => $parent->id]) }}"
                           class="btn btn-primary">
                            <i class="fe fe-plus me-1"></i> {{ __('organizations.add_subcategory') }}
                        </a>
                    </div>

                    <div class="card-body">

                        {{-- 🔍 مربع البحث --}}
                        <div class="row mb-4 align-items-center">
                            <div class="col-md-10">
                                <label class="form-label small text-muted mb-1">{{ __('messages.search') }}</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="fe fe-search text-muted"></i>
                                    </span>
                                    <input type="text" class="form-control border-start-0 ps-0" id="search-input"
                                           placeholder="{{ __('messages.search') }}...">
                                    <button class="btn btn-outline-secondary" type="button" id="clear-search" title="{{ __('messages.clear') }}">
                                        <i class="fe fe-x"></i>
                                    </button>
                                </div>
                            </div>

                            {{-- 📊 عداد النتائج --}}
                            <div class="col-md-2 text-end">
                                <label class="form-label small text-muted mb-1">{{ __('messages.results') }}</label>
                                <div class="badge bg-primary fs-6 py-2 px-3 w-100" id="results-count">0</div>
                            </div>
                        </div>

                        {{-- 📋 جدول --}}
                        <div id="subcategories-table-container">
                            @include('organization::dashboard.categories.partials._sub_table')
                        </div>

                        {{-- 🔙 زر الرجوع --}}
                        <a href="{{ route('organization.categories.index') }}" class="btn btn-secondary mt-3">
                            <i class="fe fe-arrow-left me-1"></i> {{ __('messages.back') }}
                        </a>
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

            updateResultsCount();

            // 🔍 البحث الحي
            $('#search-input').on('keyup', function () {
                clearTimeout(searchTimeout);
                let query = $(this).val();
                searchTimeout = setTimeout(() => searchSubCategories(query), 400);
            });

            // ❌ زر مسح البحث
            $('#clear-search').on('click', function () {
                $('#search-input').val('');
                searchSubCategories('');
            });

            // 📄 Pagination
            $(document).on('click', '.pagination a', function (e) {
                e.preventDefault();
                let pageUrl = $(this).attr('href');
                let query = $('#search-input').val();
                searchSubCategories(query, pageUrl);
            });

            // 🧠 دالة البحث
            function searchSubCategories(query = '', pageUrl = "{{ route('organization.categories.subcategories', $parent->id) }}") {
                $.ajax({
                    url: pageUrl,
                    type: "GET",
                    data: { search: query },
                    beforeSend: function () {
                        $('#subcategories-table-container').html(`
                            <div class="text-center py-5">
                                <div class="spinner-border text-primary" style="width:3rem;height:3rem;" role="status">
                                    <span class="visually-hidden">{{ __('messages.loading') }}</span>
                                </div>
                                <p class="mt-3 text-muted">{{ __('messages.loading') }}...</p>
                            </div>
                        `);
                    },
                    success: function (response) {
                        $('#subcategories-table-container').html(response);
                        updateResultsCount();
                    },
                    error: function () {
                        Swal.fire("{{ __('messages.error') }}", "{{ __('messages.error_occurred') }}", "error");
                    }
                });
            }

            // 🔢 تحديث عداد النتائج
            function updateResultsCount() {
                let rowsCount = $('#subcategories-table-container tbody tr').not(':has(.no-data)').length;
                $('#results-count').text(rowsCount);
            }
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

        /* تأثير الضغط */
        .btn:active {
            transform: scale(0.97);
            opacity: 0.85;
        }
    </style>
@endsection
