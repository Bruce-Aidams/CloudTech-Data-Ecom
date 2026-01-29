<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\Transaction;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PaystackController extends Controller
{
    private ?string $secretKey;
    private ?string $publicKey;

    public function __construct()
    {
        try {
            // Try to get from database first, fallback to config
            $this->secretKey = Setting::where('key', 'paystack_secret')->value('value') ?: config('paystack.secret_key');
            $this->publicKey = Setting::where('key', 'paystack_public')->value('value') ?: config('paystack.public_key');
        } catch (Exception $e) {
            Log::error('PaystackController constructor error', ['error' => $e->getMessage()]);
            $this->secretKey = config('paystack.secret_key');
            $this->publicKey = config('paystack.public_key');
        }
    }

    /**
     * Validate that API keys are configured
     */
    private function validateApiKeys(): bool
    {
        if (empty($this->secretKey) || empty($this->publicKey)) {
            Log::error('Paystack API keys not configured', [
                'has_secret' => !empty($this->secretKey),
                'has_public' => !empty($this->publicKey)
            ]);
            return false;
        }
        return true;
    }

    /**
     * Initialize a payment transaction
     */
    public function initializePayment(Request $request)
    {
        Log::info('Paystack initialization started', ['email' => $request->email, 'amount_requested' => $request->amount]);

        $request->validate([
            'amount' => 'required|numeric|min:0.5',
            'email' => 'nullable|email|max:255',
            'callback_url' => 'sometimes|url',
            'metadata' => 'sometimes|array',
            'method' => 'sometimes|string|in:paystack,momo'
        ]);

        $user = $request->user();

        // Get email from request or authenticated user
        $email = $request->email ?? ($user ? $user->email : null);

        // Sanitize and validate email (crucial for Paystack)
        if ($email) {
            $email = trim($email);
            $email = str_replace(' ', '', $email);
            $email = preg_replace('/[[:cntrl:]]/', '', $email);
        }

        // Validate email is present and valid
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $msg = 'A valid email address is required to process this transaction.';
            Log::error('Paystack Error: Invalid or missing email', [
                'user_id' => $user?->id,
                'email_provided' => $request->email,
                'user_email' => $user?->email,
                'sanitized_email' => $email
            ]);

            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'status' => false,
                    'message' => $msg
                ], 422);
            }
            return back()->with('error', $msg);
        }
        $baseAmount = (float) $request->amount;

        // Fetch limits and charges from settings
        $settings = Setting::whereIn('key', ['min_payment', 'max_payment', 'charge_type', 'charge_value'])->get()->pluck('value', 'key');

        $min = (float) ($settings['min_payment'] ?? 20);
        $max = (float) ($settings['max_payment'] ?? 50000);

        if ($baseAmount < $min) {
            $msg = "Minimum payment amount is GHS {$min}";
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json(['status' => false, 'message' => $msg], 422);
            }
            return back()->with('error', $msg);
        }
        if ($baseAmount > $max) {
            $msg = "Maximum payment amount is GHS {$max}";
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json(['status' => false, 'message' => $msg], 422);
            }
            return back()->with('error', $msg);
        }

        // Calculate Charge
        $charge = 0;
        $chargeType = $settings['charge_type'] ?? 'percentage';
        $chargeValue = (float) ($settings['charge_value'] ?? 0);

        if ($chargeType === 'percentage') {
            $charge = $baseAmount * ($chargeValue / 100);
        } else {
            $charge = $chargeValue;
        }

        $totalAmount = $baseAmount + $charge;
        $amountInSubunit = round($totalAmount * 100); // Paystack expects base units * 100
        $reference = 'PAY-' . Str::uuid();

        // Validate API keys are configured
        if (!$this->validateApiKeys()) {
            $msg = 'Paystack API keys are not configured. Please contact support.';
            Log::error('Paystack initialization failed: ' . $msg);
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'status' => false,
                    'message' => $msg
                ], 500);
            }
            return back()->with('error', $msg);
        }

        // Consolidate email source
        $email = $request->email ?? $user?->email;

        try {
            $http = Http::timeout(config('paystack.timeout', 30))
                ->withHeaders([
                    'Authorization' => 'Bearer ' . $this->secretKey,
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ]);

            // Only disable SSL verification in local environment
            if (app()->environment('local', 'testing')) {
                $http->withoutVerifying();
            }

            $method = $request->input('method', 'paystack');
            $channels = $method === 'momo' ? ['mobile_money'] : ['card'];

            // Email is already validated above, use it directly
            // Log the email being sent to Paystack for debugging
            Log::info('Sending payment to Paystack', [
                'email' => $email,
                'amount' => $amountInSubunit,
                'reference' => $reference
            ]);

            /** @var \Illuminate\Http\Client\Response $response */
            $response = $http->post(config('paystack.api_url') . '/transaction/initialize', [
                'email' => $email,
                'amount' => $amountInSubunit,
                'currency' => config('paystack.currency', 'GHS'),
                'reference' => $reference,
                'channels' => $channels,
                'callback_url' => $request->callback_url ?? (($request->expectsJson() || $request->is('api/*')) ? env('FRONTEND_URL', 'http://localhost:8000') . '/dashboard/wallet/callback' : route('paystack.verify')),
                'metadata' => array_merge([
                    'user_id' => $user?->id,
                    'user_name' => $user?->name,
                    'is_direct_order' => isset($request->metadata['order_ids']),
                    'base_amount' => $baseAmount,
                    'charge' => $charge,
                    'original_email' => $email
                ], $request->metadata ?? []),
            ]);

            if ($response->successful()) {
                $data = $response->json()['data'];
                Log::info('Paystack payment initialized', ['ref' => $reference, 'total' => $totalAmount]);

                if ($request->expectsJson() || $request->is('api/*')) {
                    return response()->json([
                        'status' => true,
                        'message' => 'Payment initialized successfully',
                        'data' => [
                            'authorization_url' => $data['authorization_url'],
                            'access_code' => $data['access_code'],
                            'reference' => $reference,
                            'total_with_charges' => $totalAmount
                        ]
                    ]);
                }

                return redirect($data['authorization_url']);
            }

            $errorData = $response->json();
            $msg = 'Payment initialization failed: ' . ($errorData['message'] ?? 'Unknown gateway error');
            Log::error('Paystack initialization failed', [
                'status_code' => $response->status(),
                'body' => $errorData,
                'ref' => $reference,
                'headers' => $response->headers()
            ]);

            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'status' => false,
                    'message' => $msg
                ], 500);
            }

            return back()->with('error', $msg);

        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            $msg = 'Unable to connect to payment gateway. Please check your internet connection.';
            Log::error('Paystack connection error', [
                'error' => $e->getMessage(),
                'ref' => $reference,
                'trace' => $e->getTraceAsString()
            ]);

            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'status' => false,
                    'message' => $msg
                ], 503);
            }

            return back()->with('error', $msg);
        } catch (Exception $e) {
            $msg = 'An error occurred while initializing payment. Please try again.';
            Log::error('Paystack initialization exception', [
                'error' => $e->getMessage(),
                'ref' => $reference,
                'trace' => $e->getTraceAsString()
            ]);

            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'status' => false,
                    'message' => $msg
                ], 500);
            }

            return back()->with('error', $msg);
        }
    }

    /**
     * Verify a payment transaction
     */
    public function verifyPayment(Request $request): JsonResponse
    {
        $request->validate(['reference' => 'required|string']);
        $reference = $request->reference;

        Log::info('Paystack verification started', ['ref' => $reference]);

        try {
            $http = Http::timeout(config('paystack.timeout', 30))
                ->withHeaders([
                    'Authorization' => 'Bearer ' . $this->secretKey,
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ]);

            // Only disable SSL verification in local environment
            if (app()->environment('local', 'testing')) {
                $http->withoutVerifying();
            }

            /** @var \Illuminate\Http\Client\Response $response */
            $response = $http->get(config('paystack.api_url') . "/transaction/verify/{$reference}");

            if ($response->successful()) {
                $data = $response->json()['data'];

                if ($data['status'] === 'success') {
                    $amount = $data['amount'] / 100; // Define amount here as it's used in the closure

                    // ATOMIC PROCESSING
                    $result = DB::transaction(function () use ($data, $reference, $amount, $request) {
                        $existingTransaction = Transaction::where('reference', $reference)->lockForUpdate()->first();

                        if ($existingTransaction && $existingTransaction->status === 'success') {
                            return ['status' => true, 'message' => 'Transaction already processed', 'new_balance' => $request->user()?->wallet_balance];
                        }

                        $userId = $data['metadata']['user_id'] ?? ($request->user() ? $request->user()->id : null);
                        $user = User::find($userId);

                        if (!$user) {
                            throw new Exception('User not found during verified credit.');
                        }

                        $orderIds = $data['metadata']['order_ids'] ?? null;

                        if ($orderIds && is_array($orderIds)) {
                            // DIRECT ORDER FLOW
                            $orders = \App\Models\Order::whereIn('id', $orderIds)->get();
                            /** @var \App\Models\Order $order */
                            foreach ($orders as $order) {
                                if ($order->status === 'pending_payment') {
                                    $order->complete([
                                        'method' => 'paystack',
                                        'gateway_response' => $data,
                                        'auto_completed' => true
                                    ]);
                                    \App\Jobs\ProcessOrder::dispatch($order);
                                }
                            }

                            if ($existingTransaction) {
                                $existingTransaction->update([
                                    'status' => 'success',
                                    'description' => 'Bundle Purchase via Paystack Direct',
                                    'metadata' => $data,
                                ]);
                            } else {
                                $user->transactions()->create([
                                    'amount' => $amount,
                                    'type' => 'credit',
                                    'reference' => $reference,
                                    'status' => 'success',
                                    'description' => 'Bundle Purchase via Paystack Direct',
                                    'metadata' => $data,
                                ]);
                            }
                            Log::info('Paystack payment verified and processed (Direct Order)', ['ref' => $reference, 'user' => $user->id]);
                            return ['status' => true, 'message' => 'Order completed successfully', 'is_direct_order' => true];
                        } else {
                            // WALLET TOPUP FLOW
                            $user->increment('wallet_balance', $amount);

                            \App\Models\Deposit::create([
                                'user_id' => $user->id,
                                'amount' => $amount,
                                'status' => 'approved',
                                'proof_image' => 'paystack',
                                'admin_note' => 'Automated Top-up via Paystack Inline',
                            ]);

                            if ($existingTransaction) {
                                $existingTransaction->update([
                                    'status' => 'success',
                                    'description' => 'Wallet top-up via Paystack',
                                    'metadata' => $data,
                                ]);
                            } else {
                                $user->transactions()->create([
                                    'amount' => $amount,
                                    'type' => 'credit',
                                    'reference' => $reference,
                                    'status' => 'success',
                                    'description' => 'Wallet top-up via Paystack',
                                    'metadata' => $data,
                                ]);
                            }

                            // Send Notification
                            try {
                                if ($existingTransaction) {
                                    $user->notify(new \App\Notifications\PaymentVerified($existingTransaction));
                                } else {
                                    $user->notify(new \App\Notifications\PaymentVerified($user->transactions()->where('reference', $reference)->first()));
                                }
                            } catch (Exception $e) {
                                Log::error('Notification error during verification', ['error' => $e->getMessage()]);
                            }
                            Log::info('Paystack payment verified and processed (Wallet Topup)', ['ref' => $reference, 'user' => $user->id]);
                            return ['status' => true, 'message' => 'Wallet topped up successfully', 'new_balance' => $user->wallet_balance];
                        }
                    });

                    return response()->json($result);
                }

                return response()->json(['status' => false, 'message' => 'Payment was not successful', 'payment_status' => $data['status']], 400);
            }

            Log::error('Paystack verification failed', [
                'status_code' => $response->status(),
                'body' => $response->json(),
                'reference' => $reference
            ]);
            return response()->json(['status' => false, 'message' => 'Payment verification failed'], 500);

        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            Log::error('Paystack verification connection error', [
                'error' => $e->getMessage(),
                'reference' => $reference,
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['status' => false, 'message' => 'Unable to verify payment. Please check your connection.'], 503);

        } catch (Exception $e) {
            Log::error('Paystack verification exception', [
                'error' => $e->getMessage(),
                'reference' => $reference,
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['status' => false, 'message' => 'An error occurred while verifying payment'], 500);
        }
    }

    public function handleWebhook(Request $request): JsonResponse
    {
        $signature = $request->header('x-paystack-signature');
        $body = $request->getContent();

        if (!$signature || !$this->secretKey || hash_hmac('sha512', $body, $this->secretKey) !== $signature) {
            Log::warning('Invalid Paystack webhook signature');
            return response()->json(['message' => 'Invalid signature'], 400);
        }

        $event = $request->input('event');
        $data = $request->input('data');

        Log::info('Paystack webhook received', ['event' => $event, 'ref' => $data['reference'] ?? null]);

        switch ($event) {
            case 'charge.success':
                $this->handleSuccessfulCharge($data);
                break;
            case 'charge.failed':
                $this->handleFailedCharge($data);
                break;
        }

        return response()->json(['message' => 'Webhook processed']);
    }

    private function handleSuccessfulCharge(array $data): void
    {
        $reference = $data['reference'];
        $existingTransaction = Transaction::where('reference', $reference)->first();
        if ($existingTransaction && $existingTransaction->status === 'success')
            return;

        $userId = $data['metadata']['user_id'] ?? null;
        if (!$userId)
            return;

        $user = User::find($userId);
        if (!$user)
            return;

        $amount = $data['amount'] / 100;

        $orderIds = $data['metadata']['order_ids'] ?? null;

        if ($orderIds && is_array($orderIds)) {
            $orders = \App\Models\Order::whereIn('id', $orderIds)->get();
            /** @var \App\Models\Order $order */
            foreach ($orders as $order) {
                if ($order->status === 'pending_payment') {
                    $order->complete([
                        'method' => 'paystack_webhook',
                        'gateway_event' => $data,
                        'auto_completed' => true,
                        'message' => 'Paystack webhook received. Order completed.'
                    ]);
                    \App\Jobs\ProcessOrder::dispatch($order);
                }
            }

            if ($existingTransaction) {
                $existingTransaction->update([
                    'status' => 'success',
                    'description' => $existingTransaction->description . ' (Webhook Verified)',
                    'metadata' => $data,
                ]);
            } else {
                $user->transactions()->create([
                    'amount' => $amount,
                    'type' => 'credit',
                    'reference' => $reference,
                    'status' => 'success',
                    'description' => 'Bundle Purchase via Paystack Direct (Webhook)',
                    'metadata' => $data,
                ]);
            }
        } else {
            $user->increment('wallet_balance', $amount);

            // Create Deposit record for admin visibility
            \App\Models\Deposit::create([
                'user_id' => $user->id,
                'amount' => $amount,
                'status' => 'approved',
                'proof_image' => 'paystack',
                'admin_note' => 'Automated Top-up via Paystack Webhook',
            ]);

            if ($existingTransaction) {
                $existingTransaction->update([
                    'status' => 'success',
                    'description' => $existingTransaction->description . ' (Webhook Topup Verified)',
                    'metadata' => $data,
                ]);
            } else {
                $user->transactions()->create([
                    'amount' => $amount,
                    'type' => 'credit',
                    'reference' => $reference,
                    'status' => 'success',
                    'description' => 'Wallet top-up via Paystack (Webhook)',
                    'metadata' => $data,
                ]);
            }
        }

        Log::info('Webhook: Payment processed successfully', ['ref' => $reference]);
    }

    private function handleFailedCharge(array $data): void
    {
        $reference = $data['reference'];
        Log::warning('Webhook: Payment failed', ['ref' => $reference]);

        $userId = $data['metadata']['user_id'] ?? null;
        if ($userId) {
            $user = User::find($userId);
            if ($user) {
                $user->transactions()->create([
                    'amount' => $data['amount'] / 100,
                    'type' => 'credit',
                    'reference' => $reference,
                    'status' => 'failed',
                    'description' => 'Failed wallet top-up (Webhook)',
                    'metadata' => $data,
                ]);
            }
        }
    }

    public function getPaymentHistory(Request $request): JsonResponse
    {
        $transactions = $request->user()->transactions()
            ->where('type', 'credit')
            ->latest()
            ->paginate(20);

        return response()->json(['status' => true, 'data' => $transactions]);
    }

    public function getPublicKey(): JsonResponse
    {
        return response()->json(['status' => true, 'public_key' => $this->publicKey]);
    }

    /**
     * Web-friendly verification that redirects back with messages
     */
    public function verifyPaymentWeb(Request $request)
    {
        $reference = $request->reference;
        if (!$reference) {
            return redirect()->route('dashboard')->with('error', 'No payment reference found.');
        }

        // Call the JSON verification logic but convert response to redirect
        $response = $this->verifyPayment($request);
        $data = $response->getData();

        if ($data->status) {
            // Determine where to redirect based on metadata
            Log::info('Web Verification Success', ['ref' => $reference]);

            // If it was a direct order, show success on orders page
            if (strpos($data->message, 'Order completed') !== false || (isset($data->is_direct_order) && $data->is_direct_order)) {
                return redirect()->route('orders.index')->with('success', 'Order completed successfully!');
            }

            return redirect()->route('wallet.index')->with('success', 'Transaction processed successfully!');
        }

        return redirect()->route('dashboard')->with('error', $data->message ?? 'Payment verification failed.');
    }
}
