<div class="table-responsive">
    <table class="table table-hover align-middle">
        <thead class="table-light">
        <tr>
            <th>#</th>
            <th>{{ __('messages.name') }}</th>
            <th class="text-center">{{ __('messages.actions') }}</th>
        </tr>
        </thead>
        <tbody>
        @forelse ($subCategories as $sub)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $sub->translate(app()->getLocale())->name }}</td>
                <td class="text-center">
                    <div class="btn-group" role="group">
                        <a href="{{ route('organization.categories.edit', $sub->id) }}"
                           class="btn btn-outline-success btn-sm" title="{{ __('messages.edit') }}">
                            <i class="fe fe-edit"></i>
                        </a>

                        @if($sub->subCategories->count() > 0)
                            <a href="{{ route('organization.categories.subcategories', $sub->id) }}"
                               class="btn btn-outline-info btn-sm" title="{{ __('messages.view') }}">
                                <i class="fe fe-eye"></i>
                            </a>
                        @endif

                        <a href="{{ route('organization.categories.create', ['parent_id' => $sub->id]) }}"
                           class="btn btn-outline-primary btn-sm" title="{{ __('organizations.add_subcategory') }}">
                            <i class="fe fe-plus"></i>
                        </a>

                        @if($sub->subCategories->count() == 0)
                            <button class="btn btn-outline-danger btn-sm delete-category"
                                    data-id="{{ $sub->id }}"
                                    title="{{ __('messages.delete') }}">
                                <i class="fe fe-trash-2"></i>
                            </button>
                        @endif
                    </div>
                </td>
            </tr>
        @empty
            <tr class="no-data">
                <td colspan="100%">
                    <div class="text-center py-4">
                        <img src="{{ asset('no-data.png') }}" alt="No Data Found" width="120" class="mb-3">
                        <p class="text-muted">{{ __('messages.no_data') }}</p>
                    </div>
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>

{{-- Pagination --}}
<div class="d-flex justify-content-center mt-4">
    {{ $subCategories->links('pagination::bootstrap-5') }}
</div>
