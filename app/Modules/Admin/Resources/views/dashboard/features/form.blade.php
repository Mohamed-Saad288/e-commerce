<form action="{{ $route }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method($method)

    {{-- Name Field --}}
    <div class="row">
        @foreach (config('translatable.locales') as $locale)
            <div class="col-md-6">
                <div class="form-group">
                    <label for="name_{{ $locale }}">{{ __("keys.name_$locale") }}</label>
                    <input type="text" name="{{ $locale }}[name]" id="name_{{ $locale }}"
                        class="form-control @error("$locale.name") is-invalid @enderror"
                        value="{{ old("$locale.name", $feature ? $feature->translate($locale)->name : '') }}" required>
                    @error("$locale.name")
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        @endforeach
    </div>

    <div class="row">
        @foreach (config('translatable.locales') as $locale)
            <div class="col-md-6">
                <div class="form-group">
                    <label for="description_{{ $locale }}">{{ __("keys.description_$locale") }}</label>
                    <textarea name="{{ $locale }}[description]" id="description_{{ $locale }}"
                        class="form-control @error("$locale.description") is-invalid @enderror" rows="3" required>
                        {{ old("$locale.description", $feature ? $feature->translate($locale)->description : '') }}</textarea>
                    @error("$locale.description")
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        @endforeach
    </div>

    {{-- Slug Field --}}
    <div class="row">
        {{-- slug --}}
        <div class="col-md-8">
            <div class="form-group">
                <label for="slug" class="font-weight-bold">{{ __("keys.slug") }}</label>
                <input type="text" name="slug" id="slug"
                       class="form-control @error('slug') is-invalid @enderror"
                       value="{{ old('slug', $feature->slug ?? '') }}" required>
                @error('slug')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>

        {{-- type --}}
        <div class="col-md-4">
            <div class="form-group">
                <label for="type" class="font-weight-bold">{{ __("keys.type") }}</label>
                <select name="type" id="type"
                        class="form-control form-control-sm @error('type') is-invalid @enderror" required>
                    @foreach($types as $type)
                        <option value="{{ $type->value }}"
                            {{ old('type', $feature->type ?? 1) == $type->value ? 'selected' : '' }}>
                            {{ $type->label() }}
                        </option>
                    @endforeach
                </select>
                @error('type')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>
    </div>


    <div class="row">
        {{-- Switch Toggle --}}
        <div class="col-md-6 d-flex align-items-center">
            <p class="mb-0 mr-3">{{ __('keys.is_active') }}</p>
            <div class="custom-control custom-switch">
                <input type="hidden" name="is_active" value="0">
                <input type="checkbox" class="custom-control-input" id="customSwitch1" name="is_active" value="1"
                    {{ old('is_active', $feature ? $feature->is_active : false) ? 'checked' : '' }}>
                <label class="custom-control-label" for="customSwitch1">{{ __('keys.yes') }}</label>
            </div>
        </div>
    </div>

    <button type="submit" class="btn btn-primary">{{ __('keys.submit') }}</button>
</form>
