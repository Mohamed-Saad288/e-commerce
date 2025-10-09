@csrf

{{-- Description Fields --}}
<div class="row">
    @foreach (config('translatable.locales') as $locale)
        <div class="col-md-12">
            <div class="form-group">
                <label for="description_{{ $locale }}" class="font-weight-bold">
                    {{ __("messages.description_$locale") }}
                </label>
                <textarea name="{{ $locale }}[description]"
                          id="description_{{ $locale }}"
                          class="form-control summernote @error("$locale.description") is-invalid @enderror"
                          rows="5">{{ old("$locale.description", isset($privacy) ? $privacy->translate($locale)?->description : '') }}
                </textarea>

                @error("$locale.description")
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>
    @endforeach
</div>



<button type="submit" class="btn btn-primary">{{ __('messages.submit') }}</button>

{{-- Script to preview multiple images --}}

