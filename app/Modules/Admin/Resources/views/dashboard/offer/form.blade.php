@csrf
<div class="row">
@foreach (config('translatable.locales') as $locale)
    <div class="col-md-6">
        <div class="form-group">
            <label for="title_{{ $locale }}">{{ __("keys.title_$locale") }}</label>
            <input type="text" name="{{ $locale }}[name]" id="title_{{ $locale }}"
                   class="form-control @error("$locale.name") is-invalid @enderror"
                   value="{{ old("$locale.name", $offer->translate($locale)->name ?? '') }}" required>
            @error("$locale.name")
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
@endforeach

@foreach (config('translatable.locales') as $locale)
    <div class="col-md-12">
        <div class="form-group">
            <label for="description_{{ $locale }}">{{ __("keys.description_$locale") }}</label>
            <textarea name="{{ $locale }}[description]" id="description_{{ $locale }}"
                      class="form-control tinymce-editor @error("$locale.description") is-invalid @enderror" rows="3" >{{ old("$locale.description", $offer->translate($locale)->description ?? '') }}</textarea>
            @error("$locale.description")
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
@endforeach
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="price">{{ __("offers.Price") }}</label>
            <input type="number" name="price" id="price"
                   class="form-control  @error('price') is-invalid @enderror"
                   value="{{ old('price', $offer->price ?? '') }}" required>
            @error('price')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label for="discount_percent">{{ __("offers.Discount_Percent") }}</label>
            <input type="text" name="discount_percent" id="discount_percent"
                   class="form-control @error('discount_percent') is-invalid @enderror"
                   value="{{ old('discount_percent', $offer->discount_percent ?? '') }}" required>
            @error('discount_percent')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>


<div class="col-md-6 d-flex align-items-center">
    <p class="mb-0 mr-3">{{ __("keys.is_active") }}</p>
    <div class="custom-control custom-switch">
        <input type="hidden" name="is_active" value="0">
        <input type="checkbox" class="custom-control-input" id="customSwitch1" name="is_active" value="1"
            {{ old('is_active', $offer->is_active ?? false) ? 'checked' : '' }}>
        <label class="custom-control-label" for="customSwitch1">{{ __("keys.yes") }}</label>
    </div>
</div>

<button type="submit" class="btn btn-primary">{{ __('keys.submit') }}</button>
