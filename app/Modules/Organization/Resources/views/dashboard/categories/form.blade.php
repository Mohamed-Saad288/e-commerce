<form action="{{ isset($category) ? route('organization.categories.update', $category->id) : route('organization.categories.store') }}"
      method="POST" enctype="multipart/form-data">
    @csrf
    @if(isset($category))
        @method('PUT')
    @endif

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
        {{-- Slug --}}
        <div class="col-md-6">
            <div class="form-group">
                <label for="slug" class="font-weight-bold">{{ __("messages.slug") }}</label>
                <input type="text" name="slug" id="slug"
                       class="form-control @error('slug') is-invalid @enderror"
                       value="{{ old('slug', $category->slug ?? '') }}" required>
                @error('slug')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>

        @if(isset($parent_id))
            <input type="hidden" name="parent_id" value="{{ $parent_id }}">
        @endif

        {{-- Parent Category --}}
        <div class="col-md-6">
            <div class="form-group mb-3">
                <label for="parent_id">{{ __('organizations.parent_category') }}</label>
                <select name="parent_id" id="parent_id" class="form-control" {{ isset($parent_id) ? 'disabled' : '' }}>
                    <option value="">{{ __('organizations.main_category') }}</option>
                    @foreach($parents as $parent)
                        <option value="{{ $parent->id }}"
                            {{ (isset($parent_id) && $parent_id == $parent->id) ? 'selected' : '' }}>
                            {{ $parent->translate(app()->getLocale())->name }}
                        </option>
                    @endforeach
                </select>

            </div>
        </div>
    </div>

    <br><br>
    <button type="submit" class="btn btn-primary">{{ __('messages.submit') }}</button>
</form>
