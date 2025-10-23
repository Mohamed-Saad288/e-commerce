<div class="table-responsive">
    <table class="table align-middle">
        <thead>
        <tr>
            <th>#</th>
            <th>{{ __('messages.name') }}</th>
            <th>{{ __('messages.actions') }}</th>
        </tr>
        </thead>
        <tbody>
        @if ($brands->count() > 0)
            @foreach ($brands as $brand)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $brand->translate(app()->getLocale())->name }}</td>
                    <td>
                        <div class="d-flex gap-2 justify-content-center">
                            <a href="{{ route('organization.brands.edit', $brand->id) }}"
                               class="btn btn-outline-success btn-sm" title="{{ __('messages.edit') }}">
                                <i class="fe fe-edit"></i>
                            </a>
                            <button class="btn btn-outline-danger btn-sm delete-brand"
                                    data-id="{{ $brand->id }}" title="{{ __('messages.delete') }}">
                                <i class="fe fe-trash-2"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="3" class="text-center">
                    <div class="no-data">
                        <img src="{{ asset('no-data.png') }}" alt="No Data Found">
                        <p>{{ __('messages.no_data') }}</p>
                    </div>
                </td>
            </tr>
        @endif
        </tbody>
    </table>

    <div class="d-flex justify-content-center mt-3">
        {{ $brands->links('pagination::bootstrap-5') }}
    </div>
</div>
