@if ($employees->count() > 0)
    @foreach ($employees as $index => $employee)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $employee->name ?? '-' }}</td>
            <td>{{ $employee->email ?? '-' }}</td>
            <td>{{ $employee->phone ?? '-' }}</td>
            <td>
                <a href="{{ route('organization.employees.edit', $employee->id) }}" class="btn btn-sm btn-success">
                    <i class='fe fe-edit fa-2x'></i>
                </a>
                <button class="btn btn-sm btn-danger delete-employee" data-id="{{ $employee->id }}">
                    <i class="fe fe-trash-2 fa-2x"></i>
                </button>
            </td>
        </tr>
    @endforeach
@else
    <tr>
        <td colspan="5">
            <div class="no-data text-center">
                <img src="{{ asset('no-data.png') }}" alt="No Data Found">
                <p>{{ __('messages.no_data') }}</p>
            </div>
        </td>
    </tr>
@endif
