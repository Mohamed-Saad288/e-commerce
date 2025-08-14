<form action="{{ $route }}" method="POST" enctype="multipart/form-data" class="p-4 bg-white rounded shadow-sm">
    @csrf
    @method($method)



    {{-- Name --}}
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="name" class="font-weight-bold">{{ __('keys.name') }}</label>
                <input type="text" name="name" id="name"
                    class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name', $testimonial ? $testimonial->name : '') }}" required>
                @error('name')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>
    </div>

    {{-- Descriptions --}}
    <div class="row">
        @foreach (config('translatable.locales') as $locale)
            <div class="col-md-12">
                <div class="form-group">
                    <label for="description_{{ $locale }}"
                        class="font-weight-bold">{{ __("keys.description_$locale") }}</label>
                    <textarea name="{{ $locale }}[description]" id="description_{{ $locale }}"
                        class="form-control tinymce-editor @error("$locale.description") is-invalid @enderror" rows="3">{{ old("$locale.description", $testimonial ? $testimonial->translate($locale)->description : '') }}</textarea>
                    @error("$locale.description")
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
        @endforeach
    </div>

    <div class="row">
        {{-- Image Upload --}}
        <div class="col-md-6">
            <div class="custom-file mb-3">
                <input type="file" name="image" class="custom-file-input @error('image') is-invalid @enderror"
                    id="validatedCustomFile" accept="image/*" onchange="previewImage(event)">
                <label class="custom-file-label" for="validatedCustomFile">{{ __('keys.choose_file') }}</label>
                @error('image')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            {{-- Image Preview --}}
            <img id="imagePreview"
                src="{{ isset($testimonial) ? $testimonial->getFirstMediaUrl('testimonial_images') : '' }}"
                class="img-fluid mt-2 mb-2"
                style="max-width: 20%; height: auto; display: {{ isset($testimonial) && $testimonial->hasMedia('testimonial_images') ? 'block' : 'none' }};">
        </div>

        {{-- Switch Toggle --}}
        <div class="col-md-6 d-flex align-items-center">
            <label class="font-weight-bold mr-3 mb-0">{{ __('keys.is_active') }}</label>
            <div class="custom-control custom-switch">
                <input type="hidden" name="is_active" value="0">
                <input type="checkbox" class="custom-control-input" id="customSwitch1" name="is_active" value="1"
                    {{ old('is_active', $testimonial ? $testimonial->is_active : false) ? 'checked' : '' }}>
                <label class="custom-control-label" for="customSwitch1">{{ __('keys.yes') }}</label>
            </div>
        </div>
    </div>

    <div class="mt-4 text-right">
        <button type="submit" class="btn btn-primary px-4 py-2">{{ __('keys.submit') }}</button>
    </div>
</form>
