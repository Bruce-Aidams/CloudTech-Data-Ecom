@extends('layouts.dashboard')

@section('title', 'Order Details')

@section('content')
    <div class="max-w-5xl mx-auto space-y-8 animate-in fade-in slide-in-from-bottom-4 duration-700">

        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="flex items-center gap-6">
                <a href="{{ route('orders.index') }}"
                    class="w-12 h-12 rounded-2xl flex items-center justify-center bg-slate-100 dark:bg-slate-800 text-slate-400 hover:text-foreground transition-all active:scale-90">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <div>
                    <div class="flex items-center gap-3">
                        <h2 class="text-3xl font-black tracking-tight text-blue-900 dark:text-white uppercase">Order <span
                                class="text-primary">#{{ $order->reference }}</span></h2>
                        @if($order->status === 'completed')
                            <span
                                class="inline-flex items-center px-4 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-widest bg-emerald-50 text-emerald-600 dark:bg-emerald-900/20 dark:text-emerald-400 border border-emerald-100 dark:border-emerald-900/20">Delivered</span>
                        @elseif($order->status === 'pending' || $order->status === 'processing')
                            <span
                                class="inline-flex items-center px-4 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-widest bg-amber-50 text-amber-600 dark:bg-amber-900/20 dark:text-amber-400 border border-amber-100 dark:border-amber-900/20">Validating</span>
                        @elseif($order->status === 'failed')
                            <span
                                class="inline-flex items-center px-4 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-widest bg-rose-50 text-rose-600 dark:bg-rose-900/20 dark:text-rose-400 border border-rose-100 dark:border-rose-900/20">Failed</span>
                        @endif
                    </div>
                    <p class="text-sm font-black text-slate-400 uppercase tracking-widest mt-1">
                        {{ $order->created_at->format('M d, Y • h:i A') }}
                    </p>
                </div>
            </div>

            {{-- Invoice Button Placeholder --}}
            {{-- @if($order->status === 'completed')
            <button
                class="h-12 px-6 inline-flex items-center justify-center rounded-2xl bg-slate-100 dark:bg-slate-800 text-xs font-black uppercase tracking-widest text-slate-400 cursor-not-allowed gap-3">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                        d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                    </path>
                </svg>
                Invoice Available Soon
            </button>
            @endif --}}
        </div>

        <div class="grid gap-8 md:grid-cols-2">
            <!-- Order Details Card -->
            <div
                class="rounded-[2.5rem] border border-border/50 bg-card/50 backdrop-blur-xl p-10 shadow-2xl shadow-slate-200/20 dark:shadow-none space-y-8">
                <div>
                    <h3 class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-6">Order Information</h3>
                    <div class="space-y-6">
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-bold text-muted-foreground uppercase tracking-widest">Total
                                Cost</span>
                            <span class="text-2xl font-black text-foreground tracking-tighter">GHS
                                {{ number_format($order->cost, 2) }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-bold text-muted-foreground uppercase tracking-widest">Payment
                                Method</span>
                            <span class="text-sm font-black text-foreground uppercase tracking-widest">Wallet Credits</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-bold text-muted-foreground uppercase tracking-widest">Reference</span>
                            <span
                                class="font-mono text-xs font-black text-primary tracking-widest">TRX-{{ strtoupper(substr($order->reference, 0, 8)) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recipient Card -->
            <div
                class="rounded-[2.5rem] border border-border/50 bg-card/50 backdrop-blur-xl p-10 shadow-2xl shadow-slate-200/20 dark:shadow-none space-y-8">
                <div>
                    <h3 class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-6">Recipient Details</h3>
                    <div class="space-y-6">
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-bold text-muted-foreground uppercase tracking-widest">Phone
                                Number</span>
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-8 h-8 rounded-full bg-primary/10 flex items-center justify-center text-primary">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                </div>
                                <span
                                    class="text-sm font-black text-foreground font-mono tracking-widest">{{ $order->recipient_phone }}</span>
                            </div>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-bold text-muted-foreground uppercase tracking-widest">Network
                                Operator</span>
                            <span
                                class="text-sm font-black text-primary uppercase tracking-widest">{{ $order->bundle->network ?? 'N/A' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Package Info Card -->
            <div
                class="rounded-[2.5rem] border border-border/50 bg-card/50 backdrop-blur-xl p-10 shadow-2xl shadow-slate-200/20 dark:shadow-none md:col-span-2">
                <h3 class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-8">Bundle Details</h3>
                <div class="flex flex-col sm:flex-row sm:items-center gap-10">
                    <div
                        class="h-20 w-20 rounded-3xl bg-primary/10 flex items-center justify-center text-primary shadow-inner">
                        <svg class="h-10 w-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-2">
                            <h4 class="font-black text-2xl text-foreground tracking-tighter">
                                {{ $order->bundle->name ?? 'Unknown Bundle' }}
                            </h4>
                            <span
                                class="px-3 py-1 bg-slate-100 dark:bg-slate-800 rounded-lg text-[10px] font-black uppercase tracking-widest text-slate-400">Standard
                                Pack</span>
                        </div>
                        <p class="text-slate-500 font-medium leading-relaxed max-w-2xl">
                            {{ $order->bundle->description ?? 'Secure data delivery to the recipient. High-priority delivery route active.' }}
                        </p>
                    </div>
                    <div class="text-right flex flex-col items-end">
                        <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1">Bundle Detail</p>
                        <p class="text-xl font-black text-foreground tracking-tighter">
                            {{ $order->bundle->data_amount ?? 'N/A' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection