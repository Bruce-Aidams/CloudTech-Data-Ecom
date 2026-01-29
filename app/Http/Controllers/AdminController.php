<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    /**
     * Get database-agnostic date format for grouping
     */
    private function getDateFormat($format)
    {
        $driver = DB::connection()->getDriverName();

        if ($driver === 'sqlite') {
            return "strftime('$format', created_at)";
        }

        // MySQL/PostgreSQL
        return "DATE_FORMAT(created_at, '$format')";
    }

    public function index(Request $request)
    {
        $todayRange = [now()->startOfDay(), now()->endOfDay()];

        // 1. Today's Orders
        $todayOrders = Order::whereBetween('created_at', $todayRange)->count();

        // 2. Today's Revenue
        $todayRevenue = Order::where('status', 'completed')->whereBetween('created_at', $todayRange)->sum('cost');

        // 3. Today's Profit
        $todayProfit = Order::where('status', 'completed')->whereBetween('created_at', $todayRange)->sum('profit');

        // 4. Data Delivered Today (GB)
        $todayCompletedOrders = Order::with('bundle')->where('status', 'completed')->whereBetween('created_at', $todayRange)->get();
        $todayDataGb = 0;
        foreach ($todayCompletedOrders as $order) {
            $todayDataGb += $this->parseDataAmountToGB($order->bundle?->data_amount ?? '0MB');
        }
        $todayDataGb = round($todayDataGb, 2);

        // 5. Total Agents
        $totalAgents = User::whereIn('role', ['agent', 'super_agent', 'dealer'])->count();

        // 6. Today's Topups
        $todayTopups = Transaction::where('type', 'credit')
            ->where('status', 'success')
            ->whereBetween('created_at', $todayRange)
            ->sum('amount');

        // 7. Total Agent Balance
        $totalAgentBalance = User::whereIn('role', ['agent', 'super_agent', 'dealer'])->sum('wallet_balance');

        // 8. Pending Data (GB)
        $pendingOrders = Order::with('bundle')->where('status', 'pending')->get();
        $pendingDataGb = 0;
        foreach ($pendingOrders as $order) {
            $pendingDataGb += $this->parseDataAmountToGB($order->bundle?->data_amount ?? '0MB');
        }
        $pendingDataGb = round($pendingDataGb, 2);

        // Additional data for existing view sections
        $totalUsers = User::where('role', 'user')->count();
        $pendingOrdersCount = Order::where('status', 'pending')->count();
        $totalRevenueAllTime = Order::where('status', 'completed')->sum('cost');
        $totalProfitAllTime = Order::where('status', 'completed')->sum('profit');
        $recentOrders = Order::with(['user', 'bundle'])->latest()->take(5)->get();

        // Monthly Revenue (Last 6 Months) for Chart
        $monthlyRevenueRaw = Order::selectRaw('SUM(cost) as total, ' . $this->getDateFormat('%Y-%m') . ' as month')
            ->where('status', 'completed')
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $monthlyRevenue = [
            'labels' => $monthlyRevenueRaw->pluck('month'),
            'data' => $monthlyRevenueRaw->pluck('total')
        ];

        // Top Performing Agents
        $topAgents = User::whereIn('role', ['agent', 'super_agent', 'dealer'])
            ->withCount([
                'orders as total_orders',
                'orders as completed_orders' => function ($query) {
                    $query->where('status', 'completed');
                }
            ])
            ->withSum([
                'orders as total_spent' => function ($query) {
                    $query->where('status', 'completed');
                }
            ], 'cost')
            ->orderBy('total_spent', 'desc')
            ->take(10)
            ->get();

        return view('admin.index', compact(
            'todayRevenue',
            'todayOrders',
            'todayDataGb',
            'totalAgents',
            'todayTopups',
            'totalAgentBalance',
            'pendingDataGb',
            'totalUsers',
            'pendingOrdersCount',
            'totalRevenueAllTime',
            'totalProfitAllTime',
            'recentOrders',
            'monthlyRevenue',
            'topAgents'
        ));
    }

    public function getPublicSettings()
    {
        $keys = [
            'site_name',
            'support_email',
            'min_payment',
            'max_payment',
            'charge_type',
            'charge_value',
            'paystack_public',
            'bank_name',
            'bank_account_name',
            'bank_account_number',
            'enable_paystack',
            'enable_momo_deposits',
            'enable_manual_transfer'
        ];
        $settings = \App\Models\Setting::whereIn('key', $keys)->get()->pluck('value', 'key');

        // Ensure paystack_public is present, fallback to env if missing in DB
        if (!isset($settings['paystack_public']) || empty($settings['paystack_public'])) {
            $settings['paystack_public'] = env('PAYSTACK_PUBLIC_KEY');
        }

        return $settings;
    }


    public function getSettings()
    {
        $settings = \App\Models\Setting::all()->pluck('value', 'key');
        return view('admin.settings', compact('settings'));
    }

    public function updateSettings(Request $request)
    {
        $data = $request->validate([
            'settings' => 'present|array'
        ]);

        foreach ($data['settings'] as $key => $value) {
            \App\Models\Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        return response()->json(['message' => 'Settings updated']);
    }

    public function transactions(Request $request)
    {
        $startDate = $request->input('start_date', now()->subDays(30));
        $endDate = $request->input('end_date', now());
        $range = [$startDate, $endDate];

        $totalRevenue = Order::where('status', 'completed')->sum('cost');
        $totalExpenses = Order::where('status', 'completed')->sum('cost_price'); // Assuming cost_price exists, or 0 if not
        $netProfit = Order::where('status', 'completed')->sum('profit');

        $stats = [
            'total_revenue' => $totalRevenue,
            'total_expenses' => $totalExpenses, // Or calculate explicitly if needed
            'net_profit' => $netProfit
        ];

        // Monthly Data for the table
        $monthlyData = Order::selectRaw($this->getDateFormat('%Y-%m') . ' as month, SUM(cost) as revenue')
            ->where('status', 'completed')
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month', 'desc')
            ->get();

        return view('admin.financials.index', compact('stats', 'monthlyData'));
    }

    public function analytics(Request $request)
    {
        $startDate = $request->input('start_date', now()->subDays(30)->toDateString());
        $endDate = $request->input('end_date', now()->toDateString());
        $range = [$startDate . ' 00:00:00', $endDate . ' 23:59:59'];

        // 1. Total Revenue (sum of completed orders in range)
        $totalRevenue = Order::where('status', 'completed')->whereBetween('created_at', $range)->sum('cost');
        $totalProfit = Order::where('status', 'completed')->whereBetween('created_at', $range)->sum('profit');

        // 2. Total Users (all time or in range?) - Let's keep all time for counter but maybe show new users in and
        $totalUsers = User::where('role', 'user')->count();
        $newUsers = User::where('role', 'user')->whereBetween('created_at', $range)->count();

        // 3. Total Orders in range
        $totalOrders = Order::whereBetween('created_at', $range)->count();

        // 4. Pending Deposits (all time)
        $pendingDeposits = \App\Models\Deposit::where('status', 'pending')->count();

        // 5. Recent Orders (last 5)
        $recentOrders = Order::with('user')->latest()->take(5)->get();

        // Count Pending Orders
        $pendingOrders = Order::where('status', 'pending')->count();

        // 6. Monthly Revenue (Last 6 Months) for Chart
        $monthlyRevenue = Order::selectRaw('SUM(cost) as total, ' . $this->getDateFormat('%Y-%m') . ' as month')
            ->where('status', 'completed')
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // 7. Order Status Distribution in range
        $orderStatus = Order::whereBetween('created_at', $range)
            ->selectRaw('count(*) as count, status')
            ->groupBy('status')
            ->get();

        // 8. Network Distribution (MTN, Vodafone, etc.) in range
        $networkDistribution = Order::join('bundles', 'orders.bundle_id', '=', 'bundles.id')
            ->whereBetween('orders.created_at', $range)
            ->selectRaw('count(orders.id) as count, bundles.network')
            ->groupBy('bundles.network')
            ->get();

        // 9. Transaction Velocity in range
        $velocity = Order::whereBetween('created_at', $range)
            ->selectRaw('count(*) as count, ' . $this->getDateFormat('%Y-%m-%d') . ' as date')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Calculate growth (mock logic for now or simple comparison)
        $revenueGrowth = 0; // consistent with no previous data
        $usersGrowth = 0;

        // Analytics Users (All Roles)
        $roleFilter = $request->input('role');

        $usersQuery = User::query()
            ->withCount([
                'orders as total_orders',
                'orders as completed_orders' => function ($query) {
                    $query->where('status', 'completed');
                }
            ])
            ->withSum([
                'orders as total_spent' => function ($query) {
                    $query->where('status', 'completed');
                }
            ], 'cost')
            ->withSum('commissions as total_commission_earned', 'amount');

        if ($roleFilter && $roleFilter !== 'all') {
            $usersQuery->where('role', $roleFilter);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $usersQuery->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%")
                    ->orWhere('phone', 'like', "%$search%");
            });
        }

        $resellers = $usersQuery->latest()->paginate(50)->withQueryString();

        return view('admin.analytics.index', compact(
            'totalRevenue',
            'totalProfit',
            'totalUsers',
            'newUsers',
            'totalOrders',
            'pendingDeposits',
            'pendingOrders',
            'recentOrders',
            'resellers', // Using same variable name to avoid view errors, now contains all roles
            'monthlyRevenue',
            'orderStatus',
            'networkDistribution',
            'velocity',
            'revenueGrowth',
            'usersGrowth'
        ));
    }

    public function getSalesReport(Request $request)
    {
        $startDate = $request->input('start_date', now()->subDays(30)->toDateString());
        $endDate = $request->input('end_date', now()->toDateString());
        $range = [$startDate . ' 00:00:00', $endDate . ' 23:59:59'];

        $orders = Order::with(['user', 'bundle'])
            ->where('status', 'completed')
            ->whereBetween('created_at', $range)
            ->get();

        $summary = [
            'total_sales' => $orders->sum('cost'),
            'total_cost' => $orders->sum('cost_price'),
            'total_profit' => $orders->sum('profit'),
            'order_count' => $orders->count(),
        ];

        return response()->json([
            'summary' => $summary,
            'orders' => $orders
        ]);
    }


    // API Provider Management
    public function getApiProviders()
    {
        return \App\Models\ApiProvider::latest()->get();
    }

    public function storeApiProvider(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'base_url' => 'required|url',
            'api_key' => 'nullable|string',
            'secret_key' => 'nullable|string',
            'is_active' => 'required|boolean'
        ]);

        $provider = \App\Models\ApiProvider::create($data);
        return response()->json($provider, 201);
    }

    public function updateApiProvider(Request $request, $id)
    {
        $provider = \App\Models\ApiProvider::findOrFail($id);
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'base_url' => 'required|url',
            'api_key' => 'nullable|string',
            'secret_key' => 'nullable|string',
            'is_active' => 'required|boolean'
        ]);

        $provider->update($data);
        return response()->json($provider);
    }

    public function deleteApiProvider($id)
    {
        $provider = \App\Models\ApiProvider::findOrFail($id);
        $provider->delete();
        return response()->json(['message' => 'Provider deleted']);
    }

    public function getApiLogs()
    {
        return \App\Models\ApiLog::with('provider')->latest()->paginate(50);
    }


    // ... existing code ...

    public function getDashboardStats(Request $request)
    {
        $todayRange = [now()->startOfDay(), now()->endOfDay()];

        // 1. Today's Orders
        $todayOrders = Order::whereBetween('created_at', $todayRange)->count();

        // 2. Today's Revenue
        $todayRevenue = Order::where('status', 'completed')->whereBetween('created_at', $todayRange)->sum('cost');

        // 3. Total Data Delivered (GB) - Approximation
        // Fetch all completed orders for today with their bundles
        $todayCompletedOrders = Order::with('bundle')->where('status', 'completed')->whereBetween('created_at', $todayRange)->get();
        $todayDataGB = 0;
        foreach ($todayCompletedOrders as $order) {
            $todayDataGB += $this->parseDataAmountToGB($order->bundle?->data_amount ?? '0MB');
        }

        // 4. Total Agents (Assuming roles other than 'user' and 'admin' are agents, or explicitly 'agent', 'super_agent', 'dealer')
        $totalAgents = User::whereIn('role', ['agent', 'super_agent', 'dealer'])->count();

        // 5. Total Wallet Topups Today
        $todayTopups = Transaction::where('type', 'credit')
            ->where('status', 'success')
            ->whereBetween('created_at', $todayRange)
            ->sum('amount');

        // 6. Sum of All Agent Account Balance
        $totalAgentBalance = User::whereIn('role', ['agent', 'super_agent', 'dealer'])->sum('wallet_balance');

        // 7. Pending Packages in GB (Orders pending)
        $pendingOrders = Order::with('bundle')->where('status', 'pending')->get();
        $pendingDataGB = 0;
        foreach ($pendingOrders as $order) {
            $pendingDataGB += $this->parseDataAmountToGB($order->bundle?->data_amount ?? '0MB');
        }

        // 8. Sales Analytics (Last 14 days) used for Chart
        $dailySales = Order::selectRaw('DATE(created_at) as date, SUM(cost) as total_revenue, COUNT(*) as total_orders')
            ->where('status', 'completed')
            ->where('created_at', '>=', now()->subDays(14))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return response()->json([
            'today_orders' => $todayOrders,
            'today_revenue' => $todayRevenue,
            'today_data_gb' => round($todayDataGB, 2),
            'total_agents' => $totalAgents,
            'today_topups' => $todayTopups,
            'total_agent_balance' => $totalAgentBalance,
            'pending_data_gb' => round($pendingDataGB, 2),
            'daily_sales' => $dailySales,
        ]);
    }

    private function parseDataAmountToGB($dataAmount)
    {
        $dataAmount = strtoupper(trim($dataAmount));
        $amount = (float) filter_var($dataAmount, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

        if (strpos($dataAmount, 'GB') !== false) {
            return $amount;
        } elseif (strpos($dataAmount, 'MB') !== false) {
            return $amount / 1024;
        } elseif (strpos($dataAmount, 'TB') !== false) {
            return $amount * 1024;
        }
        return 0;
    }

    public function getAgentStats(Request $request)
    {
        // Comprehensive order tracking for all agents + Individual performance
        $agents = User::whereIn('role', ['agent', 'super_agent', 'dealer'])
            ->withCount([
                'orders as total_orders',
                'orders as completed_orders' => function ($query) {
                    $query->where('status', 'completed');
                }
            ])
            ->withSum([
                'orders as total_spent' => function ($query) {
                    $query->where('status', 'completed');
                }
            ], 'cost')
            ->orderBy('total_spent', 'desc')
            ->paginate(20);

        return response()->json($agents);
    }

    public function getLoginActivities(Request $request)
    {
        $query = \App\Models\LoginActivity::with('user');

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($u) use ($search) {
                    $u->where('name', 'like', "%$search%")
                        ->orWhere('email', 'like', "%$search%");
                })
                    ->orWhere('ip_address', 'like', "%$search%");
            });
        }

        return $query->latest()->paginate(20);
    }

    public function deleteOldOrders(Request $request)
    {
        $request->validate([
            'days' => 'required|integer|min:1',
        ]);

        $days = $request->days;
        $count = Order::where('created_at', '<', now()->subDays($days))->delete();

        return response()->json(['message' => "Deleted $count old orders."]);
    }

    public function adjustWallet(Request $request, $id)
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
                $user->wallet_balance += $amount;
            } else {
                if ($user->wallet_balance < $amount) {
                    return response()->json(['message' => 'Insufficient wallet balance'], 400);
                }
                $user->wallet_balance -= $amount;
            }
            $user->save();

            Transaction::create([
                'user_id' => $user->id,
                'type' => $request->type,
                'amount' => $amount,
                'status' => 'success',
                'reference' => 'ADJ-' . strtoupper(bin2hex(random_bytes(4))),
                'description' => 'Manual Adjustment: ' . $request->note,
            ]);

            DB::commit();
            return response()->json(['message' => 'Wallet adjusted successfully', 'new_balance' => $user->wallet_balance]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Failed to adjust wallet'], 500);
        }
    }
}
