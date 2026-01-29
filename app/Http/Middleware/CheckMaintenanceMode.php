<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckMaintenanceMode
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if maintenance mode is enabled (cache for request duration)
        static $maintenanceMode = null;
        if ($maintenanceMode === null) {
            $maintenanceMode = \App\Models\Setting::where('key', 'maintenance_mode')->value('value');
        }

        $message = \App\Models\Setting::where('key', 'site_alert_message')->value('value') ?? 'System is currently under maintenance. Please try again later.';

        // If maintenance mode is not enabled, continue normally
        // Use loose comparison to handle both string '1' and integer 1
        if ($maintenanceMode != '1' && $maintenanceMode != 'true') {
            return $next($request);
        }

        // Allow admin users to bypass maintenance mode
        if ($request->user() && strtolower($request->user()->role) === 'admin') {
            return $next($request);
        }

        // Allow login/admin routes so admins can actually log in
        if ($request->is('login') || $request->is('login/*') || $request->is('admin/login') || $request->is('logout')) {
            return $next($request);
        }

        // Maintenance mode is active - handle response
        if ($request->expectsJson()) {
            return response()->json([
                'status' => false,
                'message' => $message,
                'maintenance' => true
            ], 503);
        }

        // Log out non-admin user if logged in
        if ($request->user()) {
            \Illuminate\Support\Facades\Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }

        return response()->view('maintenance', [
            'message' => $message
        ], 503);
    }
}
