@csrf
<div class="row">
    @foreach (config('translatable.locales') as $locale)
        <div class="col-md-6">
            <div class="form-group">
                <label for="title_{{ $locale }}" class="font-weight-bold">{{ __("keys.title_$locale") }}</label>
                <input type="text" name="{{ $locale }}[name]" id="title_{{ $locale }}"
                       class="form-control @error("$locale.name") is-invalid @enderror"
                       value="{{ old("$locale.name", $work->translate($locale)->name ?? '') }}" required>
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
                          class="form-control tinymce-editor @error("$locale.description") is-invalid @enderror" rows="3">{{ old("$locale.description", $work->translate($locale)->description ?? '') }}</textarea>
                @error("$locale.description")
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
    @endforeach
</div>

<div class="row">
    @foreach (config('translatable.locales') as $locale)
        <div class="col-md-6">
            <div class="form-group">
                <label for="meta_description_{{ $locale }}" class="font-weight-bold">{{ __("keys.meta_description_$locale") }}</label>
                <textarea name="{{ $locale }}[meta_description]" id="meta_description_{{ $locale }}"
                          class="form-control @error("$locale.meta_description") is-invalid @enderror" rows="3">{{ old("$locale.meta_description", $work->translate($locale)->meta_description ?? '') }}</textarea>
                @error("$locale.meta_description")
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
    @endforeach
</div>

<div class="row">
    @foreach (config('translatable.locales') as $locale)
        <div class="col-md-6">
            <div class="form-group">
                <label for="classification_{{ $locale }}" class="font-weight-bold">{{ __("keys.classification_$locale") }}</label>
                <textarea name="{{ $locale }}[classification]" id="classification_{{ $locale }}"
                          class="form-control @error("$locale.classification") is-invalid @enderror" rows="3">{{ old("$locale.classification", $work->translate($locale)->classification ?? '') }}</textarea>
                @error("$locale.classification")
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
            @if(isset($work) && $work->getMedia('work_images')->count() > 0)
                <div class="mb-3 d-flex flex-wrap">
                    @foreach($work->getMedia('work_images') as $image)
                        <div class="position-relative mx-2">
                            <img src="{{ $image->getUrl() }}" alt="Works Image" class="img-thumbnail" width="100">
                            {{-- Optional: Add a delete button --}}
                            {{-- <a href="#" class="btn btn-danger btn-sm position-absolute" style="top: 5px; right: 5px;">✖</a> --}}
                        </div>
                    @endforeach
                </div>
            @endif

            {{-- Image Upload --}}
            <div class="custom-file">
                <input type="file" name="images[]" class="custom-file-input @error('images') is-invalid @enderror"
                       id="images" multiple accept="image/*">
                <label class="custom-file-label" for="images">{{ __('keys.upload_images') }}</label>
                @error('images')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>

        {{-- Image Preview Container --}}
        <div class="image-preview" id="image-preview"></div>
    </div>

    {{-- Video Upload Section --}}
    <div class="col-md-6">
        <div class="form-group">
            <div class="custom-file">
                <input type="file" name="video" class="custom-file-input @error('video') is-invalid @enderror"
                       id="validatedCustomFile" {{ !isset($work) ? 'required' : '' }}>
                <label class="custom-file-label" for="validatedCustomFile">{{ __("work.choose_video") }}</label>
                @error('video')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
    </div>
</div>

<div class="row">
    {{-- Active Switch --}}
    <div class="col-md-6 d-flex align-items-center">
        <p class="mb-0 mr-3 font-weight-bold">{{ __("keys.is_active") }}</p>
        <div class="custom-control custom-switch">
            <input type="hidden" name="is_active" value="0">
            <input type="checkbox" class="custom-control-input" id="customSwitch1" name="is_active" value="1"
                {{ old('is_active', $work->is_active ?? false) ? 'checked' : '' }}>
            <label class="custom-control-label" for="customSwitch1">{{ __("keys.yes") }}</label>
        </div>
    </div>
</div>

<button type="submit" class="btn btn-primary">{{ __('keys.submit') }}</button>
