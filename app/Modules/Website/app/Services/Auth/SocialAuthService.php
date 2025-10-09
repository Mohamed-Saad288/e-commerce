<?php

namespace App\Modules\Website\app\Services\Auth;

// use App\Enums\User\RoleEnum;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

// use Laravel\Socialite\Facades\Socialite;

class SocialAuthService
{
    public function redirectToGoogle()
    {
        $url = Socialite::driver('google')
            ->stateless()
            ->redirect()
            ->getTargetUrl();

        return $url;
    }

    public function handleGoogleCallback(Request $request)
    {
        $googleUser = Socialite::driver('google')->stateless()->user();

        $user = User::updateOrCreate([
            'email' => $googleUser->getEmail(),
        ], [
            'name' => $googleUser->getName(),
            'email_verified_at' => now(),
            'provider_id' => $googleUser->getId(),
            'social_token' => $googleUser->token,
            'password' => Str::random(12),
            'role' => RoleEnum::User->value,
        ])->assignRole('user');

        if ($googleUser->getAvatar()) {
            $user->clearMediaCollection('images');
            $user->addMediaFromUrl($googleUser->getAvatar())->toMediaCollection('profile_images');
        }

        $device = $request->userAgent();
        $expiresAt = Carbon::now()->addDays(30);
        $token = $user->createToken($device, ['app:all'], $expiresAt)->plainTextToken;

        return [
            'user' => $user,
            'token' => $token,
        ];
    }
}
