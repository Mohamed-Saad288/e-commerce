<?php

namespace App\Modules\Admin\app\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Modules\Admin\app\Http\Request\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthController extends Controller
{

    public function __construct()
    {

    }

    public function getLogin() : View
    {
        return view('admin::dashboard.auth.login');
    }

    public function login(LoginRequest $request): \Illuminate\Http\RedirectResponse
    {
        $credentials = $request->only('email', 'password');
        $credentials['email'] = strtolower($credentials['email']);

        if (Auth::guard('admin')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()
                ->intended(route('admin.dashboard'))
                ->with('status', __('Welcome back!'));
        }

        return back()->withErrors([
            'email' => __('Invalid credentials'),
        ])->onlyInput('email');
    }

    public function logout(Request $request): \Illuminate\Http\RedirectResponse
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect(route('admin.login'));
    }
}
