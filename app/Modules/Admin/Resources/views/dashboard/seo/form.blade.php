<form action="{{ $route }}" method="POST" enctype="multipart/form-data" class="p-4 bg-white rounded shadow-sm">
    @csrf
    @method($method)

    <div class="row">
        @foreach (config('translatable.locales') as $locale)
            <div class="col-md-6">
                <div class="form-group">
                    <label for="meta_name_{{ $locale }}"
                           class="font-weight-bold">{{ __("seo.meta_title_$locale") }}</label>
                    <input type="text" name="{{ $locale }}[meta_name]" id="meta_name_{{ $locale }}"
                           class="form-control @error("$locale.meta_name") is-invalid @enderror"
                           value="{{ old("$locale.meta_name", $seo ? $seo->translate($locale)->meta_name : '') }}"
                           required>
                    @error("$locale.meta_name")
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
        @endforeach
    </div>

    {{-- Slug & Page Title --}}
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="slug" class="font-weight-bold">{{ __('keys.slug') }}</label>
                <input type="text" name="slug" id="slug"
                       class="form-control @error('slug') is-invalid @enderror"
                       value="{{ old('slug', $seo ? $seo->slug : '') }}" required>
                @error('slug')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="page_name" class="font-weight-bold">{{ __('seo.page_title') }}</label>
                <input type="text" name="page_name" id="page_name"
                       class="form-control @error('page_name') is-invalid @enderror"
                       value="{{ old('page_name', $seo ? $seo->page_name : '') }}" required>
                @error('page_name')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>
    </div>

    {{-- Meta Descriptions --}}
    <div class="row">
        @foreach (config('translatable.locales') as $locale)
            <div class="col-md-6">
                <div class="form-group">
                    <label for="meta_description_{{ $locale }}"
                           class="font-weight-bold">{{ __("seo.meta_description_$locale") }}</label>
                    <textarea name="{{ $locale }}[meta_description]" id="meta_description_{{ $locale }}"
                              class="form-control @error("$locale.meta_description") is-invalid @enderror" rows="3"
                              required>{{ old("$locale.meta_description", $seo ? $seo->translate($locale)->meta_description : '') }}</textarea>
                    @error("$locale.meta_description")
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
        @endforeach
    </div>

    {{-- Meta Keywords --}}
    <div class="row">
        @foreach (config('translatable.locales') as $locale)
            <div class="col-md-6">
                <div class="form-group">
                    <label for="meta_keywords_{{ $locale }}"
                           class="font-weight-bold">{{ __("seo.meta_keywords_$locale") }}</label>
                    <textarea name="{{ $locale }}[meta_keywords]" id="meta_keywords_{{ $locale }}"
                              class="form-control @error("$locale.meta_keywords") is-invalid @enderror" rows="3"
                              required>{{ old("$locale.meta_keywords", $seo ? $seo->translate($locale)->meta_keywords : '') }}</textarea>
                    @error("$locale.meta_keywords")
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
        @endforeach
    </div>

    {{-- Switch Toggle --}}
    <div class="row">
        <div class="col-md-12 d-flex align-items-center">
            <label class="font-weight-bold mr-3 mb-0">{{ __('keys.is_active') }}</label>
            <div class="custom-control custom-switch">
                <input type="hidden" name="is_active" value="0">
                <input type="checkbox" class="custom-control-input" id="customSwitch1" name="is_active" value="1"
                    {{ old('is_active', $seo ? $seo->is_active : false) ? 'checked' : '' }}>
                <label class="custom-control-label" for="customSwitch1">{{ __('keys.yes') }}</label>
            </div>
        </div>
    </div>

    <div class="mt-4 text-right">
        <button type="submit" class="btn btn-primary px-4 py-2">{{ __('keys.submit') }}</button>
    </div>
</form>
