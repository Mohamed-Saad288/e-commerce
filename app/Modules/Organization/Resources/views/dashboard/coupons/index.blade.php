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
                                {{ __('organizations.add_supervisor') }}
                            </a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">

                            <table class="table datatables" id="dataTable-1">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('messages.code') }}</th>
                                    <th>{{ __('messages.type') }}</th>
                                    <th>{{ __('messages.value') }}</th>
                                    <th>{{ __('messages.is_active') }}</th>
                                    <th>{{ __('messages.actions') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if (count($coupons) > 0)
                                    @foreach ($coupons as $coupon)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $coupon->code }}</td>
                                        @if($coupon->type == \App\Modules\Organization\Enums\Coupon\CouponTypeEnum::FIXED_AMOUNT->value)
                                                <td>{{ __('messages.fixed_amount') }}</td>
                                            @elseif($coupon->type == \App\Modules\Organization\Enums\Coupon\CouponTypeEnum::PERCENTAGE->value)
                                                <td>{{ __('messages.percentage') }}</td>
                                            @else
                                                <td>{{ __('messages.free_shipping') }}</td>
                                            @endif
                                            <td>{{ $coupon->value }}</td>
                                            <td>{{ $coupon->is_active ? __('messages.active') : __('messages.inactive') }}</td>
                                            <td>
                                                <a href="{{ route('organization.coupons.edit', $coupon->id) }}"
                                                   class="btn btn-sm btn-success">
                                                    <i class='fe fe-edit fa-2x'></i>
                                                </a>
                                                <button class="btn btn-sm btn-danger delete-coupon"
                                                        data-id="{{ $coupon->id }}">
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
    </script>

@endsection
