@extends('admin::dashboard.master')
@section('title', __('messages.admins'))

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">{{ __('messages.admins') }}</h4>
{{--                        @can('create_employees')--}}
                            <a href="{{ route('admin.admins.create') }}" class="btn btn-primary">
                                {{ __('messages.add_admin') }}
                            </a>
{{--                        @endcan--}}
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">

                            <table class="table datatables" id="dataTable-1">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('messages.name') }}</th>
                                    <th>{{ __('messages.email') }}</th>
                                    <th>{{ __('messages.phone') }}</th>
{{--                                    <th>{{ __('messages.status') }}</th>--}}
                                    <th>{{ __('messages.actions') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if (count($admins) > 0)
                                    @foreach ($admins as $admin)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $admin->name }}</td>
                                            <td>{{ $admin->email }}</td>
                                            <td>{{ $admin->phone }}</td>
{{--                                            <td>--}}
{{--                                                @can('active_employees')--}}
{{--                                                    <div class="custom-control custom-switch">--}}
{{--                                                        <input type="checkbox"--}}
{{--                                                               class="custom-control-input toggle-status"--}}
{{--                                                               id="toggleStatus{{ $admin->id }}"--}}
{{--                                                               data-id="{{ $admin->id }}"--}}
{{--                                                            {{ $admin->is_active ? 'checked' : '' }}>--}}
{{--                                                        <label class="custom-control-label"--}}
{{--                                                               for="toggleStatus{{ $admin->id }}"></label>--}}
{{--                                                    </div>--}}
{{--                                                @endcan--}}
{{--                                            </td>--}}
                                            <td>
{{--                                                @can('update_employees')--}}
                                                    <a href="{{ route('admin.admins.edit', $admin->id) }}"
                                                       class="btn btn-sm btn-success">
                                                        <i class='fe fe-edit fa-2x'></i>
                                                    </a>
{{--                                                @endcan--}}

{{--                                                @can('delete_employees')--}}
                                                    <button class="btn btn-sm btn-danger delete-admin"
                                                            data-id="{{ $admin->id }}">
                                                        <i class="fe fe-trash-2 fa-2x"></i>
                                                    </button>
{{--                                                @endcan--}}
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
        $(document).ready(function () {

            $(document).on('click', '.delete-admin', function (e) {
                e.preventDefault();
                let blogId = $(this).data('id');
                let deleteUrl = "{{ route('admin.admins.destroy', ':id') }}".replace(':id', blogId);
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
        });
    </script>

@endsection
