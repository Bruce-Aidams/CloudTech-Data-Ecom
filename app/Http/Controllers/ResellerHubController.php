<?php

namespace App\Http\Controllers;

use App\Models\Bundle;
use App\Models\ResellerPrice;
use App\Models\Order;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Commission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResellerHubController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (!$user->isReseller()) {
            return redirect()->route('dashboard')->with('error', 'Access denied to Reseller Hub.');
        }

        if (!$user->referral_code) {
            $user->update(['referral_code' => strtoupper(\Illuminate\Support\Str::random(10))]);
        }

        $referralIds = User::where('referred_by_id', $user->id)->pluck('id');

        $stats = [
            'referral_count' => $referralIds->count(),
            'total_commission' => Commission::where('user_id', $user->id)->sum('amount'),
            'managed_orders' => Order::whereIn('user_id', $referralIds)->count(),
            'wallet_balance' => $user->wallet_balance,
        ];

        $recentReferrals = User::where('referred_by_id', $user->id)
            ->latest()
            ->limit(5)
            ->get();

        return view('dashboard.reseller.index', compact('stats', 'recentReferrals', 'user'));
    }

    public function manageStore()
    {
        $user = Auth::user();
        if (!$user->isReseller())
            abort(403);

        if (!$user->referral_code) {
            $user->update(['referral_code' => strtoupper(\Illuminate\Support\Str::random(10))]);
        }

        $bundles = Bundle::where('is_active', true)->get();
        $customPrices = ResellerPrice::where('user_id', $user->id)->pluck('price', 'bundle_id');

        // Logic to get reseller's cost price
        $bundles->each(function ($bundle) use ($user, $customPrices) {
            $rolePrices = $bundle->role_prices ?: [];
            $bundle->cost_to_reseller = $rolePrices[$user->role] ?? $bundle->price;
            $bundle->custom_price = $customPrices[$bundle->id] ?? $bundle->price;
            $bundle->profit_per_unit = $bundle->custom_price - $bundle->cost_to_reseller;
        });

        return view('dashboard.reseller.manage-store', compact('bundles', 'user'));
    }

    public function updatePrice(Request $request)
    {
        $request->validate([
            'bundle_id' => 'required|exists:bundles,id',
            'price' => 'required|numeric|min:0',
        ]);

        $user = Auth::user();
        $bundle = Bundle::findOrFail($request->bundle_id);

        // Reseller can't set price lower than their cost
        $rolePrices = $bundle->role_prices ?: [];
        $cost = $rolePrices[$user->role] ?? $bundle->price;

        if ($request->price < $cost) {
            return back()->with('error', 'Selling price cannot be lower than your cost (GHC ' . number_format($cost, 2) . ')');
        }

        ResellerPrice::updateOrCreate(
            ['user_id' => $user->id, 'bundle_id' => $request->bundle_id],
            ['price' => $request->price]
        );

        return back()->with('success', 'Store price updated successfully.');
    }
    public function toggleStoreStatus()
    {
        $user = Auth::user();
        if (!$user->isReseller())
            abort(403);

        $user->store_active = !$user->store_active;
        $user->save();

        $status = $user->store_active ? 'enabled' : 'disabled';
        return back()->with('success', "Your store is now {$status}.");
    }

    public function regenerateStoreLink()
    {
        $user = Auth::user();
        if (!$user->isReseller())
            abort(403);

        $newCode = strtoupper(\Illuminate\Support\Str::random(10));

        while (\App\Models\User::where('referral_code', $newCode)->exists()) {
            $newCode = strtoupper(\Illuminate\Support\Str::random(10));
        }

        $user->referral_code = $newCode;
        $user->save();

        return back()->with('success', 'Your store link has been regenerated. Old links will no longer work.');
    }
}
