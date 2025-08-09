@extends('dashboard.master')
@section('title', __('seo.seos'))

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">{{ __('seo.seos') }}</h4>
                        @can('create_seo')
                            <a href="{{ route('admin.seo.create') }}" class="btn btn-primary">
                                {{ __('seo.add_seo') }}
                            </a>
                        @endcan
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">

                            <table class="table datatables" id="dataTable-1">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('seo.meta_title') }}</th>
                                    <th>{{ __('seo.meta_description') }}</th>
                                    <th>{{ __('seo.meta_keywords') }}</th>
                                    <th>{{ __('seo.page_title') }}</th>
                                    <th>{{ __('keys.slug') }}</th>
                                    <th>{{ __('keys.status') }}</th>
                                    <th>{{ __('keys.actions') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if (count($seos) > 0)
                                    @foreach ($seos as $seo)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $seo->translate(app()->getLocale())->meta_name }}</td>
                                            <td>{{ Str::limit($seo->translate(app()->getLocale())->meta_description, 50) }}
                                            </td>
                                            <td>{{ Str::limit($seo->translate(app()->getLocale())->meta_keywords, 50) }}
                                            </td>
                                            <td>{{ $seo->page_name }}</td>

                                            <td>{{ $seo->slug }}</td>
                                            <td>
                                                @can('active_seo')

                                                    <div class="custom-control custom-switch">
                                                        <input type="checkbox"
                                                               class="custom-control-input toggle-status"
                                                               id="toggleStatus{{ $seo->id }}"
                                                               data-id="{{ $seo->id }}"
                                                            {{ $seo->is_active ? 'checked' : '' }}>
                                                        <label class="custom-control-label"
                                                               for="toggleStatus{{ $seo->id }}"></label>
                                                    </div>
                                                @endcan

                                            </td>
                                            <td>
                                                @can('update_seo')

                                                    <a href="{{ route('admin.seo.edit', $seo->id) }}"
                                                       class="btn btn-sm btn-success">
                                                        <i class='fe fe-edit fa-2x'></i>
                                                    </a>
                                                @endcan
                                                @can('delete_seo')

                                                    <button class="btn btn-sm btn-danger delete-seo"
                                                            data-id="{{ $seo->id }}">
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
                let seoId = $(this).data('id');

                $.ajax({
                    url: "{{ route('admin.seo.changeStatus', ':id') }}".replace(':id', seoId),
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        seo_id: seoId, // The seo ID to change the status
                    },
                    success: function (response) {
                        if (response.success) {
                            toastr.success(
                                "{{ __('seo.the seo status updated successfully') }}");
                        } else {
                            toastr.error("{{ __('keys.something_wrong') }}");
                        }
                    },
                    error: function () {
                        toastr.error("{{ __('keys.error_occurred') }}");
                    }
                });
            });


            $(document).on('click', '.delete-seo', function (e) {
                e.preventDefault();
                let seoId = $(this).data('id');
                let deleteUrl = "{{ route('admin.seo.destroy', ':id') }}".replace(':id', seoId);
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
