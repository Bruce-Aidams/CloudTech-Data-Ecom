@extends('layouts.admin')

@section('title', 'Order Details')

@section('content')
    <div class="max-w-6xl mx-auto space-y-8 pb-10">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.orders') }}"
                    class="w-10 h-10 bg-white dark:bg-slate-900 rounded-xl flex items-center justify-center text-slate-400 hover:text-primary transition-all shadow-sm border border-slate-200 dark:border-slate-800 hover:-translate-x-1">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <div>
                    <h2 class="text-3xl font-black tracking-tight text-slate-800 dark:text-slate-100">Order Details</h2>
                    <p class="text-sm text-muted-foreground font-medium uppercase tracking-[0.2em]">Order ID: #{{ $order->reference }}</p>
                </div>
            </div>
            <div class="flex items-center gap-2 bg-emerald-50 px-3 py-1.5 rounded-full border border-emerald-100">
                <div class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></div>
                <span class="text-[10px] font-bold uppercase tracking-wider text-emerald-700">Live Status</span>
            </div>
        </div>

        <div class="grid lg:grid-cols-12 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-8 space-y-8">
                <!-- Order Information -->
                    <div class="flex items-center gap-3 mb-8">
                        <div class="w-1.5 h-6 bg-primary rounded-full"></div>
                        <h4 class="text-[10px] font-black uppercase tracking-[0.2em] text-muted-foreground">Order Information</h4>
                    </div>

                    <div class="space-y-8">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-3xl font-black tracking-tight text-slate-900 dark:text-slate-100 leading-tight">
                                    {{ $order->bundle->name ?? 'Bundle Archived' }}</p>
                                <div class="flex items-center gap-3 mt-3">
                                    <span class="inline-flex px-3 py-1 rounded-lg bg-slate-900 dark:bg-primary text-[10px] font-black text-white uppercase tracking-[0.2em]">{{ $order->bundle->network ?? 'N/A' }}</span>
                                    <span class="text-[10px] font-black text-muted-foreground uppercase tracking-[0.2em]">Data Bundle</span>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="text-[10px] font-black uppercase tracking-[0.2em] text-muted-foreground block mb-1.5">Date Placed</span>
                                <span class="font-black text-sm text-slate-600 dark:text-slate-400">{{ $order->created_at->format('M d, Y') }}</span>
                                <p class="text-[11px] text-muted-foreground mt-0.5 font-bold uppercase tracking-wide">{{ $order->created_at->format('H:i A') }}</p>
                            </div>
                        </div>

                        <div class="h-px bg-slate-100"></div>

                        <div class="grid grid-cols-2 gap-8">
                            <div>
                                <span class="text-[10px] font-black uppercase tracking-[0.2em] text-muted-foreground block mb-2.5">Recipient</span>
                                <p class="text-3xl font-black text-slate-900 dark:text-slate-100 tracking-tight font-mono">{{ $order->recipient_phone }}</p>
                                <p class="text-[11px] font-black text-primary mt-3 uppercase tracking-[0.2em]">Verified Number</p>
                            </div>
                            <div class="text-right">
                                <p class="text-4xl font-black tracking-tight text-slate-900 dark:text-slate-100">GHC {{ number_format($order->cost, 2) }}</p>
                                <p class="text-[10px] font-black text-muted-foreground mt-2 uppercase tracking-[0.2em]">Total</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Financial Breakdown -->
                <div class="bg-slate-950 rounded-[2.5rem] p-8 text-white shadow-xl shadow-slate-950/20 relative overflow-hidden transition-all">
                    <div class="absolute right-[-20px] top-[-20px] opacity-10">
                        <svg class="w-40 h-40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                            </path>
                        </svg>
                    </div>

                    <h4 class="text-[10px] font-black uppercase tracking-[0.4em] text-white/30 mb-8">Financial Overview</h4>

                    <div class="grid grid-cols-3 gap-6 relative z-10">
                        <div class="p-6 bg-white/5 rounded-2xl border border-white/10 hover:bg-white/10 transition-colors">
                            <span class="text-[10px] font-black uppercase tracking-[0.2em] text-white/40 block mb-2.5">Cost Price</span>
                            <p class="text-2xl font-black tracking-tight tabular-nums">GHC {{ number_format($order->cost_price, 2) }}</p>
                        </div>
                        <div class="p-6 bg-white/5 rounded-2xl border border-white/10 hover:bg-white/10 transition-colors">
                            <span class="text-[10px] font-black uppercase tracking-[0.2em] text-white/40 block mb-2.5">Selling Price</span>
                            <p class="text-2xl font-black tracking-tight tabular-nums">GHC {{ number_format($order->cost, 2) }}</p>
                        </div>
                        <div class="p-6 bg-emerald-600 rounded-2xl shadow-lg shadow-emerald-500/20 hover:scale-[1.02] transition-transform">
                            <span class="text-[10px] font-black uppercase tracking-[0.2em] text-white/80 block mb-2.5">Net Profit</span>
                            <p class="text-2xl font-black tracking-tight tabular-nums">GHC {{ number_format($order->cost - $order->cost_price, 2) }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Operational Control -->
            <div class="lg:col-span-4 space-y-8">
                <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] p-8 shadow-sm border border-slate-200/60 dark:border-slate-800 transition-all">
                    <h4 class="text-[10px] font-black uppercase tracking-[0.2em] text-muted-foreground mb-6">Manage Status</h4>

                    <div class="mb-0">
                        <div
                            class="w-full text-center py-3 rounded-xl text-[11px] font-black uppercase tracking-[0.2em] mb-6 border
                                @if($order->status === 'completed') bg-emerald-50 border-emerald-100 text-emerald-700 dark:bg-emerald-900/20 dark:text-emerald-400 dark:border-emerald-800 @elseif($order->status === 'pending') bg-blue-50 border-blue-100 text-blue-700 dark:bg-blue-900/20 dark:text-blue-400 dark:border-blue-800 @elseif($order->status === 'failed') bg-rose-50 border-rose-100 text-rose-700 dark:bg-rose-900/20 dark:text-rose-400 dark:border-rose-800 @else bg-amber-50 border-amber-100 text-amber-700 dark:bg-amber-900/20 dark:text-amber-400 dark:border-amber-800 @endif">
                            {{ $order->status === 'pending' ? 'Validating' : $order->status }}
                        </div>

                        <form action="{{ route('admin.orders.update', $order->id) }}" method="POST" class="space-y-4">
                            @csrf
                            @method('PUT')

                            <div class="space-y-2">
                                <label class="text-[10px] font-bold text-muted-foreground uppercase tracking-widest ml-1">Update Status</label>
                                <select name="status"
                                    class="w-full h-11 px-4 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-xl text-xs font-black uppercase tracking-widest outline-none focus:bg-white focus:border-primary focus:ring-4 focus:ring-primary/5 transition-all appearance-none cursor-pointer">
                                    <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Validating</option>
                                    <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Processing</option>
                                    <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="failed" {{ $order->status === 'failed' ? 'selected' : '' }}>Failed</option>
                                </select>
                            </div>

                            <button type="submit"
                                class="w-full h-12 bg-slate-900 dark:bg-primary text-white rounded-xl font-bold uppercase text-xs tracking-widest shadow-lg shadow-slate-900/10 dark:shadow-primary/20 hover:scale-[1.02] transition-all active:scale-[0.98]">
                                Update Order
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Client Profile -->
                <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] p-8 shadow-sm border border-slate-200/60 dark:border-slate-800 transition-all">
                    <h4 class="text-[10px] font-black uppercase tracking-[0.2em] text-muted-foreground mb-6">Customer Profile</h4>

                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-12 h-12 rounded-xl bg-slate-900 dark:bg-primary flex items-center justify-center text-white font-black text-lg">
                            {{ substr($order->user->name, 0, 1) }}
                        </div>
                        <div class="overflow-hidden">
                            <p class="font-black text-base text-slate-900 dark:text-slate-100 leading-none truncate tracking-tight">
                                class="font-black text-base text-slate-900 dark:text-slate-100 leading-none truncate tracking-tight">
                                {{ $order->user->name }}</p>
                            <p class="text-xs font-bold text-muted-foreground mt-1 truncate">
                                {{ $order->user->email }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div class="p-4 bg-slate-50 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-700 rounded-2xl text-center">
                            <span class="text-[9px] font-black uppercase text-muted-foreground tracking-widest block mb-1">Balance</span>
                            <span class="font-black text-xs text-slate-900 dark:text-slate-100 tabular-nums">GHC {{ number_format($order->user->wallet_balance, 2) }}</span>
                        </div>
                        <div class="p-4 bg-slate-50 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-700 rounded-2xl text-center">
                            <span class="text-[9px] font-black uppercase text-muted-foreground tracking-widest block mb-1">Orders</span>
                            <span class="font-black text-xs text-slate-900 dark:text-slate-100 tabular-nums">{{ $order->user->orders()->count() }}</span>
                        </div>
                    </div>

                    <a href="{{ route('admin.users', ['search' => $order->user->email]) }}"
                        class="mt-6 block text-center py-4 bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-slate-100 font-black uppercase text-[10px] tracking-[0.3em] hover:bg-slate-900 dark:hover:bg-primary hover:text-white transition-all border border-slate-200 dark:border-slate-700 rounded-xl">
                        View Customer Profile
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
