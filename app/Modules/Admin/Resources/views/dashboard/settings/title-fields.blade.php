<!-- resources/views/dashboard/partials/title-fields.blade.php -->
<h2 class="section-header">{{ __("keys.main_data") }}</h2>
<div class="row">
    @foreach (config('translatable.locales') as $locale)
        <div class="col-md-6">
            <div class="form-group">
                <label for="title_{{ $locale }}" class="font-weight-bold">{{ __("keys.title_$locale") }}</label>
                <input type="text" name="{{ $locale }}[name]" id="title_{{ $locale }}"
                       class="form-control @error("$locale.name") is-invalid @enderror"
                       value="{{ old("$locale.name", $setting ? $setting->translate($locale)->name : '') }}" required>
                @error("$locale.name")
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>
    @endforeach
</div>

<div class="row">
    @foreach (config('translatable.locales') as $locale)
        <div class="col-md-12">
            <div class="form-group">
                <label for="description_{{ $locale }}"
                       class="font-weight-bold">{{ __("keys.description_$locale") }}</label>
                <textarea name="{{ $locale }}[description]" id="description_{{ $locale }}"
                          class="form-control tinymce-editor @error("$locale.description") is-invalid @enderror"
                          rows="3">{{ old("$locale.description", $setting ? $setting->translate($locale)->description : '') }}</textarea>
                @error("$locale.description")
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>
    @endforeach
</div>

<div class="row">
    @foreach (config('translatable.locales') as $locale)
        <div class="col-md-12">
            <div class="form-group">
                <label for="notes_and_suggestions_{{ $locale }}"
                       class="font-weight-bold">{{ __("keys.notes_and_suggestions_$locale") }}</label>
                <textarea name="{{ $locale }}[notes_and_suggestions]" id="notes_and_suggestions_{{ $locale }}"
                          class="form-control tinymce-editor @error("$locale.notes_and_suggestions") is-invalid @enderror"
                          rows="3">{{ old("$locale.notes_and_suggestions", $setting ? $setting->translate($locale)->notes_and_suggestions : '') }}</textarea>
                @error("$locale.notes_and_suggestions")
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>
    @endforeach
</div>
