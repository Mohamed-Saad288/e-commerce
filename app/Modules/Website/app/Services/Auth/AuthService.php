<?php

namespace App\Modules\Website\app\Services\Auth;

use App\Models\User;
use App\Modules\Website\app\Traits\WebsiteLink\WebsiteLinkTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;

class AuthService
{
    use WebsiteLinkTrait;
    public function login($request)
    {
        $credentials = $request->validated();
        $user = User::query()->where('email', $credentials['email'])->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => __("auth.failed"),
            ]);
        }
        $device = $request->userAgent();
        $expiresAt = Carbon::now()->addDays(7);
        $token = $user->createToken($device, ['app:all'], $expiresAt)->plainTextToken;
        $user->token = $token;

        return $user;
    }

    public function register($request)
    {
        $data = $request->validated();
        $data["role"] = 2; // Regular user role
        $data['organization_id'] = $this->getOrganization()->id;
        $user = User::query()->create($data);

        $device = $request->userAgent();
        $expiresAt = Carbon::now()->addDays(7);
        $token = $user->createToken($device, ['app:all'], $expiresAt)->plainTextToken;
        $user->token = $token;
        return $user;
    }

    public function logout(): void
    {
        Auth::user()->tokens()->delete();
    }

    public function forgotPassword(string $email): string
    {
        $user = User::query()->where('email', $email)->first();

        if (!$user) {
            throw new ValidationException(
                __('auth.email_not_found')
            );
        }

        return Password::sendResetLink(['email' => $email]);
    }

    public function resetPassword(array $data): string
    {
        return Password::reset($data, function ($user, $password) {
            $user->password = Hash::make($password);
            $user->save();
        });
    }
}
