<div class="table-responsive">
    <table class="table table-hover table-striped">
        <thead class="table-light">
        <tr>
            <th>#</th>
            <th>{{ __('messages.name') }}</th>
            <th>{{ __('messages.category') }}</th>
            <th>{{ __('messages.created_at') }}</th>
            <th class="text-center">{{ __('messages.actions') }}</th>
        </tr>
        </thead>
        <tbody>
        @forelse($options as $option)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $option->name }}</td>
                <td>
                    @if($option->category)
                        <span class="badge bg-info">
                                <i class="fe fe-tag"></i> {{ $option->category->name }}
                            </span>
                    @else
                        <span class="text-muted">-</span>
                    @endif
                </td>
                <td>{{ $option->created_at }}</td>
                <td class="text-center">
                    <a href="{{ route('organization.options.edit', $option->id) }}"
                       class="btn btn-sm btn-warning">
                        <i class="fe fe-edit"></i>
                    </a>
                    <button class="btn btn-sm btn-danger delete-option"
                            data-id="{{ $option->id }}">
                        <i class="fe fe-trash"></i>
                    </button>
                </td>
            </tr>
        @empty
            <tr class="no-data">
                <td colspan="5" class="text-center py-4">
                    <i class="fe fe-inbox fs-1 text-muted"></i>
                    <p class="text-muted mt-2">{{ __('messages.no_data') }}</p>
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>

{{ $options->links() }}
