<form action="{{ $route }}" method="POST" enctype="multipart/form-data" class="p-4 bg-white rounded shadow-sm">
    @csrf
    @method($method)

    {{-- Name --}}
    <div class="row">
        @foreach (config('translatable.locales') as $locale)
            <div class="col-md-6">
                <div class="form-group">
                    <label for="name_{{ $locale }}">{{ __("keys.name_$locale") }}</label>
                    <input type="text" name="{{ $locale }}[name]" id="name_{{ $locale }}"
                        class="form-control @error("$locale.name") is-invalid @enderror"
                        value="{{ old("$locale.name", $about ? $about->translate($locale)->name : '') }}" required>
                    @error("$locale.name")
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        @endforeach
    </div>

    {{-- Type --}}
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {{--                <label for="type" class="font-weight-bold">{{ __('keys.type') }}</label> --}}
                <input type="hidden" name="type" id="type"
                    class="form-control @error('type') is-invalid @enderror" value="{{ $type }}" required>
                @error('type')
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
                        class="form-control tinymce-editor @error("$locale.description") is-invalid @enderror" rows="3">{{ old("$locale.description", $about ? $about->translate($locale)->description : '') }}</textarea>
                    @error("$locale.description")
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
        @endforeach
    </div>

    {{-- Meta Title --}}
    <div class="row">
        @foreach (config('translatable.locales') as $locale)
            <div class="col-md-6">
                <div class="form-group">
                    <label for="meta_title_{{ $locale }}">{{ __("seo.meta_title_$locale") }}</label>
                    <input type="text" name="{{ $locale }}[meta_title]" id="meta_title_{{ $locale }}"
                        class="form-control @error("$locale.meta_title") is-invalid @enderror"
                        value="{{ old("$locale.meta_title", $about ? $about->translate($locale)->meta_title : '') }}">
                    @error("$locale.meta_title")
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        @endforeach
    </div>

    {{-- Meta Descriptions --}}
    <div class="row">
        @foreach (config('translatable.locales') as $locale)
            <div class="col-md-6">
                <div class="form-group">
                    <label for="meta_description_{{ $locale }}"
                        class="font-weight-bold">{{ __("seo.meta_description_$locale") }}</label>
                    <textarea name="{{ $locale }}[meta_description]" id="meta_description_{{ $locale }}"
                        class="form-control @error("$locale.meta_description") is-invalid @enderror" rows="3">{{ old("$locale.meta_description", $about ? $about->translate($locale)->meta_description : '') }}</textarea>
                    @error("$locale.meta_description")
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
        @endforeach
    </div>

    <div class="row">
        {{-- Image Upload --}}
        <div class="col-md-6">
            <div class="form-group">
                @if(isset($about) && url($about->getFirstMediaUrl('about_images')))
                    <div class="mb-2">
                        <img src="{{ url($about->getFirstMediaUrl('about_images')) }}" alt="Current Image" class="img-thumbnail"
                             width="100">
                    </div>
                @endif
            <label class="font-weight-bold mr-3 mb-0">{{ __('keys.image') }}</label>
            <div class="custom-file mb-3">
                <input type="file" name="image" class="custom-file-input @error('image') is-invalid @enderror"
                    id="validatedCustomFile" accept="image/*" onchange="previewImage(event)" multiple>
                <label class="custom-file-label" for="validatedCustomFile">{{ __('keys.choose_file') }}</label>
                @error('image')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
        </div>
        <div class="image-preview" id="image-preview"></div>

        {{-- Switch Toggle --}}
        <div class="col-md-6 d-flex align-items-center">
            <label class="font-weight-bold mr-3 mb-0">{{ __('keys.is_active') }}</label>
            <div class="custom-control custom-switch">
                <input type="hidden" name="is_active" value="0">
                <input type="checkbox" class="custom-control-input" id="customSwitch1" name="is_active" value="1"
                    {{ old('is_active', $about ? $about->is_active : false) ? 'checked' : '' }}>
                <label class="custom-control-label" for="customSwitch1">{{ __('keys.yes') }}</label>
            </div>
        </div>
    </div>

    @if($type == 'about')
        <div class="row">
            {{-- org structure Upload --}}
            <div class="col-md-6">
                <div class="form-group">
                    @if(isset($about) && url($about->getFirstMediaUrl('org_structure')))
                        <div class="mb-2">
                            <img src="{{ url($about->getFirstMediaUrl('org_structure')) }}" alt="Current Image" class="img-thumbnail"
                                 width="100">
                        </div>
                    @endif
                <label class="font-weight-bold mr-3 mb-0">{{ __('keys.org_structure') }}</label>
                <div class="custom-file mb-3">
                    <input type="file" name="org_structure" class="custom-file-input @error('org_structure') is-invalid @enderror"
                           id="validatedCustomFile" accept="image/*" onchange="previewImage(event)" multiple>
                    <label class="custom-file-label" for="validatedCustomFile">{{ __('keys.choose_file') }}</label>
                    @error('org_structure')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        </div>
        <div class="image-preview" id="image-preview"></div>
    @endif


    <div class="mt-4 text-right">
        <button type="submit" class="btn btn-primary px-4 py-2">{{ __('keys.submit') }}</button>
    </div>
</form>
