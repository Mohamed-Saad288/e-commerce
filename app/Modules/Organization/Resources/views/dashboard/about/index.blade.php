@extends('dashboard.master')
@section('title', __('about.'.$type))

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">{{ __('about.'.$type) }}</h4>
                        @if($type != 'about')
                            @can('create_abouts')
                                <a href="{{ route('admin.abouts.create', ['type' => $type]) }}" class="btn btn-primary">
                                    {{ __('about.add') }}
                                </a>
                            @endcan
                        @endif
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">

                            <table class="table datatables" id="dataTable-1">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('keys.name') }}</th>
                                    <th>{{ __('keys.status') }}</th>
                                    <th>{{ __('keys.actions') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if (count($abouts) > 0)
                                    @foreach ($abouts as $about)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $about?->name ?? '' }}</td>
                                            <td>
                                                @can('active_abouts')
                                                    <div class="custom-control custom-switch">
                                                        <input type="checkbox"
                                                               class="custom-control-input toggle-status"
                                                               id="toggleStatus{{ $about->id }}"
                                                               data-id="{{ $about->id }}"
                                                            {{ $about->is_active ? 'checked' : '' }}>
                                                        <label class="custom-control-label"
                                                               for="toggleStatus{{ $about->id }}"></label>
                                                    </div>
                                            </td>

                                            @endcan
                                            <td>
                                                <a href="{{ route('admin.abouts.edit', ['about' => $about->id, 'type' => $type]) }}"
                                                   class="btn btn-sm btn-success">
                                                    <i class='fe fe-edit fa-2x'></i>
                                                </a>

                                                <button class="btn btn-sm btn-danger delete-about"
                                                        data-id="{{ $about->id }}">
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

            $('.toggle-status').change(function () {
                let aboutId = $(this).data('id');

                $.ajax({
                    url: "{{ route('admin.abouts.changeStatus', ':id') }}".replace(':id',
                        aboutId),
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        about_id: aboutId, // The about ID to change the status
                    },
                    success: function (response) {
                        if (response.success) {
                            toastr.success(
                                "{{ __('about.the about status updated successfully') }}"
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


            $(document).on('click', '.delete-about', function (e) {
                e.preventDefault();
                let aboutId = $(this).data('id');
                let deleteUrl = "{{ route('admin.abouts.destroy', ':id') }}".replace(':id',
                    aboutId);
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
