<?php

namespace App\Modules\Organization\app\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Modules\Organization\app\Http\Request\Auth\LoginRequest;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function getLogin()
    {
        return view('organization::dashboard.auth.login');
    }

    public function login(LoginRequest $request)
    {
        $field = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';

        $credentials = [$field => $request->login, 'password' => $request->password];

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
        return redirect()->route('organization.login');
    }
}
