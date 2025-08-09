<form action="{{ $route }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method($method)

    {{-- Name Field --}}
    <div class="row">
        @foreach (config('translatable.locales') as $locale)
            <div class="col-md-6">
                <div class="form-group">
                    <label for="name_{{ $locale }}">{{ __("keys.name_$locale") }}</label>
                    <input type="text" name="{{ $locale }}[name]" id="name_{{ $locale }}"
                        class="form-control @error("$locale.name") is-invalid @enderror"
                        value="{{ old("$locale.name", $country ? $country->translate($locale)->name : '') }}" required>
                    @error("$locale.name")
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        @endforeach
    </div>


    {{-- Image Upload --}}
    <div class="row">

        <div class="col-md-6">
            <div class="custom-file mb-3">
                <input type="file" name="image" class="custom-file-input @error('image') is-invalid @enderror"
                    id="validatedCustomFile" accept="image/*" onchange="previewImage(event)">
                <label class="custom-file-label" for="validatedCustomFile">{{ __('keys.choose_file') }}</label>
                @error('image')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>


        {{-- Switch Toggle --}}
        <div class="col-md-6 d-flex align-items-center">
            <p class="mb-0 mr-3">{{ __('keys.is_active') }}</p>
            <div class="custom-control custom-switch">
                <input type="hidden" name="is_active" value="0">
                <input type="checkbox" class="custom-control-input" id="customSwitch1" name="is_active" value="1"
                    {{ old('is_active', $country ? $country->is_active : false) ? 'checked' : '' }}>
                <label class="custom-control-label" for="customSwitch1">{{ __('keys.yes') }}</label>
            </div>
        </div>

    </div>
    <br>
    <br>

    <button type="submit" class="btn btn-primary">{{ __('keys.submit') }}</button>
</form>


