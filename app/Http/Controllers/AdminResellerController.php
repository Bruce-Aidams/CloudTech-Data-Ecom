<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class AdminResellerController extends Controller
{
    /**
     * Display a listing of resellers.
     */
    public function index(Request $request)
    {
        $query = User::whereIn('role', ['agent', 'dealer', 'super_agent']);

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%')
                    ->orWhere('phone', 'like', '%' . $request->search . '%')
                    ->orWhere('referral_code', 'like', '%' . $request->search . '%');
            });
        }

        $resellers = $query->withCount('referrals')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        // Calculate Overview Stats
        $stats = [
            'total_resellers' => User::whereIn('role', ['agent', 'dealer', 'super_agent'])->count(),
            'total_commission_paid' => Transaction::where('description', 'like', '%Commission%')->sum('amount'), // Approximate
            // 'active_stores' => ... (Requires a store_active column on users)
        ];

        return view('admin.resellers.index', compact('resellers', 'stats'));
    }

    /**
     * Toggle Reseller Store Status
     */
    public function toggleStoreStatus(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Toggle the boolean value
        $user->store_active = !$user->store_active;
        $user->save();

        $status = $user->store_active ? 'enabled' : 'disabled';
        return back()->with('success', "Reseller store has been {$status}.");
    }

    /**
     * Adjust Commission Balance manually
     */
    public function adjustCommission(Request $request, $id)
    {
        $request->validate([
            'type' => 'required|in:credit,debit',
            'amount' => 'required|numeric|min:0.01',
            'note' => 'required|string|max:255',
        ]);

        $user = User::findOrFail($id);
        $amount = $request->amount;

        DB::beginTransaction();
        try {
            if ($request->type === 'credit') {
                $user->commission_balance += $amount;
            } else {
                if ($user->commission_balance < $amount) {
                    return back()->with('error', 'Insufficient commission balance');
                }
                $user->commission_balance -= $amount;
            }
            $user->save();

            Transaction::create([
                'user_id' => $user->id,
                'type' => $request->type, // credit/debit
                'amount' => $amount,
                'status' => 'success',
                'reference' => 'ADM-COM-' . strtoupper(Str::random(6)),
                'description' => 'Admin Commission Adjustment: ' . $request->note,
            ]);

            DB::commit();
            return back()->with('success', 'Commission adjusted successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Commission Adj Error: " . $e->getMessage());
            return back()->with('error', 'Failed to adjust commission.');
        }
    }
}
