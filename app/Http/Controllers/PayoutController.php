<?php

namespace App\Http\Controllers;

use App\Models\Payout;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PayoutController extends Controller
{
    /**
     * List payouts for the authenticated user.
     */
    public function index(Request $request)
    {
        return $request->user()->payouts()->latest()->paginate(20);
    }

    /**
     * Request a new payout.
     */
    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:10',
            'bank_name' => 'required|string',
            'account_number' => 'required|string',
            'account_name' => 'required|string',
        ]);

        $user = $request->user();

        if ($user->wallet_balance < $request->amount) {
            return response()->json(['message' => 'Insufficient wallet balance.'], 422);
        }

        $payout = DB::transaction(function () use ($user, $request) {
            // Deduct from wallet balance
            $user->decrement('wallet_balance', $request->amount);

            // Create Payout record
            return Payout::create([
                'user_id' => $user->id,
                'amount' => $request->amount,
                'bank_name' => $request->bank_name,
                'account_number' => $request->account_number,
                'account_name' => $request->account_name,
                'status' => 'pending',
                'reference' => 'PAYOUT-' . strtoupper(Str::random(10)),
            ]);
        });

        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json([
                'message' => 'Payout request submitted successfully.',
                'payout' => $payout
            ], 201);
        }

        return back()->with('success', 'Payout request submitted successfully.');
    }

    /**
     * Admin: List all payouts.
     */
    /**
     * Admin: List all payouts.
     */
    public function adminIndex(Request $request)
    {
        $query = Payout::with('user');

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $payouts = $query->latest()->paginate($request->input('per_page', 10));

        if ($request->expectsJson() || $request->is('api/*')) {
            return $payouts;
        }

        $stats = [
            'pending' => Payout::where('status', 'pending')->count(),
            'approved' => Payout::where('status', 'completed')->count(),
            'total_amount' => Payout::where('status', 'completed')->sum('amount'),
        ];

        return view('admin.payouts.index', compact('payouts', 'stats'));
    }

    /**
     * Admin: Update payout status (Complete/Reject).
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:processing,completed,rejected',
            'admin_note' => 'nullable|string',
        ]);

        $payout = Payout::findOrFail($id);

        if ($payout->status === 'completed' || $payout->status === 'rejected') {
            return response()->json(['message' => 'This payout has already been processed.'], 422);
        }

        DB::transaction(function () use ($payout, $request) {
            if ($request->status === 'rejected') {
                // Refund the amount to wallet balance
                $payout->user->increment('wallet_balance', $payout->amount);
            }

            $payout->update([
                'status' => $request->status,
                'admin_note' => $request->admin_note,
            ]);
        });

        return response()->json(['message' => 'Payout status updated.', 'payout' => $payout]);
    }
}
