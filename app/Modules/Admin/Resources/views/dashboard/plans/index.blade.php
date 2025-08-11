@extends('admin::dashboard.master')
@section('title', __('messages.plans'))

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">{{ __('messages.plans') }}</h4>
{{--                        @can('create_fags')--}}
                            <a href="{{ route('admin.plans.create') }}" class="btn btn-primary">
                                {{ __('messages.add_plan') }}
                            </a>
{{--                        @endcan--}}
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">

                            <table class="table datatables" id="dataTable-1">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('messages.name') }}</th>
                                    <th>{{ __('messages.description') }}</th>
                                    <th>{{ __('messages.slug') }}</th>
                                    <th>{{ __('messages.billing_type') }}</th>
                                    <th>{{ __('messages.price') }}</th>
                                    <th>{{ __('messages.duration') }}</th>
                                    <th>{{ __('messages.trial_period') }}</th>
                                    <th>{{ __('messages.sort_order') }}</th>
                                    <th>{{ __('messages.status') }}</th>
                                    <th>{{ __('messages.actions') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if (count($plans) > 0)
                                    @foreach ($plans as $plan)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $plan->name }}</td>
                                            <td>{{\Illuminate\Support\Str::limit($plan->description, 50)}}</td>
                                            <td>{{ $plan->slug }}</td>
                                            <td>{{ $plan->billing_type }}</td>
                                            <td>{{ $plan->price }}</td>
                                            <td>{{ $plan->duration }}</td>
                                            <td>{{ $plan->trial_period }}</td>
                                            <td>{{ $plan->sort_order }}</td>

                                            <td>
{{--                                                @can('active_fags')--}}
                                                    <div class="custom-control custom-switch">
                                                        <input type="checkbox"
                                                               class="custom-control-input toggle-status"
                                                               id="toggleStatus{{ $plan->id }}"
                                                               data-id="{{ $plan->id }}"
                                                            {{ $plan->is_active ? 'checked' : '' }}>
                                                        <label class="custom-control-label"
                                                               for="toggleStatus{{ $plan->id }}"></label>
                                                    </div>
{{--                                                @endcan--}}
                                            </td>

                                            <td>
{{--                                                @can('create_fags')--}}
                                                    <a href="{{ route('admin.plans.edit', $plan->id) }}"
                                                       class="btn btn-sm btn-success">
                                                        <i class='fe fe-edit fa-2x'></i>
                                                    </a>
{{--                                                @endcan--}}
{{--                                                @can('delete_fags')--}}

                                                    <button class="btn btn-sm btn-danger delete-faq"
                                                            data-id="{{ $plan->id }}">
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
        $(document).ready(function () {

            $('.toggle-status').change(function () {
                let planId = $(this).data('id');

                $.ajax({
                    url: "{{ route('admin.plans.change_status', ':id') }}".replace(':id', planId),
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        faq_id: faqId, // The faq ID to change the status
                    },
                    success: function (response) {
                        if (response.success) {
                            toastr.success(
                                "{{ __('messages.updated') }}");
                        } else {
                            toastr.error("{{ __('messages.something_wrong') }}");
                        }
                    },
                    error: function () {
                        toastr.error("{{ __('messages.error_occurred') }}");
                    }
                });
            });


            $(document).on('click', '.delete-faq', function (e) {
                e.preventDefault();
                let planId = $(this).data('id');
                let deleteUrl = "{{ route('admin.plans.destroy', ':id') }}".replace(':id', planId);
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
        });
    </script>
@endsection
