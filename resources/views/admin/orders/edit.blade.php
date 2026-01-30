@extends('layouts.admin')

@section('title', 'Modify Order Ledger')

@section('content')
    <div class="max-w-4xl mx-auto space-y-6 pb-12 animate-in fade-in slide-in-from-bottom-4 duration-700">
        {{-- Header Section --}}
        <div class="flex items-center justify-between">
            <div>
                <div class="flex items-center gap-3">
                    <h2 class="text-3xl font-bold tracking-tight text-slate-900 dark:text-white uppercase tracking-tight">Modify Order</h2>
                    <span class="px-3 py-1 rounded-full bg-primary/10 text-primary text-[10px] font-black uppercase tracking-widest border border-primary/20">
                        #{{ substr($order->reference, 0, 12) }}
                    </span>
                </div>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1 uppercase tracking-widest font-bold text-[10px]">Correction Protocol: Manual Ledger Adjustment</p>
            </div>
            <a href="{{ route('admin.orders') }}" 
               class="h-11 px-6 bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 rounded-xl font-bold text-sm hover:bg-slate-200 dark:hover:bg-slate-700 transition-all flex items-center gap-2 active:scale-95">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Ledger
            </a>
        </div>

        <div class="bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 rounded-[2.5rem] overflow-hidden shadow-2xl">
            <div class="bg-gradient-to-br from-primary/10 to-transparent p-8 md:p-12">
                <form action="{{ route('admin.orders.update_v2', $order->id) }}" method="POST" class="space-y-8">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        {{-- Account Info (Disabled) --}}
                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-500 ml-1">Customer Account</label>
                            <input type="text" value="{{ $order->user->name }}" disabled
                                   class="w-full h-14 px-5 bg-slate-50 dark:bg-slate-950/50 border border-slate-100 dark:border-slate-800 rounded-2xl text-sm font-bold text-slate-400 cursor-not-allowed">
                        </div>

                        {{-- Recipient Phone --}}
                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-500 ml-1">Recipient Number</label>
                            <input type="tel" name="recipient_phone" value="{{ $order->recipient_phone }}" required maxlength="10"
                                   class="w-full h-14 px-5 bg-white dark:bg-slate-950 border-none rounded-2xl text-sm font-bold text-slate-900 dark:text-white shadow-sm focus:ring-4 focus:ring-primary/10 transition-all font-mono tracking-widest @error('recipient_phone') ring-2 ring-rose-500 @enderror">
                            @error('recipient_phone')
                                <p class="text-[10px] font-bold text-rose-500 mt-1 ml-1 uppercase">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Bundle Type (Disabled) --}}
                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-500 ml-1">Bundle Type</label>
                            <input type="text" value="{{ $order->bundle->name }} ({{ $order->bundle->network }})" disabled
                                   class="w-full h-14 px-5 bg-slate-50 dark:bg-slate-950/50 border border-slate-100 dark:border-slate-800 rounded-2xl text-sm font-bold text-slate-400 cursor-not-allowed font-mono">
                        </div>

                        {{-- Cost Adjustment --}}
                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-500 ml-1">Cost Adjustment (GHC)</label>
                            <input type="number" step="0.01" name="cost" value="{{ $order->cost }}" required
                                   class="w-full h-14 px-5 bg-white dark:bg-slate-950 border-none rounded-2xl text-sm font-bold text-slate-900 dark:text-white shadow-sm focus:ring-4 focus:ring-primary/10 transition-all font-mono">
                        </div>

                        {{-- Status Selection --}}
                        <div class="space-y-2 md:col-span-2">
                            <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-500 ml-1">Order Status Protocol</label>
                            <div class="relative group">
                                <select name="status" required 
                                        class="w-full h-14 px-5 bg-white dark:bg-slate-950 border-none rounded-2xl text-sm font-bold text-slate-900 dark:text-white shadow-sm focus:ring-4 focus:ring-primary/10 transition-all appearance-none cursor-pointer">
                                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Validating (Pending)</option>
                                    <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                                    <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed (Delivered)</option>
                                    <option value="failed" {{ $order->status == 'failed' ? 'selected' : '' }}>Failed</option>
                                </select>
                                <svg class="absolute right-5 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="pt-6">
                        <button type="submit" 
                                class="w-full h-16 bg-slate-900 dark:bg-white text-white dark:text-slate-900 rounded-[1.5rem] font-black text-xs uppercase tracking-[0.3em] hover:bg-emerald-600 dark:hover:bg-emerald-600 dark:hover:text-white transition-all shadow-2xl active:scale-[0.98] flex items-center justify-center gap-3 group">
                            <span>Update Ledger Record</span>
                            <svg class="w-5 h-5 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                            </svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Meta Information --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="p-6 bg-white dark:bg-slate-900 rounded-3xl border border-slate-100 dark:border-slate-800 shadow-sm">
                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Created At</p>
                <p class="text-sm font-bold text-slate-900 dark:text-white">{{ $order->created_at->format('F j, Y - H:i') }}</p>
            </div>
            <div class="p-6 bg-white dark:bg-slate-900 rounded-3xl border border-slate-100 dark:border-slate-800 shadow-sm">
                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Last Modified</p>
                <p class="text-sm font-bold text-slate-900 dark:text-white">{{ $order->updated_at->format('F j, Y - H:i') }}</p>
            </div>
            <div class="p-6 bg-white dark:bg-slate-900 rounded-3xl border border-slate-100 dark:border-slate-800 shadow-sm">
                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">System Reference</p>
                <p class="text-xs font-mono font-bold text-primary truncate" title="{{ $order->reference }}">{{ substr($order->reference, 0, 16) }}...</p>
            </div>
        </div>
    </div>
@endsection
