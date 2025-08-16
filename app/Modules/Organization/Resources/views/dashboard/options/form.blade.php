<form action="{{ isset($option) ? route('organization.options.update', $option->id) : route('organization.options.store') }}"
      method="POST" enctype="multipart/form-data">
    @csrf
    @if(isset($option))
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
                           value="{{ old("$locale.name", isset($option) ? $option->translate($locale)->name : '') }}" required>
                    @error("$locale.name")
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        @endforeach
    </div>


    <br><br>
    <button type="submit" class="btn btn-primary">{{ __('messages.submit') }}</button>
</form>
