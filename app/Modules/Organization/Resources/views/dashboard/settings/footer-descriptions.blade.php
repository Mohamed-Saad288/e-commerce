<!-- resources/views/dashboard/partials/footer-descriptions.blade.php -->
<h2 class="section-header">{{ __("keys.slogan_copyright") }}</h2>
<div class="row">
    @foreach (config('translatable.locales') as $locale)
        <div class="col-md-6">
            <div class="form-group">
                <label for="footer_description_{{ $locale }}"
                       class="font-weight-bold">{{ __("keys.footer_description_$locale") }}</label>
                <textarea name="{{ $locale }}[footer_description]" id="footer_description_{{ $locale }}"
                          class="form-control tinymce-editor @error("$locale.footer_description") is-invalid @enderror" rows="3"
                          required>{{ old("$locale.footer_description", $setting ? $setting->translate($locale)->footer_description : '') }}</textarea>
                @error("$locale.footer_description")
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>
    @endforeach
    @foreach (config('translatable.locales') as $locale)
        <div class="col-md-6">
            <div class="form-group">
                <label for="footer_description2_{{ $locale }}"
                       class="font-weight-bold">{{ __("keys.footer_description2_$locale") }}</label>
                <textarea name="{{ $locale }}[footer_description2]" id="footer_description2_{{ $locale }}"
                          class="form-control tinymce-editor @error("$locale.footer_description2") is-invalid @enderror" rows="3"
                          required>{{ old("$locale.footer_description2", $setting ? $setting->translate($locale)->footer_description2 : '') }}</textarea>
                @error("$locale.footer_description2")
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>
    @endforeach
</div>
