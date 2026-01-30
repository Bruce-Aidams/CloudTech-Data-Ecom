@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('content')
    <div class="space-y-4 md:space-y-8 pb-12 animate-in fade-in slide-in-from-bottom-4 duration-700">
        {{-- Header Context --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-3 md:gap-6">
            <div>
                <h2 class="text-xl md:text-3xl font-black tracking-tight text-slate-900 dark:text-white">Dashboard Overview
                </h2>
                <p
                    class="text-[9px] md:text-sm text-slate-500 dark:text-slate-400 mt-0.5 uppercase tracking-widest font-bold">
                    Status overview</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('transactions.index') }}"
                    class="h-9 md:h-11 px-3 md:px-6 flex-1 md:flex-none justify-center bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl text-slate-600 dark:text-slate-400 text-[8px] md:text-[10px] font-black uppercase tracking-widest flex items-center shadow-sm hover:border-primary transition-all active:scale-95">
                    History
                </a>
                <a href="{{ route('orders.new') }}"
                    class="h-9 md:h-11 px-3 md:px-6 flex-1 md:flex-none justify-center bg-primary text-white rounded-xl text-[8px] md:text-[10px] font-black uppercase tracking-widest flex items-center shadow-lg shadow-primary/20 hover:opacity-90 transition-all active:scale-95">
                    Buy Data
                </a>
            </div>
        </div>

        {{-- Pending Payment Verification --}}
        @if($pendingTransactions->isNotEmpty())
            <div class="space-y-3">
                @foreach($pendingTransactions as $pending)
                    <div
                        class="bg-amber-50 dark:bg-amber-900/10 border border-amber-200 dark:border-amber-800/50 p-4 md:p-6 rounded-2xl md:rounded-3xl flex flex-col md:flex-row md:items-center justify-between gap-4 animate-in slide-in-from-top-2 duration-500">
                        <div class="flex items-center gap-4">
                            <div
                                class="w-10 h-10 rounded-xl bg-amber-100 dark:bg-amber-900/30 text-amber-600 flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <h4
                                    class="text-[10px] md:text-xs font-black text-amber-900 dark:text-amber-400 uppercase tracking-widest">
                                    Awaiting Verification</h4>
                                <p class="text-[11px] md:text-sm text-amber-700 dark:text-amber-500/70 font-medium">Your top-up of
                                    ₵{{ number_format($pending->amount, 2) }} is pending. Reference: {{ $pending->reference }}</p>
                            </div>
                        </div>
                        <a href="{{ route('wallet.callback', ['reference' => $pending->reference]) }}"
                            class="h-10 md:h-12 px-6 bg-amber-600 text-white rounded-xl text-[10px] font-black uppercase tracking-[0.2em] shadow-lg shadow-amber-600/20 hover:bg-amber-700 transition-all flex items-center justify-center">
                            Verify Payment
                        </a>
                    </div>
                @endforeach
            </div>
        @endif

        {{-- Statistics & Actions --}}
        <div class="grid gap-3 md:gap-6 md:grid-cols-3">
            {{-- Account Status --}}
            <div
                class="bg-gradient-to-br from-emerald-600 via-emerald-500 to-teal-500 p-3 md:p-6 rounded-2xl md:rounded-[2.5rem] shadow-xl relative overflow-hidden group text-white">
                <div class="absolute top-0 right-0 w-24 h-24 bg-white/5 rounded-bl-full pointer-events-none"></div>
                <div class="flex items-center gap-4">
                    <div class="relative items-center justify-center flex shrink-0">
                        <div class="absolute inset-0 border-2 border-emerald-400/30 rounded-full animate-ping"></div>
                        <div
                            class="w-12 h-12 md:w-20 md:h-20 border-4 border-white/20 rounded-full flex items-center justify-center bg-white/10 backdrop-blur-md">
                            <span class="text-xs md:text-lg font-black text-white">100%</span>
                        </div>
                    </div>
                    <div>
                        <p class="text-[8px] md:text-[10px] font-black tracking-widest text-white/50 uppercase">Account
                            Status</p>
                        <h4 class="text-[11px] md:text-sm font-black text-white uppercase tracking-wider mt-1">Verified
                            Account</h4>
                        <div
                            class="mt-2 w-fit px-2 py-0.5 bg-white/20 text-[7px] md:text-[9px] font-black uppercase tracking-widest rounded-full">
                            Active</div>
                    </div>
                </div>
            </div>

            {{-- Wallet Balance --}}
            <div
                class="bg-white dark:bg-slate-900 p-4 md:p-6 rounded-2xl md:rounded-[2.5rem] border border-slate-200 dark:border-slate-800 shadow-sm hover:shadow-md transition-all duration-300">
                <div class="flex items-start justify-between mb-4">
                    <div>
                        <p class="text-[9px] md:text-xs font-black text-slate-400 uppercase tracking-widest">Wallet Balance
                        </p>
                        <h3 class="text-xl md:text-3xl font-black text-blue-600 dark:text-white mt-1 tabular-nums">
                            GH₵{{ number_format($balance, 2) }}</h3>
                    </div>
                    <div
                        class="w-8 h-8 md:w-10 md:h-10 rounded-xl bg-blue-50 dark:bg-blue-900/20 text-blue-600 flex items-center justify-center">
                        <svg class="w-4 h-4 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z">
                            </path>
                        </svg>
                    </div>
                </div>
                <a href="{{ route('wallet.index') }}"
                    class="w-full h-9 md:h-11 flex items-center justify-center gap-2 rounded-xl bg-blue-600 dark:bg-white text-white dark:text-slate-900 text-[8px] md:text-xs font-black uppercase tracking-widest hover:opacity-90 transition-all">
                    <span>Top up</span>
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path>
                    </svg>
                </a>
            </div>

            {{-- Quick Actions --}}
            <div
                class="bg-white dark:bg-slate-900 p-4 md:p-6 rounded-2xl md:rounded-[2.5rem] border border-slate-200 dark:border-slate-800 shadow-sm">
                <div class="flex items-center justify-between mb-3">
                    <h4 class="text-[10px] md:text-sm font-black text-slate-800 dark:text-white uppercase tracking-tight">
                        Quick Actions</h4>
                    <span
                        class="text-[7px] md:text-[9px] font-black bg-slate-100 dark:bg-slate-800 p-1.5 rounded-lg uppercase">Shortcuts</span>
                </div>
                <div class="grid grid-cols-2 gap-2 md:block md:space-y-2">
                    <a href="{{ route('orders.new') }}"
                        class="flex items-center gap-2 p-2 rounded-xl bg-slate-50 dark:bg-slate-800/50 border border-transparent hover:border-primary/20 transition-all">
                        <div
                            class="w-7 h-7 rounded-lg bg-indigo-500 text-white flex items-center justify-center shrink-0 shadow-sm">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                        </div>
                        <span
                            class="text-[9px] md:text-xs font-black text-slate-700 dark:text-slate-200 uppercase tracking-tighter">Buy
                            Data</span>
                    </a>
                    <a href="{{ route('referrals.index') }}"
                        class="flex items-center gap-2 p-2 rounded-xl bg-slate-50 dark:bg-slate-800/50 border border-transparent hover:border-primary/20 transition-all">
                        <div
                            class="w-7 h-7 rounded-lg bg-amber-500 text-white flex items-center justify-center shrink-0 shadow-sm">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                                </path>
                            </svg>
                        </div>
                        <span
                            class="text-[9px] md:text-xs font-black text-slate-700 dark:text-slate-200 uppercase tracking-tighter">Refer</span>
                    </a>
                    <a href="{{ route('notifications.index') }}"
                        class="flex items-center gap-2 p-2 rounded-xl bg-slate-50 dark:bg-slate-800/50 border border-transparent hover:border-primary/20 transition-all">
                        <div
                            class="w-7 h-7 rounded-lg bg-pink-500 text-white flex items-center justify-center shrink-0 shadow-sm">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                                </path>
                            </svg>
                        </div>
                        <span
                            class="text-[9px] md:text-xs font-black text-slate-700 dark:text-slate-200 uppercase tracking-tighter">Alerts</span>
                    </a>
                </div>
            </div>
        </div>

        {{-- Recent Orders --}}
        <div
            class="bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 rounded-2xl md:rounded-[2.5rem] overflow-hidden shadow-sm">
            <div
                class="px-5 md:px-8 py-4 md:py-6 border-b border-slate-50 dark:border-slate-800 flex items-center justify-between">
                <div>
                    <h3 class="text-sm md:text-xl font-black text-slate-900 dark:text-white uppercase tracking-tight">Recent
                        Orders</h3>
                    <p class="text-[8px] md:text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-0.5">latest
                        purchases</p>
                </div>
                <a href="{{ route('orders.index') }}"
                    class="text-[8px] md:text-[9px] font-black text-primary uppercase tracking-widest">View All</a>
            </div>

            {{-- Integrated Responsive Table --}}
            <div class="relative">
                <!-- Desktop View (md+) -->
                <div class="hidden md:block overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr
                                class="text-[10px] text-muted-foreground uppercase bg-slate-50/50 dark:bg-slate-950/20 border-b border-slate-200/50 dark:border-white/5">
                                <th class="px-8 py-5 font-black tracking-widest text-slate-400">Reference</th>
                                <th class="px-6 py-5 font-black tracking-widest text-slate-400">Package</th>
                                <th class="px-6 py-5 font-black tracking-widest text-slate-400">Recipient</th>
                                <th class="px-6 py-5 font-black tracking-widest text-slate-400">Price</th>
                                <th class="px-8 py-5 font-black tracking-widest text-right text-slate-400">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100/30 dark:divide-slate-800/30">
                            @forelse($recentOrders as $order)
                                <tr
                                    class="group hover:bg-slate-50 dark:hover:bg-slate-900/50 transition-colors border-b border-slate-100/50 dark:border-slate-800/50">
                                    <td class="px-8 py-5">
                                        <span
                                            class="font-mono text-[10px] font-black text-primary tracking-tighter uppercase whitespace-nowrap bg-primary/5 px-2 py-1 rounded-md border border-primary/10">
                                            #{{ strtoupper(substr($order->reference, 0, 8)) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-5">
                                        <span
                                            class="text-[11px] font-black text-slate-900 dark:text-white uppercase">{{ $order->bundle->name ?? 'Bundle' }}</span>
                                    </td>
                                    <td class="px-6 py-5">
                                        <span
                                            class="font-mono text-[11px] text-slate-400 font-bold tracking-widest">{{ $order->recipient_phone }}</span>
                                    </td>
                                    <td class="px-6 py-5 whitespace-nowrap">
                                        <span
                                            class="text-xs font-black text-slate-900 dark:text-white tabular-nums">₵{{ number_format($order->cost, 2) }}</span>
                                    </td>
                                    <td class="px-8 py-5 text-right">
                                        @php
                                            $statuses = [
                                                'completed' => 'bg-emerald-50 dark:bg-emerald-500/10 text-emerald-500 border-emerald-100 dark:border-emerald-500/20',
                                                'pending' => 'bg-amber-50 dark:bg-amber-500/10 text-amber-500 border-amber-100 dark:border-amber-500/20',
                                                'processing' => 'bg-blue-50 dark:bg-blue-500/10 text-blue-500 border-blue-100 dark:border-blue-500/20',
                                                'failed' => 'bg-rose-50 dark:bg-rose-500/10 text-rose-500 border-rose-100 dark:border-rose-500/20',
                                            ];
                                            $statusLabels = [
                                                'completed' => 'Delivered',
                                                'pending' => 'Validating',
                                                'processing' => 'Processing',
                                                'failed' => 'Failed',
                                            ];
                                            $sc = $statuses[$order->status] ?? 'bg-slate-50 dark:bg-slate-800 text-slate-600 border-slate-100 dark:border-slate-700';
                                            $label = $statusLabels[$order->status] ?? ucfirst($order->status);
                                        @endphp
                                        <span
                                            class="inline-flex items-center px-2.5 py-1 rounded-lg text-[8px] font-black uppercase tracking-widest border {{ $sc }}">{{ $label }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-12 text-center opacity-20">
                                        <p class="text-[10px] font-black uppercase tracking-widest">No activity</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Mobile View (md-) -->
                <div class="md:hidden divide-y divide-slate-50 dark:divide-slate-800/50">
                    @forelse($recentOrders as $order)
                        <div
                            class="p-4 space-y-3 relative overflow-hidden group active:bg-slate-50 dark:active:bg-slate-800/50 transition-all">
                            <div class="flex items-center justify-between relative">
                                <span
                                    class="font-mono text-[9px] font-black text-primary">#{{ strtoupper(substr($order->reference, 0, 8)) }}</span>
                                @php
                                    $sc = $statuses[$order->status] ?? 'bg-slate-50 dark:bg-slate-800 text-slate-600 border-slate-100 dark:border-slate-700';
                                    $label = $statusLabels[$order->status] ?? ucfirst($order->status);
                                @endphp
                                <span
                                    class="text-[8px] font-black uppercase tracking-[0.15em] {{ $sc }} px-2 py-0.5 rounded-md border">{{ $label }}</span>
                            </div>
                            <div class="flex items-end justify-between relative">
                                <div class="space-y-0.5">
                                    <h4 class="text-[11px] font-black text-slate-900 dark:text-white uppercase">
                                        {{ $order->bundle->name ?? 'Bundle' }}</h4>
                                    <p class="text-[10px] font-bold text-slate-400 font-mono tracking-tighter">
                                        {{ $order->recipient_phone }}</p>
                                </div>
                                <span
                                    class="text-xs font-black text-slate-900 dark:text-white tabular-nums">₵{{ number_format($order->cost, 2) }}</span>
                            </div>
                        </div>
                    @empty
                        <div class="py-12 text-center opacity-20">
                            <p class="text-[10px] font-black uppercase tracking-widest">No activity</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection