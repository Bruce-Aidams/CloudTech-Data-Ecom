@extends('layouts.dashboard')

@section('title', 'Reseller Hub')

@section('content')
    <div class="space-y-8 pb-20 animate-in fade-in slide-in-from-bottom-4 duration-700">
        {{-- Header --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <h2
                    class="text-3xl font-black tracking-tight text-foreground bg-clip-text text-transparent bg-gradient-to-r from-primary to-indigo-600 uppercase">
                    Reseller Hub</h2>
                <p class="text-sm text-muted-foreground font-medium mt-1">Strategic business tools for our elite partners.
                </p>
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
            <!-- Total Referrals -->
            <div
                class="group relative rounded-[2.5rem] bg-gradient-to-br from-indigo-600 to-blue-500 p-8 shadow-xl transition-all hover:scale-[1.02] overflow-hidden text-white border border-white/10">
                <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-white/10 blur-3xl rounded-full"></div>
                <div class="flex items-center justify-between mb-4">
                    <div
                        class="w-12 h-12 bg-white/10 backdrop-blur-md rounded-2xl flex items-center justify-center text-white transition-transform group-hover:rotate-12">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                </div>
                <p class="text-[10px] font-black uppercase tracking-[0.2em] text-white/60 mb-1">Total Referrals</p>
                <p class="text-3xl font-black text-white tracking-tighter tabular-nums">{{ $stats['referral_count'] }}</p>
            </div>

            <!-- Commission Earned -->
            <div
                class="group relative rounded-[2.5rem] bg-gradient-to-br from-emerald-600 to-teal-500 p-8 shadow-xl transition-all hover:scale-[1.02] overflow-hidden text-white border border-white/10">
                <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-white/10 blur-3xl rounded-full"></div>
                <div class="flex items-center justify-between mb-4">
                    <div
                        class="w-12 h-12 bg-white/10 backdrop-blur-md rounded-2xl flex items-center justify-center text-white transition-transform group-hover:rotate-12">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <p class="text-[10px] font-black uppercase tracking-[0.2em] text-white/60 mb-1">Commission Earned</p>
                <div class="flex items-baseline gap-1">
                    <span class="text-sm font-black text-white/50 uppercase">GHC</span>
                    <p class="text-3xl font-black text-white tracking-tighter tabular-nums">
                        {{ number_format($stats['total_commission'], 2) }}</p>
                </div>
            </div>

            <!-- Network Orders -->
            <div
                class="group relative rounded-[2.5rem] bg-gradient-to-br from-rose-600 to-pink-500 p-8 shadow-xl transition-all hover:scale-[1.02] overflow-hidden text-white border border-white/10">
                <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-white/10 blur-3xl rounded-full"></div>
                <div class="flex items-center justify-between mb-4">
                    <div
                        class="w-12 h-12 bg-white/10 backdrop-blur-md rounded-2xl flex items-center justify-center text-white transition-transform group-hover:rotate-12">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                    </div>
                </div>
                <p class="text-[10px] font-black uppercase tracking-[0.2em] text-white/60 mb-1">Network Orders</p>
                <p class="text-3xl font-black text-white tracking-tighter tabular-nums">{{ $stats['managed_orders'] }}</p>
            </div>

            <!-- Wallet Balance -->
            <div
                class="group relative rounded-[2.5rem] bg-gradient-to-br from-violet-600 to-purple-500 p-8 shadow-xl transition-all hover:scale-[1.02] overflow-hidden text-white border border-white/10">
                <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-white/10 blur-3xl rounded-full"></div>
                <div class="flex items-center justify-between mb-4">
                    <div
                        class="w-12 h-12 bg-white/10 backdrop-blur-md rounded-2xl flex items-center justify-center text-white transition-transform group-hover:rotate-12">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                        </svg>
                    </div>
                </div>
                <p class="text-[10px] font-black uppercase tracking-[0.2em] text-white/60 mb-1">Wallet Balance</p>
                <div class="flex items-baseline gap-1">
                    <span class="text-sm font-black text-white/50 uppercase">GHC</span>
                    <p class="text-3xl font-black text-white tracking-tighter tabular-nums">
                        {{ number_format($stats['wallet_balance'], 2) }}</p>
                </div>
            </div>
        </div>

        <div class="grid lg:grid-cols-2 gap-8">
            {{-- Quick Tools --}}
            <div
                class="bg-white/40 dark:bg-slate-900/40 backdrop-blur-xl border border-white/20 dark:border-slate-800/50 rounded-[3rem] p-10 shadow-2xl shadow-slate-200/20 dark:shadow-none h-fit">
                <div class="flex items-center gap-4 mb-8">
                    <div class="w-12 h-12 rounded-2xl bg-primary/10 flex items-center justify-center text-primary">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-black text-foreground uppercase tracking-tight">Partner Toolkit</h3>
                </div>

                <div class="grid grid-cols-1 gap-4">
                    <a href="{{ route('reseller.store.manage') }}"
                        class="group flex items-center justify-between p-6 bg-white dark:bg-slate-800 rounded-3xl border border-slate-100 dark:border-slate-700/50 hover:border-primary/30 transition-all hover:shadow-xl hover:translate-y-[-2px]">
                        <div class="flex items-center gap-6">
                            <div
                                class="w-14 h-14 rounded-2xl bg-gradient-to-br from-primary to-indigo-600 text-white flex items-center justify-center shadow-lg shadow-primary/20">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-black text-foreground uppercase tracking-tight">Manage E-Store</p>
                                <p class="text-xs font-bold text-muted-foreground mt-0.5">Custom pricing & profit margins.
                                </p>
                            </div>
                        </div>
                        <div
                            class="w-10 h-10 rounded-full bg-slate-50 dark:bg-slate-700 flex items-center justify-center text-slate-400 group-hover:bg-primary group-hover:text-white transition-all">
                            <svg class="w-5 h-5 group-hover:translate-x-0.5 transition-transform" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7" />
                            </svg>
                        </div>
                    </a>

                    @if($user->referral_code)
                        <a href="{{ route('store.show', $user->referral_code) }}" target="_blank"
                            class="group flex items-center justify-between p-6 bg-white dark:bg-slate-800 rounded-3xl border border-slate-100 dark:border-slate-700/50 hover:border-emerald-500/30 transition-all hover:shadow-xl hover:translate-y-[-2px]">
                            <div class="flex items-center gap-6">
                                <div
                                    class="w-14 h-14 rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-600 text-white flex items-center justify-center shadow-lg shadow-emerald-500/20">
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-black text-foreground uppercase tracking-tight">Visit Live Store</p>
                                    <p class="text-xs font-bold text-muted-foreground mt-0.5">Your public brand storefront.</p>
                                </div>
                            </div>
                            <div
                                class="w-10 h-10 rounded-full bg-slate-50 dark:bg-slate-700 flex items-center justify-center text-slate-400 group-hover:bg-emerald-500 group-hover:text-white transition-all">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                        d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                </svg>
                            </div>
                        </a>
                    @endif
                </div>
            </div>

            {{-- Recent Referrals --}}
            <div
                class="bg-white/40 dark:bg-slate-900/40 backdrop-blur-xl border border-white/20 dark:border-slate-800/50 rounded-[3rem] p-10 shadow-2xl shadow-slate-200/20 dark:shadow-none">
                <div class="flex items-center justify-between mb-8">
                    <div class="flex items-center gap-4">
                        <div
                            class="w-12 h-12 rounded-2xl bg-indigo-500/10 flex items-center justify-center text-indigo-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-black text-foreground uppercase tracking-tight">Network growth</h3>
                    </div>
                    <a href="{{ route('referrals.index') }}"
                        class="text-[10px] font-black text-primary uppercase tracking-[0.2em] hover:underline bg-primary/5 px-4 py-2 rounded-xl">View
                        Directory</a>
                </div>

                <div class="space-y-4">
                    @forelse($recentReferrals as $ref)
                        <div
                            class="flex items-center justify-between p-5 bg-white dark:bg-slate-800 rounded-[2rem] border border-slate-100 dark:border-slate-700/50 hover:border-primary/20 transition-all">
                            <div class="flex items-center gap-5">
                                <div
                                    class="w-12 h-12 rounded-2xl bg-gradient-to-br from-slate-100 to-slate-200 dark:from-slate-700 dark:to-slate-800 text-slate-900 dark:text-white flex items-center justify-center font-black text-sm shadow-inner">
                                    {{ strtoupper(substr($ref->name, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="text-sm font-black text-foreground uppercase tracking-tight leading-none">
                                        {{ $ref->name }}</p>
                                    <p
                                        class="text-[10px] font-bold text-muted-foreground mt-2 uppercase tracking-widest flex items-center gap-2">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        {{ $ref->created_at->format('M d, Y') }}
                                    </p>
                                </div>
                            </div>
                            <div
                                class="px-3 py-1.5 bg-primary/5 dark:bg-primary/20 text-primary border border-primary/10 rounded-xl text-[9px] font-black uppercase tracking-widest">
                                {{ str_replace('_', ' ', $ref->role) }}
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-20 opacity-30 select-none">
                            <svg class="w-16 h-16 mx-auto mb-4 text-slate-300" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                            <p class="text-[10px] font-black uppercase tracking-[0.2em]">No network activity yet</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection