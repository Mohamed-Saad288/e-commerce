@csrf
<div class="row">
    @foreach (config('translatable.locales') as $locale)
        <div class="col-md-6">
            <div class="form-group">
                <label for="title_{{ $locale }}" class="font-weight-bold">{{ __("keys.title_$locale") }}</label>
                <input type="text" name="{{ $locale }}[name]" id="title_{{ $locale }}"
                       class="form-control @error("$locale.name") is-invalid @enderror"
                       value="{{ old("$locale.name", $heroSection->translate($locale)->name ?? '') }}" required>
                @error("$locale.name")
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
    @endforeach

    @foreach (config('translatable.locales') as $locale)
        <div class="col-md-12">
            <div class="form-group">
                <label for="sub_description_{{ $locale }}" class="font-weight-bold">{{ __("keys.sub_description_$locale") }}</label>
                <textarea name="{{ $locale }}[sub_description]" id="sub_description_{{ $locale }}"
                          class="form-control tinymce-editor @error("$locale.sub_description") is-invalid @enderror"
                          rows="3">{{ old("$locale.sub_description", $heroSection->translate($locale)->sub_description ?? '') }}</textarea>
                @error("$locale.sub_description")
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
                          class="form-control tinymce-editor @error("$locale.description") is-invalid @enderror"
                          rows="3">{{ old("$locale.description", $heroSection->translate($locale)->description ?? '') }}</textarea>
                @error("$locale.description")
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
    @endforeach
</div>

<div class="row">

{{--    <div class="col-md-12">--}}
{{--        <div class="form-group">--}}
{{--            <label for="media_type" class="font-weight-bold">{{ __('keys.choose_media_type') }}</label>--}}
{{--            <select name="media_type" id="media_type" class="form-control @error('media_type') is-invalid @enderror">--}}
{{--                <option value="image" {{ old('media_type', $heroSection->media_type ?? 'image') == 'image' ? 'selected' : '' }}>{{ __('keys.image') }}</option>--}}
{{--                <option value="video" {{ old('media_type', $heroSection->media_type ?? 'image') == 'video' ? 'selected' : '' }}>{{ __('keys.video') }}</option>--}}
{{--            </select>--}}
{{--            @error('media_type')--}}
{{--            <span class="text-danger">{{ $message }}</span>--}}
{{--            @enderror--}}
{{--        </div>--}}
{{--    </div>--}}


    {{-- Image Upload Section --}}
    <div class="col-md-6">
        <div class="form-group">
            @if(isset($heroSection) && $heroSection->getMedia('heroSection_images')->count() > 0)
                <div class="mb-3 d-flex flex-wrap">
                    @foreach($heroSection->getMedia('heroSection_images') as $image)
                        <div class="position-relative mx-2">
                            <img src="{{ $image->getUrl() }}" alt="Hero Section Image" class="img-thumbnail" width="100">
                            {{-- Optional: Add a delete button --}}
                            {{-- <a href="#" class="btn btn-danger btn-sm position-absolute" style="top: 5px; right: 5px;">✖</a> --}}
                        </div>
                    @endforeach
                </div>
            @endif

            {{-- Image Upload --}}
            <div class="custom-file">
                <input type="file" name="image" class="custom-file-input @error('image') is-invalid @enderror"
                       id="images" multiple accept="image/*">
                <label class="custom-file-label" for="images">{{ __('keys.upload_images') }}</label>
                @error('image')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>

        {{-- Image Preview Container --}}
        <div class="image-preview" id="image-preview"></div>
    </div>

    {{-- Video Upload Section --}}
{{--    <div class="col-md-6">--}}
{{--        <div class="form-group">--}}
{{--            <div class="custom-file">--}}
{{--                <input type="file" name="video" class="custom-file-input @error('video') is-invalid @enderror"--}}
{{--                       id="validatedCustomFile" {{ !isset($heroSection) ? 'required' : '' }}>--}}
{{--                <label class="custom-file-label" for="validatedCustomFile">{{ __("keys.upload_video") }}</label>--}}
{{--                @error('video')--}}
{{--                <span class="text-danger">{{ $message }}</span>--}}
{{--                @enderror--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
</div>

<button type="submit" class="btn btn-primary">{{ __('keys.submit') }}</button>
