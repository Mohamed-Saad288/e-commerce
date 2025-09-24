<?php

use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Auth\RestPasswordController;
use App\Modules\Website\app\Http\Controllers\Auth\AuthController;
use App\Modules\Website\app\Http\Controllers\Brand\BrandController;
use App\Modules\Website\app\Http\Controllers\Category\CategoryController;
use Illuminate\Support\Facades\Route;

Route::prefix('api/site')->middleware(["set.organization.context"])->group(function () {

    // Auth Routes
        Route::post('login', [AuthController::class, 'login']);
        Route::post('register', [AuthController::class, 'register']);
//        Route::get('google', [SocialAuthController::class, 'redirectToGoogle']);
//        Route::get('google/callback', [SocialAuthController::class, 'handleGoogleCallback']);
//        Route::get('apple', [SocialAuthController::class, 'redirectToApple']);
//        Route::get('apple/callback', [SocialAuthController::class, 'handleAppleCallback']);

        /*****************************************REST PASSWORD******************************************/
        Route::post("send_otp", [RestPasswordController::class, 'sendOtp']);
        Route::post("check_otp", [RestPasswordController::class, 'checkOtp'])->name("check_otp");
        Route::post("rest_password", [RestPasswordController::class, 'resetPassword']);
        Route::post("resend_otp", [RestPasswordController::class, 'resendOtp']);

        // Protected Routes
        Route::middleware('auth:sanctum')->group(function () {
            Route::get('logout', [AuthController::class, 'logout']);

            // Email Verification Routes
            Route::post('email/verification-notification', [EmailVerificationController::class, 'sendVerificationEmail']
            )
                ->middleware('throttle:6,1')
                ->name('verification.send');

            Route::get('email/verify/{id}/{hash}', [EmailVerificationController::class, 'verify'])
                ->middleware('signed')
                ->name('verification.verify');
        });

    Route::get('categories', [CategoryController::class, "list"]);
    Route::get("brands", [BrandController::class, "list"]);
});


