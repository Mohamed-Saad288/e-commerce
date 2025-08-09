<form action="{{ $route }}" method="POST" enctype="multipart/form-data" class="p-4 bg-white rounded shadow-sm">
    @csrf
    @method($method)

    {{-- Title Fields --}}
    <div class="row">
        @foreach (config('translatable.locales') as $locale)
            <div class="col-md-6">
                <div class="form-group">
                    <label for="title_{{ $locale }}" class="font-weight-bold">{{ __("keys.title_$locale") }}</label>
                    <input type="text" name="{{ $locale }}[name]" id="title_{{ $locale }}"
                           class="form-control @error("$locale.name") is-invalid @enderror"
                           value="{{ old("$locale.name", $blog ? $blog->translate($locale)->name : '') }}" required>
                    @error("$locale.name")
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
        @endforeach
    </div>

    {{-- Slug Field --}}
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="slug" class="font-weight-bold">{{ __("keys.slug") }}</label>
                <input type="text" name="slug" id="slug"
                       class="form-control @error('slug') is-invalid @enderror"
                       value="{{ old('slug', $blog ? $blog->slug : '') }}" required>
                @error('slug')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>
    </div>

    {{-- Description Fields --}}
    <div class="row">
        @foreach (config('translatable.locales') as $locale)
            <div class="col-md-12">
                <div class="form-group">
                    <label for="description_{{ $locale }}"
                           class="font-weight-bold">{{ __("keys.description_$locale") }}</label>
                    <textarea name="{{ $locale }}[description]" id="description_{{ $locale }}"
                              class="form-control tinymce-editor @error("$locale.description") is-invalid @enderror"
                              rows="3">{{ old("$locale.description", $blog ? $blog->translate($locale)->description : '') }}</textarea>
                    @error("$locale.description")
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
        @endforeach
    </div>

    {{-- File Upload --}}
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                @if(isset($blog) && url($blog->getFirstMediaUrl('images')))
                    <div class="mb-2">
                        <img src="{{ url($blog->getFirstMediaUrl('images')) }}" alt="Current Image"
                             class="img-thumbnail" width="100">
                    </div>
                @endif
                <div class="custom-file">
                    <input type="file" name="image" class="custom-file-input @error('image') is-invalid @enderror"
                           id="images" {{ !isset($blog) ? 'required' : '' }}>
                    <label class="custom-file-label" for="validatedCustomFile">{{ __("keys.choose_file") }}</label>
                    @error('image')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
        </div>


        {{-- Switch Toggle --}}
        <div class="col-md-6 d-flex align-items-center mt-3 mt-md-0">
            <label class="font-weight-bold mr-3 mb-0">{{ __("keys.is_active") }}</label>
            <div class="custom-control custom-switch">
                <input type="hidden" name="is_active" value="0">
                <input type="checkbox" class="custom-control-input" id="customSwitch1" name="is_active" value="1"
                    {{ old('is_active', $blog ? $blog->is_active : false) ? 'checked' : '' }}>
                <label class="custom-control-label" for="customSwitch1">{{ __("keys.yes") }}</label>
            </div>
        </div>
    </div>

    <div class="image-preview" id="image-preview"></div>


    <div class="mt-4 text-right">
        <button type="submit" class="btn btn-primary px-4 py-2">{{ __('keys.submit') }}</button>
    </div>
</form>
