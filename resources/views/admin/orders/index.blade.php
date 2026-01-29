@extends('layouts.admin')

@section('title', 'Order Management')

@section('content')
    <div class="space-y-6 pb-12 animate-in fade-in slide-in-from-bottom-4 duration-700">
        {{-- Header Section --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-3xl font-bold tracking-tight text-slate-900 dark:text-white">Order Management</h2>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Coordinate logistics and monitor data deliveries.
                </p>
            </div>

            <div class="flex items-center gap-3 w-full md:w-auto">
                {{-- Export Button --}}
                <a href="{{ route('admin.orders.export', request()->all()) }}"
                    class="h-11 px-6 bg-emerald-600 text-white rounded-xl font-bold text-sm shadow-lg shadow-emerald-200/50 hover:bg-emerald-700 active:scale-95 transition-all flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                    Export
                </a>

                {{-- Search --}}
                <div class="relative flex-1 md:w-80 group">
                    <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400 group-focus-within:text-primary transition-colors"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <input type="text" id="searchInput" placeholder="Search reference, phone, customer..."
                        value="{{ request('search') }}"
                        class="h-11 w-full pl-10 pr-4 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl text-sm font-medium outline-none focus:ring-4 focus:ring-primary/10 transition-all">
                </div>
            </div>
        </div>

        @if(request('user_id'))
            @php $filteredUser = \App\Models\User::find(request('user_id')); @endphp
            @if($filteredUser)
                <div
                    class="flex items-center gap-3 bg-primary/5 border border-primary/10 px-4 py-2.5 rounded-2xl w-fit animate-in fade-in slide-in-from-left-4 duration-500">
                    <div
                        class="w-8 h-8 rounded-lg bg-primary text-white flex items-center justify-center font-black text-xs shadow-lg shadow-primary/20">
                        {{ strtoupper(substr($filteredUser->name, 0, 1)) }}
                    </div>
                    <div>
                        <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 leading-none">Filtering Protocol
                        </p>
                        <p class="text-sm font-black text-slate-900 dark:text-white mt-1">{{ $filteredUser->name }}'s Ledger</p>
                    </div>
                    <a href="{{ route('admin.orders') }}"
                        class="ml-2 p-1.5 hover:bg-rose-50 dark:hover:bg-rose-900/20 text-slate-400 hover:text-rose-600 rounded-lg transition-all"
                        title="Clear Filter">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </a>
                </div>
            @endif
        @endif

        {{-- Filters Section --}}
        <div class="flex flex-col gap-4">
            {{-- Status Filter Tabs --}}
            <div class="flex gap-2 p-1 bg-slate-100 dark:bg-slate-800/50 rounded-xl w-fit overflow-x-auto scrollbar-hide">
                @php
                    $statusMap = ['all' => 'All Status', 'awaiting_transfer' => 'Awaiting Transfer', 'pending' => 'Validating', 'processing' => 'Processing', 'completed' => 'Delivered', 'failed' => 'Failed'];
                @endphp
                @foreach(['all', 'awaiting_transfer', 'pending', 'processing', 'completed', 'failed'] as $s)
                        <button onclick="filterBy('status', '{{ $s }}')" class="px-4 py-2 rounded-lg text-xs font-bold capitalize transition-all whitespace-nowrap
                                                                                                                                    {{ request('status', 'all') == $s
                    ? 'bg-white dark:bg-slate-900 text-slate-900 dark:text-white shadow-sm'
                    : 'text-slate-500 hover:text-slate-700 dark:hover:text-slate-300' }}">
                            {{ $statusMap[$s] }}
                        </button>
                @endforeach
            </div>

            {{-- Filter Actions --}}
            <div class="flex items-center gap-3">
                {{-- Network Filter Tabs --}}
                <div
                    class="flex gap-2 p-1 bg-slate-100 dark:bg-slate-800/50 rounded-xl w-fit overflow-x-auto scrollbar-hide">
                    <button onclick="filterBy('network', 'all')" class="px-4 py-2 rounded-lg text-xs font-bold capitalize transition-all whitespace-nowrap
                                                                            {{ request('network', 'all') == 'all'
        ? 'bg-white dark:bg-slate-900 text-slate-900 dark:text-white shadow-sm'
        : 'text-slate-500 hover:text-slate-700 dark:hover:text-slate-300' }}">
                        All Networks
                    </button>
                    @foreach($networks as $network)
                                <button onclick="filterBy('network', '{{ $network }}')" class="px-4 py-2 rounded-lg text-xs font-bold uppercase transition-all whitespace-nowrap
                                                                                                                                        {{ request('network') == $network
                        ? 'bg-white dark:bg-slate-900 text-slate-900 dark:text-white shadow-sm'
                        : 'text-slate-500 hover:text-slate-700 dark:hover:text-slate-300' }}">
                                    {{ $network }}
                                </button>
                    @endforeach
                </div>

                @if(request()->anyFilled(['status', 'network', 'user_id', 'search']))
                    <a href="{{ route('admin.orders') }}"
                        class="px-4 py-2 bg-rose-50 dark:bg-rose-900/20 text-rose-600 dark:text-rose-400 rounded-xl text-xs font-black uppercase tracking-widest hover:bg-rose-100 transition-all flex items-center gap-2">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12">
                            </path>
                        </svg>
                        Clear All
                    </a>
                @endif
            </div>
        </div>

        {{-- Network Summary --}}
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 xl:grid-cols-7 gap-4">
            {{-- Global Total Card --}}
            <div class="p-4 rounded-2xl border border-primary/20 bg-primary/5 shadow-sm flex items-center justify-between group transition-all cursor-pointer hover:bg-primary/10 hover:scale-[1.02] active:scale-95"
                onclick="window.location.href='{{ route('admin.orders') }}'">
                <div>
                    <p class="text-[11px] font-black uppercase tracking-widest text-primary/60">Global Stream</p>
                    <p class="text-2xl font-black tabular-nums text-primary">{{ $totalFilteredOrders }}</p>
                </div>
                <div
                    class="w-10 h-10 rounded-xl bg-primary text-white flex items-center justify-center shadow-lg shadow-primary/20">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                        </path>
                    </svg>
                </div>
            </div>

            @foreach($networks as $net)
                @php
                    $count = $networkCounts[$net] ?? 0;
                    $netColors = [
                        'MTN' => 'bg-amber-400 text-amber-950 border-amber-500/50',
                        'Telecel' => 'bg-rose-600 text-white border-rose-700/50',
                        'AirtelTigo' => 'bg-sky-600 text-white border-sky-700/50',
                        'AT' => 'bg-sky-600 text-white border-sky-700/50',
                    ];
                    $nc = $netColors[$net] ?? 'bg-white dark:bg-slate-900 text-slate-900 dark:text-white border-slate-100 dark:border-slate-800';
                @endphp
                @if($count > 0)
                    <div class="p-4 rounded-2xl border shadow-sm flex items-center justify-between group transition-all cursor-pointer {{ $nc }} hover:scale-[1.02] active:scale-95"
                        onclick="filterBy('network', '{{ $net }}')">
                        <div>
                            <p class="text-[11px] font-black uppercase tracking-widest opacity-80">{{ $net }}</p>
                            <p class="text-2xl font-black tabular-nums">{{ $count }}</p>
                        </div>
                        <div class="w-10 h-10 rounded-xl bg-white/20 backdrop-blur-md flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>

        {{-- Orders Table / Responsive Grid --}}
        <div class="relative" x-data="{ loading: false }">
            <!-- Helper for loading overlay if needed in future ajax -->
            <div x-show="loading"
                class="absolute inset-0 bg-white/50 dark:bg-slate-900/50 backdrop-blur-sm z-10 flex items-center justify-center rounded-2xl"
                style="display: none;">
                <svg class="animate-spin h-8 w-8 text-primary" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor"
                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                    </path>
                </svg>
            </div>

            <!-- Table View -->
            <div
                class="bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 rounded-2xl overflow-hidden shadow-sm">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-slate-50 dark:bg-slate-800/50 border-b border-slate-100 dark:border-slate-800">
                            <tr>
                                <th
                                    class="px-6 py-4 text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">
                                    Order ID</th>
                                <th
                                    class="px-6 py-4 text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">
                                    Customer</th>
                                <th
                                    class="px-6 py-4 text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">
                                    Bundle Info</th>
                                <th
                                    class="px-6 py-4 text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest text-right">
                                    Cost</th>
                                <th
                                    class="px-6 py-4 text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest text-center">
                                    Status</th>
                                <th
                                    class="px-6 py-4 text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest text-center">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50 dark:divide-slate-800">
                            @forelse($orders as $order)
                                <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-colors group">
                                    <td class="px-6 py-4">
                                        <div class="flex flex-col">
                                            <span
                                                class="font-mono text-sm font-bold text-primary">#{{ substr($order->reference, 0, 12) }}...</span>
                                            <span
                                                class="text-[10px] text-slate-500 dark:text-slate-500 mt-1 uppercase tracking-tighter">{{ $order->created_at->format('M d, H:i') }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-8 h-8 rounded-lg bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-500 dark:text-slate-400 font-bold text-[10px]">
                                                {{ strtoupper(substr($order->user->name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <p class="font-bold text-sm text-slate-900 dark:text-white leading-none">
                                                    {{ $order->user->name }}
                                                </p>
                                                <p class="text-[10px] text-slate-500 dark:text-slate-500 mt-1">
                                                    {{ $order->user->phone }}
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2">
                                            <span
                                                class="px-2 py-0.5 rounded text-[10px] font-bold bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 uppercase border border-slate-200 dark:border-slate-700">
                                                {{ $order->bundle->network }}
                                            </span>
                                            <div class="flex flex-col">
                                                <span
                                                    class="text-sm font-semibold text-slate-900 dark:text-slate-200">{{ $order->bundle->name }}</span>
                                                <span
                                                    class="text-[10px] text-slate-500 font-mono">{{ $order->recipient_phone }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <p class="text-sm font-bold text-slate-900 dark:text-white">GHC
                                            {{ number_format($order->cost, 2) }}
                                        </p>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @php
                                            $statuses = [
                                                'pending' => 'bg-amber-50 dark:bg-amber-900/20 text-amber-600',
                                                'processing' => 'bg-blue-50 dark:bg-blue-900/20 text-blue-600',
                                                'completed' => 'bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600',
                                                'failed' => 'bg-rose-50 dark:bg-rose-900/20 text-rose-600',
                                            ];
                                            $sc = $statuses[$order->status] ?? 'bg-slate-50 dark:bg-slate-800 text-slate-600';
                                        @endphp
                                        <span
                                            class="inline-flex items-center px-2.5 py-1 rounded-lg text-[10px] font-bold uppercase tracking-tight {{ $sc }}">
                                            {{ $statusLabels[$order->status] ?? $order->status }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-center gap-2" x-data="{ open: false }">
                                            <div class="relative">
                                                <button @click="open = !open" @click.outside="open = false"
                                                    class="w-8 h-8 rounded-lg bg-slate-50 dark:bg-slate-800 hover:bg-primary/5 dark:hover:bg-primary/10 text-slate-400 hover:text-primary transition-all flex items-center justify-center">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z">
                                                        </path>
                                                    </svg>
                                                </button>

                                                <div x-show="open" x-cloak
                                                    class="absolute right-0 mt-2 w-48 bg-white dark:bg-slate-900 rounded-xl shadow-xl border border-slate-100 dark:border-slate-800 z-10 p-1 animate-in slide-in-from-top-2 duration-200">
                                                    @foreach(['pending', 'processing', 'completed', 'failed'] as $st)
                                                        <button onclick="updateStatus({{ $order->id }}, '{{ $st }}')"
                                                            class="w-full text-left px-3 py-2 rounded-lg text-xs font-bold capitalize hover:bg-slate-50 dark:hover:bg-slate-800 border-none {{ $order->status === $st ? 'text-primary' : 'text-slate-600 dark:text-slate-400' }}">
                                                            Mark as {{ $statusLabels[$st] ?? $st }}
                                                        </button>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-24 text-center">
                                        <div class="flex flex-col items-center gap-3 text-slate-400 dark:text-slate-600">
                                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                            </svg>
                                            <p class="font-medium">No order activity recorded</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        @if ($orders->isNotEmpty())
            <div
                class="px-6 py-4 border-t border-slate-50 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/20 flex items-center justify-between">
                <div class="text-xs font-bold text-slate-500 dark:text-slate-500 uppercase tracking-widest italic">Global
                    Stream: {{ $orders->total() }} Records</div>
                <div>{{ $orders->links() }}</div>
            </div>
        @endif
    </div>
    </div>

    @push('scripts')
        <script>
            function filterBy(key, value) {
                const url = new URL(window.location.href);
                if (value === 'all') {
                    url.searchParams.delete(key);
                } else {
                    url.searchParams.set(key, value);
                }
                // Reset page on filter change
                url.searchParams.delete('page');
                window.location.href = url.href;
            }

            async function updateStatus(orderId, status) {
                if (!confirm(`Update order #${orderId} to ${status}?`)) return;

                try {
                    const response = await fetch(`{{ url('admin/orders') }}/${orderId}`, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ status })
                    });

                    if (response.ok) {
                        window.location.reload();
                    } else {
                        const data = await response.json();
                        alert(data.message || 'Verification Error');
                    }
                } catch (e) {
                    alert('Network Communication Error');
                }
            }

            document.getElementById('searchInput').addEventListener('keypress', function (e) {
                if (e.key === 'Enter') {
                    const url = new URL(window.location.href);
                    url.searchParams.set('search', this.value);
                    window.location.href = url.href;
                }
            });
        </script>
    @endpush
@endsection