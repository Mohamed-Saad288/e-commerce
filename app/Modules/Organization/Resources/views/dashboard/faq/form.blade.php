<form action="{{ $route }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method($method)

    {{-- QUESTION Field --}}
    <div class="row">
        @foreach (config('translatable.locales') as $locale)
            <div class="col-md-6">
                <div class="form-group">
                    <label for="question_{{ $locale }}">{{ __("keys.question_$locale") }}</label>
                    <input type="text" name="{{ $locale }}[question]" id="question_{{ $locale }}"
                        class="form-control @error("$locale.question") is-invalid @enderror"
                        value="{{ old("$locale.question", $faq ? $faq->translate($locale)->question : '') }}" required>
                    @error("$locale.question")
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
                    <label for="answer_{{ $locale }}">{{ __("keys.answer_$locale") }}</label>
                    <textarea name="{{ $locale }}[answer]" id="answer_{{ $locale }}"
                        class="form-control @error("$locale.answer") is-invalid @enderror" rows="3" required>
                        {{ old("$locale.answer", $faq ? $faq->translate($locale)->answer : '') }}</textarea>
                    @error("$locale.answer")
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        @endforeach
    </div>

    <div class="row">
        {{-- Switch Toggle --}}
        <div class="col-md-6 d-flex align-items-center">
            <p class="mb-0 mr-3">{{ __('keys.is_active') }}</p>
            <div class="custom-control custom-switch">
                <input type="hidden" name="is_active" value="0">
                <input type="checkbox" class="custom-control-input" id="customSwitch1" name="is_active" value="1"
                    {{ old('is_active', $faq ? $faq->is_active : false) ? 'checked' : '' }}>
                <label class="custom-control-label" for="customSwitch1">{{ __('keys.yes') }}</label>
            </div>
        </div>
    </div>

    <button type="submit" class="btn btn-primary">{{ __('keys.submit') }}</button>
</form>
