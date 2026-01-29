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

        try {
            return \DB::transaction(function () use ($data, $reference) {
                $transaction = Transaction::where('reference', $reference)->lockForUpdate()->first();

                if (!$transaction) {
                    Log::error('Paystack Webhook: Transaction found on Paystack but missing locally', ['ref' => $reference]);
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

                $user->notify(new \App\Notifications\PaymentVerified($transaction));

                Log::info('Paystack Webhook: Payment processed successfully', ['user' => $user->id, 'ref' => $reference]);
                return response()->json(['status' => 'success']);
            });
        } catch (\Exception $e) {
            Log::error('Paystack Webhook Processing Error', ['error' => $e->getMessage(), 'ref' => $reference]);
            return response()->json(['message' => 'Internal server error'], 500);
        }
    }
}
