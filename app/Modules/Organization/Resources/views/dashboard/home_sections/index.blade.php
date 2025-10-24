@extends('organization::dashboard.master')
@section('title', __('organizations.home_sections'))

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">{{ __('organizations.home_sections') }}</h4>
                            <a href="{{ route('organization.home_sections.create') }}" class="btn btn-primary">
                                {{ __('organizations.add_home_section') }}
                            </a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">

                            <table class="table datatables" id="dataTable-1">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('messages.name') }}</th>
                                    <th>{{ __('messages.sort_order') }}</th>
                                    <th>{{ __('messages.actions') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if (count($home_sections) > 0)
                                    @foreach ($home_sections as $home_section)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                {{ $home_section->translate(app()->getLocale())?->title
                                                    ?? __("messages." . \App\Modules\Organization\Enums\HomeSection\HomeSectionTypeEnum::from($home_section->type)->name) }}
                                            </td>
                                            <td>{{ $home_section->sort_order ?? "-" }}</td>
                                            <td>
                                                    <a href="{{ route('organization.home_sections.edit', $home_section->id) }}"
                                                       class="btn btn-sm btn-outline-success">
                                                        <i class='fe fe-edit fa-2x'></i>
                                                    </a>

                                                    <button class="btn btn-sm btn-outline-danger delete-home_section"
                                                            data-id="{{ $home_section->id }}">
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


            $(document).on('click', '.delete-home_section', function (e) {
                e.preventDefault();
                let home_sectionId = $(this).data('id');
                let deleteUrl = "{{ route('organization.home_sections.destroy', ':id') }}".replace(':id', home_sectionId);
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
