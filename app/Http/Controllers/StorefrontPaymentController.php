<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use App\Models\Bundle;
use App\Models\Transaction;
use App\Models\ResellerPrice;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class StorefrontPaymentController extends Controller
{
    private ?string $secretKey;
    private ?string $apiBaseUrl;

    public function __construct()
    {
        // Follow the same pattern as PaystackController
        $this->secretKey = Setting::where('key', 'paystack_secret')->value('value') ?: config('paystack.secret_key');
        $this->apiBaseUrl = config('paystack.api_url', 'https://api.paystack.co');
    }

    /**
     * Initialize Paystack Payment for Guest Customer
     */
    public function initialize(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'phone' => ['required', 'string', new \App\Rules\GhanaPhoneValidation()],
            'bundle_id' => 'required|exists:bundles,id',
            'reseller_code' => 'required|exists:users,referral_code',
        ]);

        $email = $request->email;
        if ($email) {
            $email = trim($email);
            $email = str_replace(' ', '', $email);
            $email = preg_replace('/[[:cntrl:]]/', '', $email);
        }

        $reseller = User::where('referral_code', $request->reseller_code)->firstOrFail();

        // Ensure store is active
        if (!$reseller->store_active) {
            return back()->with('error', 'This store is currently unavailable.');
        }

        $bundle = Bundle::findOrFail($request->bundle_id);

        // 1. Determine Price (Custom or Default)
        $customPrice = ResellerPrice::where('user_id', $reseller->id)
            ->where('bundle_id', $bundle->id)
            ->value('price');

        // Final Selling Price to Guest
        $amount = $customPrice ? (float) $customPrice : (float) $bundle->price;

        // 2. Determine Cost to Reseller (Base Cost)
        $rolePrices = $bundle->role_prices ?: [];
        $costToReseller = (float) ($rolePrices[$reseller->role] ?? $bundle->price);

        // 3. Ensure reseller has enough balance to facilitate this sale
        if ($reseller->wallet_balance < $costToReseller) {
            return back()->with('error', 'This store is temporarily unable to process orders due to insufficient balance. Please contact the store owner.');
        }

        // 4. Calculate Profit
        $profit = max(0, $amount - $costToReseller);

        // 4. Pre-create Order (Status: pending_payment)
        $order = Order::create([
            'user_id' => $reseller->id,
            'bundle_id' => $bundle->id,
            'guest_email' => $email,
            'recipient_phone' => $request->phone,
            'cost' => $amount,
            'cost_price' => $costToReseller,
            'profit' => $profit,
            'status' => 'pending_payment',
            'reference' => 'STR-' . Str::uuid(),
            'payment_method' => 'paystack',
            'source' => 'storefront',
        ]);

        $metadata = [
            'type' => 'storefront_purchase',
            'order_id' => $order->id,
            'reseller_id' => $reseller->id,
        ];

        Log::info("Storefront Purchase Initializing", [
            'email' => $request->email,
            'amount' => $amount,
            'reseller' => $reseller->id,
            'bundle' => $bundle->id
        ]);

        try {
            $http = Http::timeout(config('paystack.timeout', 60))
                ->withHeaders([
                    'Authorization' => 'Bearer ' . $this->secretKey,
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ]);

            if (app()->environment('local', 'testing')) {
                $http->withoutVerifying();
            }

            $response = $http->post("{$this->apiBaseUrl}/transaction/initialize", [
                'amount' => (int) ($amount * 100), // Kobo
                'email' => $email,
                'reference' => $order->reference,
                'currency' => config('paystack.currency', 'GHS'),
                'callback_url' => route('store.callback'),
                'metadata' => $metadata
            ]);

            if ($response->successful()) {
                Log::info("Paystack Init Success (Storefront)");
                return redirect($response->json()['data']['authorization_url']);
            }

            // Cleanup if init fails
            $order->delete();
            Log::error("Paystack Init Error (Storefront): " . $response->body());
            return back()->with('error', 'Payment initialization failed. Gateway error: ' . ($response->json()['message'] ?? 'Unknown'));

        } catch (\Exception $e) {
            if (isset($order))
                $order->delete();
            Log::error("Paystack Init Exception (Storefront): " . $e->getMessage());
            return back()->with('error', 'An error occurred while initiating payment.');
        }
    }

    /**
     * Handle Paystack Callback for Storefront
     */
    public function callback(Request $request)
    {
        $reference = $request->query('reference');

        if (!$reference) {
            return redirect('/')->with('error', 'No reference found.');
        }

        try {
            $http = Http::timeout(config('paystack.timeout', 60))
                ->withHeaders([
                    'Authorization' => 'Bearer ' . $this->secretKey,
                    'Accept' => 'application/json',
                ]);

            if (app()->environment('local', 'testing')) {
                $http->withoutVerifying();
            }

            $response = $http->get("{$this->apiBaseUrl}/transaction/verify/{$reference}");

            if (!$response->successful() || $response->json()['data']['status'] !== 'success') {
                return redirect('/')->with('error', 'Payment verification failed.');
            }

            $data = $response->json()['data'];
            $meta = $data['metadata'] ?? [];

            // Verify if this is a storefront transaction
            if (($meta['type'] ?? '') !== 'storefront_purchase') {
                return redirect('/')->with('error', 'Invalid transaction mapping.');
            }

            $order = Order::where('reference', $reference)
                ->where('source', 'storefront')
                ->first();

            if (!$order) {
                Log::error("Storefront Callback: Order not found for reference {$reference}");
                return redirect('/')->with('error', 'Order record not found.');
            }

            if ($order->status !== 'pending_payment') {
                $reseller = User::find($meta['reseller_id']);
                return redirect()->route('store.show', $reseller->referral_code)->with('success', 'Order already processed.');
            }

            DB::beginTransaction();

            // 1. Finalize Order
            $order->update([
                'status' => 'pending',
                'payment_reference' => $data['reference'],
                'response_data' => $data
            ]);

            $reseller = User::findOrFail($meta['reseller_id']);
            // 2. Business Logic: Deduct Wholesale Cost from Reseller Wallet
            if ($order->cost_price > 0) {
                if ($reseller->wallet_balance >= $order->cost_price) {
                    $reseller->decrement('wallet_balance', $order->cost_price);

                    Transaction::create([
                        'user_id' => $reseller->id,
                        'type' => 'debit',
                        'amount' => $order->cost_price,
                        'status' => 'success',
                        'reference' => 'WHS-' . Str::random(10),
                        'description' => "Wholesale Cost for Order #{$order->id} (Storefront)",
                        'metadata' => ['order_id' => $order->id]
                    ]);
                } else {
                    Log::error("Storefront Critical: Reseller {$reseller->id} balance low during callback for order #{$order->id}");
                    // We continue since the customer already paid, but this is a configuration/timing issue
                }
            }

            // 3. Credit Full Storefront Payment to Reseller Wallet (Covers Cost + Profit)
            $reseller->increment('wallet_balance', $order->cost);

            Transaction::create([
                'user_id' => $reseller->id,
                'type' => 'credit',
                'amount' => $order->cost,
                'status' => 'success',
                'reference' => $reference,
                'description' => "Storefront Revenue for Order #{$order->id}",
                'metadata' => $data
            ]);

            // 4. (Old logic replaced) We no longer credit commission_balance for storefront 
            // as it is now handled as wallet profit (Revenue - Cost).

            DB::commit();

            // Fire Order Processing logic
            try {
                \App\Jobs\ProcessOrder::dispatch($order);
            } catch (\Exception $e) {
                Log::error("Storefront Order Dispatch Error: " . $e->getMessage());
            }

            return redirect()->route('store.show', $reseller->referral_code)->with('success', 'Order placed successfully! Automated delivery is being processed.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Storefront Callback Error: " . $e->getMessage());
            return redirect('/')->with('error', 'An error occurred while processing your order.');
        }
    }
}
