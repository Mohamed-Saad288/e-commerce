@extends("organization::dashboard.master")
@section('title', isset($coupon) ? __('organizations.edit_coupon') : __('organizations.add_coupon'))

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <strong
                            class="card-title">{{ isset($coupon) ? __('organizations.edit_coupon') : __('organizations.add_coupon') }}</strong>
                    </div>
                    <div class="card-body">
                        @include('organization::dashboard.coupons.form', [
                            "route" => isset($coupon) ? route("organization.coupons.update" , ["coupon" => $coupon->id ]) :
                            route('organization.coupons.store'),
                            "coupon" => $coupon ?? null,
                            "method" => isset($coupon) ? "PUT" : "POST",
                        ])
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
