@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <div class="space-y-6 animate-in fade-in slide-in-from-bottom-4 duration-700">
        <div>
            <h2 class="text-3xl font-black tracking-tight text-slate-800">Dashboard</h2>
            <p class="text-muted-foreground">Overview of system performance and agent activities.</p>
        </div>

        {{-- Stats Grid (matching AdminStatsGrid.tsx) --}}
        <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
            {{-- Today's Revenue - Emerald Gradient --}}
            <div
                class="border-none text-white overflow-hidden relative group transition-all duration-300 hover:-translate-y-1 hover:shadow-xl bg-gradient-to-br from-emerald-500 to-teal-700 rounded-xl">
                <div
                    class="absolute top-0 right-0 p-4 opacity-10 scale-150 group-hover:scale-[2] group-hover:rotate-12 transition-transform duration-700">
                    <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                    </svg>
                </div>
                <div class="relative z-10">
                    <div class="flex flex-row items-center justify-between space-y-0 pb-2 p-6">
                        <h3 class="text-xs font-bold uppercase tracking-wider text-white/80">Today's Revenue</h3>
                        <div class="p-2 rounded-xl bg-white/20 backdrop-blur-md border border-white/20">
                            <svg class="h-4 w-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                            </svg>
                        </div>
                    </div>
                    <div class="px-6 pb-6">
                        <div class="text-2xl font-black tracking-tight">GHS
                            {{ number_format($stats['today_revenue'] ?? 0, 2) }}</div>
                    </div>
                </div>
            </div>

            {{-- Today's Orders - Blue Gradient --}}
            <div
                class="border-none text-white overflow-hidden relative group transition-all duration-300 hover:-translate-y-1 hover:shadow-xl bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl">
                <div
                    class="absolute top-0 right-0 p-4 opacity-10 scale-150 group-hover:scale-[2] group-hover:rotate-12 transition-transform duration-700">
                    <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <div class="relative z-10">
                    <div class="flex flex-row items-center justify-between space-y-0 pb-2 p-6">
                        <h3 class="text-xs font-bold uppercase tracking-wider text-white/80">Today's Orders</h3>
                        <div class="p-2 rounded-xl bg-white/20 backdrop-blur-md border border-white/20">
                            <svg class="h-4 w-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                    </div>
                    <div class="px-6 pb-6">
                        <div class="text-2xl font-black tracking-tight">{{ $stats['today_orders'] ?? 0 }}</div>
                    </div>
                </div>
            </div>

            {{-- Data Delivered Today - Purple Gradient --}}
            <div
                class="border-none text-white overflow-hidden relative group transition-all duration-300 hover:-translate-y-1 hover:shadow-xl bg-gradient-to-br from-violet-500 to-purple-700 rounded-xl">
                <div
                    class="absolute top-0 right-0 p-4 opacity-10 scale-150 group-hover:scale-[2] group-hover:rotate-12 transition-transform duration-700">
                    <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                    </svg>
                </div>
                <div class="relative z-10">
                    <div class="flex flex-row items-center justify-between space-y-0 pb-2 p-6">
                        <h3 class="text-xs font-bold uppercase tracking-wider text-white/80">Data Delivered Today</h3>
                        <div class="p-2 rounded-xl bg-white/20 backdrop-blur-md border border-white/20">
                            <svg class="h-4 w-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                            </svg>
                        </div>
                    </div>
                    <div class="px-6 pb-6">
                        <div class="text-2xl font-black tracking-tight">{{ $stats['today_data_gb'] ?? 0 }} GB</div>
                    </div>
                </div>
            </div>

            {{-- Total Agents - Orange Gradient --}}
            <div
                class="border-none text-white overflow-hidden relative group transition-all duration-300 hover:-translate-y-1 hover:shadow-xl bg-gradient-to-br from-orange-500 to-amber-600 rounded-xl">
                <div
                    class="absolute top-0 right-0 p-4 opacity-10 scale-150 group-hover:scale-[2] group-hover:rotate-12 transition-transform duration-700">
                    <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
                <div class="relative z-10">
                    <div class="flex flex-row items-center justify-between space-y-0 pb-2 p-6">
                        <h3 class="text-xs font-bold uppercase tracking-wider text-white/80">Total Agents</h3>
                        <div class="p-2 rounded-xl bg-white/20 backdrop-blur-md border border-white/20">
                            <svg class="h-4 w-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                    </div>
                    <div class="px-6 pb-6">
                        <div class="text-2xl font-black tracking-tight">{{ $stats['total_agents'] ?? 0 }}</div>
                    </div>
                </div>
            </div>

            {{-- Today's Topups - Indigo Gradient --}}
            <div
                class="border-none text-white overflow-hidden relative group transition-all duration-300 hover:-translate-y-1 hover:shadow-xl bg-gradient-to-br from-indigo-500 to-blue-600 rounded-xl">
                <div
                    class="absolute top-0 right-0 p-4 opacity-10 scale-150 group-hover:scale-[2] group-hover:rotate-12 transition-transform duration-700">
                    <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <div class="relative z-10">
                    <div class="flex flex-row items-center justify-between space-y-0 pb-2 p-6">
                        <h3 class="text-xs font-bold uppercase tracking-wider text-white/80">Today's Topups</h3>
                        <div class="p-2 rounded-xl bg-white/20 backdrop-blur-md border border-white/20">
                            <svg class="h-4 w-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                    </div>
                    <div class="px-6 pb-6">
                        <div class="text-2xl font-black tracking-tight">GHS
                            {{ number_format($stats['today_topups'] ?? 0, 2) }}</div>
                    </div>
                </div>
            </div>

            {{-- Agent Balances - Pink Gradient --}}
            <div
                class="border-none text-white overflow-hidden relative group transition-all duration-300 hover:-translate-y-1 hover:shadow-xl bg-gradient-to-br from-pink-500 to-rose-600 rounded-xl">
                <div
                    class="absolute top-0 right-0 p-4 opacity-10 scale-150 group-hover:scale-[2] group-hover:rotate-12 transition-transform duration-700">
                    <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                    </svg>
                </div>
                <div class="relative z-10">
                    <div class="flex flex-row items-center justify-between space-y-0 pb-2 p-6">
                        <h3 class="text-xs font-bold uppercase tracking-wider text-white/80">Agent Balances</h3>
                        <div class="p-2 rounded-xl bg-white/20 backdrop-blur-md border border-white/20">
                            <svg class="h-4 w-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                    </div>
                    <div class="px-6 pb-6">
                        <div class="text-2xl font-black tracking-tight">GHS
                            {{ number_format($stats['total_agent_balance'] ?? 0, 2) }}</div>
                    </div>
                </div>
            </div>

            {{-- Pending Data - Yellow Gradient --}}
            <div
                class="border-none text-white overflow-hidden relative group transition-all duration-300 hover:-translate-y-1 hover:shadow-xl bg-gradient-to-br from-amber-400 to-yellow-600 rounded-xl">
                <div
                    class="absolute top-0 right-0 p-4 opacity-10 scale-150 group-hover:scale-[2] group-hover:rotate-12 transition-transform duration-700">
                    <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01" />
                    </svg>
                </div>
                <div class="relative z-10">
                    <div class="flex flex-row items-center justify-between space-y-0 pb-2 p-6">
                        <h3 class="text-xs font-bold uppercase tracking-wider text-white/80">Validating Data</h3>
                        <div class="p-2 rounded-xl bg-white/20 backdrop-blur-md border border-white/20">
                            <svg class="h-4 w-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01" />
                            </svg>
                        </div>
                    </div>
                    <div class="px-6 pb-6">
                        <div class="text-2xl font-black tracking-tight">{{ $stats['pending_data_gb'] ?? 0 }} GB</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Charts Section --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 pb-6">
            {{-- Revenue Chart --}}
            <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 p-8 h-[400px] flex flex-col">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-xl font-black tracking-tight text-slate-900">Revenue Analytics</h3>
                        <p class="text-sm text-slate-400 font-bold uppercase tracking-wider">7 Day Performance</p>
                    </div>
                    <div class="p-2 bg-indigo-50 rounded-xl text-indigo-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z" />
                        </svg>
                    </div>
                </div>
                <div class="flex-1 relative w-full h-full">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>

            {{-- Order Volume Chart --}}
            <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 p-8 h-[400px] flex flex-col">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-xl font-black tracking-tight text-slate-900">Order Volume</h3>
                        <p class="text-sm text-slate-400 font-bold uppercase tracking-wider">Network Distribution</p>
                    </div>
                    <div class="p-2 bg-emerald-50 rounded-xl text-emerald-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>
                <div class="flex-1 relative w-full h-full">
                    <canvas id="ordersChart"></canvas>
                </div>
            </div>
        </div>

        {{-- Agent Performance Table (matching AgentPerformanceTable.tsx) --}}
        <div class="col-span-4 lg:col-span-4 border-none shadow-sm bg-white/50 backdrop-blur-xl rounded-xl">
            <div class="p-6">
                <h3 class="text-xl font-semibold">Top Performing Agents</h3>
            </div>
            <div class="px-6 pb-6">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b">
                                <th class="text-left py-3 px-4 font-medium text-sm text-muted-foreground">Agent</th>
                                <th class="text-left py-3 px-4 font-medium text-sm text-muted-foreground">Role</th>
                                <th class="text-left py-3 px-4 font-medium text-sm text-muted-foreground">Orders (Completed)
                                </th>
                                <th class="text-left py-3 px-4 font-medium text-sm text-muted-foreground">Total Volume</th>
                                <th class="text-right py-3 px-4 font-medium text-sm text-muted-foreground">Balance</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($agentStats as $agent)
                                <tr class="border-b hover:bg-slate-50/50 transition-colors">
                                    <td class="py-4 px-4">
                                        <div class="font-medium">{{ $agent->name }}</div>
                                        <div class="text-xs text-muted-foreground">{{ $agent->email }}</div>
                                    </td>
                                    <td class="py-4 px-4">
                                        <span
                                            class="inline-flex items-center rounded-md border px-2.5 py-0.5 text-xs font-semibold capitalize">{{ $agent->role }}</span>
                                    </td>
                                    <td class="py-4 px-4">
                                        {{ $agent->completed_orders ?? 0 }}
                                        <span class="text-muted-foreground text-xs">/ {{ $agent->total_orders ?? 0 }}</span>
                                    </td>
                                    <td class="py-4 px-4">
                                        GHS {{ number_format($agent->total_spent ?? 0, 2) }}
                                    </td>
                                    <td class="py-4 px-4 text-right font-bold">
                                        GHS {{ number_format($agent->wallet_balance ?? 0, 2) }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted-foreground h-24 py-4">No agents found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        // Charts initialized in a script tag to ensure DOM is ready
    });

    document.addEventListener('DOMContentLoaded', function() {
        // Revenue Chart
        const revenueCtx = document.getElementById('revenueChart').getContext('2d');
        const revenueGradient = revenueCtx.createLinearGradient(0, 0, 0, 400);
        revenueGradient.addColorStop(0, 'rgba(79, 70, 229, 0.4)');
        revenueGradient.addColorStop(1, 'rgba(79, 70, 229, 0)');

        new Chart(revenueCtx, {
            type: 'line',
            data: {
                labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                datasets: [{
                    label: 'Revenue (GHS)',
                    data: [1200, 1900, 3000, 5000, 2000, 3000, {{ $stats['today_revenue'] ?? 4500 }}],
                    borderColor: '#4f46e5',
                    backgroundColor: revenueGradient,
                    borderWidth: 3,
                    tension: 0.4,
                    fill: true,
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: '#4f46e5',
                    pointBorderWidth: 2,
                    pointRadius: 6,
                    pointHoverRadius: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#1e293b',
                        padding: 12,
                        titleFont: { family: 'Geist', size: 13 },
                        bodyFont: { family: 'Geist', size: 13 },
                        cornerRadius: 10,
                        displayColors: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: '#f1f5f9', borderDash: [5, 5] },
                        ticks: { font: { family: 'Geist', size: 11 }, color: '#94a3b8' }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { font: { family: 'Geist', size: 11 }, color: '#94a3b8' }
                    }
                }
            }
        });

        // Orders Chart
        const ordersCtx = document.getElementById('ordersChart').getContext('2d');
        new Chart(ordersCtx, {
            type: 'bar',
            data: {
                labels: ['MTN', 'Telecel', 'AT'],
                datasets: [{
                    label: 'Orders',
                    data: [65, 40, 25], // Mock data for distribution
                    backgroundColor: [
                        '#eab308', // MTN Yellow
                        '#ef4444', // Telecel Red
                        '#2563eb'  // AT Blue
                    ],
                    borderRadius: 10,
                    borderSkipped: false
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#1e293b',
                        padding: 12,
                        cornerRadius: 10,
                        titleFont: { family: 'Geist' },
                        bodyFont: { family: 'Geist' }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: '#f1f5f9', borderDash: [5, 5] },
                        ticks: { font: { family: 'Geist', size: 11 }, color: '#94a3b8' }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { font: { family: 'Geist', size: 11 }, color: '#94a3b8' }
                    }
                }
            }
        });
    });
</script>
@endpush