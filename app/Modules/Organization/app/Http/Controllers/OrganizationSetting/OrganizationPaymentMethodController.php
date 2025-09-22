<?php

namespace App\Modules\Organization\app\Http\Controllers\OrganizationSetting;

use App\Http\Controllers\Controller;
use App\Modules\Organization\app\Http\Request\PaymentMethods\updateOrganizationPaymentMethodRequest;
use App\Modules\Organization\app\Models\OrganizationPaymentMethod;
use App\Modules\Organization\app\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OrganizationPaymentMethodController extends Controller
{
    public function index()
    {
        try {
            $organization = auth()->user()->organization;

            if (!$organization) {
                return redirect()->back()->with('error', 'Organization not found');
            }

            $paymentMethods = PaymentMethod::where('is_active', true)->get();

            $orgPaymentMethods = $organization->paymentMethods()
                ->withPivot('is_active', 'credentials')
                ->get()
                ->keyBy('id')
                ->map(function ($method) {
                    return [
                        'is_active'   => (bool) $method->pivot->is_active,
                        'credentials' => json_decode($method->pivot->credentials ?? '{}', true),
                    ];
                })
                ->toArray();

            return view('organization::dashboard.payment_methods.index', compact('paymentMethods', 'orgPaymentMethods'));

        } catch (\Exception $e) {
            Log::error('Error loading payment methods: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error loading payment methods');
        }
    }

    public function update(updateOrganizationPaymentMethodRequest $request, $id)
    {
        try {
            $organization = auth()->user()->organization;

            if (!$organization) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Organization not found.',
                ], 404);
            }

            // التحقق من وجود payment method
            $paymentMethod = PaymentMethod::findOrFail($id);

            $validated = $request->validated();

            $orgPaymentMethod = OrganizationPaymentMethod::firstOrNew([
                'organization_id'   => $organization->id,
                'payment_method_id' => $id,
            ]);

            // تحديث حالة التفعيل
            if ($request->has('is_active')) {
                $orgPaymentMethod->is_active = (bool) $request->input('is_active');
            }

            // تحديث بيانات الاعتماد
            if (array_key_exists('credentials', $validated)) {
                $credentials = $validated['credentials'] ?? [];

                // تنظيف البيانات الفارغة
                $cleanedCredentials = array_filter($credentials, function($value) {
                    return !is_null($value) && trim($value) !== '';
                });

                $orgPaymentMethod->credentials = json_encode($cleanedCredentials);
            }

            $orgPaymentMethod->save();

            $message = $orgPaymentMethod->is_active ?
                'Payment method enabled successfully.' :
                'Payment method disabled successfully.';

            return response()->json([
                'status' => 'success',
                'message' => $message,
                'data' => [
                    'is_active' => $orgPaymentMethod->is_active,
                    'method_name' => $paymentMethod->name
                ]
            ]);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Payment method not found.',
            ], 404);

        } catch (\Exception $e) {
            Log::error('Error updating payment method: ' . $e->getMessage(), [
                'organization_id' => $organization->id ?? null,
                'payment_method_id' => $id,
                'request_data' => $request->all()
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while updating payment method.',
            ], 500);
        }
    }
}
