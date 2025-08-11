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

        return redirect()->route('login');
    }
}
