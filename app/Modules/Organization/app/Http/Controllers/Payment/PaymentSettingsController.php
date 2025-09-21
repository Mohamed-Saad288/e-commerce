<?php

namespace App\Modules\Organization\app\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Modules\Organization\app\Models\PaymentMethod;
use App\Modules\Organization\app\Models\OrganizationPaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PaymentSettingsController extends Controller
{
    /**
     * Display the payment methods settings page
     */
    public function index()
    {
        $organization = auth()->user()->organization;
        $paymentMethods = PaymentMethod::with(['translations'])
            ->where('is_active', true)
            ->get();

        $organizationPaymentMethods = OrganizationPaymentMethod::with(['paymentMethod.translations'])
            ->where('organization_id', $organization->id)
            ->orderBy('sort_order')
            ->get();

        return view('organization::payment.settings.index', compact('paymentMethods', 'organizationPaymentMethods'));
    }

    /**
     * Update organization payment method settings
     */
    public function update(Request $request, PaymentMethod $paymentMethod)
    {
        $organization = auth()->user()->organization;

        // Get the gateway implementation
        $gatewayClass = "App\\Modules\\Organization\\app\\Services\\Payment\\Gateways\\" .
                        ucfirst($paymentMethod->code) . "Gateway";

        if (!class_exists($gatewayClass)) {
            return back()->with('error', 'Payment gateway not found');
        }

        $gateway = new $gatewayClass();

        // Validate settings
        $validator = Validator::make($request->all(), [
            'is_active' => 'required|boolean',
            'settings' => 'required|array',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Validate gateway specific settings
        if (!$gateway->validateSettings($request->settings)) {
            return back()->with('error', 'Invalid gateway settings');
        }

        // Update or create organization payment method
        OrganizationPaymentMethod::updateOrCreate(
            [
                'organization_id' => $organization->id,
                'payment_method_id' => $paymentMethod->id,
            ],
            [
                'is_active' => $request->is_active,
                'credentials' => $request->credentials,
                'sort_order' => $request->sort_order ?? 0,
            ]
        );

        return back()->with('success', 'Payment method settings updated successfully');
    }

    /**
     * Update payment methods sort order
     */
    public function updateOrder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'orders' => 'required|array',
            'orders.*.id' => 'required|exists:organization_payment_methods,id',
            'orders.*.order' => 'required|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        foreach ($request->orders as $item) {
            OrganizationPaymentMethod::where('id', $item['id'])
                ->update(['sort_order' => $item['order']]);
        }

        return response()->json(['message' => 'Order updated successfully']);
    }

    /**
     * Toggle payment method status
     */
    public function toggleStatus(OrganizationPaymentMethod $paymentMethod)
    {
        $paymentMethod->update([
            'is_active' => !$paymentMethod->is_active
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully',
            'is_active' => $paymentMethod->is_active
        ]);
    }
}
