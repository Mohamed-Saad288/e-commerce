@extends('dashboard.master')
@section('title', __('keys.roles'))

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">{{ __('keys.roles') }}</h4>
                        @can('create_roles')
                            <a href="{{ route('admin.roles.create') }}" class="btn btn-primary">
                                {{ __('keys.add_role') }}
                            </a>
                        @endcan

                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table datatables" id="dataTable-1">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('keys.title') }}</th>
                                    {{--                                    <th>{{ __('keys.status') }}</th>--}}
                                    <th>{{ __('keys.actions') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if (count($roles) > 0)
                                    @foreach ($roles as $role)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $role->name }}</td>
                                            {{--                                            <td>--}}
                                            {{--                                                <div class="custom-control custom-switch">--}}
                                            {{--                                                    <input type="checkbox" class="custom-control-input toggle-status"--}}
                                            {{--                                                           id="toggleStatus{{ $role->id }}"--}}
                                            {{--                                                           data-id="{{ $role->id }}"--}}
                                            {{--                                                        {{ $role->is_active ? 'checked' : '' }}>--}}
                                            {{--                                                    <label class="custom-control-label"--}}
                                            {{--                                                           for="toggleStatus{{ $role->id }}"></label>--}}
                                            {{--                                                </div>--}}
                                            {{--                                            </td>--}}
                                            <td>
                                                @can('update_roles')

                                                    <a href="{{ route('admin.roles.edit', $role->id) }}"
                                                       class="btn btn-sm btn-success">
                                                        <i class='fe fe-edit fa-2x'></i>
                                                    </a>
                                                @endcan
                                                @can('delete_roles')
                                                    <button class="btn btn-sm btn-danger delete-role"
                                                            data-id="{{ $role->id }}">
                                                        <i class="fe fe-trash-2 fa-2x"></i>
                                                    </button>
                                                @endcan

                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="100%">
                                            <div class="alert alert-primary text-center">
                                                {{ __('keys.no_found_records') }}
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
@endsection

@section('after_script')

    <script>
        $(document).ready(function () {
            // Toggle role status
            $('.toggle-status').change(function () {
                let roleId = $(this).data('id');

                $.ajax({
                    url: "{{ route('admin.roles.changeStatus', ':id') }}".replace(':id', roleId),
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        role_id: roleId,
                    },
                    success: function (response) {
                        if (response.success) {
                            toastr.success("{{ __('roles.the role status updated successfully') }}");
                        } else {
                            toastr.error("{{ __('keys.something_wrong') }}");
                        }
                    },
                    error: function () {
                        toastr.error("{{ __('keys.error_occurred') }}");
                    }
                });
            });

            // Delete role

            $(document).on('click', '.delete-role', function (e) {
                e.preventDefault();
                let roleId = $(this).data('id');
                let deleteUrl = "{{ route('admin.roles.destroy', ':id') }}".replace(':id', roleId);
                let row = $(this).closest('tr');

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
