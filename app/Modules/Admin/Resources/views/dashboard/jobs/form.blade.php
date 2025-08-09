@csrf
<div class="row">
    @foreach (config('translatable.locales') as $locale)
        <div class="col-md-6">
            <div class="form-group">
                <label for="title_{{ $locale }}" class="font-weight-bold">{{ __("keys.name_$locale") }}</label>
                <input type="text" name="{{ $locale }}[name]" id="name_{{ $locale }}"
                    class="form-control @error("$locale.name") is-invalid @enderror"
                    value="{{ old("$locale.name", $job->translate($locale)->name ?? '') }}" required>
                @error("$locale.name")
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
    @endforeach

    @foreach (config('translatable.locales') as $locale)
        <div class="col-md-6">
            <div class="form-group">
                <label for="title_{{ $locale }}"
                    class="font-weight-bold">{{ __("keys.position_$locale") }}</label>
                <input type="text" name="{{ $locale }}[position]" id="title_{{ $locale }}"
                    class="form-control @error("$locale.position") is-invalid @enderror"
                    value="{{ old("$locale.position", $job->translate($locale)->position ?? '') }}" required>
                @error("$locale.position")
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
    @endforeach

</div>

<div class="row">
    {{-- Image Upload Section --}}
    <div class="col-md-6">
        <div class="custom-file mb-3">
            <input type="file" name="image" class="custom-file-input @error('image') is-invalid @enderror"
                id="validatedCustomFile" accept="image/*" onchange="previewImage(event)">
            <label class="custom-file-label mt-2" for="validatedCustomFile">{{ __('keys.choose_file') }}</label>
            @error('image')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>

    {{-- Active Switch --}}
    <div class="col-md-6 d-flex align-items-center">
        <p class="mb-0 mr-3 font-weight-bold">{{ __('keys.is_active') }}</p>
        <div class="custom-control custom-switch">
            <input type="hidden" name="is_active" value="0">
            <input type="checkbox" class="custom-control-input" id="customSwitch1" name="is_active" value="1"
                {{ old('is_active', $service->is_active ?? false) ? 'checked' : '' }}>
            <label class="custom-control-label" for="customSwitch1">{{ __('keys.yes') }}</label>
        </div>
    </div>

    {{-- Parent Service Dropdown --}}
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="parent_id" class="font-weight-bold mt-5">{{ __('jobs.parentJob') }}</label>
            <select name="parent_id" id="parent_id" class="form-control  @error('parent_id') is-invalid @enderror">
                <option value="">{{ __('keys.none') }}</option>
                @foreach ($mainJobs as $mainJob)
                    <option value="{{ $mainJob->id }}"
                        {{ old('parent_id', $job->parent_id ?? '') == $mainJob->id ? 'selected' : '' }}>
                        {{ $mainJob->position }}
                    </option>
                @endforeach
            </select>
            @error('parent_id')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
    </div>

</div>

<button type="submit" class="btn btn-primary">{{ __('keys.submit') }}</button>
