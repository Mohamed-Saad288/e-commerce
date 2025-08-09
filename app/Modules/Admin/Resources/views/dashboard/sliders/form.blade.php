@csrf
<div class="row">
    @foreach (config('translatable.locales') as $locale)
        <div class="col-md-6">
            <div class="form-group">
                <label for="title_{{ $locale }}" class="font-weight-bold">{{ __("keys.title_$locale") }}</label>
                <input type="text" name="{{ $locale }}[name]" id="title_{{ $locale }}"
                       class="form-control @error("$locale.name") is-invalid @enderror"
                       value="{{ old("$locale.name", $slider->translate($locale)->name ?? '') }}" required>
                @error("$locale.name")
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
    @endforeach
    @foreach (config('translatable.locales') as $locale)
        <div class="col-md-12">
            <div class="form-group">
                <label for="description_{{ $locale }}" class="font-weight-bold">{{ __("keys.description_$locale") }}</label>
                <textarea name="{{ $locale }}[description]" id="description_{{ $locale }}"
                          class="form-control tinymce-editor @error("$locale.description") is-invalid @enderror" rows="3">{{ old("$locale.description", $slider->translate($locale)->description ?? '') }}</textarea>
                @error("$locale.description")
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
    @endforeach
</div>

<div class="row">
    {{-- Image Upload Section --}}
    <div class="col-md-6">
        <div class="form-group">
            @if(isset($slider) && $slider->getMedia('slider_images')->count() > 0)
                <div class="mb-3 d-flex flex-wrap">
                    @foreach($slider->getMedia('slider_images') as $image)
                        <div class="position-relative mx-2">
                            <img src="{{ $image->getUrl() }}" alt="Slider Image" class="img-thumbnail" width="100">
                            {{-- Optional: Add a delete button --}}
                            {{-- <a href="#" class="btn btn-danger btn-sm position-absolute" style="top: 5px; right: 5px;">✖</a> --}}
                        </div>
                    @endforeach
                </div>
            @endif

            {{-- Image Upload --}}
            <div class="custom-file">
                <input type="file" name="image" class="custom-file-input @error('image') is-invalid @enderror"
                       id="images" accept="image/*">
                <label class="custom-file-label" for="images">{{ __('keys.upload_image') }}</label>
                @error('image')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>

        {{-- Image Preview Container --}}
        <div class="image-preview" id="image-preview"></div>
    </div>
</div>

<div class="row">
    {{-- Active Switch --}}
    <div class="col-md-6 d-flex align-items-center">
        <p class="mb-0 mr-3 font-weight-bold">{{ __("keys.is_active") }}</p>
        <div class="custom-control custom-switch">
            <input type="hidden" name="is_active" value="0">
            <input type="checkbox" class="custom-control-input" id="customSwitch1" name="is_active" value="1"
                {{ old('is_active', $slider->is_active ?? false) ? 'checked' : '' }}>
            <label class="custom-control-label" for="customSwitch1">{{ __("keys.yes") }}</label>
        </div>
    </div>
</div>

<button type="submit" class="btn btn-primary">{{ __('keys.submit') }}</button>
