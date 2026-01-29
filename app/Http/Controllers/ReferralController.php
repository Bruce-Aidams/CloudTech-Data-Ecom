<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Commission;
use Illuminate\Http\Request;

class ReferralController extends Controller
{
    /**
     * Display referral program for authenticated user
     */
    public function index(Request $request)
    {
        $user = $request->user();

        $referrals = User::where('referred_by_id', $user->id)
            ->latest()
            ->get();

        $totalEarnings = Commission::where('user_id', $user->id)
            ->where('status', 'approved')
            ->sum('amount');

        $pendingEarnings = Commission::where('user_id', $user->id)
            ->where('status', 'pending')
            ->sum('amount');

        return view('dashboard.referrals', compact('referrals', 'totalEarnings', 'pendingEarnings'));
    }

    /**
     * Admin view of all referrals
     */
    public function adminIndex(Request $request)
    {
        $query = User::whereNotNull('referred_by_id')
            ->with(['referrer']);

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        $referrals = $query->latest()->paginate(20);

        $stats = [
            'total_referrals' => User::whereNotNull('referred_by_id')->count(),
            'total_commissions' => Commission::where('status', 'approved')->sum('amount'),
            'pending_commissions' => Commission::where('status', 'pending')->sum('amount'),
            'active_referrers' => User::whereHas('referrals')->count(),
        ];

        $commissionRate = \App\Models\Setting::where('key', 'commission_rate')->value('value') ?? 0;

        return view('admin.referrals.index', compact('referrals', 'stats', 'commissionRate'));
    }
}
