<form action="{{ isset($brand) ? route('organization.brands.update', $brand->id) : route('organization.brands.store') }}"
      method="POST" enctype="multipart/form-data">
    @csrf
    @if(isset($brand))
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
                           value="{{ old("$locale.name", isset($brand) ? $brand->translate($locale)->name : '') }}" required>
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
                              class="form-control tinymce-editor @error("$locale.description") is-invalid @enderror" rows="3">{{ old("$locale.description", isset($brand) ? $brand->translate($locale)->description : '') }}</textarea>
                    @error("$locale.description")
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
        @endforeach
    </div>

    {{-- Slug + Categories --}}
    <div class="row">
        {{-- Slug --}}
        <div class="col-md-6">
            <div class="form-group">
                <label for="slug" class="font-weight-bold">{{ __("messages.slug") }}</label>
                <input type="text" name="slug" id="slug"
                       class="form-control @error('slug') is-invalid @enderror"
                       value="{{ old('slug', $brand->slug ?? '') }}" required>
                @error('slug')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>

        {{-- Categories --}}
        <div class="col-md-6">
            <div class="form-group">
                <label for="categories" class="font-weight-bold">{{ __("organizations.categories") }}</label>
                <select multiple name="categories[]" id="categories"
                        class="form-control select2 @error('categories') is-invalid @enderror">
                    <option></option> {{-- علشان يظهر الـ placeholder --}}
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ (collect(old('categories', isset($brand) ? $brand->categories->pluck('id')->toArray() : []))->contains($category->id)) ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('categories')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>
    </div>
    <div class="row">
        {{-- Image Upload Section --}}
        <div class="col-md-6">
            <div class="form-group">
                {{-- Show old image if editing --}}


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
                @if(isset($brand) &&  $brand->image )
                    <div class="mb-3">
                        <img src="{{ asset("storage/$brand->image") }}"
                             alt="Header Image" class="img-thumbnail" width="150">
                    </div>
                @endif
                {{-- Preview for new selected image --}}
                <div id="image-preview" class="mt-2"></div>
            </div>
        </div>
    </div>

    <br>
    <button type="submit" class="btn btn-primary">{{ __('messages.submit') }}</button>
</form>

<script>
    $(document).ready(function() {
        $('#categories').select2({
            placeholder: "{{ __('messages.choose_categories') }}",
            allowClear: true,
            width: '100%'
        });
    });
</script>
