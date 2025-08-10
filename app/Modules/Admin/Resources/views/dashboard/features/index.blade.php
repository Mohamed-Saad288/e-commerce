@extends('admin::dashboard.master')
@section('title', __('keys.features'))

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">{{ __('keys.features') }}</h4>
{{--                        @can('create_fags')--}}
                            <a href="{{ route('admin.features.create') }}" class="btn btn-primary">
                                {{ __('keys.add_feature') }}
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
                                    <th>{{ __('keys.description') }}</th>
                                    <th>{{ __('keys.slug') }}</th>
                                    <th>{{ __('keys.type') }}</th>
                                    <th>{{ __('keys.status') }}</th>
                                    <th>{{ __('keys.actions') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if (count($features) > 0)
                                    @foreach ($features as $feature)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $feature->name }}</td>
                                            <td>{{ Str::limit($feature->description, 50) }}</td>
                                            <td>{{ $feature->slug }}</td>
                                            <td>{{ $feature->type }}</td>

                                            <td>
{{--                                                @can('active_fags')--}}
                                                    <div class="custom-control custom-switch">
                                                        <input type="checkbox"
                                                               class="custom-control-input toggle-status"
                                                               id="toggleStatus{{ $feature->id }}"
                                                               data-id="{{ $feature->id }}"
                                                            {{ $feature->is_active ? 'checked' : '' }}>
                                                        <label class="custom-control-label"
                                                               for="toggleStatus{{ $feature->id }}"></label>
                                                    </div>
{{--                                                @endcan--}}
                                            </td>

                                            <td>
{{--                                                @can('create_fags')--}}
                                                    <a href="{{ route('admin.features.edit', $feature->id) }}"
                                                       class="btn btn-sm btn-success">
                                                        <i class='fe fe-edit fa-2x'></i>
                                                    </a>
{{--                                                @endcan--}}
{{--                                                @can('delete_fags')--}}

                                                    <button class="btn btn-sm btn-danger delete-faq"
                                                            data-id="{{ $feature->id }}">
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
                let faqId = $(this).data('id');

                $.ajax({
                    url: "{{ route('admin.features.change_status', ':id') }}".replace(':id', faqId),
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        faq_id: faqId, // The faq ID to change the status
                    },
                    success: function (response) {
                        if (response.success) {
                            toastr.success(
                                "{{ __('keys.the faq status updated successfully') }}");
                        } else {
                            toastr.error("{{ __('keys.something_wrong') }}");
                        }
                    },
                    error: function () {
                        toastr.error("{{ __('keys.error_occurred') }}");
                    }
                });
            });


            $(document).on('click', '.delete-faq', function (e) {
                e.preventDefault();
                let featureId = $(this).data('id');
                let deleteUrl = "{{ route('admin.features.destroy', ':id') }}".replace(':id', featureId);
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
