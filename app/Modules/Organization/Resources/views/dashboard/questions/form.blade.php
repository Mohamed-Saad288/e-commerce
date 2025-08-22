@csrf
{{-- Question Fields --}}
<div class="row">
    @foreach (config('translatable.locales') as $locale)
        <div class="col-md-12">
            <div class="form-group">
                <label for="question_{{ $locale }}" class="font-weight-bold">{{ __("messages.question_$locale") }}</label>
                <textarea name="{{ $locale }}[question]" id="question_{{ $locale }}"
                          class="form-control tinymce-editor @error("$locale.question") is-invalid @enderror"
                          rows="3">{{ old("$locale.question", isset($question) ? $question->translate($locale)->question : '') }}</textarea>
                @error("$locale.question")
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>
    @endforeach
</div>

{{-- Answer Fields --}}
<div class="row">
    @foreach (config('translatable.locales') as $locale)
        <div class="col-md-12">
            <div class="form-group">
                <label for="answer_{{ $locale }}" class="font-weight-bold">{{ __("messages.answer_$locale") }}</label>
                <textarea name="{{ $locale }}[answer]" id="answer_{{ $locale }}"
                          class="form-control tinymce-editor @error("$locale.answer") is-invalid @enderror"
                          rows="5">{{ old("$locale.answer", isset($question) ? $question->translate($locale)->answer : '') }}</textarea>
                @error("$locale.answer")
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>
    @endforeach
</div>


<button type="submit" class="btn btn-primary">{{ __('messages.submit') }}</button>
