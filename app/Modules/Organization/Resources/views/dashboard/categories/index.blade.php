@extends('organization::dashboard.master')
@section('title', __('organizations.categories'))

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">{{ __('organizations.categories') }}</h4>
                        <a href="{{ route('organization.categories.create') }}" class="btn btn-primary">
                            <i class="fe fe-plus-circle me-1"></i>{{ __('organizations.add_category') }}
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
                        <div id="categories-table-container">
                            @include('organization::dashboard.categories.partials._table')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endSection

@section('after_script')
    <script>
        // اجعل الدالة متاحة في الـ Global Scope
        function updateResultsCount() {
            let rowsCount = $('#categories-table-container tbody tr').not(':has(.no-data)').length;
            $('#results-count').text(rowsCount);
        }

        $(document).ready(function () {
            let searchTimeout;

            // تحديث العداد عند الصفحة الأولى
            updateResultsCount();

            $('#search-input').on('keyup', function () {
                clearTimeout(searchTimeout);
                let query = $(this).val();
                searchTimeout = setTimeout(() => searchCategories(query), 400);
            });

            $('#clear-search').on('click', function () {
                $('#search-input').val('');
                searchCategories('');
            });

            $(document).on('click', '.pagination a', function (e) {
                e.preventDefault();
                let pageUrl = $(this).attr('href');
                searchCategories($('#search-input').val(), pageUrl);
            });

            function searchCategories(query = '', pageUrl = "{{ route('organization.categories.index') }}") {
                $.ajax({
                    url: pageUrl,
                    type: "GET",
                    data: { search: query },
                    beforeSend: function () {
                        $('#categories-table-container').html(`
                        <div class="text-center py-5">
                            <div class="spinner-border text-primary" style="width:3rem;height:3rem;" role="status">
                                <span class="visually-hidden">{{ __('messages.loading') }}</span>
                            </div>
                            <p class="mt-3 text-muted">{{ __('messages.loading') }}...</p>
                        </div>
                    `);
                    },
                    success: function (response) {
                        $('#categories-table-container').html(response);
                        updateResultsCount();
                    },
                    error: function () {
                        Swal.fire("{{ __('messages.error') }}", "{{ __('messages.error_occurred') }}", "error");
                    }
                });
            }
        });

        // Event الحذف يجب يبقى خارج الـ ready
        $(document).on('click', '.delete-category', function (e) {
            e.preventDefault();
            let id = $(this).data('id');
            let url = "{{ route('organization.categories.destroy', ':id') }}".replace(':id', id);
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
                        url: url,
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            _method: "DELETE"
                        },
                        success: function (response) {
                            if (response.success) {
                                Swal.fire("{{ __('messages.deleted') }}", response.message, "success");

                                row.fadeOut(300, function () {
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
