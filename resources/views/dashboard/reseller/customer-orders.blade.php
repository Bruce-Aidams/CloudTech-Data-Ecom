@extends('layouts.dashboard')

@section('title', 'Customer Orders')

@section('content')
    <div class="space-y-6 animate-in fade-in slide-in-from-bottom-4 duration-700" x-data="{ loading: true }"
        x-init="setTimeout(() => loading = false, 800)">

        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <div
                    class="w-12 h-12 rounded-xl bg-emerald-500/10 flex items-center justify-center text-emerald-500 ring-1 ring-emerald-500/20">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                        </path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-3xl font-black tracking-tight text-blue-900 dark:text-white uppercase">Customer Orders
                    </h2>
                    <p class="text-sm text-slate-500 dark:text-slate-400 font-medium mt-1">Monitor all orders from your
                        referrals and storefront guests.</p>
                </div>
            </div>
            <a href="{{ route('reseller.hub') }}"
                class="inline-flex items-center justify-center rounded-xl text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:bg-slate-200 h-10 px-4 py-2 shadow-sm">
                <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18">
                    </path>
                </svg>
                Back to Hub
            </a>
        </div>

        <div class="bg-white dark:bg-slate-900 rounded-2xl md:rounded-[2.5rem] border border-slate-100 dark:border-slate-800 shadow-sm overflow-hidden"
            x-data="{ showFilters: false }">

            {{-- Header Actions Area --}}
            <div
                class="px-6 py-6 border-b border-slate-100 dark:border-slate-800 flex flex-wrap items-center justify-between gap-4 bg-slate-50/30 dark:bg-slate-950/20">
                <div class="flex items-center gap-3">
                    <button @click="showFilters = !showFilters"
                        class="h-10 px-5 rounded-xl bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-xs font-bold uppercase tracking-widest text-slate-600 dark:text-slate-400 hover:border-primary/50 transition-all flex items-center gap-2 shadow-sm">
                        <svg class="w-4 h-4 transition-transform duration-300" :class="{'rotate-180': showFilters}"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                        </svg>
                        <span x-text="showFilters ? 'Hide Filters' : 'Filters'"></span>
                    </button>

                    @if(request()->anyFilled(['search', 'status', 'network', 'start_date', 'end_date']))
                        <a href="{{ route('reseller.customer-orders') }}"
                            class="h-10 px-4 rounded-xl bg-rose-50 dark:bg-rose-900/10 text-rose-600 dark:text-rose-400 text-[10px] font-bold uppercase tracking-widest hover:bg-rose-100 transition-all flex items-center gap-2 border border-rose-100 dark:border-rose-900/20">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Clear
                        </a>
                    @endif
                </div>

                <div class="flex items-center gap-4">
                    <div class="hidden lg:block text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                        Records: {{ $orders->firstItem() ?? 0 }}-{{ $orders->lastItem() ?? 0 }} of {{ $orders->total() }}
                    </div>
                    <div class="flex items-center gap-2">
                        {{ $orders->appends(request()->query())->links('pagination::simple-tailwind') }}
                    </div>
                </div>
            </div>

            {{-- Expandable Filter Panel --}}
            <div x-show="showFilters" x-collapse x-cloak
                class="bg-white dark:bg-slate-900 border-b border-slate-100 dark:border-slate-800">
                <div class="p-6 md:p-8">
                    <form action="{{ route('reseller.customer-orders') }}" method="GET" class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                            <!-- Search -->
                            <div class="space-y-2">
                                <label class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Search
                                    ID/Phone</label>
                                <div class="relative group">
                                    <svg class="absolute left-4 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400 group-focus-within:text-primary transition-colors"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                    <input type="text" name="search" value="{{ request('search') }}"
                                        placeholder="Reference code..."
                                        class="w-full h-11 pl-11 pr-4 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 text-xs font-bold text-slate-900 dark:text-white focus:ring-2 focus:ring-primary/20 transition-all outline-none">
                                </div>
                            </div>

                            <!-- Status -->
                            <div class="space-y-2">
                                <label class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Status</label>
                                <select name="status"
                                    class="w-full h-11 px-4 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 text-xs font-bold text-slate-900 dark:text-white focus:ring-2 focus:ring-primary/20 transition-all outline-none appearance-none cursor-pointer">
                                    <option value="all">All Status</option>
                                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>
                                        Delivered</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Validating
                                    </option>
                                    <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>
                                        Processing</option>
                                    <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Failed
                                    </option>
                                </select>
                            </div>

                            <!-- Network -->
                            <div class="space-y-2">
                                <label class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Network</label>
                                <select name="network"
                                    class="w-full h-11 px-4 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 text-xs font-bold text-slate-900 dark:text-white focus:ring-2 focus:ring-primary/20 transition-all outline-none appearance-none cursor-pointer">
                                    <option value="all">All Networks</option>
                                    @foreach($networks as $network)
                                        <option value="{{ $network }}" {{ request('network') == $network ? 'selected' : '' }}>
                                            {{ strtoupper($network) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Per Page -->
                            <div class="space-y-2">
                                <label class="text-[10px] font-bold uppercase tracking-wider text-slate-400">View
                                    Count</label>
                                <select name="per_page"
                                    class="w-full h-11 px-4 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 text-xs font-bold text-slate-900 dark:text-white focus:ring-2 focus:ring-primary/20 transition-all outline-none appearance-none cursor-pointer">
                                    @foreach([10, 15, 30, 50, 100] as $val)
                                        <option value="{{ $val }}" {{ request('per_page', 10) == $val ? 'selected' : '' }}>
                                            {{ $val }} Per Page
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Date Range -->
                            <div class="lg:col-span-2 grid grid-cols-2 gap-4">
                                <div class="space-y-2 text-left">
                                    <label
                                        class="text-[10px] font-bold uppercase tracking-wider text-slate-400">From</label>
                                    <input type="date" name="start_date" value="{{ request('start_date') }}"
                                        class="w-full h-11 px-4 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 text-xs font-bold text-slate-900 dark:text-white outline-none">
                                </div>
                                <div class="space-y-2">
                                    <label class="text-[10px] font-bold uppercase tracking-wider text-slate-400">To</label>
                                    <input type="date" name="end_date" value="{{ request('end_date') }}"
                                        class="w-full h-11 px-4 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 text-xs font-bold text-slate-900 dark:text-white outline-none">
                                </div>
                            </div>

                            <div class="lg:col-span-2 flex items-end gap-3">
                                <button type="submit"
                                    class="flex-1 h-11 bg-primary text-white rounded-xl font-bold text-sm shadow-lg shadow-primary/20 hover:opacity-90 active:scale-95 transition-all">
                                    Apply Filters
                                </button>
                                <a href="{{ route('reseller.customer-orders') }}"
                                    class="h-11 px-6 bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 rounded-xl font-bold text-sm hover:bg-slate-200 transition-all flex items-center justify-center">
                                    Reset
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Table View -->
            <div class="hidden md:block overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-slate-50/50 dark:bg-slate-800/50 border-b border-slate-100 dark:border-slate-800">
                        <tr>
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Reference
                            </th>
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Customer /
                                Recipient</th>
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Product
                            </th>
                            <th
                                class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">
                                Amount / Profit</th>
                            <th
                                class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">
                                Status</th>
                            <th
                                class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">
                                Date</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50 dark:divide-slate-800">
                        @forelse($orders as $order)
                                        <tr class="hover:bg-slate-50/20 dark:hover:bg-slate-800/10 transition-colors group">
                                            <td class="px-8 py-6 whitespace-nowrap">
                                                <div class="flex flex-col">
                                                    <span
                                                        class="text-xs font-black text-slate-900 dark:text-white font-mono">#{{ substr($order->reference, 0, 10) }}</span>
                                                    <span class="text-[9px] text-slate-400 font-bold uppercase tracking-widest mt-0.5">Order
                                                        Ref</span>
                                                </div>
                                            </td>
                                            <td class="px-8 py-6">
                                                <div class="flex items-center gap-3">
                                                    <div
                                                        class="w-9 h-9 rounded-xl bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-[11px] font-black text-slate-500 border border-slate-200 dark:border-slate-700">
                                                        @if($order->user_id === auth()->id())
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                                            </svg>
                                                        @else
                                                            {{ strtoupper(substr($order->user->name, 0, 1)) }}
                                                        @endif
                                                    </div>
                                                    <div class="flex flex-col">
                                                        <span class="text-xs font-black text-slate-900 dark:text-white">
                                                            @if($order->source === 'storefront')
                                                                Storefront Guest
                                                            @else
                                                                {{ $order->user->name }}
                                                            @endif
                                                        </span>
                                                        <div class="flex flex-col gap-0.5">
                                                            <span
                                                                class="text-[9px] text-slate-400 dark:text-slate-500 font-bold uppercase tracking-tight">{{ $order->recipient_phone }}</span>
                                                            @if($order->source === 'storefront' && $order->guest_email)
                                                                <span
                                                                    class="text-[9px] text-primary/70 font-semibold lowercase tracking-tight">{{ $order->guest_email }}</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-8 py-6">
                                                <div class="flex items-center gap-2">
                                                    <div
                                                        class="px-2 py-0.5 rounded-lg text-[9px] font-black bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 uppercase border border-slate-200 dark:border-slate-700">
                                                        {{ $order->bundle->network }}
                                                    </div>
                                                    <span
                                                        class="text-xs font-bold text-slate-500 dark:text-slate-400">{{ $order->bundle->name }}</span>
                                                </div>
                                            </td>
                                            <td class="px-8 py-6 text-right">
                                                <div class="flex flex-col">
                                                    <span class="text-xs font-black text-slate-900 dark:text-white italic">GHS
                                                        {{ number_format($order->cost, 2) }}</span>
                                                    @if($order->profit > 0)
                                                        <span
                                                            class="text-[9px] text-emerald-500 font-black uppercase tracking-widest mt-0.5">Profit:
                                                            GHS {{ number_format($order->profit, 2) }}</span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="px-8 py-6">
                                                <div class="flex justify-center">
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-widest
                                                                                                                                {{ $order->status === 'completed' ? 'bg-emerald-500/10 text-emerald-600 border border-emerald-500/20' :
                            ($order->status === 'failed' ? 'bg-rose-500/10 text-rose-600 border border-rose-500/20' :
                                'bg-amber-500/10 text-amber-600 border border-amber-500/20') }}">
                                                        <span
                                                            class="w-1 h-1 rounded-full mr-1.5 {{ $order->status === 'completed' ? 'bg-emerald-500' : ($order->status === 'failed' ? 'bg-rose-500' : 'bg-amber-500') }}"></span>
                                                        {{ $order->status === 'completed' ? 'Delivered' : strtoupper($order->status) }}
                                                    </span>
                                                </div>
                                            </td>
                                            <td class="px-8 py-6 text-right whitespace-nowrap">
                                                <span
                                                    class="text-[10px] font-bold text-slate-400 dark:text-slate-600 uppercase tracking-tighter">{{ $order->created_at->format('M d, H:i') }}</span>
                                            </td>
                                        </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-8 py-24 text-center">
                                    <div class="flex flex-col items-center">
                                        <div
                                            class="w-16 h-16 bg-slate-50 dark:bg-slate-800/50 rounded-full flex items-center justify-center text-slate-300 dark:text-slate-600 mb-4 opacity-50">
                                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                                </path>
                                            </svg>
                                        </div>
                                        <h3 class="text-sm font-black text-slate-400 uppercase tracking-[0.2em]">No Orders Found
                                        </h3>
                                        <p
                                            class="text-[10px] text-slate-300 dark:text-slate-600 font-bold uppercase tracking-widest mt-1">
                                            Adjust your filters or check back later.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Mobile Card View -->
            <div class="md:hidden divide-y divide-slate-50 dark:divide-slate-800">
                @forelse($orders as $order)
                        <div class="p-6 space-y-4">
                            <div class="flex items-center justify-between">
                                <span
                                    class="text-[10px] font-black text-primary font-mono uppercase">#{{ substr($order->reference, 0, 10) }}</span>
                                <span
                                    class="inline-flex items-center px-2.5 py-1 rounded-full text-[8px] font-black uppercase tracking-widest
                                                                                    {{ $order->status === 'completed' ? 'bg-emerald-500/10 text-emerald-600' :
                    ($order->status === 'failed' ? 'bg-rose-500/10 text-rose-600' : 'bg-amber-500/10 text-amber-600') }}">
                                    {{ $order->status === 'completed' ? 'Delivered' : strtoupper($order->status) }}
                                </span>
                            </div>

                            <div class="flex items-center gap-3">
                                <div
                                    class="w-10 h-10 rounded-xl bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-xs font-black text-slate-500">
                                    @if($order->user_id === auth()->id())
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                        </svg>
                                    @else
                                        {{ strtoupper(substr($order->user->name, 0, 1)) }}
                                    @endif
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-[11px] font-black text-slate-900 dark:text-white">
                                        @if($order->source === 'storefront')
                                            Storefront Guest
                                        @else
                                            {{ $order->user->name }}
                                        @endif
                                    </span>
                                    <div class="flex items-center gap-2">
                                        <span class="text-[10px] font-bold text-slate-400">{{ $order->recipient_phone }}</span>
                                        @if($order->source === 'storefront' && $order->guest_email)
                                            <span
                                                class="text-[9px] text-primary/70 font-semibold lowercase tracking-tight">{{ $order->guest_email }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4 pt-2">
                                <div class="space-y-1">
                                    <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest block">Product</span>
                                    <div class="flex items-center gap-1.5">
                                        <div
                                            class="px-1.5 py-0.5 rounded-md text-[8px] font-black bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 uppercase border border-slate-200 dark:border-slate-700">
                                            {{ $order->bundle->network }}
                                        </div>
                                        <span
                                            class="text-[10px] font-bold text-slate-600 dark:text-slate-400">{{ $order->bundle->name }}</span>
                                    </div>
                                </div>
                                <div class="space-y-1 text-right">
                                    <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest block">Amount</span>
                                    <span class="text-xs font-black text-slate-900 dark:text-white italic">GHS
                                        {{ number_format($order->cost, 2) }}</span>
                                    @if($order->profit > 0)
                                        <span class="text-[9px] text-emerald-500 font-black block mt-0.5">+ GHS
                                            {{ number_format($order->profit, 2) }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                @empty
                    <div class="p-12 text-center text-[10px] font-bold text-slate-400 uppercase tracking-widest">No orders
                        detected.</div>
                @endforelse
            </div>

            <div class="px-6 py-8 border-t border-slate-100 dark:border-slate-800 bg-slate-50/20 dark:bg-slate-950/10">
                <div class="md:flex items-center justify-between gap-4">
                    <div
                        class="text-[10px] font-bold text-slate-400 uppercase tracking-widest text-center md:text-left mb-4 md:mb-0">
                        Records: {{ $orders->firstItem() ?? 0 }}-{{ $orders->lastItem() ?? 0 }} of {{ $orders->total() }}
                    </div>
                    <div>
                        {{ $orders->appends(request()->query())->links('pagination::simple-tailwind') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection