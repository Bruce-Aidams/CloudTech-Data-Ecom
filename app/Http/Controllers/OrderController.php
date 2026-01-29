<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Bundle;
use App\Jobs\ProcessOrder;
use App\Rules\GhanaPhoneValidation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Setting;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    // User: List own orders
    public function index(Request $request)
    {
        return $request->user()->orders()->with('bundle')->latest()->paginate(10);
    }

    // User: Order History (Optimized)
    public function userOrders(Request $request)
    {
        $query = $request->user()->orders();

        // Search Filter (Reference or Phone)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('reference', 'like', "%$search%")
                    ->orWhere('recipient_phone', 'like', "%$search%");
            });
        }

        // Status Filter
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Network Filter
        if ($request->filled('network') && $request->network !== 'all') {
            $query->whereHas('bundle', function ($q) use ($request) {
                $q->where('network', $request->network);
            });
        }

        // Date Range Filter
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [$request->start_date . ' 00:00:00', $request->end_date . ' 23:59:59']);
        }

        $orders = $query->select('id', 'user_id', 'bundle_id', 'recipient_phone', 'status', 'cost', 'reference', 'created_at')
            ->with([
                'bundle' => function ($q) {
                    $q->select('id', 'name', 'network', 'price');
                }
            ])
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $networks = Bundle::distinct()->pluck('network');

        return view('dashboard.orders.index', compact('orders', 'networks'));
    }

    // User: Show Purchase Form
    public function create()
    {
        $bundles = Bundle::where('is_active', true)->get();
        $networks = Bundle::distinct()->where('is_active', true)->pluck('network');
        return view('dashboard.orders.new', compact('bundles', 'networks'));
    }

    // API: Get Bundles
    public function getBundles()
    {
        return response()->json(Bundle::where('is_active', true)->get());
    }

    // API: Get Networks
    public function getNetworks()
    {
        return response()->json(Bundle::distinct()->where('is_active', true)->pluck('network'));
    }

    public function adminIndex(Request $request)
    {
        $query = Order::with(['user', 'bundle']);

        // Search Filter
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('reference', 'like', "%$search%")
                    ->orWhere('recipient_phone', 'like', "%$search%")
                    ->orWhereHas('user', function ($qu) use ($search) {
                        $qu->where('name', 'like', "%$search%")
                            ->orWhere('email', 'like', "%$search%");
                    });
            });
        }

        // User Filter
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        // Status Filter
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Network Filter
        if ($request->filled('network') && $request->network !== 'all') {
            $query->whereHas('bundle', function ($q) use ($request) {
                $q->where('network', $request->network);
            });
        }

        // Date Range Filter
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [$request->start_date . ' 00:00:00', $request->end_date . ' 23:59:59']);
        }

        $orders = $query->latest()->paginate(40);
        $networks = Bundle::distinct()->pluck('network');

        // Global counts for the dashboard summary (respecting filters except network itself)
        $summaryQuery = Order::query();
        if ($request->has('search')) {
            $search = $request->search;
            $summaryQuery->where(function ($q) use ($search) {
                $q->where('reference', 'like', "%$search%")
                    ->orWhere('recipient_phone', 'like', "%$search%")
                    ->orWhereHas('user', function ($qu) use ($search) {
                        $qu->where('name', 'like', "%$search%")
                            ->orWhere('email', 'like', "%$search%");
                    });
            });
        }
        if ($request->filled('status') && $request->status !== 'all') {
            $summaryQuery->where('status', $request->status);
        }

        $networkCounts = [];
        foreach ($networks as $net) {
            $networkCounts[$net] = (clone $summaryQuery)->whereHas('bundle', function ($q) use ($net) {
                $q->where('network', $net);
            })->count();
        }

        $totalFilteredOrders = $summaryQuery->count();

        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json(['orders' => $orders, 'networks' => $networks, 'networkCounts' => $networkCounts, 'totalFilteredOrders' => $totalFilteredOrders]);
        }

        return view('admin.orders.index', compact('orders', 'networks', 'networkCounts', 'totalFilteredOrders'));
    }

    public function export(Request $request)
    {
        $query = Order::with(['user', 'bundle']);

        // Apply filters (Same as adminIndex)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('reference', 'like', "%$search%")
                    ->orWhere('recipient_phone', 'like', "%$search%")
                    ->orWhereHas('user', function ($qu) use ($search) {
                        $qu->where('name', 'like', "%$search%")
                            ->orWhere('email', 'like', "%$search%");
                    });
            });
        }
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }
        if ($request->filled('network') && $request->network !== 'all') {
            $query->whereHas('bundle', function ($q) use ($request) {
                $q->where('network', $request->network);
            });
        }
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [$request->start_date . ' 00:00:00', $request->end_date . ' 23:59:59']);
        }

        $orders = $query->latest()->get();
        $filename = "orders_" . now()->format('Y-m-d_His') . ".csv";

        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $columns = ['Date', 'Reference', 'Customer', 'Phone', 'Network', 'Bundle', 'Cost', 'Status'];

        $callback = function () use ($orders, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($orders as $order) {
                fputcsv($file, [
                    $order->created_at->format('Y-m-d H:i:s'),
                    $order->reference,
                    $order->user->name ?? 'N/A',
                    "'" . $order->recipient_phone, // Force string in Excel
                    $order->bundle->network ?? 'N/A',
                    $order->bundle->name ?? 'N/A',
                    $order->cost,
                    strtoupper($order->status),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }


    // User: Place Order
    public function store(Request $request)
    {
        $request->validate([
            'bundle_id' => 'required|exists:bundles,id',
            'recipient_phone' => ['required', 'string', new GhanaPhoneValidation()],
            'payment_method' => 'required|in:wallet,paystack,momo,transfer'
        ]);

        $user = Auth::user();
        $bundle = Bundle::findOrFail($request->bundle_id);
        $price = $this->getPriceForUser($bundle, $user);

        // 1. WALLET FLOW
        if ($request->payment_method === 'wallet') {
            if ($user->wallet_balance < $price) {
                $msg = 'Insufficient wallet balance.';
                return $request->expectsJson() ? response()->json(['message' => $msg], 402) : back()->with('error', $msg);
            }

            $order = DB::transaction(function () use ($user, $bundle, $request, $price) {
                $order = Order::create([
                    'user_id' => $user->id,
                    'bundle_id' => $bundle->id,
                    'recipient_phone' => $request->recipient_phone,
                    'cost' => $price,
                    'cost_price' => $bundle->cost_price ?? 0,
                    'status' => 'pending',
                    'reference' => 'ORD-' . Str::uuid(),
                ]);

                $user->decrement('wallet_balance', $price);
                $user->transactions()->create([
                    'order_id' => $order->id,
                    'amount' => $price,
                    'type' => 'debit',
                    'reference' => 'TRX-' . Str::uuid(),
                    'status' => 'success',
                    'description' => "Purchase: {$bundle->name} for {$request->recipient_phone}",
                ]);

                $order->complete(['method' => 'wallet', 'auto_completed' => true]);
                return $order;
            });

            ProcessOrder::dispatch($order);
            return $request->expectsJson()
                ? response()->json(['status' => true, 'message' => 'Order placed successfully', 'redirect' => route('orders.index')])
                : redirect()->route('orders.index')->with('success', 'Order placed successfully');
        }

        // 2. GATEWAY FLOW (Paystack / MOMO)
        if (in_array($request->payment_method, ['paystack', 'momo'])) {
            $settings = Setting::whereIn('key', ['charge_type', 'charge_value'])->get()->pluck('value', 'key');
            $chargeType = $settings['charge_type'] ?? 'percentage';
            $chargeValue = (float) ($settings['charge_value'] ?? 0);
            $charge = $chargeType === 'percentage' ? ($price * ($chargeValue / 100)) : $chargeValue;

            $order = Order::create([
                'user_id' => $user->id,
                'bundle_id' => $bundle->id,
                'recipient_phone' => $request->recipient_phone,
                'cost' => $price,
                'cost_price' => $bundle->cost_price ?? 0,
                'status' => 'pending_payment',
                'reference' => 'ORD-' . Str::uuid(),
            ]);

            $initData = [
                'amount' => $price, // Send Base Price, PaystackController adds charge
                'email' => $user->email,
                'method' => $request->payment_method,
                'metadata' => [
                    'order_ids' => [$order->id],
                    'is_direct_order' => true,
                    'base_amount' => $price,
                    'charge' => $charge,
                    'user_id' => $user->id
                ]
            ];

            $paystackRequest = new Request();
            $paystackRequest->merge($initData);

            if ($request->expectsJson()) {
                $paystackRequest->headers->set('Accept', 'application/json');
            }
            return app(\App\Http\Controllers\PaystackController::class)->initializePayment($paystackRequest);
        }

        // 3. TRANSFER FLOW
        if ($request->payment_method === 'transfer') {
            $order = Order::create([
                'user_id' => $user->id,
                'bundle_id' => $bundle->id,
                'recipient_phone' => $request->recipient_phone,
                'cost' => $price,
                'cost_price' => $bundle->cost_price ?? 0,
                'status' => 'awaiting_transfer',
                'reference' => 'ORD-' . Str::uuid(),
            ]);

            $msg = 'Order submitted. Please upload proof of payment in the Finance Hub to complete processing.';
            return $request->expectsJson()
                ? response()->json(['status' => true, 'message' => $msg, 'redirect' => route('orders.index')])
                : redirect()->route('orders.index')->with('success', $msg);
        }

        return back()->with('error', 'Invalid payment method.');
    }

    // Show Order (for Invoice)
    public function show(Request $request, Order $order)
    {
        // Ensure user owns order or is admin
        if ($request->user()->id !== $order->user_id && $request->user()->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        $order->load(['user', 'bundle']);

        if ($request->expectsJson() || $request->is('api/*')) {
            return $order;
        }

        return view('admin.orders.show', compact('order'));
    }

    // Admin: Update Status manually
    public function update(Request $request, Order $order)
    {
        $request->validate(['status' => 'required|in:pending,processing,completed,failed']);

        if ($request->status === 'completed') {
            $order->cost_price = $order->bundle->cost_price ?? 0;
            $order->profit = $order->cost - $order->cost_price;
            $order->status = 'completed';
            $order->save();
            $order->complete(); // This handles commissions
        } else {
            $order->update(['status' => $request->status]);
        }


        return response()->json(['message' => 'Order updated.', 'order' => $order]);
    }

    // User: Bulk Place Orders (Shopping Cart)
    public function bulkStore(Request $request)
    {
        Log::info('Bulk store started', ['payment_method' => $request->payment_method]);
        $user = $request->user();
        $items = $request->input('items', []);

        // 1. If no items in request, check session cart
        if (empty($items) && session()->has('cart')) {
            $items = session('cart');
        }

        // 2. If it's the "one bundle to many recipients" format (from bulk page)
        if (empty($items) && $request->has('bundle_id') && $request->has('phone_numbers')) {
            $bundle = Bundle::findOrFail($request->bundle_id);
            $phones = is_array($request->phone_numbers) ? $request->phone_numbers : explode(',', $request->phone_numbers);

            foreach ($phones as $phone) {
                if (empty(trim($phone)))
                    continue;
                $items[] = [
                    'bundle_id' => $bundle->id,
                    'recipient_phone' => trim($phone)
                ];
            }
        }

        if (empty($items)) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Your cart is empty or no valid items provided.'], 422);
            }
            return back()->with('error', 'Your cart is empty or no valid items provided.');
        }

        // Calculate total cost
        $totalCost = 0;
        $orderData = [];

        foreach ($items as $item) {
            $bundle = Bundle::findOrFail($item['bundle_id']);
            $price = $this->getPriceForUser($bundle, $user);
            $totalCost += $price;

            $orderData[] = [
                'bundle' => $bundle,
                'recipient_phone' => $item['recipient_phone'],
                'price' => $price
            ];
        }

        if (!in_array($request->payment_method, ['paystack', 'momo', 'transfer', 'wallet'])) {
            return back()->with('error', 'Invalid payment method selected.');
        }

        $allSettings = Setting::whereIn('key', ['enable_paystack', 'enable_momo_deposits', 'enable_manual_transfer'])->get()->pluck('value', 'key');

        if ($request->payment_method === 'paystack' && ($allSettings['enable_paystack'] ?? '1') !== '1') {
            return back()->with('error', 'Paystack gateway is currently disabled.');
        }
        if ($request->payment_method === 'momo' && ($allSettings['enable_momo_deposits'] ?? '1') !== '1') {
            return back()->with('error', 'MOMO payments are currently disabled.');
        }
        if ($request->payment_method === 'transfer' && ($allSettings['enable_manual_transfer'] ?? '1') !== '1') {
            return back()->with('error', 'Manual bank transfers are currently disabled.');
        }

        $isPaystack = in_array($request->payment_method, ['paystack', 'momo']);

        if ($request->payment_method === 'wallet' && $user->wallet_balance < $totalCost) {
            $msg = "Insufficient wallet balance. Total: GHS " . number_format($totalCost, 2);
            return back()->with('error', $msg);
        }

        // Calculate Charge if Paystack/MOMO
        $charge = 0;
        if ($isPaystack) {
            $settings = Setting::whereIn('key', ['charge_type', 'charge_value'])->get()->pluck('value', 'key');
            $chargeType = $settings['charge_type'] ?? 'percentage';
            $chargeValue = (float) ($settings['charge_value'] ?? 0);
            $charge = $chargeType === 'percentage' ? ($totalCost * ($chargeValue / 100)) : $chargeValue;
        }

        $orders = DB::transaction(function () use ($user, $totalCost, $orderData, $request, $isPaystack) {
            $status = 'pending';
            if ($isPaystack)
                $status = 'pending_payment';
            if ($request->payment_method === 'transfer')
                $status = 'awaiting_transfer';

            if ($request->payment_method === 'wallet') {
                $user->decrement('wallet_balance', $totalCost);
                $user->transactions()->create([
                    'amount' => $totalCost,
                    'type' => 'debit',
                    'reference' => 'TRX-ORD-' . Str::uuid(),
                    'status' => 'success',
                    'description' => "Order payment from wallet",
                ]);
            }

            $createdOrders = [];
            foreach ($orderData as $data) {
                $order = Order::create([
                    'user_id' => $user->id,
                    'bundle_id' => $data['bundle']->id,
                    'recipient_phone' => $data['recipient_phone'],
                    'cost' => $data['price'],
                    'cost_price' => $data['bundle']->cost_price ?? 0,
                    'status' => $status,
                    'reference' => 'ORD-' . Str::uuid(),
                ]);

                if ($request->payment_method === 'wallet') {
                    $order->complete(['method' => 'wallet', 'auto_completed' => true]);
                }

                $createdOrders[] = $order;
            }
            return $createdOrders;
        });

        // Clear cart
        session()->forget('cart');

        if ($isPaystack) {
            $orderIds = collect($orders)->pluck('id')->toArray();
            $initData = [
                'amount' => $totalCost + $charge,
                'email' => $user->email,
                'method' => $request->payment_method, // 'paystack' or 'momo'
                'metadata' => [
                    'order_ids' => $orderIds,
                    'is_direct_order' => true,
                    'base_amount' => $totalCost,
                    'charge' => $charge
                ]
            ];

            if ($request->expectsJson() || $request->is('api/*')) {
                // Initialize payment via PaystackController logic or internal call
                $paystackRequest = new Request($initData);
                $paystackResponse = app(\App\Http\Controllers\PaystackController::class)->initializePayment($paystackRequest);
                return $paystackResponse;
            }

            return redirect()->route('paystack.initialize', $initData);
        }

        if ($request->payment_method === 'transfer') {
            return redirect()->route('orders.index')->with('success', 'Order submitted. Please upload proof of payment in the Finance Hub to complete processing.');
        }

        foreach ($orders as $order) {
            ProcessOrder::dispatch($order);
        }

        return redirect()->route('orders.index')->with('success', count($orders) . ' orders placed successfully.');

        session()->forget('cart');
        return redirect()->route('orders.index')->with('success', count($orders) . ' orders placed successfully.');
    }

    private function getPriceForUser($bundle, $user)
    {
        if ($user && $user->role && $user->role !== 'user' && !empty($bundle->role_prices)) {
            $prices = is_string($bundle->role_prices) ? json_decode($bundle->role_prices, true) : $bundle->role_prices;
            if (isset($prices[$user->role])) {
                return $prices[$user->role];
            }
        }
        return $bundle->price;
    }
}
