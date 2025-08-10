<form action="{{ $route }}" method="POST" enctype="multipart/form-data" class="p-4 bg-white rounded shadow-sm">
    @csrf
    @method($method)

    <div class="row">
        @foreach ($fields as $name => $type)
            <div class="col-md-6">
                <div class="form-group">
                    <label for="{{ $name }}" class="font-weight-bold">{{ __("messages.$name") }}</label>
                    <input type="{{ $type }}" name="{{ $name }}" id="{{ $name }}"
                           class="form-control @error($name) is-invalid @enderror"
                           value="{{ old($name, $admin->$name ?? '') }}">
                    @error($name)
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
        @endforeach

    </div>

    <div class="row">



    </div>

    <div class="mt-4 text-right">
        <button type="submit" class="btn btn-primary px-4 py-2">{{ __('messages.submit') }}</button>
    </div>
</form>
