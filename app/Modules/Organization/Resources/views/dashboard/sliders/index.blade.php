@extends('dashboard.master')
@section('title', __('slider.sliders'))

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h2 class="h5 page-title">{{ __('slider.sliders') }}</h2>
                        @can('create_sliders')
                            <a href="{{ route('admin.sliders.create') }}" class="btn btn-primary">
                                {{ __('keys.add_new') }}
                            </a>
                        @endcan
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">

                            <table class="table datatables" id="dataTable-1">
                                <thead>
                                <tr>

                                    <th></th>
                                    <th>#</th>
                                    <th>{{ __('keys.title') }}</th>
                                    <th>{{ __('keys.status') }}</th>
                                    <th>{{ __('keys.actions') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if (count($sliders) > 0)
                                    @foreach ($sliders as $slider)
                                        <tr>
                                            <td>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input">
                                                    <label class="custom-control-label"></label>
                                                </div>
                                            </td>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $slider->name }}</td>

                                            <td>
                                                @can('active_sliders')

                                                    <div class="custom-control custom-switch">
                                                        <input type="checkbox"
                                                               class="custom-control-input toggle-status"
                                                               id="customSwitch{{ $slider->id }}"
                                                               data-id="{{ $slider->id }}"
                                                            {{ $slider->is_active ? 'checked' : '' }}>
                                                        <label class="custom-control-label"
                                                               for="customSwitch{{ $slider->id }}"></label>
                                                    </div>
                                                @endcan

                                            </td>
                                            <td style="width:10%">
                                                @can('update_sliders')

                                                    <a href="{{ route('admin.sliders.edit', $slider->id) }}"
                                                       class="btn btn-sm btn-success">
                                                        <i class='fe fe-edit fa-2x'></i>
                                                    </a>
                                                @endcan
                                                @can('delete_sliders')
                                                    <button class="btn btn-sm btn-danger delete-slider"
                                                            data-id="{{ $slider->id }}">
                                                        <i class="fe fe-trash-2 fa-2x"></i>
                                                    </button>
                                                @endcan

                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="100%">
                                            <div class="no-data">
                                                <img src="{{ asset('no-data.png') }}" alt="No Data Found">
                                                <p>{{ __('keys.no_data') }}</p>
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
        $(document).ready(function () {
            $('.toggle-status').on('change', function () {
                var sliderId = $(this).data('id');

                $.ajax({
                    url: '/admin/change_status/sliders/' + sliderId,
                    method: 'get',
                    data: {
                        _token: '{{ csrf_token() }}',
                    },
                    success: function (response) {
                        if (response.success) {
                            toastr.success(
                                "{{ __('slider.the slider status updated successfully') }}"
                            );
                        } else {
                            toastr.error("{{ __('keys.something_wrong') }}");
                        }
                    },
                    error: function () {
                        toastr.error("{{ __('keys.error_occurred') }}");
                    }
                });
            });


            $(document).on('click', '.delete-slider', function (e) {
                e.preventDefault();
                let sliderId = $(this).data('id');
                let deleteUrl = "{{ route('admin.sliders.destroy', ':id') }}".replace(':id', sliderId);
                let row = $(this).closest('tr'); // Select the row to remove

                // SweetAlert confirmation
                Swal.fire({
                    title: "{{ __('keys.confirm_delete') }}",
                    text: "{{ __('keys.are_you_sure') }}",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "{{ __('keys.yes_delete') }}",
                    cancelButtonText: "{{ __('keys.no_cancel') }}"
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
                                    Swal.fire("{{ __('keys.deleted') }}",
                                        response.message,
                                        "success");
                                    row.fadeOut(500, function () {
                                        $(this).remove();
                                    });
                                } else {
                                    Swal.fire("{{ __('keys.error') }}",
                                        "{{ __('keys.something_wrong') }}",
                                        "error");
                                }
                            },
                            error: function () {
                                Swal.fire("{{ __('keys.error') }}",
                                    "{{ __('keys.error_occurred') }}", "error");
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection
