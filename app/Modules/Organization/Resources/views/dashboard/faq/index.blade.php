@extends('dashboard.master')
@section('title', __('keys.faqs'))

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">{{ __('keys.faqs') }}</h4>
                        @can('create_fags')
                            <a href="{{ route('admin.faqs.create') }}" class="btn btn-primary">
                                {{ __('keys.add_faq') }}
                            </a>
                        @endcan
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">

                            <table class="table datatables" id="dataTable-1">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('keys.question') }}</th>
                                    <th>{{ __('keys.answer') }}</th>
                                    <th>{{ __('keys.status') }}</th>
                                    <th>{{ __('keys.actions') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if (count($faqs) > 0)
                                    @foreach ($faqs as $faq)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $faq->translate(app()->getLocale())->question }}</td>
                                            <td>{{ Str::limit($faq->translate(app()->getLocale())->answer, 50) }}
                                            </td>

                                            <td>
                                                @can('active_fags')
                                                    <div class="custom-control custom-switch">
                                                        <input type="checkbox"
                                                               class="custom-control-input toggle-status"
                                                               id="toggleStatus{{ $faq->id }}"
                                                               data-id="{{ $faq->id }}"
                                                            {{ $faq->is_active ? 'checked' : '' }}>
                                                        <label class="custom-control-label"
                                                               for="toggleStatus{{ $faq->id }}"></label>
                                                    </div>
                                                @endcan
                                            </td>

                                            <td>
                                                @can('create_fags')
                                                    <a href="{{ route('admin.faqs.edit', $faq->id) }}"
                                                       class="btn btn-sm btn-success">
                                                        <i class='fe fe-edit fa-2x'></i>
                                                    </a>
                                                @endcan
                                                @can('delete_fags')

                                                    <button class="btn btn-sm btn-danger delete-faq"
                                                            data-id="{{ $faq->id }}">
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
                let faqId = $(this).data('id');

                $.ajax({
                    url: "{{ route('admin.faqs.changeStatus', ':id') }}".replace(':id', faqId),
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
                let faqId = $(this).data('id');
                let deleteUrl = "{{ route('admin.faqs.destroy', ':id') }}".replace(':id', faqId);
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
