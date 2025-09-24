@csrf
{{-- Name Fields --}}
<div class="row">
    @foreach (config('translatable.locales') as $locale)
        <div class="col-md-6">
            <div class="form-group">
                <label for="name_{{ $locale }}">{{ __("messages.name_$locale") }}</label>
                <input type="text" name="{{ $locale }}[name]" id="name_{{ $locale }}"
                       class="form-control @error("$locale.name") is-invalid @enderror"
                       value="{{ old("$locale.name", isset($header) ? optional($header->translate($locale))->name : '') }}" required>
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
                <label for="description_{{ $locale }}" class="font-weight-bold">
                    {{ __("messages.description_$locale") }}
                </label>
                <textarea name="{{ $locale }}[description]"
                          id="description_{{ $locale }}"
                          class="form-control summernote @error("$locale.description") is-invalid @enderror"
                          rows="5">{{ old("$locale.description", isset($header) ? $header->translate($locale)?->description : '') }}
                </textarea>

                @error("$locale.description")
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>
    @endforeach
</div>


<div class="row">
    {{-- Images Upload Section --}}
    <div class="col-md-12">
        <div class="form-group">
            {{-- Upload multiple images --}}
            <div class="custom-file">
                <input type="file"
                       name="images[]"
                       class="custom-file-input @error('images.*') is-invalid @enderror"
                       id="images"
                       accept="image/*"
                       multiple>
                <label class="custom-file-label" for="images">{{ __('messages.upload_images') }}</label>
                @error('images.*')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            {{-- Show old images if editing --}}
            @if(isset($header) && $header->images)
                <div class="mb-3 d-flex flex-wrap gap-2" id="old-images-container">
                    @foreach($header->images as $img)
                        <img src="{{ asset("storage/$img") }}"
                             alt="Header Image"
                             class="img-thumbnail"
                             width="150">
                    @endforeach
                </div>
            @endif

            {{-- Preview for new selected images --}}
            <div id="images-preview" class="mt-2 d-flex flex-wrap gap-2"></div>
        </div>
    </div>
</div>

<button type="submit" class="btn btn-primary">{{ __('messages.submit') }}</button>

{{-- Script to preview multiple images --}}

