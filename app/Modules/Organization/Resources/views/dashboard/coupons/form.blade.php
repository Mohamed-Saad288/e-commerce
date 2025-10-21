<form action="{{ $route }}" method="POST" enctype="multipart/form-data" class="p-4 bg-white rounded shadow-sm">
    @csrf
    @method($method)

    <div class="row">
        {{-- Coupon Code --}}
        <div class="col-md-6 mb-3">
            <label for="code" class="form-label">{{ __('organizations.code') }}</label>
            <input type="text" name="code" id="code"
                   class="form-control @error('code') is-invalid @enderror"
                   value="{{ old('code', $coupon->code ?? '') }}"
                   placeholder="{{ __('organizations.enter_code') }}">
            @error('code')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Type --}}
        <div class="col-md-6 mb-3">
            <label for="type" class="form-label">{{ __('organizations.type') }}</label>
            <select name="type" id="type" class="form-control @error('type') is-invalid @enderror">
                <option value="">{{ __('organizations.select_type') }}</option>
                @foreach(\App\Modules\Organization\Enums\Coupon\CouponTypeEnum::cases() as $type)
                    <option value="{{ $type->value }}"
                        {{ old('type', $coupon->type ?? '') == $type->value ? 'selected' : '' }}>
                        {{ __('organizations.coupon_type_' . $type->name) }}
                    </option>
                @endforeach
            </select>
            @error('type')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Value --}}
        <div class="col-md-6 mb-3">
            <label for="value" class="form-label">{{ __('organizations.value') }}</label>
            <input type="number" name="value" id="value" step="0.01"
                   class="form-control @error('value') is-invalid @enderror"
                   value="{{ old('value', $coupon->value ?? '') }}"
                   placeholder="{{ __('organizations.enter_value') }}">
            @error('value')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Minimum Order Amount --}}
        <div class="col-md-6 mb-3">
            <label for="min_order_amount" class="form-label">{{ __('organizations.min_order_amount') }}</label>
            <input type="number" name="min_order_amount" id="min_order_amount" step="0.01"
                   class="form-control @error('min_order_amount') is-invalid @enderror"
                   value="{{ old('min_order_amount', $coupon->min_order_amount ?? '') }}"
                   placeholder="{{ __('organizations.enter_min_order_amount') }}">
            @error('min_order_amount')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Start Date --}}
        <div class="col-md-6 mb-3">
            <label for="start_date" class="form-label">{{ __('organizations.start_date') }}</label>
            <input type="date" name="start_date" id="start_date"
                   class="form-control @error('start_date') is-invalid @enderror"
                   value="{{ old('start_date', isset($coupon->start_date) ? \Illuminate\Support\Carbon::parse($coupon->start_date)->format('Y-m-d') : '') }}">
            @error('start_date')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- End Date --}}
        <div class="col-md-6 mb-3">
            <label for="end_date" class="form-label">{{ __('organizations.end_date') }}</label>
            <input type="date" name="end_date" id="end_date"
                   class="form-control @error('end_date') is-invalid @enderror"
                   value="{{ old('end_date', isset($coupon->end_date) ? \Illuminate\Support\Carbon::parse($coupon->end_date)->format('Y-m-d') : '') }}">
            @error('end_date')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Usage Limit --}}
        <div class="col-md-6 mb-3">
            <label for="usage_limit" class="form-label">{{ __('organizations.usage_limit') }}</label>
            <input type="number" name="usage_limit" id="usage_limit"
                   class="form-control @error('usage_limit') is-invalid @enderror"
                   value="{{ old('usage_limit', $coupon->usage_limit ?? '') }}"
                   placeholder="{{ __('organizations.enter_usage_limit') }}">
            @error('usage_limit')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

{{--        --}}{{-- Is Active --}}
{{--        <div class="col-md-6 mb-3">--}}
{{--            <label for="is_active" class="form-label">{{ __('organizations.is_active') }}</label>--}}
{{--            <select name="is_active" id="is_active" class="form-control @error('is_active') is-invalid @enderror">--}}
{{--                <option value="1" {{ old('is_active', $coupon->is_active ?? 1) == 1 ? 'selected' : '' }}>--}}
{{--                    {{ __('organizations.active') }}--}}
{{--                </option>--}}
{{--                <option value="0" {{ old('is_active', $coupon->is_active ?? 1) == 0 ? 'selected' : '' }}>--}}
{{--                    {{ __('organizations.inactive') }}--}}
{{--                </option>--}}
{{--            </select>--}}
{{--            @error('is_active')--}}
{{--            <div class="invalid-feedback">{{ $message }}</div>--}}
{{--            @enderror--}}
{{--        </div>--}}
    </div>

    {{-- Submit Button --}}
    <div class="mt-4 text-right">
        <button type="submit" class="btn btn-primary px-4 py-2">
            {{ isset($coupon) ? __('organizations.update') : __('organizations.submit') }}
        </button>
    </div>
</form>
