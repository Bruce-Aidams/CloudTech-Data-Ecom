<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\User;
use App\Models\Deposit;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaystackWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $payload = $request->getContent();
        $signature = $request->header('X-Paystack-Signature');

        if (!$this->verifySignature($payload, $signature)) {
            Log::warning('Paystack Webhook: Invalid Signature');
            return response()->json(['message' => 'Invalid signature'], 400);
        }

        $event = json_decode($payload, true);
        Log::info('Paystack Webhook Received', ['event' => $event['event'] ?? 'unknown']);

        if (($event['event'] ?? '') === 'charge.success') {
            return $this->processChargeSuccess($event['data']);
        }

        return response()->json(['status' => 'success']);
    }

    protected function verifySignature($payload, $signature)
    {
        $secret = Setting::where('key', 'paystack_secret')->value('value') ?: env('PAYSTACK_SECRET_KEY');
        return hash_hmac('sha512', $payload, $secret) === $signature;
    }

    protected function processChargeSuccess($data)
    {
        $reference = $data['reference'];
        $meta = $data['metadata'] ?? [];
        $type = $meta['type'] ?? '';

        try {
            return \DB::transaction(function () use ($data, $reference, $type, $meta) {
                // 1. Handle Storefront Purchase
                if ($type === 'storefront_purchase') {
                    $order = \App\Models\Order::where('reference', $reference)
                        ->where('source', 'storefront')
                        ->lockForUpdate()
                        ->first();

                    if (!$order) {
                        Log::error('Paystack Webhook: Storefront Order not found', ['ref' => $reference]);
                        return response()->json(['message' => 'Order not found'], 404);
                    }

                    if ($order->status !== 'pending_payment') {
                        return response()->json(['message' => 'Already processed']);
                    }

                    // Finalize Order
                    $order->update([
                        'status' => 'pending',
                        'payment_reference' => $data['reference'],
                        'response_data' => $data
                    ]);

                    $reseller = User::findOrFail($meta['reseller_id']);
                    $profit = $order->profit;

                    // Credit Reseller Commission
                    if ($profit > 0) {
                        $reseller->increment('commission_balance', $profit);
                        Transaction::create([
                            'user_id' => $reseller->id,
                            'type' => 'credit',
                            'amount' => $profit,
                            'status' => 'success',
                            'reference' => 'COM-' . \Illuminate\Support\Str::random(10),
                            'description' => "Commission for Order #{$order->id} (Storefront Guest Purchase - Webhook)",
                            'metadata' => ['order_id' => $order->id]
                        ]);
                    }

                    // Log Main Payment Transaction
                    Transaction::create([
                        'user_id' => $reseller->id,
                        'type' => 'credit',
                        'amount' => $data['amount'] / 100,
                        'status' => 'success',
                        'reference' => $reference,
                        'description' => "Storefront Payment Received for Order #{$order->id} (Webhook Verified)",
                        'metadata' => json_encode($data)
                    ]);

                    // Dispatch Delivery
                    try {
                        \App\Jobs\ProcessOrder::dispatch($order);
                    } catch (\Exception $e) {
                        Log::error("Webhook: Storefront Order Dispatch Error: " . $e->getMessage());
                    }

                    Log::info('Paystack Webhook: Storefront Payment processed');
                    return response()->json(['status' => 'success']);
                }

                // 2. Handle Wallet Topup (Existing Logic)
                $transaction = Transaction::where('reference', $reference)->lockForUpdate()->first();

                if (!$transaction) {
                    Log::error('Paystack Webhook: Transaction not found locally', ['ref' => $reference]);
                    return response()->json(['message' => 'Transaction not found'], 404);
                }

                if ($transaction->status === 'success') {
                    return response()->json(['message' => 'Already processed']);
                }

                $user = $transaction->user;
                $user->increment('wallet_balance', (float) $transaction->amount);

                Deposit::create([
                    'user_id' => $user->id,
                    'amount' => $transaction->amount,
                    'status' => 'approved',
                    'proof_image' => 'paystack',
                    'admin_note' => 'Credited via Paystack Webhook',
                ]);

                $transaction->update([
                    'status' => 'success',
                    'description' => 'Wallet Topup via Paystack (Webhook Verified)',
                    'metadata' => json_encode($data)
                ]);

                if ($user->role !== 'guest') {
                    try {
                        $user->notify(new \App\Notifications\PaymentVerified($transaction));
                    } catch (\Exception $e) {
                    }
                }

                Log::info('Paystack Webhook: Wallet Topup processed');
                return response()->json(['status' => 'success']);
            });
        } catch (\Exception $e) {
            Log::error('Paystack Webhook Processing Error', ['error' => $e->getMessage(), 'ref' => $reference]);
            return response()->json(['message' => 'Internal server error'], 500);
        }
    }
}
