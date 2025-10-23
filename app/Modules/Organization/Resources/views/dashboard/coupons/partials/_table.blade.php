<table class="table table-hover align-middle">
    <thead class="table-light">
    <tr>
        <th>#</th>
        <th>{{ __('messages.code') }}</th>
        <th>{{ __('messages.type') }}</th>
        <th>{{ __('messages.value') }}</th>
        <th>{{ __('messages.is_active') }}</th>
        <th class="text-center">{{ __('messages.actions') }}</th>
    </tr>
    </thead>
    <tbody>
    @forelse ($coupons as $coupon)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $coupon->code }}</td>

            @if($coupon->type == \App\Modules\Organization\Enums\Coupon\CouponTypeEnum::FIXED_AMOUNT->value)
                <td>{{ __('messages.fixed_amount') }}</td>
            @elseif($coupon->type == \App\Modules\Organization\Enums\Coupon\CouponTypeEnum::PERCENTAGE->value)
                <td>{{ __('messages.percentage') }}</td>
            @else
                <td>{{ __('messages.free_shipping') }}</td>
            @endif

            <td>{{ $coupon->value }}</td>

            <td>
                <button class="btn btn-sm toggle-status {{ $coupon->is_active ? 'btn-success' : 'btn-secondary' }}"
                        data-id="{{ $coupon->id }}">
                    {{ $coupon->is_active ? __('messages.active') : __('messages.inactive') }}
                </button>
            </td>

            <td class="text-center">
                <a href="{{ route('organization.coupons.edit', $coupon->id) }}"
                   class="btn btn-sm btn-success me-1" title="{{ __('messages.edit') }}">
                    <i class="fe fe-edit"></i>
                </a>
                <button class="btn btn-sm btn-danger delete-coupon"
                        data-id="{{ $coupon->id }}"
                        title="{{ __('messages.delete') }}">
                    <i class="fe fe-trash-2"></i>
                </button>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="6" class="text-center py-4">
                <div class="no-data">
                    <img src="{{ asset('no-data.png') }}" alt="No Data" style="max-width: 120px;">
                    <p class="text-muted">{{ __('messages.no_data') }}</p>
                </div>
            </td>
        </tr>
    @endforelse
    </tbody>
</table>

<div class="d-flex justify-content-center mt-4" dir="{{ LaravelLocalization::getCurrentLocale() == 'ar' ? 'rtl' : 'ltr' }}">
    {{ $coupons->onEachSide(1)->links('pagination::bootstrap-5') }}
</div>
