@extends('layouts.dashboard')

@section('title', 'Reseller Management')

@section('content')
    <div class="space-y-6 animate-in fade-in slide-in-from-bottom-4 duration-700">
        {{-- Header --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-black text-slate-900 dark:text-white uppercase tracking-tight">Resellers</h2>
                <p class="text-slate-500 dark:text-slate-400 text-sm">Manage reseller accounts, commissions, and storefronts.</p>
            </div>
            
            {{-- Stats Overview --}}
            <div class="flex gap-4">
                <div class="px-4 py-2 bg-white dark:bg-slate-900 rounded-xl border border-slate-100 dark:border-slate-800 shadow-sm">
                    <p class="text-[10px] font-black uppercase text-slate-400">Total Resellers</p>
                    <p class="text-lg font-black text-slate-900 dark:text-white">{{ $stats['total_resellers'] }}</p>
                </div>
                 <div class="px-4 py-2 bg-white dark:bg-slate-900 rounded-xl border border-slate-100 dark:border-slate-800 shadow-sm">
                    <p class="text-[10px] font-black uppercase text-slate-400">Paid Commission</p>
                    <p class="text-lg font-black text-emerald-500">₵{{ number_format($stats['total_commission_paid'], 2) }}</p>
                </div>
            </div>
        </div>

        {{-- Filters & Search --}}
        <div class="bg-white dark:bg-slate-900 p-4 rounded-2xl border border-slate-100 dark:border-slate-800 shadow-sm">
            <form method="GET" class="flex gap-4">
                <div class="flex-1 relative">
                    <svg class="w-5 h-5 absolute left-3 top-1/2 -translate-y-1/2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name, email, phone or code..." 
                        class="w-full pl-10 h-10 bg-slate-50 dark:bg-slate-950 border-none rounded-xl text-sm focus:ring-2 focus:ring-primary/20">
                </div>
                <button type="submit" class="px-6 h-10 bg-slate-900 dark:bg-white text-white dark:text-slate-900 rounded-xl font-bold text-xs uppercase tracking-widest hover:bg-primary transition-colors">
                    Filter
                </button>
            </form>
        </div>

        {{-- Resellers Table --}}
        <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-100 dark:border-slate-800 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-slate-50 dark:bg-slate-950 border-b border-slate-100 dark:border-slate-800">
                        <tr>
                            <th class="px-6 py-4 font-black text-slate-400 uppercase tracking-widest text-[10px]">Reseller</th>
                            <th class="px-6 py-4 font-black text-slate-400 uppercase tracking-widest text-[10px]">Role</th>
                            <th class="px-6 py-4 font-black text-slate-400 uppercase tracking-widest text-[10px]">Wallet Balance</th>
                            <th class="px-6 py-4 font-black text-slate-400 uppercase tracking-widest text-[10px]">Commission</th>
                            <th class="px-6 py-4 font-black text-slate-400 uppercase tracking-widest text-[10px]">Store Link</th>
                            <th class="px-6 py-4 font-black text-slate-400 uppercase tracking-widest text-[10px] text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                        @forelse($resellers as $reseller)
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-primary/10 flex items-center justify-center text-primary font-bold">
                                            {{ substr($reseller->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <p class="font-bold text-slate-900 dark:text-white">{{ $reseller->name }}</p>
                                            <p class="text-xs text-slate-500">{{ $reseller->email }}</p>
                                            <p class="text-[10px] text-slate-400 font-mono">{{ $reseller->phone }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wide bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400">
                                        {{ $reseller->role }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 font-mono font-bold text-slate-900 dark:text-white">
                                    ₵{{ number_format($reseller->wallet_balance, 2) }}
                                </td>
                                <td class="px-6 py-4 font-mono font-bold text-emerald-500">
                                    ₵{{ number_format($reseller->commission_balance, 2) }}
                                </td>
                                <td class="px-6 py-4">
                                    @if($reseller->referral_code)
                                        <a href="{{ route('store.show', $reseller->referral_code) }}" target="_blank" class="text-xs text-primary hover:underline flex items-center gap-1">
                                            Visit Store
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                        </a>
                                    @else
                                        <span class="text-xs text-slate-400">Not Set</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div x-data="{ open: false }" class="relative inline-block text-left">
                                        <button @click="open = !open" @click.away="open = false" class="p-2 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg transition-colors">
                                            <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path></svg>
                                        </button>
                                        <div x-show="open" class="absolute right-0 mt-2 w-48 bg-white dark:bg-slate-900 rounded-xl shadow-xl border border-slate-100 dark:border-slate-800 z-50 overflow-hidden" x-cloak>
                                            <div class="py-1">
                                                <button onclick="openCommissionModal({{ $reseller->id }}, '{{ $reseller->name }}')" class="w-full text-left px-4 py-2 text-xs font-medium text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800">
                                                    Adjust Commission
                                                </button>
                                                <form action="{{ route('admin.resellers.toggle-store', $reseller->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="w-full text-left px-4 py-2 text-xs font-medium text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800">
                                                        Toggle Store Status
                                                    </button>
                                                </form>
                                                <a href="{{ route('admin.users') }}?search={{$reseller->email}}" class="block w-full text-left px-4 py-2 text-xs font-medium text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800">
                                                    Manage User
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-slate-500">
                                    No resellers found matching your criteria.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($resellers->hasPages())
                <div class="p-4 border-t border-slate-100 dark:border-slate-800">
                    {{ $resellers->links() }}
                </div>
            @endif
        </div>
    </div>

    {{-- Commission Adjustment Modal --}}
    <div x-data="{ open: false, userId: null, userName: '' }" 
         @open-commission-modal.window="open = true; userId = $event.detail.id; userName = $event.detail.name"
         class="relative z-[100]" aria-labelledby="modal-title" role="dialog" aria-modal="true" x-show="open" x-cloak>
        
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity"></div>

        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-2xl bg-white dark:bg-slate-900 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-md border border-slate-100 dark:border-slate-800"
                    @click.away="open = false">
                    <form x-bind:action="'/admin/resellers/' + userId + '/commission'" method="POST" class="p-6 space-y-4">
                        @csrf
                        <div>
                            <h3 class="text-lg font-black text-slate-900 dark:text-white uppercase tracking-tight">Adjust Commission</h3>
                            <p class="text-xs text-slate-500">For <span x-text="userName" class="font-bold"></span></p>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="text-[10px] font-bold uppercase tracking-widest text-slate-500">Action</label>
                                <select name="type" class="w-full mt-1 bg-slate-50 dark:bg-slate-950 border-none rounded-xl text-sm font-bold">
                                    <option value="credit">Credit (+)</option>
                                    <option value="debit">Debit (-)</option>
                                </select>
                            </div>
                            <div>
                                <label class="text-[10px] font-bold uppercase tracking-widest text-slate-500">Amount</label>
                                <input type="number" step="0.01" name="amount" required class="w-full mt-1 bg-slate-50 dark:bg-slate-950 border-none rounded-xl text-sm font-bold" placeholder="0.00">
                            </div>
                        </div>

                        <div>
                             <label class="text-[10px] font-bold uppercase tracking-widest text-slate-500">Reason</label>
                             <input type="text" name="note" required class="w-full mt-1 bg-slate-50 dark:bg-slate-950 border-none rounded-xl text-sm" placeholder="e.g. Sales Bonus">
                        </div>

                        <div class="pt-4 flex gap-3">
                            <button type="button" @click="open = false" class="flex-1 py-3 text-xs font-bold uppercase tracking-widest text-slate-500 hover:text-slate-900 dark:hover:text-white">Cancel</button>
                            <button type="submit" class="flex-1 py-3 bg-primary text-white rounded-xl text-xs font-black uppercase tracking-widest shadow-lg shadow-primary/20 hover:bg-primary-focus">Confirm</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openCommissionModal(id, name) {
            window.dispatchEvent(new CustomEvent('open-commission-modal', { detail: { id, name } }));
        }
    </script>
@endsection
