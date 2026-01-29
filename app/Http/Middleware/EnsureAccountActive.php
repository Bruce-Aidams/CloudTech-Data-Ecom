<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAccountActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user() && $request->user()->is_active === false) {
            $request->user()->currentAccessToken()->delete();
            return response()->json([
                'message' => 'Account suspended. Please contact support.',
                'debug' => 'EnsureAccountActive: is_active is false',
                'url' => $request->fullUrl()
            ], 403);
        }

        return $next($request);
    }
}
