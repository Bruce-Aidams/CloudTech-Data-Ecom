@extends('layouts.dashboard')

@section('title', 'Reseller Hub')

@section('content')
    <div class="space-y-8 pb-20 animate-in fade-in slide-in-from-bottom-4 duration-700">
        {{-- Header --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="flex items-center gap-4">
                <div
                    class="w-12 h-12 rounded-xl bg-indigo-500/10 flex items-center justify-center text-indigo-500 ring-1 ring-indigo-500/20">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                        </path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-3xl font-black tracking-tight text-blue-900 dark:text-white uppercase">Reseller Hub</h2>
                    <p class="text-sm text-slate-500 dark:text-slate-400 font-medium mt-1">Strategic business tools for our
                        elite partners.</p>
                </div>
            </div>

            <div
                class="px-6 py-3 bg-white/40 dark:bg-slate-900/40 backdrop-blur-xl border border-white/20 dark:border-slate-800/50 rounded-2xl shadow-xl">
                <p class="text-[10px] font-black uppercase tracking-[0.2em] text-primary">Your Status</p>
                <p class="text-sm font-black text-foreground mt-1 uppercase tracking-tight">
                    {{ str_replace('_', ' ', $user->role) }}
                </p>
            </div>
        </div>

        {{-- Stats Grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Available Funds -->
            <div
                class="group relative rounded-[2.5rem] bg-slate-900 p-5 md:p-8 shadow-2xl transition-all hover:scale-[1.02] overflow-hidden text-white border border-white/5">
                <div class="absolute top-0 right-0 -mt-2 -mr-2 w-20 h-20 bg-primary/20 blur-3xl rounded-full"></div>
                <div class="flex items-center justify-between mb-4">
                    <div
                        class="w-12 h-12 bg-white/5 backdrop-blur-md rounded-2xl flex items-center justify-center text-primary transition-transform group-hover:rotate-12 border border-white/10">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                </div>
                <p class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-1">Available Funds</p>
                <div class="flex items-baseline gap-1">
                    <span class="text-xs font-black text-slate-500 uppercase">GHC</span>
                    <p class="text-3xl font-black text-white tracking-tighter tabular-nums">
                        {{ number_format($stats['wallet_balance'], 2) }}
                    </p>
                </div>
            </div>

            <!-- Total Earnings -->
            <div
                class="group relative rounded-[2.5rem] bg-gradient-to-br from-indigo-600 to-indigo-700 p-5 md:p-8 shadow-xl transition-all hover:scale-[1.02] overflow-hidden text-white border border-white/10">
                <div class="absolute top-0 right-0 -mt-2 -mr-2 w-20 h-20 bg-white/10 blur-3xl rounded-full"></div>
                <div class="flex items-center justify-between mb-4">
                    <div
                        class="w-12 h-12 bg-white/10 backdrop-blur-md rounded-2xl flex items-center justify-center text-white transition-transform group-hover:rotate-12">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <p class="text-[10px] font-black uppercase tracking-[0.2em] text-white/60 mb-1">Total Net Profit</p>
                <div class="flex items-baseline gap-1">
                    <span class="text-xs font-black text-white/50 uppercase">GHC</span>
                    <p class="text-3xl font-black text-white tracking-tighter tabular-nums">
                        {{ number_format($stats['total_earnings'], 2) }}
                    </p>
                </div>
            </div>

            <!-- Customer Orders -->
            <div
                class="group relative rounded-[2.5rem] bg-white dark:bg-slate-900 p-5 md:p-8 shadow-sm transition-all hover:scale-[1.02] overflow-hidden border border-slate-100 dark:border-slate-800">
                <div class="absolute top-0 right-0 -mt-2 -mr-2 w-20 h-20 bg-rose-500/5 blur-3xl rounded-full"></div>
                <div class="flex items-center justify-between mb-4">
                    <div
                        class="w-12 h-12 bg-rose-500/10 dark:bg-rose-500/20 rounded-2xl flex items-center justify-center text-rose-500 transition-transform group-hover:rotate-12">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                    </div>
                </div>
                <p class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-1">Completed Sales</p>
                <p class="text-3xl font-black text-slate-900 dark:text-white tracking-tighter tabular-nums">
                    {{ $stats['total_sales'] }}
                </p>
            </div>

            <!-- Network Size -->
            <div
                class="group relative rounded-[2.5rem] bg-white dark:bg-slate-900 p-5 md:p-8 shadow-sm transition-all hover:scale-[1.02] overflow-hidden border border-slate-100 dark:border-slate-800">
                <div class="absolute top-0 right-0 -mt-2 -mr-2 w-20 h-20 bg-emerald-500/5 blur-3xl rounded-full"></div>
                <div class="flex items-center justify-between mb-4">
                    <div
                        class="w-12 h-12 bg-emerald-500/10 dark:bg-emerald-500/20 rounded-2xl flex items-center justify-center text-emerald-500 transition-transform group-hover:rotate-12">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                </div>
                <p class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-1">Referred Partners</p>
                <p class="text-3xl font-black text-slate-900 dark:text-white tracking-tighter tabular-nums">
                    {{ $stats['referral_count'] }}
                </p>
            </div>
        </div>

        <div class="grid lg:grid-cols-2 gap-8">
            {{-- Quick Tools --}}
            <div
                class="bg-white/40 dark:bg-slate-900/40 backdrop-blur-xl border border-white/20 dark:border-slate-800/50 rounded-[3rem] p-10 shadow-2xl shadow-slate-200/20 dark:shadow-none h-fit">
                <div class="flex items-center gap-4 mb-8">
                    <div
                        class="w-12 h-12 rounded-2xl bg-indigo-500/10 flex items-center justify-center text-indigo-600 border border-indigo-500/10">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 00-1-1H4a2 2 0 110-4h1a1 1 0 001-1V7a1 1 0 011-1h3a1 1 0 001-1V4z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-black text-foreground uppercase tracking-tight">E-Commerce Toolkit</h3>
                </div>

                <div class="grid grid-cols-1 gap-4">
                    <a href="{{ route('reseller.customer-orders') }}"
                        class="group p-6 bg-white dark:bg-slate-800 rounded-3xl border border-slate-100 dark:border-slate-700/50 hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-all">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-6">
                                <div
                                    class="w-14 h-14 rounded-2xl bg-indigo-500/10 text-indigo-600 flex items-center justify-center border border-indigo-500/10">
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-black text-foreground uppercase tracking-tight">Customer Ledger
                                    </p>
                                    <p class="text-xs font-bold text-muted-foreground mt-0.5">Track every storefront and
                                        network sale.</p>
                                </div>
                            </div>
                            <svg class="w-5 h-5 text-slate-300 transition-transform group-hover:translate-x-1" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7" />
                            </svg>
                        </div>
                    </a>

                    <a href="{{ route('reseller.store.manage') }}"
                        class="group p-6 bg-white dark:bg-slate-800 rounded-3xl border border-slate-100 dark:border-slate-700/50 hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-all">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-6">
                                <div
                                    class="w-14 h-14 rounded-2xl bg-primary/10 text-primary flex items-center justify-center border border-primary/10">
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-black text-foreground uppercase tracking-tight">Store Management
                                    </p>
                                    <p class="text-xs font-bold text-muted-foreground mt-0.5">Control pricing, toggle
                                        status, and links.</p>
                                </div>
                            </div>
                            <svg class="w-5 h-5 text-slate-300 transition-transform group-hover:translate-x-1" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7" />
                            </svg>
                        </div>
                    </a>

                    @if($user->referral_code)
                        <div
                            class="p-6 bg-slate-50 dark:bg-slate-900 rounded-[2rem] border border-slate-100 dark:border-slate-800 space-y-4">
                            <div class="flex items-center justify-between">
                                <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">
                                    {{ $user->name }}'s @ {{ config('app.name') }} Link
                                </p>
                                <span
                                    class="px-2 py-0.5 bg-emerald-500/10 text-emerald-500 text-[8px] font-black uppercase rounded-lg border border-emerald-500/10">Active
                                    Gateway</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <input type="text" readonly value="{{ route('store.show', $user->referral_code) }}"
                                    class="flex-1 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-2.5 text-xs font-bold text-slate-600 dark:text-slate-400 outline-none">
                                <button
                                    onclick="navigator.clipboard.writeText('Check out {{ $user->name }}\'s store on {{ config('app.name') }}: {{ route('store.show', $user->referral_code) }}'); alert('Store link with agent details copied!')"
                                    class="h-10 px-4 bg-primary text-white rounded-xl text-[10px] font-black uppercase tracking-widest hover:opacity-90 active:scale-95 transition-all">Copy</button>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <div class="space-y-8">
                {{-- Recent Sales Activity --}}
                <div
                    class="bg-white/40 dark:bg-slate-900/40 backdrop-blur-xl border border-white/20 dark:border-slate-800/50 rounded-[3rem] p-10 shadow-2xl shadow-slate-200/20 dark:shadow-none h-fit">
                    <div class="flex items-center justify-between mb-8">
                        <div class="flex items-center gap-4">
                            <div
                                class="w-12 h-12 rounded-2xl bg-rose-500/10 flex items-center justify-center text-rose-600 border border-rose-500/10">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M12 8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-black text-foreground uppercase tracking-tight">Recent Sales</h3>
                        </div>
                        <a href="{{ route('reseller.customer-orders') }}"
                            class="text-[10px] font-black text-primary uppercase tracking-[0.2em] bg-primary/5 px-4 py-2 rounded-xl border border-primary/5">All
                            Orders</a>
                    </div>

                    <div class="space-y-4">
                        @forelse($recentOrders as $order)
                            <div
                                class="flex items-center justify-between p-5 bg-white dark:bg-slate-800 rounded-3xl border border-slate-100 dark:border-slate-700/50 transition-all hover:border-primary/20">
                                <div class="flex items-center gap-4">
                                    <div
                                        class="w-10 h-10 rounded-xl bg-slate-50 dark:bg-slate-900 flex items-center justify-center text-slate-400">
                                        {{ strtoupper(substr($order->bundle->network, 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="text-[11px] font-black text-foreground uppercase leading-none">
                                            {{ $order->bundle->name }}
                                        </p>
                                        <p
                                            class="text-[9px] font-bold text-muted-foreground mt-1.5 uppercase tabular-nums tracking-widest">
                                            {{ $order->recipient_phone }}
                                        </p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-xs font-black text-emerald-500 italic">+ GHS
                                        {{ number_format($order->profit, 2) }}
                                    </p>
                                    <p
                                        class="text-[8px] font-black text-slate-300 dark:text-slate-600 uppercase mt-0.5 tracking-tighter">
                                        {{ $order->created_at->diffForHumans(null, true) }}
                                    </p>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-12 opacity-30 select-none">
                                <p class="text-[10px] font-black uppercase tracking-[0.2em]">No recent sales activity</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                {{-- Network Growth --}}
                <div
                    class="bg-white/40 dark:bg-slate-900/40 backdrop-blur-xl border border-white/20 dark:border-slate-800/50 rounded-[3rem] p-10 shadow-2xl shadow-slate-200/20 dark:shadow-none">
                    <div class="flex items-center justify-between mb-8">
                        <div class="flex items-center gap-4">
                            <div
                                class="w-12 h-12 rounded-2xl bg-indigo-500/10 flex items-center justify-center text-indigo-600 border border-indigo-500/10">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-black text-foreground uppercase tracking-tight">New Partners</h3>
                        </div>
                    </div>

                    <div class="space-y-4">
                        @forelse($recentReferrals as $ref)
                            <div
                                class="flex items-center justify-between p-5 bg-white dark:bg-slate-800 rounded-3xl border border-slate-100 dark:border-slate-700/50 transition-all">
                                <div class="flex items-center gap-4">
                                    <div
                                        class="w-10 h-10 rounded-xl bg-gradient-to-br from-slate-100 to-slate-200 dark:from-slate-700 dark:to-slate-800 text-slate-900 dark:text-white flex items-center justify-center font-black text-[10px]">
                                        {{ strtoupper(substr($ref->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="text-[11px] font-black text-foreground uppercase leading-none">
                                            {{ $ref->name }}
                                        </p>
                                        <p
                                            class="text-[9px] font-bold text-muted-foreground mt-1.5 uppercase tabular-nums tracking-widest">
                                            {{ $ref->created_at->format('M d') }}
                                        </p>
                                    </div>
                                </div>
                                <div
                                    class="px-2.5 py-1 bg-primary/5 text-primary border border-primary/10 rounded-lg text-[8px] font-black uppercase tracking-widest">
                                    {{ str_replace('_', ' ', $ref->role) }}
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-12 opacity-30 select-none">
                                <p class="text-[10px] font-black uppercase tracking-[0.2em]">No new partners yet</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection