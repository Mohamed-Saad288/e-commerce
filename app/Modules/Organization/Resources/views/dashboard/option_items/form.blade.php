<form action="{{ isset($option_item) ? route('organization.option_items.update', $option_item->id) : route('organization.option_items.store') }}"
      method="POST" enctype="multipart/form-data">
    @csrf
    @if(isset($option_item))
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
                           value="{{ old("$locale.name", isset($option_item) ? $option_item->translate($locale)->name : '') }}" required>
                    @error("$locale.name")
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        @endforeach
    </div>


    <div class="row">

        {{-- Parent Category --}}
        <div class="col-md-12">
            <div class="form-group">
                <label for="option_id" class="font-weight-bold">{{ __('organizations.parent') }}</label>
                <select name="option_id" id="option_id" class="form-control @error('option_id') is-invalid @enderror">
                    <option value="">{{ __('messages.none') }}</option>
                    @foreach ($options as $option)
                        <option value="{{ $option->id }}"
                            {{ old('option_id', $option_item->option_id ?? '') == $option->id ? 'selected' : '' }}>
                            {{ $option->name }}
                        </option>
                    @endforeach
                </select>
                @error('option_id')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>
    </div>

    <br><br>
    <button type="submit" class="btn btn-primary">{{ __('messages.submit') }}</button>
</form>
