<?php

namespace App\Http\Controllers;

use App\Models\ApiProvider;
use App\Models\ApiLog;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    // List all providers
    public function index(Request $request)
    {
        $providers = ApiProvider::all();

        if ($request->expectsJson() || $request->is('api/*')) {
            return $providers;
        }

        $logs = ApiLog::with('provider')->latest()->paginate($request->input('per_page', 10));

        return view('admin.api.index', compact('providers', 'logs'));
    }

    // Create a new provider
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'base_url' => 'required|url',
            'webhook_url' => 'nullable|url',
            'api_key' => 'nullable|string',
            'secret_key' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        $provider = ApiProvider::create($validated);

        // Sync to .env if it's a known provider
        $this->syncToEnv($provider);

        return redirect()->back()->with('success', 'API Provider added successfully');
    }

    // Update a provider
    public function update(Request $request, $id)
    {
        $provider = ApiProvider::findOrFail($id);

        $validated = $request->validate([
            'name' => 'sometimes|string',
            'base_url' => 'sometimes|url',
            'webhook_url' => 'nullable|url',
            'api_key' => 'nullable|string',
            'secret_key' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        $provider->update($validated);

        // Sync to .env
        $this->syncToEnv($provider);

        return redirect()->back()->with('success', 'API Provider updated successfully');
    }

    private function syncToEnv(ApiProvider $provider)
    {
        if (!$provider->is_active)
            return;

        $name = strtoupper($provider->name);
        if ($name === 'PAYSTACK') {
            \App\Helpers\EnvHelper::set('PAYSTACK_SECRET_KEY', $provider->secret_key);
            \App\Helpers\EnvHelper::set('PAYSTACK_PUBLIC_KEY', $provider->api_key);
        }
    }

    // Delete a provider
    public function destroy($id)
    {
        ApiProvider::destroy($id);
        return redirect()->back()->with('success', 'API Provider deleted successfully');
    }

    // Get API Error Logs
    public function logs(Request $request)
    {
        return ApiLog::with('provider')->latest()->paginate($request->input('per_page', 10));
    }
}
