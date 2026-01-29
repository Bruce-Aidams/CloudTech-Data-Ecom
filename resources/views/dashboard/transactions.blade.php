@extends('layouts.dashboard')

@section('title', 'Transaction History')

@section('content')
    <div class="max-w-7xl mx-auto space-y-8 animate-in fade-in slide-in-from-bottom-4 duration-700">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <h2 class="text-3xl font-black tracking-tight text-foreground bg-clip-text text-transparent bg-gradient-to-r from-primary to-indigo-500">Transaction History</h2>
                <p class="text-muted-foreground font-medium">A detailed record of all your financial transactions.</p>
            </div>
        </div>

        <!-- Transactions Card -->
        <div class="rounded-[2.5rem] border border-border/50 bg-card/50 backdrop-blur-xl shadow-2xl shadow-slate-200/20 dark:shadow-none overflow-hidden">
            <!-- Filter Header -->
            <div class="flex flex-col lg:flex-row items-center justify-between p-8 gap-6 border-b border-border/10">
                <div class="flex items-center gap-6 flex-1 w-full lg:w-auto">
                    <!-- Search -->
                    <form action="{{ route('transactions.index') }}" method="GET" class="relative flex-1 max-w-md w-full">
                        <div class="absolute left-5 top-1/2 -translate-y-1/2 text-slate-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <input type="text" name="search" placeholder="Search by reference..."
                            value="{{ request('search') }}"
                            class="w-full h-14 pl-14 pr-6 bg-slate-100/50 dark:bg-slate-800/50 border-none rounded-2xl text-sm font-black tracking-tight focus:ring-2 focus:ring-primary/20 outline-none transition-all placeholder:text-slate-400">
                        
                         @if(request('type')) <input type="hidden" name="type" value="{{ request('type') }}"> @endif
                         @if(request('status')) <input type="hidden" name="status" value="{{ request('status') }}"> @endif
                    </form>

                    <div class="flex items-center gap-3 hidden sm:flex">
                        <form id="filterForm" action="{{ route('transactions.index') }}" method="GET" class="flex items-center gap-3">
                            @if(request('search')) <input type="hidden" name="search" value="{{ request('search') }}"> @endif
                            
                            <div class="relative group">
                                <select name="type" onchange="document.getElementById('filterForm').submit()"
                                    class="appearance-none h-14 bg-primary/10 pl-6 pr-12 rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] text-primary cursor-pointer border border-primary/20 transition-all outline-none group-hover:bg-primary/20">
                                    <option value="">All Transactions</option>
                                    <option value="credit" {{ request('type') === 'credit' ? 'selected' : '' }}>Credits Only</option>
                                    <option value="debit" {{ request('type') === 'debit' ? 'selected' : '' }}>Debits Only</option>
                                </select>
                                <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-primary">
                                     <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>

                             <div class="relative group">
                                <select name="status" onchange="document.getElementById('filterForm').submit()"
                                    class="appearance-none h-14 bg-slate-100 dark:bg-slate-800 pl-6 pr-12 rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] text-slate-500 cursor-pointer border border-transparent transition-all outline-none group-hover:bg-slate-200 dark:group-hover:bg-slate-700">
                                    <option value="">All Statuses</option>
                                    <option value="success" {{ request('status') === 'success' ? 'selected' : '' }}>Completed</option>
                                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Validating</option>
                                    <option value="failed" {{ request('status') === 'failed' ? 'selected' : '' }}>Failed</option>
                                </select>
                                 <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">
                                     <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                            
                            @if(request('type') || request('status') || request('search'))
                                <a href="{{ route('transactions.index') }}" class="w-14 h-14 rounded-2xl bg-rose-50 dark:bg-rose-900/10 flex items-center justify-center text-rose-500 hover:scale-95 transition-all" title="Reset Filters">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </a>
                            @endif
                        </form>
                    </div>
                </div>
            </div>

            {{-- Mobile List View --}}
            <div class="lg:hidden divide-y divide-border/10">
                @forelse($transactions as $trx)
                    <div class="p-6 space-y-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl flex items-center justify-center {{ $trx->type === 'credit' ? 'bg-emerald-100 text-emerald-600 dark:bg-emerald-900/20 dark:text-emerald-400' : 'bg-rose-100 text-rose-600 dark:bg-rose-900/20 dark:text-rose-400' }}">
                                    @if($trx->type === 'credit')
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
                                    @else
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                                    @endif
                                </div>
                                <div>
                                    <p class="font-mono text-[9px] font-black text-primary tracking-widest">#{{ strtoupper(substr($trx->reference, 0, 10)) }}</p>
                                    <p class="text-[9px] font-black text-slate-400 mt-1 uppercase">{{ $trx->created_at->format('d M, Y') }}</p>
                                </div>
                            </div>
                            <span class="text-lg font-black tracking-tighter {{ $trx->type === 'credit' ? 'text-emerald-600' : 'text-foreground' }}">
                                {{ $trx->type === 'credit' ? '+' : '-' }}₵{{ number_format($trx->amount, 2) }}
                            </span>
                        </div>
                        <div class="bg-slate-50 dark:bg-slate-800/50 rounded-2xl p-4">
                            <p class="text-[11px] font-black text-foreground mb-2">{{ $trx->description }}</p>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <div class="h-1.5 w-1.5 rounded-full {{ $trx->status === 'success' || $trx->status === 'completed' ? 'bg-emerald-500' : ($trx->status === 'pending' ? 'bg-amber-500' : 'bg-rose-500') }}"></div>
                                    <p class="text-[9px] font-black uppercase text-slate-400 tracking-widest">
                                        {{ $trx->status === 'success' ? 'Delivered' : ($trx->status === 'pending' ? 'Validating' : ucfirst($trx->status)) }}
                                    </p>
                                </div>
                                <a href="{{ route('billing.invoice', $trx->id) }}" class="text-[9px] font-black text-primary uppercase tracking-widest flex items-center gap-1">
                                    Invoice 
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="py-20 text-center opacity-20"><p class="text-[10px] font-black uppercase tracking-widest">No transactions</p></div>
                @endforelse
            </div>

            {{-- Desktop Table View --}}
            <div class="hidden lg:block overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="border-b border-border/10">
                            <th class="px-10 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400">Type</th>
                            <th class="px-10 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400">Reference</th>
                            <th class="px-10 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400">Details</th>
                            <th class="px-10 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400">Amount</th>
                            <th class="px-10 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400 text-right">Date</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border/10">
                        @foreach($transactions as $trx)
                            <tr class="group hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-all duration-300">
                                <td class="px-10 py-6">
                                    <div class="w-12 h-12 rounded-2xl flex items-center justify-center {{ $trx->type === 'credit' ? 'bg-emerald-100 text-emerald-600 dark:bg-emerald-900/20 dark:text-emerald-400' : 'bg-rose-100 text-rose-600 dark:bg-rose-900/20 dark:text-rose-400' }}">
                                        @if($trx->type === 'credit')
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
                                        @else
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-10 py-6">
                                    <p class="font-mono text-[10px] font-black text-primary tracking-widest">#{{ strtoupper(substr($trx->reference, 0, 12)) }}</p>
                                    <p class="text-[9px] font-black text-slate-400 mt-1 uppercase tracking-tighter">NODE-{{ $trx->id }}</p>
                                </td>
                                <td class="px-10 py-6">
                                    <p class="font-black text-sm text-foreground mb-1">{{$trx->description}}</p>
                                    <div class="flex items-center gap-2">
                                        <div class="h-1.5 w-1.5 rounded-full {{ $trx->status === 'success' || $trx->status === 'completed' ? 'bg-emerald-500' : ($trx->status === 'pending' ? 'bg-amber-500' : 'bg-rose-500') }}"></div>
                                        <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest">
                                            {{ $trx->status === 'success' ? 'Delivered' : ($trx->status === 'pending' ? 'Validating' : ucfirst($trx->status)) }}
                                        </p>
                                    </div>
                                </td>
                                <td class="px-10 py-6">
                                    <span class="text-xl font-black tracking-tighter {{ $trx->type === 'credit' ? 'text-emerald-600' : 'text-foreground' }}">
                                        {{ $trx->type === 'credit' ? '+' : '-' }}GHS {{ number_format($trx->amount, 2) }}
                                    </span>
                                </td>
                                <td class="px-10 py-6 text-right">
                                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest leading-relaxed">
                                        {{ $trx->created_at->format('M d, Y') }}<br>
                                        <span class="opacity-50 text-[9px]">{{ $trx->created_at->format('h:i A') }}</span>
                                    </p>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>


            @if($transactions->hasPages())
                <div class="p-10 border-t border-border/10 flex flex-col sm:flex-row items-center justify-between gap-6">
                    <span class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Showing: {{ $transactions->firstItem() ?? 0 }} - {{ $transactions->lastItem() ?? 0 }} of {{ $transactions->total() }}</span>
                    <div class="modern-pagination">
                        {{ $transactions->withQueryString()->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
