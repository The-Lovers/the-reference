<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ForcePasswordChange
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user || !$user->force_password_change) {
            return $next($request);
        }

        $allowedRoutes = [
            'profile.edit',
            'profile.update',
            'logout',
        ];

        if ($request->route() && in_array($request->route()->getName(), $allowedRoutes, true)) {
            return $next($request);
        }

        return redirect()
            ->route('profile.edit', ['locale' => app()->getLocale(), 'user' => $user])
            ->with('warning', __('forms.profile.force_password_change'));
    }
};
