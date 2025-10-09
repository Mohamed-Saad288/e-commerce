<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class EmailVerificationController extends Controller
{
    public function sendVerificationEmail(Request $request): JsonResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return response()->json([
                'status' => false,
                'message' => __('auth.already_verified'),
            ]);
        }

        $request->user()->sendEmailVerificationNotification();

        return response()->json([
            'status' => true,
            'message' => __('auth.verification_link_sent'),
        ]);
    }

    public function verify(Request $request, string $id, string $hash): JsonResponse
    {
        $user = User::findOrFail($id);

        if ($user->hasVerifiedEmail()) {
            return response()->json([
                'status' => false,
                'message' => __('auth.already_verified'),
            ]);
        }

        if (! URL::hasValidSignature($request)) {
            return response()->json([
                'status' => false,
                'message' => __('auth.invalid_verification_link'),
            ], 400);
        }

        if (! hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
            return response()->json([
                'status' => false,
                'message' => __('auth.invalid_verification_link'),
            ], 400);
        }

        $user->markEmailAsVerified();

        return response()->json([
            'status' => true,
            'message' => __('auth.verified_success'),
        ]);
    }
}
