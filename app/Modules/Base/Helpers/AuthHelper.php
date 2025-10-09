<?php

if (! function_exists('loginRouteFor')) {
    function loginRouteFor(?string $guard): string
    {
        return match ($guard) {
            'admin' => route('admin.login'),
            default => route('organization.login'),
        };
    }
}

if (! function_exists('getLoginRoute')) {
    function getLoginRoute($request, $guard = null): string
    {
        if ($request->routeIs('admin.*') || $guard === 'admin') {
            return route('admin.login');
        }

        return route('organization.login');
    }
}
