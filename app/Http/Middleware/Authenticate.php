<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    protected function redirectTo($request): ?string
    {
        if (! $request->expectsJson()) {
            if ($request->routeIs('admin.*')) {
                return route('admin.login');
            }

            if ($request->routeIs('organization.*')) {
                return route('organization.login');
            }

            // Default
            return route('organization.login');
        }

        return null;
    }

}
