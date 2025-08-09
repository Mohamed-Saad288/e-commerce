@csrf
<div class="row">
    @foreach (config('translatable.locales') as $locale)
        <div class="col-md-6">
            <div class="form-group">
                <label for="title_{{ $locale }}" class="font-weight-bold">{{ __("keys.title_$locale") }}</label>
                <input type="text" name="{{ $locale }}[title]" id="title_{{ $locale }}"
                       class="form-control @error("$locale.title") is-invalid @enderror"
                       value="{{ old("$locale.title", $page->translate($locale)->title ?? '') }}" required>
                @error("$locale.title")
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
                          class="form-control tinymce-editor @error("$locale.description") is-invalid @enderror" rows="3">{{ old("$locale.description", $page->translate($locale)->description ?? '') }}</textarea>
                @error("$locale.description")
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
    @endforeach
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="service" class="font-weight-bold">{{ __("keys.choose_service") }}</label>
            <select name="service_id" id="service" class="form-control @error('service_id') is-invalid @enderror" required>
                <option value="">{{ __('keys.select_service') }}</option>
                @foreach($services as $id => $name)
                    <option value="{{ $id }}" {{ old('service_id', $page->service_id ?? '') == $id ? 'selected' : '' }}>{{ $name }}</option>
                @endforeach
            </select>
            @error('service_id')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>

<div class="row">
    @foreach (config('translatable.locales') as $locale)
        <div class="col-md-6">
            <div class="form-group">
                <label for="meta_description_{{ $locale }}" class="font-weight-bold">{{ __("keys.meta_description_$locale") }}</label>
                <textarea name="{{ $locale }}[meta_description]" id="meta_description_{{ $locale }}"
                          class="form-control @error("$locale.meta_description") is-invalid @enderror" rows="3">{{ old("$locale.meta_description", $page->translate($locale)->meta_description ?? '') }}</textarea>
                @error("$locale.meta_description")
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
            @if(isset($page) && $page->getMedia('Page_images')->count() > 0)
                <div class="mb-3 d-flex flex-wrap">
                    @foreach($page->getMedia('Page_images') as $image)
                        <div class="position-relative mx-2">
                            <img src="{{ $image->getUrl() }}" alt="Pages Image" class="img-thumbnail" width="100">
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
                {{ old('is_active', $page->is_active ?? false) ? 'checked' : '' }}>
            <label class="custom-control-label" for="customSwitch1">{{ __("keys.yes") }}</label>
        </div>
    </div>
</div>

<button type="submit" class="btn btn-primary">{{ __('keys.submit') }}</button>
