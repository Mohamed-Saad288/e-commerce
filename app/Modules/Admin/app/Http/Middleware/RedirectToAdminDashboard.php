<?php

namespace App\Modules\Admin\app\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectToAdminDashboard
{
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }
        if (auth()->guard('organization_employee')->check()) {
            return redirect()->route('organization.home');
        }

        return redirect()->route('organization.login');
    }
}
