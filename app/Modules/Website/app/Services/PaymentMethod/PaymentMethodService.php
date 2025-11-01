<?php

namespace App\Modules\Website\app\Services\PaymentMethod;

use App\Modules\Admin\app\Models\Organization\Organization;
use App\Modules\Base\app\Response\DataSuccess;
use App\Modules\Base\app\Services\BaseService;
use App\Modules\Organization\app\Models\Order\Payment;
use App\Modules\Website\app\Http\Resources\PaymentMethod\PaymentMethodResource;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class PaymentMethodService extends BaseService
{
    public function __construct()
    {
        parent::__construct(resolve(Payment::class));
    }

    public function index($request = null, bool $paginate = false): Collection|LengthAwarePaginator|DataSuccess
    {
        $organization = Organization::query()->whereId(app()->bound('organization_id'))->first();
        $paymentMethods = $organization->paymentMethods->where('is_active', true)->values();

        $results = $paginate || filled($request->with_pagination)
            ? PaymentMethodResource::collection($paymentMethods)->response()->getData(true)
            : PaymentMethodResource::collection($paymentMethods);

        return new DataSuccess(
            data: $results,
            status: true,
            message: __('messages.data_retrieved_successfully')
        );
    }
}
