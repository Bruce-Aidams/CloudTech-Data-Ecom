<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class WalletController extends Controller
{
    // User: Get Balance & History
    public function index(Request $request)
    {
        $user = $request->user();
        return response()->json([
            'balance' => $user->wallet_balance,
            'transactions' => $user->transactions()->latest()->paginate(10)
        ]);
    }

    public function topup(Request $request)
    {
        Log::info('Wallet topup attempt', ['user_id' => $request->user()?->id, 'amount' => $request->amount]);

        try {
            $request->validate(['amount' => 'required|numeric|min:0.5', 'method' => 'sometimes|string']);
            $method = $request->input('method', 'paystack');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['message' => 'Invalid amount. Minimum is GHS 0.50', 'errors' => $e->errors()], 422);
        }

        $user = $request->user();
        if (!$user) {
            return response()->json(['message' => 'Authentication required.'], 401);
        }

        // Get email from request or user's profile
        $email = $request->input('email') ?? $user->email;

        // ULTRA-ROBUST EMAIL SANITIZATION for Paystack
        $email = trim($email ?? '');
        $email = str_replace([' ', "\t", "\n", "\r", "\0", "\x0B"], '', $email);
        $email = preg_replace('/[[:cntrl:]]/', '', $email);
        $email = preg_replace('/[^\x20-\x7E]/', '', $email); // Remove non-ASCII
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        $email = strtolower($email); // Paystack prefers lowercase

        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            Log::error('Wallet Paystack Error: Invalid email', [
                'user_id' => $user->id,
                'email_raw' => $request->input('email') ?? $user->email,
                'email_sanitized' => $email
            ]);
            return response()->json([
                'status' => false,
                'message' => 'Invalid email. Update your profile with a valid email (e.g., user@example.com).'
            ], 422);
        }

        // Additional strict validation for Paystack
        if (!preg_match('/^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$/', $email)) {
            Log::error('Wallet Paystack Error: Email regex validation failed', ['email' => $email]);
            return response()->json([
                'status' => false,
                'message' => 'Email format not accepted. Use format: user@example.com'
            ], 422);
        }

        Log::info('Wallet topup - email validated', [
            'user_id' => $user->id,
            'email' => $email
        ]);

        $baseAmount = (float) $request->amount;
        $reference = 'TOPUP-' . strtoupper(Str::random(12));

        // Fetch limits and charges
        $settings = Setting::whereIn('key', ['min_payment', 'max_payment', 'charge_type', 'charge_value', 'paystack_secret', 'paystack_public'])
            ->get()->pluck('value', 'key');

        $min = (float) ($settings['min_payment'] ?? 1);
        $max = (float) ($settings['max_payment'] ?? 100000);

        if ($baseAmount < $min || $baseAmount > $max) {
            return response()->json(['message' => "Amount must be between GHS {$min} and GHS {$max}"], 422);
        }

        // Calculate Fees
        $chargeType = $settings['charge_type'] ?? 'percentage';
        $chargeValue = (float) ($settings['charge_value'] ?? 0);

        $charge = $chargeType === 'percentage'
            ? $baseAmount * ($chargeValue / 100)
            : $chargeValue;

        $totalCharged = $baseAmount + $charge;

        // PRE-INIT: Create Traceable Transaction
        $transaction = $user->transactions()->create([
            'amount' => $baseAmount,
            'type' => 'credit',
            'reference' => $reference,
            'status' => 'pending',
            'description' => "Wallet Topup (₵{$baseAmount} + ₵{$charge} fee)"
        ]);

        if ($method === 'paystack' && ($settings['enable_paystack'] ?? '1') !== '1') {
            return response()->json(['message' => 'Paystack gateway is currently disabled.'], 403);
        }
        if ($method === 'momo' && ($settings['enable_momo_deposits'] ?? '1') !== '1') {
            return response()->json(['message' => 'MOMO payments are currently disabled.'], 403);
        }

        $secretKey = $settings['paystack_secret'] ?? config('services.paystack.secret_key');

        // SIMULATION Logic
        if (app()->environment('local') && (!$secretKey || str_starts_with($secretKey, 'sk_test_placeholder'))) {
            return response()->json([
                'status' => true,
                'simulation' => true,
                'authorization_url' => route('wallet.callback', ['reference' => $reference]),
                'access_code' => 'SIM_ACC',
                'reference' => $reference
            ]);
        }

        $secretKey = trim($settings['paystack_secret'] ?? config('paystack.secret_key') ?? config('services.paystack.secret_key') ?? '');

        if (!$secretKey) {
            $transaction->update(['status' => 'failed', 'description' => 'Gateway not configured']);
            return response()->json(['message' => 'Paystack secret key is not configured. Please check your settings.'], 500);
        }

        // External API Handshake
        try {
            $channels = $method === 'momo' ? ['mobile_money'] : ['card'];

            $http = Http::withHeaders([
                'Authorization' => "Bearer {$secretKey}",
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])->timeout(config('paystack.timeout', 30));

            if (app()->environment('local')) {
                $http->withoutVerifying();
            }

            // Use the already-validated email from lines 40-47
            // Log the email being sent for debugging
            Log::info('Sending Paystack initialization request', [
                'user_id' => $user->id,
                'email' => $email,
                'amount' => $totalCharged,
                'reference' => $reference
            ]);

            $apiUrl = config('paystack.api_url', 'https://api.paystack.co');
            /** @var \Illuminate\Http\Client\Response $response */
            $response = $http->post("{$apiUrl}/transaction/initialize", [
                'email' => $email,
                'amount' => round($totalCharged * 100),
                'reference' => $reference,
                'callback_url' => route('wallet.callback'),
                'channels' => $channels,
                'currency' => 'GHS',
                'metadata' => [
                    'user_id' => $user->id,
                    'tx_id' => $transaction->id,
                    'original_email' => $user->email // Track if we used a fallback
                ]
            ]);

            if ($response->successful()) {
                $data = $response->json()['data'];
                Log::info('Paystack initialization successful', [
                    'reference' => $reference,
                    'authorization_url' => $data['authorization_url'] ?? null
                ]);
                return response()->json([
                    'status' => true,
                    'authorization_url' => $data['authorization_url'],
                    'access_code' => $data['access_code'],
                    'reference' => $reference
                ]);
            }

            $error = $response->json()['message'] ?? 'Gateway handshake failed';
            $fullResponse = $response->json();

            Log::error('Paystack initialization failed', [
                'status_code' => $response->status(),
                'error_message' => $error,
                'full_response' => $fullResponse,
                'request_email' => $email,
                'request_amount' => round($totalCharged * 100),
                'request_reference' => $reference
            ]);

            $transaction->update(['status' => 'failed', 'description' => $error]);
            return response()->json(['message' => $error], 502);

        } catch (\Illuminate\Http\Client\ConnectionException | \Illuminate\Http\Client\RequestException $e) {
            Log::critical('Paystack Connection Error', ['error' => $e->getMessage(), 'ref' => $reference]);
            $transaction->update(['status' => 'failed', 'description' => 'Gateway connection timeout']);
            return response()->json(['message' => 'Unable to reach the payment gateway. Please check your internet connection or try again later.'], 503);
        } catch (\Exception $e) {
            Log::critical('Paystack Initialization Error', ['error' => $e->getMessage(), 'ref' => $reference]);
            $transaction->update(['status' => 'failed', 'description' => 'Upstream connection error']);
            return response()->json(['message' => 'A system error occurred. Please try again.'], 504);
        }
    }

    // Webhook or Callback Verification
    public function verify(Request $request)
    {
        $reference = $request->reference;
        if (!$reference) {
            return redirect()->route('wallet.index')->with('error', 'No payment reference found.');
        }

        Log::info('Verifying payment', ['ref' => $reference]);

        $transaction = Transaction::where('reference', $reference)->first();

        if (!$transaction) {
            if (str_starts_with($reference, 'PAY-')) {
                return redirect()->route('paystack.verify', ['reference' => $reference]);
            }
            return redirect()->route('wallet.index')->with('error', 'Invalid transaction reference.');
        }

        if ($transaction->status === 'success') {
            return redirect()->route('wallet.index')->with('success', 'Wallet already updated successfully.');
        }

        $settings = Setting::whereIn('key', ['paystack_secret'])->get()->pluck('value', 'key');
        $secretKey = trim($settings['paystack_secret'] ?? config('paystack.secret_key') ?? config('services.paystack.secret_key') ?? '');

        if (!$secretKey) {
            return redirect()->route('wallet.index')->with('error', 'Paystack secret key is not configured.');
        }

        // Bulletproof SIMULATION Check
        if (app()->environment('local') && (!$secretKey || str_starts_with($secretKey, 'sk_test_placeholder'))) {
            $this->creditUser($transaction, 'Simulated Topup');
            return redirect()->route('wallet.index')->with('success', '₵' . number_format((float) $transaction->amount, 2) . ' credited (Simulation Mode).');
        }

        try {
            $http = Http::withHeaders([
                'Authorization' => "Bearer {$secretKey}",
                'Accept' => 'application/json',
            ])->timeout(config('paystack.timeout', 30));

            if (app()->environment('local')) {
                $http->withoutVerifying();
            }

            $apiUrl = config('paystack.api_url', 'https://api.paystack.co');
            /** @var \Illuminate\Http\Client\Response $response */
            $response = $http->get("{$apiUrl}/transaction/verify/{$reference}");

            if ($response->successful() && $response->json()['data']['status'] === 'success') {
                $data = $response->json()['data'];
                $this->creditUser($transaction, 'Paystack Verification', $data);
                return redirect()->route('wallet.index')->with('success', 'Wallet credited successfully!');
            }

            $message = $response->json()['message'] ?? 'Payment verification failed.';
            $transaction->update(['status' => 'failed', 'description' => $message]);
            return redirect()->route('wallet.index')->with('error', $message);

        } catch (\Illuminate\Http\Client\ConnectionException | \Illuminate\Http\Client\RequestException $e) {
            Log::critical('Verification Connection Error', ['error' => $e->getMessage(), 'ref' => $reference]);
            return redirect()->route('wallet.index')->with('error', 'Unable to reach the payment gateway for verification. Your wallet will be updated automatically once the transaction is confirmed (usually within 5 minutes).');
        } catch (\Exception $e) {
            Log::error('Verification System Error', ['error' => $e->getMessage(), 'ref' => $reference]);
            return redirect()->route('wallet.index')->with('error', 'A system error occurred during verification. If you have been debited, please wait 5-10 minutes for automatic processing.');
        }
    }

    protected function creditUser($transaction, $method, $gatewayData = null)
    {
        \DB::transaction(function () use ($transaction, $method, $gatewayData) {
            // Reload transaction to prevent race conditions
            $transaction = Transaction::lockForUpdate()->find($transaction->id);

            if ($transaction->status === 'success')
                return;

            $user = $transaction->user;
            $user->increment('wallet_balance', (float) $transaction->amount);

            \App\Models\Deposit::create([
                'user_id' => $user->id,
                'amount' => $transaction->amount,
                'status' => 'approved',
                'proof_image' => 'paystack',
                'admin_note' => "Credited via {$method}",
            ]);

            $transaction->update([
                'status' => 'success',
                'description' => "Wallet Topup via {$method}",
                'metadata' => $gatewayData ? json_encode($gatewayData) : null
            ]);

            // Manual notification creation to match custom table schema
            \App\Models\Notification::create([
                'user_id' => $user->id,
                'title' => 'Payment Verified',
                'message' => "Your top-up of ₵" . number_format((float) $transaction->amount, 2) . " has been successfully verified.",
                'type' => 'success',
                'is_read' => false
            ]);
        });
    }

    public function invoice($id)
    {
        $transaction = Transaction::where('user_id', auth()->id())->findOrFail($id);
        return view('invoices.transaction', compact('transaction'));
    }

    public function billingHistory(Request $request)
    {
        $user = $request->user();
        $query = $user->transactions();

        // Search Filter (Reference or Description)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('reference', 'like', "%$search%")
                    ->orWhere('description', 'like', "%$search%");
            });
        }

        // Status Filter
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Type Filter (Credit/Debit)
        if ($request->filled('type') && $request->type !== 'all') {
            $query->where('type', $request->type);
        }

        // Date Range Filter
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [$request->start_date . ' 00:00:00', $request->end_date . ' 23:59:59']);
        }

        $transactions = $query->latest()->paginate(15)->withQueryString();

        $monthStart = now()->startOfMonth();
        $stats = [
            'total_credits' => $user->transactions()->where('type', 'credit')->sum('amount') ?? 0,
            'total_spent' => $user->transactions()->where('type', 'debit')->sum('amount') ?? 0,
            'this_month' => $user->transactions()->where('type', 'debit')->where('created_at', '>=', $monthStart)->sum('amount') ?? 0,
        ];

        return view('dashboard.billing', compact('transactions', 'stats'));
    }
    public function wallet(Request $request)
    {
        $user = $request->user();
        $balance = $user->wallet_balance ?? 0.00;
        $transactions = $user->transactions()->latest()->paginate(10);
        $publicSettings = app(\App\Http\Controllers\AdminController::class)->getPublicSettings();

        $stats = [
            'total_credits' => $user->transactions()->where('type', 'credit')->sum('amount') ?? 0,
            'total_spent' => $user->transactions()->where('type', 'debit')->sum('amount') ?? 0,
        ];

        return view('dashboard.wallet.index', compact('balance', 'transactions', 'publicSettings', 'stats'));
    }
}
