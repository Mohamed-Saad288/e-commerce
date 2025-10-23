<table class="table table-striped align-middle">
    <thead>
    <tr>
        <th>#</th>
        <th>{{ __('messages.name') }}</th>
        <th>{{ __('organizations.option') }}</th>
        <th>{{ __('messages.actions') }}</th>
    </tr>
    </thead>
    <tbody>
    @if ($option_items->count() > 0)
        @foreach ($option_items as $index => $option_item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $option_item->translate(app()->getLocale())->name ?? '-' }}</td>
                <td>{{ $option_item->option?->translate(app()->getLocale())->name ?? '-' }}</td>
                <td class="text-nowrap">
                    <a href="{{ route('organization.option_items.edit', $option_item->id) }}" class="btn btn-outline-success btn-sm">
                        <i class="fe fe-edit"></i>
                    </a>
                    <button class="btn btn-outline-danger btn-sm delete-option_item" data-id="{{ $option_item->id }}">
                        <i class="fe fe-trash-2"></i>
                    </button>
                </td>
            </tr>
        @endforeach
    @else
        <tr>
            <td colspan="100%">
                <div class="no-data text-center">
                    <img src="{{ asset('no-data.png') }}" alt="No Data Found">
                    <p>{{ __('messages.no_data') }}</p>
                </div>
            </td>
        </tr>
    @endif
    </tbody>
</table>

<div class="d-flex justify-content-center mt-4">
    {{ $option_items->links('pagination::bootstrap-5') }}
</div>
