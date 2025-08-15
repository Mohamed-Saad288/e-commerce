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

        {{-- Parent Category --}}
        <div class="col-md-6">
            <div class="form-group">
                <label for="parent_id" class="font-weight-bold">{{ __('organizations.parent') }}</label>
                <select name="parent_id" id="parent_id" class="form-control @error('parent_id') is-invalid @enderror">
                    <option value="">{{ __('messages.none') }}</option>
                    @foreach ($categories as $parentCategory)
                        <option value="{{ $parentCategory->id }}"
                            {{ old('parent_id', $category->parent_id ?? '') == $parentCategory->id ? 'selected' : '' }}>
                            {{ $parentCategory->name }}
                        </option>
                    @endforeach
                </select>
                @error('parent_id')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>
    </div>

    <br><br>
    <button type="submit" class="btn btn-primary">{{ __('messages.submit') }}</button>
</form>
