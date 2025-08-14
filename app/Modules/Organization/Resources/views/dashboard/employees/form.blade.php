<form action="{{ $route }}" method="POST" enctype="multipart/form-data" class="p-4 bg-white rounded shadow-sm">
    @csrf
    @method($method)

    <div class="row">
        @foreach ($fields as $name => $type)
            <div class="col-md-6">
                <div class="form-group">
                    <label for="{{ $name }}" class="font-weight-bold">{{ __("keys.$name") }}</label>
                    <input type="{{ $type }}" name="{{ $name }}" id="{{ $name }}"
                           class="form-control @error($name) is-invalid @enderror"
                           value="{{ old($name, $employee->$name ?? '') }}">
                    @error($name)
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
        @endforeach

    </div>

    <div class="row">

        {{-- Role Selection --}}
        <div class="col-md-6">
            <div class="form-group">
                <label for="role" class="font-weight-bold">{{ __("keys.role") }}</label>
                <select name="role_id" id="role" class="form-control @error('role_id') is-invalid @enderror">
                    <option value="">{{ __("keys.select_role") }}</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->id }}" {{ old('role_id', $employee?->roles?->first()?->id ?? '') == $role->id ? 'selected' : '' }}>
                            {{ $role->name }}
                        </option>
                    @endforeach
                </select>
                @error('role_id')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>

        {{-- Switch Toggle --}}

        <div class="col-md-6 d-flex align-items-center mt-3 mt-md-0">
            <label class="font-weight-bold mr-3 mb-0">{{ __("keys.is_active") }}</label>
            <div class="custom-control custom-switch">
                <input type="hidden" name="is_active" value="0">
                <input type="checkbox" class="custom-control-input" id="customSwitch1" name="is_active" value="1"
                    {{ old('is_active', $employee ? $employee->is_active : false) ? 'checked' : '' }}>
                <label class="custom-control-label" for="customSwitch1">{{ __("keys.yes") }}</label>
            </div>
        </div>
    </div>

    <div class="mt-4 text-right">
        <button type="submit" class="btn btn-primary px-4 py-2">{{ __('keys.submit') }}</button>
    </div>
</form>
