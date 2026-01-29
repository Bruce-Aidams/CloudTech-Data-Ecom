@extends('layouts.admin')

@section('title', 'Invoice Management')

@section('content')
    <div class="space-y-8 pb-12 animate-in fade-in slide-in-from-bottom-4 duration-700">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <h2 class="text-3xl font-bold tracking-tight text-slate-900 dark:text-white">Financial Documents</h2>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Platform-wide financial transparency and record
                    auditing.</p>
            </div>
            <div
                class="flex items-center gap-2 bg-emerald-50 dark:bg-emerald-900/20 px-3 py-1.5 rounded-full border border-emerald-100 dark:border-emerald-800/50">
                <div class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></div>
                <span class="text-[10px] font-bold uppercase tracking-wider text-emerald-700 dark:text-emerald-400">System
                    Audit Engaged</span>
            </div>
        </div>

        <!-- Filters & Search -->
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
            <form action="{{ route('admin.invoices.index') }}" method="GET" class="relative w-full lg:max-w-md group">
                <div
                    class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400 group-focus-within:text-primary transition-colors">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <input type="text" name="search" placeholder="Search reference, email or entity..."
                    value="{{ request('search') }}"
                    class="h-11 w-full pl-11 pr-4 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl text-sm font-medium outline-none focus:ring-4 focus:ring-primary/10 transition-all dark:text-white">
            </form>

            <div class="flex gap-2 p-1 bg-slate-100 dark:bg-slate-800/50 rounded-xl w-fit overflow-x-auto">
                <a href="{{ route('admin.invoices.index') }}"
                    class="px-4 py-2 rounded-lg text-xs font-bold transition-all {{ !request('type') ? 'bg-white dark:bg-slate-900 text-slate-900 dark:text-white shadow-sm' : 'text-slate-500 hover:text-slate-700 dark:hover:text-slate-300' }}">
                    All Logs
                </a>
                <a href="{{ route('admin.invoices.index', ['type' => 'credit']) }}"
                    class="px-4 py-2 rounded-lg text-xs font-bold transition-all {{ request('type') == 'credit' ? 'bg-white dark:bg-slate-900 text-emerald-600 shadow-sm' : 'text-slate-500 hover:text-emerald-600' }}">
                    Credits
                </a>
                <a href="{{ route('admin.invoices.index', ['type' => 'debit']) }}"
                    class="px-4 py-2 rounded-lg text-xs font-bold transition-all {{ request('type') == 'debit' ? 'bg-white dark:bg-slate-900 text-rose-600 shadow-sm' : 'text-slate-500 hover:text-rose-600' }}">
                    Debits
                </a>
            </div>
        </div>

        <!-- Ledger Table -->
        <div
            class="bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 rounded-3xl overflow-hidden shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-slate-50 dark:bg-slate-800/50 border-b border-slate-100 dark:border-slate-800">
                        <tr>
                            <th
                                class="px-8 py-4 text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">
                                Execution Point</th>
                            <th
                                class="px-8 py-4 text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">
                                Entity</th>
                            <th
                                class="px-8 py-4 text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">
                                Protocol Metadata</th>
                            <th
                                class="px-8 py-4 text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest text-right">
                                Value (GHS)</th>
                            <th
                                class="px-8 py-4 text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest text-center">
                                Export</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50 dark:divide-slate-800">
                        @forelse($transactions as $transaction)
                            <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-colors group">
                                <td class="px-8 py-6">
                                    <span
                                        class="font-bold text-sm text-slate-900 dark:text-white block">{{ $transaction->created_at->format('d M, Y') }}</span>
                                    <span
                                        class="text-[10px] text-slate-500 dark:text-slate-500 mt-1 uppercase">{{ $transaction->created_at->format('h:i A') }}</span>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="flex items-center gap-4">
                                        <div
                                            class="w-10 h-10 rounded-xl bg-slate-900 dark:bg-slate-800 flex items-center justify-center text-white font-bold text-sm">
                                            {{ strtoupper(substr($transaction->user->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="font-bold text-sm text-slate-900 dark:text-white leading-none">
                                                {{ $transaction->user->name }}</p>
                                            <p class="text-[10px] text-slate-500 dark:text-slate-500 mt-1.5">
                                                {{ $transaction->user->email }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    <p class="text-xs font-bold text-slate-700 dark:text-slate-300 leading-snug">
                                        {{ Str::limit($transaction->description, 45) }}</p>
                                    <span
                                        class="font-mono text-[9px] font-bold text-primary uppercase tracking-widest mt-1.5 block">#{{ $transaction->reference }}</span>
                                </td>
                                <td class="px-8 py-6 text-right">
                                    <span
                                        class="text-base font-black tabular-nums {{ $transaction->type === 'credit' ? 'text-emerald-500' : 'text-rose-500' }}">
                                        {{ $transaction->type === 'credit' ? '+' : '-' }}
                                        {{ number_format($transaction->amount, 2) }}
                                    </span>
                                    <p
                                        class="text-[9px] font-bold text-slate-400 dark:text-slate-600 uppercase tracking-tighter mt-1">
                                        {{ $transaction->type }}</p>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="flex justify-center">
                                        <a href="{{ route('admin.invoices.download', $transaction->id) }}"
                                            class="w-10 h-10 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-400 hover:text-primary hover:border-primary transition-all flex items-center justify-center group/btn shadow-sm">
                                            <svg class="w-5 h-5 group-hover/btn:scale-110 transition-transform" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                    d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                                </path>
                                            </svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-24 text-center text-slate-400 dark:text-slate-700 opacity-50">
                                    <svg class="w-16 h-16 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                        </path>
                                    </svg>
                                    <p class="font-bold uppercase tracking-widest italic text-sm">Binary Records Missing</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($transactions->hasPages())
                <div
                    class="px-8 py-6 bg-slate-50/50 dark:bg-slate-800/20 border-t border-slate-50 dark:border-slate-800 flex items-center justify-between">
                    <span class="text-[10px] font-bold uppercase tracking-widest text-slate-400 italic">Page Matrix:
                        {{ $transactions->currentPage() }} / {{ $transactions->lastPage() }}</span>
                    <div>{{ $transactions->links() }}</div>
                </div>
            @endif
        </div>
    </div>
@endsection