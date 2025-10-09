<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\OtpRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Mail\OtpMail;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class RestPasswordController extends Controller
{
    // ----------------------------------------------------------------SEND OTP
    public function sendOtp(OtpRequest $request)
    {
        return $this->generateAndSendOtp($request->validated());
    }

    // ----------------------------------------------------------------CHECK OTP
    public function checkOtp(OtpRequest $request)
    {
        $user = $this->getUserByEmail($request->validated()['email']);
        if (! $user) {
            return $this->errorResponse(message: __('messages.not_found'));
        }

        if ($user->expire_code < now()) {
            return $this->errorResponse(message: __('messages.code_expired'));
        }

        if ($user->code !== $request->validated()['code']) {
            return $this->errorResponse(message: __('messages.code_not_match'));
        }

        $user->update(['code' => null, 'expire_code' => now()]);

        return $this->successResponse(message: __('messages.success'));
    }

    // ----------------------------------------------------------------RESET PASSWORD
    public function resetPassword(ResetPasswordRequest $request)
    {
        $data = $request->validated();
        $user = $this->getUserByEmail($data['email']);

        if (! $user) {
            return $this->errorResponse(message: __('messages.not_found'));
        }

        if (Hash::check($data['password'], $user->password)) {
            return $this->errorResponse(message: __('messages.new_password_must_be_different_from_old_password'));
        }

        $user->update(['password' => Hash::make($data['password'])]);

        return $this->successResponse(message: __('messages.success'));
    }

    // ----------------------------------------------------------------RESEND OTP
    public function resendOtp(OtpRequest $request)
    {
        return $this->generateAndSendOtp($request->validated());
    }

    private function generateAndSendOtp(array $validatedData)
    {
        $user = $this->getUserByEmail($validatedData['email']);
        if (! $user) {
            return $this->errorResponse(message: __('messages.not_found'));
        }

        $code = generate_unique_code(User::class, length: 6, letter_type: 'numbers');
        $expireMinutes = 10;
        $user->update([
            'code' => $code,
            'expire_code' => now()->addMinutes($expireMinutes),
        ]);

        // Send OTP via email
        Mail::to($user->email)->send(new OtpMail($code, $user->email));

        return $this->successResponse(message: __('messages.the otp code has been sent successfully'));
    }

    // ----------------------------------------------------------------GET USER BY EMAIL
    private function getUserByEmail(string $email): ?User
    {
        return User::query()->whereEmail($email)->first();
    }
}
