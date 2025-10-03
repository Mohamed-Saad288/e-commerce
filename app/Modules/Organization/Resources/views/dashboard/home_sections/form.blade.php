<form action="{{ isset($home_section) ? route('organization.home_sections.update', $home_section->id) : route('organization.home_sections.store') }}"
      method="POST" enctype="multipart/form-data">
    @csrf
    @if(isset($home_section))
        @method('PUT')
    @endif

    <div class="row">

        {{-- Type --}}
        <div class="col-md-6">
            <div class="form-group">
                <label for="type" class="font-weight-bold">{{ __('messages.type') }}</label>
                <select name="type" id="type" class="form-control @error('type') is-invalid @enderror" >
                    @foreach (\App\Modules\Organization\Enums\HomeSection\HomeSectionTypeEnum::cases() as $case)
                        <option value="{{ $case->value }}"
                            {{ old('type', $home_section->type->value ?? '') == $case->value ? 'selected' : '' }}>
                            {{ __("messages." . $case->name) }}
                        </option>
                    @endforeach
                </select>
                @error('type')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>
    </div>

    {{-- Name & Description (only if Custom) --}}
    <div id="custom-fields" style="display: none;">
        <div class="row">
            @foreach (config('translatable.locales') as $locale)
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="title_{{ $locale }}">{{ __("messages.name_$locale") }}</label>
                        <input type="text" name="{{ $locale }}[title]" id="name_{{ $locale }}"
                               class="form-control @error("$locale.title") is-invalid @enderror"
                               value="{{ old("$locale.title", isset($home_section) ? $home_section->translate($locale)?->title : '') }}">
                        @error("$locale.title")
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label for="description_{{ $locale }}">{{ __("messages.description_$locale") }}</label>
                        <textarea name="{{ $locale }}[description]" id="description_{{ $locale }}"
                                  class="form-control @error("$locale.description") is-invalid @enderror"
                                  rows="2">{{ old("$locale.description", isset($home_section) ? $home_section->translate($locale)?->description : '') }}</textarea>
                        @error("$locale.description")
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <hr>

    <div class="row">
        {{-- Sort Order (only in edit) --}}
        @if(isset($home_section))
            <div class="col-md-6">
                <div class="form-group">
                    <label for="sort_order" class="font-weight-bold">{{ __('messages.sort_order') }}</label>
                    <input type="number" name="sort_order" id="sort_order"
                           value="{{ old('sort_order', $home_section->sort_order ?? '') }}"
                           class="form-control @error('sort_order') is-invalid @enderror">
                    @error('sort_order')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
        @endif


        {{-- Start Date --}}
        {{-- Start Date --}}
        <div class="col-md-6">
            <div class="form-group">
                <label for="start_date" class="font-weight-bold">{{ __('messages.start_date') }}</label>
                <input type="date" name="start_date" id="start_date"
                       value="{{ old('start_date', isset($home_section->start_date) ? $home_section->start_date->format('Y-m-d') : '') }}"
                       class="form-control @error('start_date') is-invalid @enderror">
                @error('start_date')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>

        {{-- End Date --}}
        <div class="col-md-6">
            <div class="form-group">
                <label for="end_date" class="font-weight-bold">{{ __('messages.end_date') }}</label>
                <input type="date" name="end_date" id="end_date"
                       value="{{ old('end_date', isset($home_section->end_date) ? $home_section->end_date->format('Y-m-d') : '') }}"
                       class="form-control @error('end_date') is-invalid @enderror">
                @error('end_date')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>

    </div>

    <hr>

    {{-- Select Products --}}
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="products" class="font-weight-bold">{{ __('messages.products') }}</label>
                <select name="products[]" id="products" class="form-control select2 @error('products') is-invalid @enderror" multiple >
                    @foreach ($products as $product)
                        <option value="{{ $product->id }}"
                            {{ in_array($product->id, old('products', isset($home_section) ? $home_section->products->pluck('id')->toArray() : [])) ? 'selected' : '' }}>
                            {{ $product->name }}
                        </option>
                    @endforeach
                </select>
                @error('products')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>
    </div>

    <br>
    <button type="submit" class="btn btn-primary">{{ __('messages.submit') }}</button>
</form>
