<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware to restrict web app access to admin and pastor only.
 * Members, staff, workers, and leaders should use the mobile app.
 */
class RestrictWebToAdminPastor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Skip check if user is not authenticated
        if (! $request->user()) {
            return $next($request);
        }

        // Get user role
        $role = $request->user()->role;

        // Allow admin and pastor to access web app
        if (in_array($role, ['admin', 'pastor'])) {
            return $next($request);
        }

        // For API requests from mobile app, allow access
        if ($request->is('api/*') || $request->is('mobile/*') || $request->expectsJson()) {
            return $next($request);
        }

        // Redirect members, staff, workers, and leaders to mobile app
        if ($request->is('mobile/*')) {
            return $next($request);
        }

        // Redirect to mobile app with message
        return redirect('/mobile/dashboard')
            ->with('info', 'Please use the mobile app to access member features. The web portal is for administrators only.');
    }
}
