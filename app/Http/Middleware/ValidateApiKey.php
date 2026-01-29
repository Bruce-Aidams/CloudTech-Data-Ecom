<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\ApiKey;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class ValidateApiKey
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->bearerToken();

        if (!$token) {
            return response()->json(['message' => 'API Key missing'], 401);
        }

        // Token format should be id|key
        if (strpos($token, '|') === false) {
            return response()->json(['message' => 'Invalid API Key format'], 401);
        }

        [$id, $key] = explode('|', $token, 2);

        $apiKey = ApiKey::find($id);

        if (!$apiKey || !Hash::check($key, $apiKey->key)) {
            return response()->json(['message' => 'Invalid API Key'], 401);
        }

        if ($apiKey->expires_at && $apiKey->expires_at->isPast()) {
            return response()->json(['message' => 'API Key expired'], 401);
        }

        // Update usage
        $apiKey->update(['last_used_at' => now()]);

        // Log in the user
        Auth::login($apiKey->user);

        return $next($request);
    }
}
