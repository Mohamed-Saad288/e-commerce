@extends('organization::dashboard.master')
@section('title', __('messages.our_teams'))

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-our_team d-flex justify-content-between align-items-center">
                        <h4 class="card-title">{{ __('organizations.our_teams') }}</h4>
                        <a href="{{ route('organization.our_teams.create') }}" class="btn btn-primary">
                            {{ __('organizations.add_our_team') }}
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">

                            <table class="table datatables" id="dataTable-1">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('messages.name') }}</th>
                                    {{--                                    <th>{{ __('messages.role') }}</th>--}}
                                    {{--                                    <th>{{ __('messages.status') }}</th>--}}
                                    <th>{{ __('messages.actions') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if (count($our_teams) > 0)
                                    @foreach ($our_teams as $our_team)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $our_team->name ?? '-' }}</td>>
                                            <td>
                                                <a href="{{ route('organization.our_teams.edit', $our_team->id) }}"
                                                   class="btn btn-sm btn-success">
                                                    <i class='fe fe-edit fa-2x'></i>
                                                </a>
                                                <button class="btn btn-sm btn-danger delete-our_team"
                                                        data-id="{{ $our_team->id }}">
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

        $(document).on('click', '.delete-our_team', function (e) {
            e.preventDefault();
            let our_teamId = $(this).data('id');
            let deleteUrl = "{{ route('organization.our_teams.destroy', ':id') }}".replace(':id', our_teamId);
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
