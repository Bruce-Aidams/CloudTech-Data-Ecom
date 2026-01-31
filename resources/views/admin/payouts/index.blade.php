@extends('layouts.admin')

@section('title', 'Payout Requests')

@section('content')
    <div class="space-y-8 pb-12 animate-in fade-in slide-in-from-bottom-4 duration-700">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-teal-500/10 flex items-center justify-center text-teal-500 ring-1 ring-teal-500/20">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-3xl font-bold tracking-tight text-blue-900 dark:text-white">Capital Disbursement</h2>
                    <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Review and process user withdrawal requests.</p>
                </div>
            </div>
            <div
                class="flex items-center gap-2 bg-amber-50 dark:bg-amber-900/20 px-3 py-1.5 rounded-full border border-amber-100 dark:border-amber-800/50">
                <div class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></div>
                <span class="text-[10px] font-bold uppercase tracking-wider text-amber-700 dark:text-amber-400">Audit
                    Protocol Active</span>
            </div>
        </div>

        @if(session('success'))
            <div
                class="bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800/50 rounded-2xl p-4 text-emerald-700 dark:text-emerald-400 text-sm font-bold flex items-center gap-3 animate-in slide-in-from-top-2 duration-300">
                <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                </svg>
                Disbursement status localized and updated.
            </div>
        @endif

        <!-- Stat Cards -->
        <div class="grid gap-6 md:grid-cols-3">
            <div
                class="relative p-8 rounded-3xl bg-white dark:bg-slate-900 shadow-sm border border-slate-100 dark:border-slate-800 overflow-hidden group">
                <div
                    class="absolute right-[-20px] top-[-20px] opacity-5 transition-transform duration-700 group-hover:rotate-12 text-amber-500">
                    <svg class="w-32 h-32" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="relative z-10 space-y-2">
                    <p class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">Validating
                        Disbursals</p>
                    <h3 class="text-3xl font-black text-amber-600 dark:text-amber-500 tabular-nums">{{ $stats['pending'] }}
                    </h3>
                    <p class="text-[9px] text-slate-400 font-bold uppercase">Awaiting authorization</p>
                </div>
            </div>

            <div
                class="relative p-8 rounded-3xl bg-white dark:bg-slate-900 shadow-sm border border-slate-100 dark:border-slate-800 overflow-hidden group">
                <div
                    class="absolute right-[-20px] top-[-20px] opacity-5 transition-transform duration-700 group-hover:rotate-12 text-emerald-500">
                    <svg class="w-32 h-32" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <div class="relative z-10 space-y-2">
                    <p class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">Settled
                        Requests</p>
                    <h3 class="text-3xl font-black text-emerald-600 dark:text-emerald-500 tabular-nums">
                        {{ $stats['approved'] }}</h3>
                    <p class="text-[9px] text-slate-400 font-bold uppercase">Successfully projected</p>
                </div>
            </div>

            <div
                class="relative p-8 rounded-3xl bg-slate-900 dark:bg-slate-800 text-white shadow-xl shadow-slate-900/20 overflow-hidden group">
                <div
                    class="absolute right-[-20px] top-[-20px] opacity-10 transition-transform duration-700 group-hover:rotate-12">
                    <svg class="w-32 h-32" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                        </path>
                    </svg>
                </div>
                <div class="relative z-10 space-y-2">
                    <p class="text-[10px] font-bold text-white/50 uppercase tracking-widest">Aggregate Yield Outflow</p>
                    <h3 class="text-3xl font-black tabular-nums">GHC {{ number_format($stats['total_amount'], 2) }}</h3>
                    <p class="text-[9px] text-white/40 font-bold uppercase">Cumulative disbursement volume</p>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex gap-2 p-1 bg-slate-100 dark:bg-slate-800/50 rounded-xl w-fit overflow-x-auto">
                <a href="{{ route('admin.payouts') }}"
                    class="px-4 py-2 rounded-lg text-xs font-bold transition-all {{ !request('status') ? 'bg-white dark:bg-slate-900 text-slate-900 dark:text-white shadow-sm' : 'text-slate-500 hover:text-slate-700 dark:hover:text-slate-300' }}">
                    All Requests
                </a>
                @foreach(['pending', 'processing', 'completed', 'rejected'] as $status)
                    <a href="{{ route('admin.payouts', ['status' => $status]) }}"
                        class="px-4 py-2 rounded-lg text-xs font-bold capitalize transition-all {{ request('status') === $status ? 'bg-white dark:bg-slate-900 text-slate-900 dark:text-white shadow-sm' : 'text-slate-500 hover:text-slate-700 dark:hover:text-slate-300' }}">
                        {{ $status }}
                    </a>
                @endforeach
            </div>

            <div class="relative min-w-[140px]">
                <form action="{{ route('admin.payouts') }}" method="GET">
                    @if(request('status'))
                        <input type="hidden" name="status" value="{{ request('status') }}">
                    @endif
                    <select name="per_page" onchange="this.form.submit()"
                        class="h-11 w-full px-4 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl text-xs font-bold uppercase tracking-widest outline-none focus:ring-4 focus:ring-primary/10 transition-all dark:text-slate-400 appearance-none cursor-pointer">
                        @foreach([10, 20, 50, 100, 200] as $val)
                            <option value="{{ $val }}" {{ request('per_page', 10) == $val ? 'selected' : '' }}>{{ $val }} Per
                                Page</option>
                        @endforeach
                    </select>
                </form>
            </div>
        </div>

        <!-- Payout Table -->
        <div
            class="bg-white dark:bg-slate-900 rounded-3xl shadow-sm border border-slate-100 dark:border-slate-800 overflow-hidden">

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-slate-50 dark:bg-slate-800/50 border-b border-slate-100 dark:border-slate-800">
                        <tr>
                            <th
                                class="px-8 py-4 text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">
                                Entity</th>
                            <th
                                class="px-6 py-4 text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">
                                Quantum</th>
                            <th
                                class="px-6 py-4 text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">
                                Bank Details</th>
                            <th
                                class="px-6 py-4 text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest text-center">
                                Status</th>
                            <th
                                class="px-6 py-4 text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">
                                Timestamp</th>
                            <th
                                class="px-8 py-4 text-right text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">
                                Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50 dark:divide-slate-800">
                        @forelse($payouts as $payout)
                            <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-colors group">
                                <td class="px-8 py-6">
                                    <div class="flex items-center gap-4">
                                        <div
                                            class="w-10 h-10 rounded-xl bg-slate-900 dark:bg-slate-800 flex items-center justify-center text-white font-bold text-sm">
                                            {{ strtoupper(substr($payout->user->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="font-bold text-sm text-slate-900 dark:text-white leading-none">
                                                {{ $payout->user->name }}</p>
                                            <p class="text-[10px] text-slate-500 dark:text-slate-500 mt-1.5">
                                                {{ $payout->user->email }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-6 whitespace-nowrap">
                                    <span class="text-base font-black text-slate-900 dark:text-white tabular-nums">GHC
                                        {{ number_format($payout->amount, 2) }}</span>
                                </td>
                                <td class="px-6 py-6">
                                    <p
                                        class="text-[11px] font-bold text-slate-700 dark:text-slate-300 uppercase tracking-tight">
                                        {{ $payout->bank_name }}</p>
                                    <p class="font-mono text-[11px] text-slate-500 dark:text-slate-500 mt-0.5">
                                        {{ $payout->account_number }}</p>
                                </td>
                                <td class="px-6 py-6 text-center">
                                    @php
                                        $statuses = [
                                            'completed' => 'bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600',
                                            'pending' => 'bg-amber-50 dark:bg-amber-900/20 text-amber-600',
                                            'failed' => 'bg-rose-50 dark:bg-rose-900/20 text-rose-600',
                                        ];
                                        $sc = $statuses[$payout->status] ?? 'bg-slate-50 dark:bg-slate-800 text-slate-600';
                                    @endphp
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-lg text-[10px] font-bold uppercase tracking-tight {{ $sc }}">
                                        {{ $payout->status === 'pending' ? 'Validating' : $payout->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-6 whitespace-nowrap">
                                    <span
                                        class="text-xs font-bold text-slate-500 dark:text-slate-500">{{ $payout->created_at->format('d M, Y') }}</span>
                                </td>
                                <td class="px-8 py-6 text-right">
                                    @if($payout->status === 'pending')
                                        <div class="flex gap-2 justify-end">
                                            <form action="{{ route('admin.payouts.approve', $payout->id) }}" method="POST">
                                                @csrf
                                                <button type="submit"
                                                    class="h-9 px-4 bg-primary text-white rounded-xl font-bold text-[10px] uppercase tracking-wide hover:opacity-90 transition-all shadow-lg shadow-primary/10 active:scale-95">Authorize</button>
                                            </form>
                                            <form action="{{ route('admin.payouts.reject', $payout->id) }}" method="POST">
                                                @csrf
                                                <button type="submit"
                                                    class="h-9 px-4 bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 rounded-xl font-bold text-[10px] uppercase tracking-wide hover:bg-rose-50 dark:hover:bg-rose-900/20 hover:text-rose-600 transition-all active:scale-95">Purge</button>
                                            </form>
                                        </div>
                                    @else
                                        <p
                                            class="text-[10px] font-bold uppercase tracking-[.2em] text-slate-300 dark:text-slate-700 italic">
                                            Archived</p>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-24 text-center text-slate-400 dark:text-slate-700">
                                    <svg class="w-16 h-16 mx-auto mb-4 opacity-30" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                        </path>
                                    </svg>
                                    <p class="font-bold uppercase tracking-widest italic text-sm">Disbursement Stream Empty</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($payouts->hasPages())
                <div class="px-8 py-6 bg-slate-50/50 dark:bg-slate-800/20 border-t border-slate-50 dark:border-slate-800">
                    {{ $payouts->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection