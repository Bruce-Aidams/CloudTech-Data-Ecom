<?php

namespace App\Http\Controllers;

use App\Models\Deposit;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DepositController extends Controller
{
    // Admin: Get all deposits
    public function index(Request $request)
    {
        $query = Deposit::with('user')->latest();

        if ($request->has('search')) {
            $search = $request->search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%");
            })->orWhere('amount', 'like', "%$search%");
        }

        $deposits = $query->paginate(15);
        if ($request->expectsJson() || $request->is('api/*')) {
            return $deposits;
        }

        return view('admin.deposits.index', compact('deposits'));
    }

    public function store(Request $request)
    {
        $settings = \App\Models\Setting::whereIn('key', ['min_payment', 'max_payment', 'enable_manual_transfer'])->get()->pluck('value', 'key');

        if (($settings['enable_manual_transfer'] ?? '1') !== '1') {
            $msg = "Manual bank transfers are currently disabled.";
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json(['message' => $msg], 403);
            }
            return back()->with('error', $msg);
        }

        $min = (float) ($settings['min_payment'] ?? 1);
        $max = (float) ($settings['max_payment'] ?? 100000);

        $request->validate([
            'amount' => "required|numeric|min:$min|max:$max",
            'proof_image' => 'required|image|max:5120', // Max 5MB
        ]);

        $data = [
            'user_id' => $request->user()->id,
            'amount' => $request->amount,
            'status' => 'pending',
        ];

        if ($request->hasFile('proof_image')) {
            $data['proof_image'] = $request->file('proof_image')->store('deposits', 'public');
        }

        $deposit = Deposit::create($data);

        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json($deposit, 201);
        }

        return redirect()->back()->with('success', 'Manual deposit request submitted successfully. Node synchronization Validating verification.');
    }

    // Admin: Approve/Reject deposit
    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected',
            'admin_note' => 'nullable|string',
        ]);

        $deposit = Deposit::findOrFail($id);

        if ($deposit->status !== 'pending') {
            return redirect()->back()->with('error', 'Deposit already processed');
        }

        DB::beginTransaction();
        try {
            $deposit->status = $request->status;
            $deposit->admin_note = $request->admin_note;
            $deposit->save();

            if ($request->status === 'approved') {
                $user = User::findOrFail($deposit->user_id);
                $user->wallet_balance += $deposit->amount;
                $user->save();

                // Create Transaction record
                Transaction::create([
                    'user_id' => $user->id,
                    'type' => 'credit',
                    'amount' => $deposit->amount,
                    'status' => 'success',
                    'reference' => 'DEP-' . $deposit->id,
                    'description' => 'Manual Transfer Credit',
                ]);
            }

            DB::commit();
            return redirect()->back()->with('success', 'Deposit processed successfully');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error processing deposit');
        }
    }
}
