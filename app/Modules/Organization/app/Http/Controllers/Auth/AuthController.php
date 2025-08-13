<?php

namespace App\Modules\Organization\app\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Modules\Organization\app\Http\Request\Auth\LoginRequest;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function getLogin()
    {
        return view('organization::auth.login');
    }

    public function login(LoginRequest $request)
    {
        $auth_field = $request->filled('email') ? 'email' : 'phone';

        $credentials = [
            $auth_field => $request->input($auth_field),
            'password' => $request->input('password'),
        ];

        if (Auth::guard('organization_employee')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()
                ->intended(route('organization.home'))
                ->with('status', __('Welcome back!'));
        }

        return back()->withErrors([
            'email' => __('Invalid credentials'),
        ])->onlyInput('email', 'phone');
    }

    public function logout()
    {
        Auth::guard('organization_employee')->logout();
        return redirect()->route('organization.getLogin');
    }
}
