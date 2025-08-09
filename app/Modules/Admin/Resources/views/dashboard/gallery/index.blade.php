@extends('dashboard.master')
@section('title', __('keys.galleries'))

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">{{ __('keys.galleries') }}</h4>
                        @can('create_galleries')
                            <a href="{{ route('admin.galleries.create') }}" class="btn btn-primary">
                                {{ __('keys.add_Gallery') }}
                            </a>
                        @endcan
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table datatables" id="dataTable-1">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('keys.image') }}</th>
                                    <th>{{ __('keys.status') }}</th>
                                    <th>{{ __('keys.actions') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if ($Galleries->count() > 0)
                                    @foreach ($Galleries as $Gallery)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>

                                            {{-- Gallery Images --}}
                                            <td>
                                                <div class="d-flex flex-wrap">
                                                    @foreach ($Gallery->getMedia('images') as $image)
                                                        <a href="{{ $image->getUrl() }}" data-toggle="modal"
                                                           data-target="#imageModal{{ $image->id }}">
                                                            <img src="{{ $image->getUrl() }}" class="img-thumbnail mx-1"
                                                                 width="50" height="50">
                                                        </a>

                                                        {{-- Modal for Full Image View --}}
                                                        <div class="modal fade" id="imageModal{{ $image->id }}"
                                                             tabindex="-1" role="dialog"
                                                             aria-labelledby="imageModalLabel{{ $image->id }}"
                                                             aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered"
                                                                 role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title"
                                                                            id="imageModalLabel{{ $image->id }}">
                                                                            {{ __('keys.image_preview') }}</h5>
                                                                        <button type="button" class="close"
                                                                                data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body text-center">
                                                                        <img src="{{ $image->getUrl() }}"
                                                                             class="img-fluid rounded">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </td>

                                            <td>
                                                @can('active_galleries')
                                                    <div class="custom-control custom-switch">
                                                        <input type="checkbox"
                                                               class="custom-control-input toggle-status"
                                                               id="toggleStatus{{ $Gallery->id }}"
                                                               data-id="{{ $Gallery->id }}"
                                                            {{ $Gallery->is_active ? 'checked' : '' }}>
                                                        <label class="custom-control-label"
                                                               for="toggleStatus{{ $Gallery->id }}"></label>
                                                    </div>
                                                @endcan
                                            </td>
                                            <td>
                                                @can('update_galleries')
                                                    <a href="{{ route('admin.galleries.edit', $Gallery->id) }}"
                                                       class="btn btn-sm btn-success">
                                                        <i class='fe fe-edit fa-2x'></i>
                                                    </a>
                                                @endcan
                                                @can('delete_galleries')
                                                    <button class="btn btn-sm btn-danger delete-gallery"
                                                            data-id="{{ $Gallery->id }}">
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
@endsection

@section('after_script')

    <script>
        $(document).ready(function () {

            $('.toggle-status').change(function () {
                let galleryId = $(this).data('id');

                $.ajax({
                    url: "{{ route('admin.galleries.changeStatus', ':id') }}".replace(':id',
                        galleryId),
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        gallery_id: galleryId,
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


            $(document).on('click', '.delete-gallery', function (e) {
                e.preventDefault();
                let galleryId = $(this).data('id');
                let deleteUrl = "{{ route('admin.galleries.destroy', ':id') }}".replace(':id', galleryId);
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
                                    Swal.fire("{{ __('keys.deleted') }}", response
                                        .message, "success");
                                    row.fadeOut(500, function () {
                                        $(this).remove();
                                    });
                                } else {
                                    Swal.fire("{{ __('keys.error') }}",
                                        "{{ __('keys.something_wrong') }}", "error"
                                    );
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
