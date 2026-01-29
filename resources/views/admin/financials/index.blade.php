@extends('layouts.admin')

@section('title', 'Financial Reports')

@section('content')
    <div class="space-y-6 pb-12 animate-in fade-in slide-in-from-bottom-4 duration-700">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-3xl font-bold tracking-tight text-slate-900 dark:text-white">Financial Reports</h2>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">System-wide financial statistics and revenue
                    analysis.
                </p>
            </div>
            <div
                class="flex items-center gap-2 bg-emerald-50 dark:bg-emerald-900/20 px-3 py-1.5 rounded-full border border-emerald-100 dark:border-emerald-800/50">
                <div class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></div>
                <span class="text-[10px] font-bold uppercase tracking-wider text-emerald-700 dark:text-emerald-400">Live
                    Sync</span>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid gap-6 md:grid-cols-3">
            <!-- Total Revenue -->
            <div
                class="relative overflow-hidden bg-slate-900 border border-slate-800 rounded-3xl shadow-lg shadow-slate-900/10 group p-8">
                <div
                    class="absolute -right-4 -bottom-4 w-32 h-32 bg-primary/20 rounded-full blur-3xl group-hover:scale-150 transition-transform duration-700">
                </div>
                <div class="relative z-10">
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">Total Revenue</p>
                    <h3 class="text-3xl font-black text-white mb-4">GHC {{ number_format($stats['total_revenue'], 2) }}</h3>
                    <div
                        class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-emerald-500/10 text-emerald-400 text-[10px] font-bold uppercase">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M5 10l7-7 7 7M5 14l7 7 7-7" stroke-width="3"></path>
                        </svg>
                        Gross Revenue
                    </div>
                </div>
            </div>

            <!-- Total Expenses -->
            <div
                class="relative overflow-hidden bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 rounded-3xl shadow-sm hover:shadow-md transition-all group p-8">
                <div
                    class="absolute -right-4 -bottom-4 w-32 h-32 bg-rose-500/10 rounded-full blur-3xl group-hover:scale-150 transition-transform duration-700">
                </div>
                <div class="relative z-10">
                    <p class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-2">
                        Operating Expenses</p>
                    <h3 class="text-3xl font-black text-slate-900 dark:text-white mb-4">GHC
                        {{ number_format($stats['total_expenses'], 2) }}
                    </h3>
                    <div
                        class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-rose-500/10 text-rose-600 dark:text-rose-400 text-[10px] font-bold uppercase">
                        Operating Cost
                    </div>
                </div>
            </div>

            <!-- Net Profit -->
            <div
                class="relative overflow-hidden bg-gradient-to-br from-emerald-600 to-emerald-700 dark:from-emerald-500 dark:to-emerald-600 rounded-3xl shadow-lg shadow-emerald-500/20 group p-8">
                <div
                    class="absolute -right-4 -bottom-4 w-32 h-32 bg-white/10 rounded-full blur-3xl group-hover:scale-150 transition-transform duration-700">
                </div>
                <div class="relative z-10">
                    <p class="text-[10px] font-bold text-emerald-100 uppercase tracking-widest mb-2">Net Profit</p>
                    <h3 class="text-3xl font-black text-white mb-4">GHC {{ number_format($stats['net_profit'], 2) }}</h3>
                    <p class="text-[10px] text-emerald-100/70 font-bold uppercase tracking-tighter">Performance</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Monthly Analysis -->
    <div
        class="bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 rounded-3xl overflow-hidden shadow-sm">
        <div
            class="px-8 py-6 border-b border-slate-50 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/20 flex items-center justify-between">
            <div>
                <h3 class="text-xl font-bold text-slate-900 dark:text-white">Monthly Revenue Breakdown</h3>
                <p class="text-[10px] text-slate-500 dark:text-slate-500 font-bold uppercase tracking-widest mt-0.5">
                    Historical Data</p>
            </div>
        </div>


        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-50 dark:bg-slate-800/50 border-b border-slate-100 dark:border-slate-800">
                    <tr>
                        <th
                            class="px-6 py-4 text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">
                            Month / Period</th>
                        <th
                            class="px-6 py-4 text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest text-right">
                            Revenue (GHS)</th>
                        <th
                            class="px-6 py-4 text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest text-right">
                            Trend</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 dark:divide-slate-800">
                    @forelse($monthlyData as $data)
                        <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-colors group">
                            <td class="px-6 py-5">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-10 h-10 rounded-xl bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-400 dark:text-slate-500">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                    </div>
                                    <span class="font-bold text-sm text-slate-900 dark:text-white">
                                        {{ \Carbon\Carbon::parse($data->month . '-01')->format('F Y') }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-5 text-right">
                                <span class="text-base font-black text-slate-900 dark:text-white">
                                    {{ number_format($data->revenue, 2) }}
                                </span>
                            </td>
                            <td class="px-6 py-5 text-right">
                                <div
                                    class="flex items-center justify-end gap-2 text-emerald-500 font-black text-[10px] uppercase tracking-tighter">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path d="M5 10l7-7 7 7" stroke-width="3"></path>
                                    </svg>
                                    Growth
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-24 text-center text-slate-400 dark:text-slate-700">
                                <svg class="w-16 h-16 mx-auto mb-4 opacity-50" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M9 17v-2m3 2v-4m3 2v-6m-8-2h10a2 2 0 012 2v12a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2z">
                                    </path>
                                </svg>
                                <p class="font-bold text-sm uppercase tracking-widest italic">Insufficient Data</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    </div>
@endsection