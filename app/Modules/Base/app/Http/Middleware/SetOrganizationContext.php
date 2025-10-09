<?php

namespace App\Modules\Base\app\Http\Middleware;

use App\Modules\Admin\app\Models\Organization\Organization;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SetOrganizationContext
{
    public function handle(Request $request, Closure $next): Response
    {
        $organizationId = null;

        if (Auth::guard('organization_employee')->check()) {
            $organizationId = Auth::guard('organization_employee')->user()->organization_id;
        }

        if (! $organizationId && $request->hasHeader('website-link')) {
            $website_link = $request->header('website-link');
            $organizationId = Organization::query()
                ->where('website_link', $website_link)
                ->value('id');
        }
        if (! $organizationId) {
            abort(404, 'Organization not found');
        }

        app()->singleton('organization_id', fn () => $organizationId);

        return $next($request);
    }
}
