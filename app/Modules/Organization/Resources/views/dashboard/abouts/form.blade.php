@csrf
{{-- Name Fields --}}
<div class="row">
    @foreach (config('translatable.locales') as $locale)
        <div class="col-md-6">
            <div class="form-group">
                <label for="name_{{ $locale }}">{{ __("messages.name_$locale") }}</label>
                <input type="text" name="{{ $locale }}[name]" id="name_{{ $locale }}"
                       class="form-control @error("$locale.name") is-invalid @enderror"
                       value="{{ old("$locale.name", isset($category) ? $category->translate($locale)->name : '') }}" required>
                @error("$locale.name")
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
    @endforeach
</div>

{{-- Description Fields --}}
<div class="row">
    @foreach (config('translatable.locales') as $locale)
        <div class="col-md-12">
            <div class="form-group">
                <label for="description_{{ $locale }}" class="font-weight-bold">{{ __("messages.description_$locale") }}</label>
                <textarea name="{{ $locale }}[description]" id="description_{{ $locale }}"
                          class="form-control tinymce-editor @error("$locale.description") is-invalid @enderror" rows="3">{{ old("$locale.description", isset($category) ? $category->translate($locale)->description : '') }}</textarea>
                @error("$locale.description")
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>
    @endforeach
</div>

<div class="row">
    {{-- Image Upload Section --}}
    <div class="col-md-6">
        <div class="form-group">
            {{-- Show old image if editing --}}
            @if(isset($about) && $about->getFirstMediaUrl('about_images'))
                <div class="mb-3">
                    <img src="{{ $about->getFirstMediaUrl('about_images') }}"
                         alt="Header Image" class="img-thumbnail" width="150">
                </div>
            @endif

            {{-- Upload new image --}}
            <div class="custom-file">
                <input type="file"
                       name="image"
                       class="custom-file-input @error('image') is-invalid @enderror"
                       id="image"
                       accept="image/*">
                <label class="custom-file-label" for="image">{{ __('messages.upload_image') }}</label>
                @error('image')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            {{-- Preview for new selected image --}}
            <div id="image-preview" class="mt-2"></div>
        </div>
    </div>
</div>

<button type="submit" class="btn btn-primary">{{ __('messages.submit') }}</button>
