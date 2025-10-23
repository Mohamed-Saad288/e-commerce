<div class="table-responsive">
    <table class="table table-hover align-middle">
        <thead>
        <tr>
            <th>#</th>
            <th>{{ __('messages.name') }}</th>
            <th>{{ __('messages.actions') }}</th>
        </tr>
        </thead>
        <tbody>
        @if ($options->count() > 0)
            @foreach ($options as $index => $option)
                <tr>
                    <td>{{ $options->firstItem() + $index }}</td>
                    <td>{{ $option->name ?? '-' }}</td>
                    <td>
                        <a href="{{ route('organization.options.edit', $option->id) }}" class="btn btn-outline-success btn-sm">
                            <i class="fe fe-edit fa-2x"></i>
                        </a>
                        <button class="btn btn-outline-danger btn-sm delete-option" data-id="{{ $option->id }}">
                            <i class="fe fe-trash-2 fa-2x"></i>
                        </button>
                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="3" class="text-center">
                    <div class="no-data py-5">
                        <img src="{{ asset('no-data.png') }}" alt="No Data" style="width:120px;">
                        <p class="mt-2 text-muted">{{ __('messages.no_data') }}</p>
                    </div>
                </td>
            </tr>
        @endif
        </tbody>
    </table>
</div>

@if ($options->hasPages())
    <div class="d-flex justify-content-center mt-3">
        {{ $options->links('pagination::bootstrap-5') }}
    </div>
@endif
