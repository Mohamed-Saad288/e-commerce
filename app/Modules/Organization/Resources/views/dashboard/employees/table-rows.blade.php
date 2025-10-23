@if ($employees->count() > 0)
    @foreach ($employees as $index => $employee)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $employee->name ?? '-' }}</td>
            <td>{{ $employee->email ?? '-' }}</td>
            <td>{{ $employee->phone ?? '-' }}</td>
            <td class="text-center">
                <div class="btn-group" role="group">
                    {{-- ✏️ Edit --}}
                    <a href="{{ route('organization.employees.edit', $employee->id) }}"
                       class="btn btn-outline-success btn-sm" title="{{ __('messages.edit') }}">
                        <i class="fe fe-edit"></i>
                    </a>

                    {{-- 🗑️ Delete --}}
                    <button type="button"
                            class="btn btn-outline-danger btn-sm delete-employee"
                            data-id="{{ $employee->id }}"
                            title="{{ __('messages.delete') }}">
                        <i class="fe fe-trash-2"></i>
                    </button>
                </div>
            </td>
        </tr>
    @endforeach
@else
    <tr>
        <td colspan="5">
            <div class="no-data text-center py-4">
                <img src="{{ asset('no-data.png') }}" alt="No Data Found" width="120" class="mb-3">
                <p class="text-muted">{{ __('messages.no_data') }}</p>
            </div>
        </td>
    </tr>
@endif
