@extends('dashboard.master')
@section('title', __('keys.country'))

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">{{ __('keys.countries') }}</h4>
                        @can('create_countries')
                            <a href="{{ route('admin.countries.create') }}" class="btn btn-primary">
                                {{ __('keys.add_country') }}
                            </a>
                        @endcan
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">

                            <table class="table datatables" id="dataTable-1">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('keys.name') }}</th>
                                    <th>{{ __('keys.image') }}</th>
                                    <th>{{ __('keys.status') }}</th>
                                    <th>{{ __('keys.actions') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if (count($countries) > 0)
                                    @foreach ($countries as $country)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $country->translate(app()->getLocale())->name }}</td>
                                            <td>
                                                @if (!empty($country->getFirstMediaUrl('country_images')))
                                                    <img src="{{ $country->getFirstMediaUrl('country_images') }}"
                                                         alt="country Image" width="50">
                                                @else
                                                    <span class="text-muted">{{ __('keys.no_image') }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                @can('active_countries')
                                                    <div class="custom-control custom-switch">
                                                        <input type="checkbox"
                                                               class="custom-control-input toggle-status"
                                                               id="toggleStatus{{ $country->id }}"
                                                               data-id="{{ $country->id }}"
                                                            {{ $country->is_active ? 'checked' : '' }}>
                                                        <label class="custom-control-label"
                                                               for="toggleStatus{{ $country->id }}"></label>
                                                    </div>
                                                @endcan
                                            </td>
                                            <td>
                                                @can('update_countries')
                                                    <a href="{{ route('admin.countries.edit', $country->id) }}"
                                                       class="btn btn-sm btn-success">
                                                        <i class='fe fe-edit fa-2x'></i>
                                                    </a>
                                                @endcan
                                                @can('delete_countries')

                                                    <button class="btn btn-sm btn-danger delete-blog"
                                                            data-id="{{ $country->id }}">
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

            $('.toggle-status').change(function () {
                let countryId = $(this).data('id');

                $.ajax({
                    url: "{{ route('admin.countries.changeStatus', ':id') }}".replace(':id',
                        countryId),
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        country_id: countryId, // The country ID to change the status
                    },
                    success: function (response) {
                        if (response.success) {
                            toastr.success(
                                "{{ __('keys.the country status updated successfully') }}");
                        } else {
                            toastr.error("{{ __('keys.something_wrong') }}");
                        }
                    },
                    error: function () {
                        toastr.error("{{ __('keys.error_occurred') }}");
                    }
                });
            });


            $(document).on('click', '.delete-blog', function (e) {
                e.preventDefault();
                let countryId = $(this).data('id');
                let deleteUrl = "{{ route('admin.countries.destroy', ':id') }}".replace(':id', countryId);
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
