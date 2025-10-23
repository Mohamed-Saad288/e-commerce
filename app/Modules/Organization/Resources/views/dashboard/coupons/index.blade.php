@extends('organization::dashboard.master')
@section('title', __('messages.coupons'))

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">{{ __('organizations.coupons') }}</h4>
                            <a href="{{ route('organization.coupons.create') }}" class="btn btn-primary">
                                {{ __('organizations.add_coupon') }}
                            </a>
                    </div>
                    <div class="card-body">
                        <!-- 🔍 البحث -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-text bg-white"><i class="fe fe-search"></i></span>
                                    <input type="text" class="form-control" id="search-input"
                                           placeholder="{{ __('messages.search') }}...">
                                    <button class="btn btn-outline-secondary" type="button" id="clear-search">
                                        <i class="fe fe-x"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- 📋 الجدول -->
                        <div id="coupons-table-container">
                            @include('organization::dashboard.coupons.partials._table')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endSection

@section('after_script')

    <script>

            $(document).on('click', '.delete-coupon', function (e) {
                e.preventDefault();
                let couponId = $(this).data('id');
                let deleteUrl = "{{ route('organization.coupons.destroy', ':id') }}".replace(':id', couponId);
                let row = $(this).closest('tr'); // Select the row to remove

                // SweetAlert confirmation
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

            $(document).on('click', '.toggle-status', function (e) {
                e.preventDefault();
                let button = $(this);
                let couponId = button.data('id');
                let url = "{{ route('organization.coupons.toggleStatus', ':id') }}".replace(':id', couponId);

                $.ajax({
                    url: url,
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function (response) {
                        if (response.success) {
                            if (response.status) {
                                button.removeClass('btn-secondary').addClass('btn-success')
                                    .text("{{ __('messages.active') }}");
                            } else {
                                button.removeClass('btn-success').addClass('btn-secondary')
                                    .text("{{ __('messages.inactive') }}");
                            }

                            Swal.fire({
                                icon: 'success',
                                title: response.message,
                                showConfirmButton: false,
                                timer: 1000
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
                    }
                });
            });
            $(document).ready(function () {
                let searchTimeout;

                // 🔎 Live Search
                $('#search-input').on('keyup', function () {
                    clearTimeout(searchTimeout);
                    let query = $(this).val();
                    searchTimeout = setTimeout(() => searchCoupons(query), 400);
                });

                // ❌ Clear Search
                $('#clear-search').on('click', function () {
                    $('#search-input').val('');
                    searchCoupons('');
                });

                // 📡 Ajax Search + Pagination
                function searchCoupons(query, pageUrl = "{{ route('organization.coupons.index') }}") {
                    $.ajax({
                        url: pageUrl,
                        type: "GET",
                        data: { search: query },
                        beforeSend: function () {
                            $('#coupons-table-container').html(`
                    <div class="text-center py-4">
                        <div class="spinner-border text-primary" role="status"></div>
                    </div>
                `);
                        },
                        success: function (response) {
                            $('#coupons-table-container').html(response);
                        },
                        error: function () {
                            Swal.fire("{{ __('messages.error') }}", "{{ __('messages.error_occurred') }}", "error");
                        }
                    });
                }

                // 📄 Handle pagination
                $(document).on('click', '.pagination a', function (e) {
                    e.preventDefault();
                    let pageUrl = $(this).attr('href');
                    let query = $('#search-input').val();
                    searchCoupons(query, pageUrl);
                });
            });
    </script>

@endsection
