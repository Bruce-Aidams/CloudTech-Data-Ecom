<?php

namespace App\Http\Controllers;

use App\Models\ApiKey;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class ApiKeyController extends Controller
{
    /**
     * Generate a new API key
     */
    public function generateKey(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'expires_in_days' => 'sometimes|integer|min:1|max:365',
        ]);

        $user = $request->user();

        // Check if user has reached maximum number of API keys (optional limit)
        $maxKeys = 5;
        if ($user->apiKeys()->count() >= $maxKeys) {
            return response()->json([
                'message' => "Maximum number of API keys ($maxKeys) reached. Please revoke an existing key first."
            ], 400);
        }

        // Generate a unique API key
        $key = 'sk_' . env('APP_ENV', 'local') . '_' . Str::random(40);

        // Calculate expiration date
        $expiresAt = $request->expires_in_days
            ? now()->addDays($request->expires_in_days)
            : null;

        // Create API key
        $apiKey = $user->apiKeys()->create([
            'name' => $request->name,
            'key' => Hash::make($key), // Store hashed version
            'key_preview' => substr($key, 0, 12) . '...' . substr($key, -4), // Store preview
            'expires_at' => $expiresAt,
        ]);

        return response()->json([
            'message' => 'API key generated successfully',
            'api_key' => $apiKey->id . '|' . $key, // Return ID|Key for lookup
            'key_id' => $apiKey->id,
            'name' => $apiKey->name,
            'expires_at' => $apiKey->expires_at,
            'warning' => 'Please save this API key now. You will not be able to see it again.'
        ], 201);
    }

    /**
     * List all API keys for the authenticated user
     */
    public function listKeys(Request $request)
    {
        $user = $request->user();

        $apiKeys = $user->apiKeys()
            ->select(['id', 'name', 'key_preview', 'last_used_at', 'expires_at', 'created_at'])
            ->latest()
            ->get();

        return response()->json([
            'api_keys' => $apiKeys
        ]);
    }

    /**
     * Revoke (delete) an API key
     */
    public function revokeKey(Request $request, $id)
    {
        $user = $request->user();

        $apiKey = $user->apiKeys()->find($id);

        if (!$apiKey) {
            return response()->json([
                'message' => 'API key not found'
            ], 404);
        }

        $apiKey->delete();

        return response()->json([
            'message' => 'API key revoked successfully'
        ]);
    }

    /**
     * Regenerate an existing API key
     */
    public function regenerateKey(Request $request, $id)
    {
        $user = $request->user();

        $apiKey = $user->apiKeys()->find($id);

        if (!$apiKey) {
            return response()->json([
                'message' => 'API key not found'
            ], 404);
        }

        // Generate new key
        $key = 'sk_' . env('APP_ENV', 'local') . '_' . Str::random(40);

        // Update API key
        $apiKey->update([
            'key' => Hash::make($key),
            'key_preview' => substr($key, 0, 12) . '...' . substr($key, -4),
            'last_used_at' => null, // Reset usage
        ]);

        return response()->json([
            'message' => 'API key regenerated successfully',
            'api_key' => $apiKey->id . '|' . $key,
            'key_id' => $apiKey->id,
            'name' => $apiKey->name,
            'warning' => 'Please save this API key now. You will not be able to see it again.'
        ]);
    }

    /**
     * Get API key usage statistics
     */
    public function getKeyStats(Request $request, $id)
    {
        $user = $request->user();

        $apiKey = $user->apiKeys()->find($id);

        if (!$apiKey) {
            return response()->json([
                'message' => 'API key not found'
            ], 404);
        }

        return response()->json([
            'id' => $apiKey->id,
            'name' => $apiKey->name,
            'key_preview' => $apiKey->key_preview,
            'created_at' => $apiKey->created_at,
            'last_used_at' => $apiKey->last_used_at,
            'expires_at' => $apiKey->expires_at,
            'is_expired' => $apiKey->expires_at ? $apiKey->expires_at->isPast() : false,
            'days_until_expiry' => $apiKey->expires_at ? now()->diffInDays($apiKey->expires_at, false) : null,
        ]);
    }
}
