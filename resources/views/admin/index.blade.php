@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
    <div class="space-y-8 pb-12 animate-in fade-in slide-in-from-bottom-4 duration-700">
        {{-- Header Section --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-indigo-500/10 flex items-center justify-center text-indigo-500 ring-1 ring-indigo-500/20">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-3xl font-bold tracking-tight text-blue-900 dark:text-white">Admin Dashboard</h2>
                    <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Platform overview and real-time business metrics.</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <div class="px-4 py-2 bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 rounded-xl shadow-sm text-[10px] font-bold uppercase tracking-widest text-slate-500 dark:text-slate-500 flex items-center gap-2">
                    <div class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></div>
                    System Online: {{ now()->format('M d, Y') }}
                </div>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-4">
            @php
                $stats = [
                    ['label' => "Total Revenue", 'value' => "GHS " . number_format($todayRevenue ?? 0, 2), 'icon' => 'banknotes', 'color' => 'indigo', 'desc' => 'Daily revenue'],
                    ['label' => "Total Orders", 'value' => $todayOrders ?? 0, 'icon' => 'shopping-cart', 'color' => 'blue', 'desc' => 'Processed today'],
                    ['label' => "Data Usage", 'value' => ($todayDataGb ?? 0) . " GB", 'icon' => 'signal', 'color' => 'emerald', 'desc' => 'Total data delivered'],
                    ['label' => "Total Agents", 'value' => $totalAgents ?? 0, 'icon' => 'users', 'color' => 'amber', 'desc' => 'Active sales partners'],
                ];

                $iconPaths = [
                    'banknotes' => 'M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z',
                    'shopping-cart' => 'M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 0a2 2 0 100 4 2 2 0 000-4z',
                    'signal' => 'M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0',
                    'users' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z',
                ];
            @endphp

            @foreach($stats as $stat)
                <div class="bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 rounded-3xl p-6 shadow-sm hover:shadow-md transition-all group overflow-hidden relative">
                    <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-gradient-to-br from-{{ $stat['color'] }}-500/10 to-transparent rounded-full blur-2xl group-hover:scale-150 transition-transform duration-700"></div>
                    
                    <div class="flex items-center justify-between mb-6">
                        <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-{{ $stat['color'] }}-500 to-{{ $stat['color'] }}-600 text-white flex items-center justify-center transition-all group-hover:scale-110 shadow-lg shadow-{{ $stat['color'] }}-500/20">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="{{ $iconPaths[$stat['icon']] }}" />
                            </svg>
                        </div>
                    </div>
                    
                    <div class="relative z-10">
                        <h4 class="text-2xl font-black text-slate-900 dark:text-white">{{ $stat['value'] }}</h4>
                        <p class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest mt-1">{{ $stat['label'] }}</p>
                        <p class="text-[9px] text-slate-400 mt-3 italic">{{ $stat['desc'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="grid gap-6 lg:grid-cols-3">
            {{-- Revenue Overview --}}
            <div class="lg:col-span-2 bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 rounded-3xl p-8 shadow-sm">
                <div class="flex items-center justify-between mb-10">
                    <div>
                        <h4 class="text-xl font-bold text-slate-900 dark:text-white">Revenue Overview</h4>
                        <p class="text-[10px] text-slate-500 font-black uppercase tracking-widest mt-1">Monthly Revenue Performance Analysis</p>
                    </div>
                </div>
                <div class="h-[340px]">
                    <canvas id="salesChart"></canvas>
                </div>
            </div>

            {{-- Quick Command Center --}}
            <div class="bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 rounded-3xl p-8 shadow-sm flex flex-col">
                <h4 class="text-xl font-bold text-slate-900 dark:text-white mb-8">Quick Actions</h4>
                <div class="space-y-4 flex-1">
                    @foreach([
                        ['route' => 'admin.orders', 'label' => 'Manage Orders', 'desc' => 'Validating data orders', 'icon' => '1'],
                        ['route' => 'admin.deposits', 'label' => 'Manage Deposits', 'desc' => 'Confirm user funding', 'icon' => '2'],
                        ['route' => 'admin.api', 'label' => 'API Management', 'desc' => 'Monitor API connections', 'icon' => '3'],
                        ['route' => 'admin.notifications', 'label' => 'Send Notifications', 'desc' => 'Platform alerts', 'icon' => '4'],
                    ] as $action)
                        <a href="{{ route($action['route']) }}"
                            class="flex items-center gap-4 p-4 rounded-2xl bg-slate-50 dark:bg-slate-800/40 hover:bg-primary/5 dark:hover:bg-primary/10 transition-all border border-transparent hover:border-primary/20 group">
                            <div class="w-10 h-10 rounded-xl bg-white dark:bg-slate-900 shadow-sm flex items-center justify-center text-primary font-black text-sm group-hover:scale-105 transition-transform">
                                {{ $action['icon'] }}
                            </div>
                            <div class="min-w-0">
                                <p class="text-xs font-bold text-slate-900 dark:text-white block">{{ $action['label'] }}</p>
                                <p class="text-[9px] text-slate-500 dark:text-slate-500 uppercase tracking-tight mt-0.5 truncate">{{ $action['desc'] }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Log Stream --}}
        <div class="bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 rounded-3xl overflow-hidden shadow-sm">
            <div class="px-8 py-6 border-b border-slate-50 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/20 flex items-center justify-between">
                <div>
                    <h4 class="text-lg font-bold text-slate-900 dark:text-white">Recent Orders</h4>
                    <p class="text-[10px] text-slate-500 font-black uppercase tracking-widest mt-0.5">Real-time Order History</p>
                </div>
                <a href="{{ route('admin.orders') }}" class="text-[10px] font-bold text-primary uppercase tracking-widest hover:underline">Full Feed</a>
            </div>

            <div class="overflow-x-auto font-medium">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-slate-50 dark:bg-slate-800/50 border-b border-slate-100 dark:border-slate-800">
                        <tr>
                            <th class="px-6 py-4 text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">Reference</th>
                            <th class="px-6 py-4 text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">User</th>
                            <th class="px-6 py-4 text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">Bundle</th>
                            <th class="px-6 py-4 text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest text-right">Amount</th>
                            <th class="px-6 py-4 text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50 dark:divide-slate-800">
                        @forelse($recentOrders as $order)
                            <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-colors group">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex flex-col">
                                        <span class="text-sm font-black text-primary font-mono">#{{ substr($order->reference, 0, 8) }}</span>
                                        <span class="text-[9px] text-slate-400 dark:text-slate-600 font-bold uppercase tracking-tighter">{{ $order->created_at->diffForHumans() }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <div class="w-6 h-6 rounded-md bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-[10px] font-bold text-slate-500">
                                            {{ strtoupper(substr($order->user->name, 0, 1)) }}
                                        </div>
                                        <span class="text-xs font-bold text-slate-900 dark:text-white truncate max-w-[120px]">{{ $order->user->name }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <span class="px-1.5 py-0.5 rounded text-[8px] font-black bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 uppercase">
                                            {{ $order->bundle->network }}
                                        </span>
                                        <span class="text-xs font-bold text-slate-500 dark:text-slate-400">{{ $order->bundle->name }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <span class="text-sm font-black text-slate-900 dark:text-white">GHS {{ number_format($order->cost, 2) }}</span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex px-2 py-0.5 rounded-lg text-[10px] font-bold uppercase tracking-tight
                                        {{ $order->status === 'completed' ? 'bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600' : 
                                           ($order->status === 'failed' ? 'bg-rose-50 dark:bg-rose-900/20 text-rose-600' : 'bg-amber-50 dark:bg-amber-900/20 text-amber-600') }}">
                                         {{ $order->status === 'completed' ? 'Delivered' : 
                                            ($order->status === 'failed' ? 'Failed' : ($order->status === 'pending' ? 'Validating' : ucfirst($order->status))) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="px-6 py-20 text-center text-slate-400 dark:text-slate-700 italic">No orders found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const ctx = document.getElementById('salesChart').getContext('2d');
            const isDark = document.documentElement.classList.contains('dark');
            
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($chartData['labels'] ?? []) !!},
                    datasets: [{
                        label: 'Revenue (GHS)',
                        data: {!! json_encode($chartData['values'] ?? []) !!},
                        borderColor: '#4f46e5',
                        borderWidth: 4,
                        backgroundColor: (context) => {
                            const chart = context.chart;
                            const {ctx, canvas, chartArea} = chart;
                            if (!chartArea) return null;
                            const gradient = ctx.createLinearGradient(0, chartArea.bottom, 0, chartArea.top);
                            gradient.addColorStop(0, 'rgba(79, 70, 229, 0)');
                            gradient.addColorStop(1, 'rgba(79, 70, 229, 0.15)');
                            return gradient;
                        },
                        fill: true,
                        tension: 0.4,
                        pointRadius: 0,
                        pointHoverRadius: 8,
                        pointHoverBackgroundColor: '#4f46e5',
                        pointHoverBorderColor: '#fff',
                        pointHoverBorderWidth: 4,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: {
                        intersect: false,
                        mode: 'index',
                    },
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#1e293b',
                            titleFont: { family: 'Inter', size: 12, weight: 'bold' },
                            bodyFont: { family: 'Inter', size: 14, weight: '900' },
                            padding: 12,
                            cornerRadius: 12,
                            displayColors: false,
                        }
                    },
                    scales: {
                        y: {
                            grid: { color: isDark ? 'rgba(255, 255, 255, 0.05)' : 'rgba(0, 0, 0, 0.05)', drawBorder: false },
                            ticks: { 
                                color: '#94a3b8', 
                                font: { family: 'Inter', weight: 'bold', size: 10 },
                                callback: (v) => 'GHS ' + v
                            }
                        },
                        x: {
                            grid: { display: false },
                            ticks: { color: '#94a3b8', font: { family: 'Inter', weight: 'bold', size: 10 } }
                        }
                    }
                }
            });
        </script>
    @endpush
@endsection