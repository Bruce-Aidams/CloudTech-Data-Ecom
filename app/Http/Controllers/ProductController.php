<?php

namespace App\Http\Controllers;

use App\Models\Bundle;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Public: List active bundles (with role-based pricing)
    public function index(Request $request)
    {
        $bundles = Bundle::where('is_active', true)->get();
        $user = $request->user('sanctum');

        if ($user && $user->role && $user->role !== 'user') {
            $bundles->transform(function ($bundle) use ($user) {
                if (!empty($bundle->role_prices) && isset($bundle->role_prices[$user->role])) {
                    $bundle->price = $bundle->role_prices[$user->role];
                }
                return $bundle;
            });
        }

        return $bundles;
    }

    // Admin: List all
    public function adminIndex(Request $request)
    {
        $query = Bundle::latest();

        if ($request->has('network')) {
            $query->where('network', $request->network);
        }

        $bundles = $query->paginate($request->input('per_page', 10));
        $networks = Bundle::distinct()->pluck('network');

        return view('admin.bundles.index', compact('bundles', 'networks'));
    }

    // Admin: Create
    public function store(Request $request)
    {
        $request->validate([
            'network' => 'required',
            'name' => 'required',
            'price' => 'required|numeric',
            'cost_price' => 'required|numeric',
            'data_amount' => 'required',
            'image' => 'nullable|image|max:2048',
            'role_prices' => 'nullable' // Can be JSON string or array
        ]);

        $data = $request->all();

        // Uppercase bundle name and data amount
        if (isset($data['name'])) {
            $data['name'] = strtoupper($data['name']);
        }
        if (isset($data['data_amount'])) {
            $data['data_amount'] = strtoupper($data['data_amount']);
        }

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $data['image_path'] = $path;
        }

        // Ensure role_prices is a clean array (though casts handle conversion, consistency is good)
        if (isset($data['role_prices']) && is_string($data['role_prices'])) {
            $data['role_prices'] = json_decode($data['role_prices'], true);
        }

        $bundle = Bundle::create($data);
        return redirect()->route('admin.bundles')->with('success', 'Product created successfully');
    }

    // Admin: Update
    public function update(Request $request, Bundle $bundle)
    {
        $request->validate([
            'role_prices' => 'nullable'
        ]);

        $data = $request->all();

        // Uppercase bundle name and data amount
        if (isset($data['name'])) {
            $data['name'] = strtoupper($data['name']);
        }
        if (isset($data['data_amount'])) {
            $data['data_amount'] = strtoupper($data['data_amount']);
        }

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $data['image_path'] = $path;
        }

        if (isset($data['role_prices']) && is_string($data['role_prices'])) {
            $data['role_prices'] = json_decode($data['role_prices'], true);
        }

        $bundle->update($data);
        return redirect()->route('admin.bundles')->with('success', 'Product updated successfully');
    }

    public function destroy($id)
    {
        Bundle::destroy($id);
        return redirect()->route('admin.bundles')->with('success', 'Product deleted successfully');
    }

    public function getNetworks()
    {
        return response()->json(Bundle::select('network')->distinct()->pluck('network'));
    }
}
