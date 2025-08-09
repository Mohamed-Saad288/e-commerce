@extends('dashboard.master')
@section('title', __('keys.users'))

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">{{ __('keys.users') }}</h4>
{{--                        @can('create_employees')--}}
                            <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                                {{ __('keys.add_user') }}
                            </a>
{{--                        @endcan--}}
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">

                            <table class="table datatables" id="dataTable-1">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('keys.name') }}</th>
                                    <th>{{ __('keys.email') }}</th>
                                    <th>{{ __('keys.phone') }}</th>
                                    <th>{{ __('keys.status') }}</th>
                                    <th>{{ __('keys.actions') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if (count($users) > 0)
                                    @foreach ($users as $user)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->phone }}</td>
                                            <td>
{{--                                                @can('active_employees')--}}
                                                    <div class="custom-control custom-switch">
                                                        <input type="checkbox"
                                                               class="custom-control-input toggle-status"
                                                               id="toggleStatus{{ $user->id }}"
                                                               data-id="{{ $user->id }}"
                                                            {{ $user->is_active ? 'checked' : '' }}>
                                                        <label class="custom-control-label"
                                                               for="toggleStatus{{ $user->id }}"></label>
                                                    </div>
{{--                                                @endcan--}}
                                            </td>
                                            <td>
{{--                                                @can('update_employees')--}}
                                                    <a href="{{ route('admin.users.edit', $user->id) }}"
                                                       class="btn btn-sm btn-success">
                                                        <i class='fe fe-edit fa-2x'></i>
                                                    </a>
{{--                                                @endcan--}}

{{--                                                @can('delete_employees')--}}
                                                    <button class="btn btn-sm btn-danger delete-user"
                                                            data-id="{{ $user->id }}">
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
                let blogId = $(this).data('id');

                $.ajax({
                    url: "{{ route('admin.users.changeStatus', ':id') }}".replace(':id',
                        blogId),
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        blog_id: blogId, // The blog ID to change the status
                    },
                    success: function (response) {
                        if (response.success) {
                            toastr.success("{{ __('keys.the status updated successfully') }}");
                        } else {
                            toastr.error("{{ __('keys.something_wrong') }}");
                        }
                    },
                    error: function () {
                        toastr.error("{{ __('keys.error_occurred') }}");
                    }
                });
            });


            $(document).on('click', '.delete-user', function (e) {
                e.preventDefault();
                let blogId = $(this).data('id');
                let deleteUrl = "{{ route('admin.users.destroy', ':id') }}".replace(':id', blogId);
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
