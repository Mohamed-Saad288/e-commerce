@extends('organization::dashboard.master')
@section('title', __('messages.supervisors'))

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">

                <div class="card shadow-sm border-0 rounded-3">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center border-bottom">
                        <h4 class="card-title mb-0 text-primary">
                            <i class="fe fe-users me-2"></i> {{ __('organizations.supervisors') }}
                        </h4>
                        <a href="{{ route('organization.employees.create') }}" class="btn btn-primary">
                            <i class="fe fe-plus me-1"></i> {{ __('organizations.add_supervisor') }}
                        </a>
                    </div>

                    <div class="card-body">
                        <!-- 🔍 Search -->
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

                        <!-- 📋 Table -->
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('messages.name') }}</th>
                                    <th>{{ __('messages.email') }}</th>
                                    <th>{{ __('messages.phone') }}</th>
                                    <th class="text-center">{{ __('messages.actions') }}</th>
                                </tr>
                                </thead>
                                <tbody id="employees-table-body">
                                @forelse ($employees as $employee)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $employee->name ?? '-' }}</td>
                                        <td>{{ $employee->email ?? '-' }}</td>
                                        <td>{{ $employee->phone ?? '-' }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('organization.employees.edit', $employee->id) }}"
                                               class="btn btn-outline-success btn-sm" title="{{ __('messages.edit') }}">
                                                <i class="fe fe-edit"></i>
                                            </a>
                                            <button class="btn btn-outline-danger btn-sm delete-employee"
                                                    data-id="{{ $employee->id }}"
                                                    title="{{ __('messages.delete') }}">
                                                <i class="fe fe-trash-2"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4">
                                            <div class="no-data">
                                                <img src="{{ asset('no-data.png') }}" alt="No Data Found"
                                                     class="mb-2" style="max-width: 120px;">
                                                <p class="text-muted">{{ __('messages.no_data') }}</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- 📄 Pagination -->
                        <div class="d-flex justify-content-center mt-4 rtl" dir="rtl">
                            {{ $employees->onEachSide(1)->links('pagination::bootstrap-5') }}
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
            let searchTimeout;

            // 🔎 Live Search
            $('#search-input').on('keyup', function () {
                clearTimeout(searchTimeout);
                let query = $(this).val();
                searchTimeout = setTimeout(() => searchEmployees(query), 400);
            });

            // ❌ Clear Search
            $('#clear-search').on('click', function () {
                $('#search-input').val('');
                searchEmployees('');
            });

            // 📡 Ajax Search Function
            function searchEmployees(query) {
                $.ajax({
                    url: "{{ route('organization.employees.search') }}",
                    type: "GET",
                    data: { search: query },
                    beforeSend: function () {
                        $('#employees-table-body').html(`
                        <tr>
                            <td colspan="5" class="text-center">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">{{ __('messages.loading') }}...</span>
                                </div>
                            </td>
                        </tr>
                    `);
                    },
                    success: function (response) {
                        $('#employees-table-body').html(response.html);
                    },
                    error: function () {
                        Swal.fire(
                            "{{ __('messages.error') }}",
                            "{{ __('messages.error_occurred') }}",
                            "error"
                        );
                    }
                });
            }

            // 🗑️ Delete Employee
            $(document).on('click', '.delete-employee', function (e) {
                e.preventDefault();
                const employeeId = $(this).data('id');
                const deleteUrl = "{{ route('organization.employees.destroy', ':id') }}".replace(':id', employeeId);
                const row = $(this).closest('tr');

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
                                    Swal.fire("{{ __('messages.deleted') }}", response.message, "success");
                                    row.fadeOut(400, () => row.remove());
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
        });
    </script>
@endsection
