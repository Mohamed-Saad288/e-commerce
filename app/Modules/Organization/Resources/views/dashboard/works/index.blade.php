@extends('dashboard.master')
@section('title', __('work.works'))

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h2 class="h5 page-title">{{ __('work.works') }}</h2>
                        @can('create_works')
                            <a href="{{ route('admin.works.create') }}" class="btn btn-primary">
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
                                @if (count($works) > 0)
                                    @foreach ($works as $work)
                                        <tr>
                                            <td>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input">
                                                    <label class="custom-control-label"></label>
                                                </div>
                                            </td>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $work->name }}</td>

                                            <td>
                                                @can('active_works')
                                                    <div class="custom-control custom-switch">
                                                        <input type="checkbox"
                                                               class="custom-control-input toggle-status"
                                                               id="customSwitch{{ $work->id }}"
                                                               data-id="{{ $work->id }}"
                                                            {{ $work->is_active ? 'checked' : '' }}>
                                                        <label class="custom-control-label"
                                                               for="customSwitch{{ $work->id }}"></label>
                                                    </div>
                                                @endcan
                                            </td>
                                            <td style="width:10%">
                                                @can('update_works')
                                                    <a href="{{ route('admin.works.edit', $work->id) }}"
                                                       class="btn btn-sm btn-success">
                                                        <i class='fe fe-edit fa-2x'></i>
                                                    </a>
                                                @endcan
                                                @can('delete_works')
                                                    <button class="btn btn-sm btn-danger delete-work"
                                                            data-id="{{ $work->id }}">
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
                var workId = $(this).data('id');

                $.ajax({
                    url: '/admin/change_status/works/' + workId,
                    method: 'get',
                    data: {
                        _token: '{{ csrf_token() }}',
                    },
                    success: function (response) {
                        if (response.success) {
                            toastr.success(
                                "{{ __('work.the work status updated successfully') }}");
                        } else {
                            toastr.error("{{ __('keys.something_wrong') }}");
                        }
                    },
                    error: function () {
                        toastr.error("{{ __('keys.error_occurred') }}");
                    }
                });
            });


            $(document).on('click', '.delete-work', function (e) {
                e.preventDefault();
                let workId = $(this).data('id');
                let deleteUrl = "{{ route('admin.works.destroy', ':id') }}".replace(':id', workId);
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
