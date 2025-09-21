<?php

namespace App\Modules\Organization\app\Http\Controllers\OrganizationSetting;

use App\Http\Controllers\Controller;
use App\Modules\Organization\app\Models\OrganizationPaymentMethod;
use App\Modules\Organization\app\Models\PaymentMethod;
use Illuminate\Http\Request;



class OrganizationPaymentMethodController extends Controller
{
    public function index()
    {
        $organization = auth()->user()->organization;
        $paymentMethods = PaymentMethod::all();
        $orgPaymentMethods = $organization->paymentMethods()
            ->pluck('credentials', 'payment_method_id')
            ->toArray();

        return view('organization::dashboard.payment_methods.index', compact('paymentMethods', 'orgPaymentMethods'));
    }

    public function update(Request $request, $id)
    {
        $organization = auth()->user()->organization;

        $validated = $request->validate([
            'is_active'   => 'nullable|boolean',
            'credentials' => 'array|nullable',
        ]);

        $orgPaymentMethod = OrganizationPaymentMethod::firstOrNew([
            'organization_id' => $organization->id,
            'payment_method_id' => $id,
        ]);

        $orgPaymentMethod->is_active = $validated['is_active'] ?? false;
        $orgPaymentMethod->credentials = json_encode(array_filter($validated['credentials'] ?? []));
        $orgPaymentMethod->save();

        if ($request->ajax()) {
            return response()->json([
                'status'  => 'success',
                'message' => 'Payment method updated successfully.',
            ]);
        }

        return redirect()->back()->with('success', 'Payment method updated successfully.');
    }
}
