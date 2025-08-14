<form action="{{ $route }}" method="POST" enctype="multipart/form-data" class="p-4 bg-white rounded shadow-sm">
    @csrf
    @method($method)

    {{-- Role Name Input --}}
    <div class="form-group">
        <label for="role_name" class="font-weight-bold">{{ __('keys.role_name') }}</label>
        <input type="text" name="name" id="role_name" class="form-control @error('name') is-invalid @enderror"
            value="{{ old('name', $role->name ?? '') }}">
        @error('name')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    {{-- Permissions Selection --}}
    <div class="form-group">
        <label class="font-weight-bold">{{ __('keys.permissions') }}</label>
        <div class="list-group">
            @foreach ($permissions as $type => $permissionGroup)
                <div class="list-group-item">
                    <div class="d-flex justify-content-between align-items-center">
                        <span style="width: 20%" class="font-weight-bold">{{ __("permission.models.$type") }}</span>

                        <div>
                            <input type="checkbox" id="selectAll-{{ $type }}" class="select-all-checkbox">
                            <label for="selectAll-{{ $type }}">{{ __('keys.select_all') }}</label>
                        </div>

                        <button type="button" class="btn btn-sm btn-primary toggle-permissions"
                            data-target="#permissions-{{ $type }}">
                            {{ __('keys.show_permissions') }}
                        </button>
                    </div>

                    <div id="permissions-{{ $type }}" class="permissions-list mt-3" style="display: none;">
                        <div class="row">
                            @foreach ($permissionGroup as $permission)
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input permission-checkbox"
                                            id="permission_{{ $permission['id'] }}" name="permission[]"
                                            value="{{ $permission['id'] }}"
                                            {{ in_array($permission['id'], old('permissions', $rolePermissions ?? [])) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="permission_{{ $permission['id'] }}">
                                            {{ $permission['name'] }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        @error('permissions')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <div class="mt-4 text-right">
        <button type="submit" class="btn btn-primary px-4 py-2">{{ __('keys.submit') }}</button>
    </div>
</form>
