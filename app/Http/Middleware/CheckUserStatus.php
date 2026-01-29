<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUserStatus
{
    /**
     * Handle an incoming request.
     * Check if authenticated user is active/not suspended
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();

            // Check if user is suspended
            if (!$user->is_active) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                if ($request->expectsJson()) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Your account has been suspended. Please contact support.',
                        'suspended' => true
                    ], 403);
                }

                return redirect()->route('login')
                    ->with('error', 'Your account has been suspended. Please contact support.');
            }
        }

        return $next($request);
    }
}
