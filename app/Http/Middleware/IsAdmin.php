<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && trim(strtolower($user->role)) === 'admin') {
            // Check if already verified in this session or if currently on the verify page
            if ($request->session()->get('admin_verified') || $request->routeIs('admin.verify')) {
                return $next($request);
            }

            return redirect()->route('admin.verify', ['intended' => $request->fullUrl()]);
        }

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Unauthorized. Admin access required.',
            ], 403);
        }

        return redirect()->route('login')->with('error', 'Unauthorized access denied. Admin clearance required.');
    }
}
