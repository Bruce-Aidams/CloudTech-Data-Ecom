<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\ApiKey;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;

class ApiAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $apiKey = $request->bearerToken();

        if (!$apiKey) {
            return response()->json([
                'error' => 'API key is required',
                'message' => 'Please provide an API key in the Authorization header as Bearer token'
            ], 401);
        }

        // Extract key prefix to find potential matches
        $keyPrefix = substr($apiKey, 0, 12);

        // Find all API keys with matching preview prefix
        $apiKeys = ApiKey::where('key_preview', 'like', $keyPrefix . '%')
            ->whereNull('expires_at')
            ->orWhere('expires_at', '>', now())
            ->get();

        $validKey = null;
        foreach ($apiKeys as $key) {
            if (Hash::check($apiKey, $key->key)) {
                $validKey = $key;
                break;
            }
        }

        if (!$validKey) {
            return response()->json([
                'error' => 'Invalid API key',
                'message' => 'The provided API key is invalid or has expired'
            ], 401);
        }

        // Check if key has expired
        if ($validKey->expires_at && $validKey->expires_at->isPast()) {
            return response()->json([
                'error' => 'API key expired',
                'message' => 'The provided API key has expired'
            ], 401);
        }

        // Rate limiting
        $key = 'api_key:' . $validKey->id;
        $maxAttempts = 100; // 100 requests
        $decayMinutes = 1; // per minute

        if (RateLimiter::tooManyAttempts($key, $maxAttempts)) {
            $seconds = RateLimiter::availableIn($key);

            return response()->json([
                'error' => 'Rate limit exceeded',
                'message' => "Too many requests. Please try again in {$seconds} seconds.",
                'retry_after' => $seconds
            ], 429);
        }

        RateLimiter::hit($key, $decayMinutes * 60);

        // Update last used timestamp
        $validKey->update(['last_used_at' => now()]);

        // Attach user to request
        $request->setUserResolver(function () use ($validKey) {
            return User::find($validKey->user_id);
        });

        return $next($request);
    }
}
