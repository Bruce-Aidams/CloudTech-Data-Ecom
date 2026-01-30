<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Bundle;
use App\Models\ResellerPrice;
use Illuminate\Http\Request;

class StorefrontController extends Controller
{
    public function show(Request $request, $referral_code)
    {
        $reseller = User::where('referral_code', $referral_code)
            ->whereIn('role', ['agent', 'dealer', 'super_agent'])
            ->firstOrFail();

        if (!$reseller->store_active) {
            return view('reseller.store.disabled', compact('reseller'));
        }

        // Store in session for referral attribution
        session(['referred_by_code' => $referral_code]);

        $bundles = Bundle::where('is_active', true)->get();

        // Load custom prices
        $customPrices = ResellerPrice::where('user_id', $reseller->id)
            ->pluck('price', 'bundle_id');

        // Apply custom prices to bundles for display
        $bundles->each(function ($bundle) use ($customPrices) {
            if ($customPrices->has($bundle->id)) {
                $bundle->display_price = $customPrices[$bundle->id];
            } else {
                $bundle->display_price = $bundle->price;
            }
        });

        return view('reseller.store.index', compact('reseller', 'bundles'));
    }
}
