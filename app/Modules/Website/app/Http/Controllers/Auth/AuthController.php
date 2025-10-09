<?php

namespace App\Modules\Website\app\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Modules\Base\app\Response\DataFailed;
use App\Modules\Base\app\Response\DataSuccess;
use App\Modules\Website\app\Http\Request\Auth\ForgotPasswordRequest;
use App\Modules\Website\app\Http\Request\Auth\LoginRequest;
use App\Modules\Website\app\Http\Request\Auth\RegisterRequest;
use App\Modules\Website\app\Http\Request\Auth\ResetPasswordRequest;
use App\Modules\Website\app\Http\Resources\User\UserResource;
use App\Modules\Website\app\Services\Auth\AuthService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Password;

class AuthController extends Controller
{
    public function __construct(protected AuthService $authService) {}

    public function login(LoginRequest $request): JsonResponse
    {
        try {
            $result = $this->authService->login($request);

            return (new DataSuccess(
                data: UserResource::make($result), status: true,
                message: __('auth.Login_successfully')
            ))->response();
        } catch (Exception $e) {
            return (new DataFailed(
                status: false,
                message: $e->getMessage()
            ))->response();
        }
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $result = $this->authService->register($request);

        return (new DataSuccess(
            data: UserResource::make($result), status: true,
            message: __('auth.Register_successfully')
        ))->response();
    }

    public function logout(): JsonResponse
    {
        $this->authService->logout();

        return (new DataSuccess(
            message: __('auth.Logout_successfully')
        ))->response();
    }

    public function forgotPassword(ForgotPasswordRequest $request): JsonResponse
    {
        $result = $this->authService->forgotPassword($request->email);

        return (new DataSuccess(
            status: $result === Password::RESET_LINK_SENT,
            message: __('auth.password_reset_link_sent')
        ))->response();
    }

    public function resetPassword(ResetPasswordRequest $request): JsonResponse
    {
        $result = $this->authService->resetPassword($request->validated());

        return (new DataSuccess(
            status: $result === Password::PASSWORD_RESET,
            message: __('auth.password_reset_successfully')
        ))->response();
    }
}
