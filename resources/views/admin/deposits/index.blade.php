@extends('layouts.admin')

@section('title', 'Deposit Management')

@section('content')
    <div class="space-y-6 pb-12 animate-in fade-in slide-in-from-bottom-4 duration-700" x-data="{ 
            modalOpen: false, 
            deposit: { id: '', user: { name: '' }, amount: '', proof_image: '', status: '' },
            openProcess(d) {
                this.deposit = d;
                this.modalOpen = true;
            }
        }">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-3xl font-bold tracking-tight text-slate-900 dark:text-white">Deposit Management</h2>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Process and verify wallet top-up requests.</p>
            </div>
            <div class="flex items-center gap-2 bg-emerald-50 dark:bg-emerald-900/20 px-3 py-1.5 rounded-full border border-emerald-100 dark:border-emerald-800/50">
                <div class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></div>
                <span class="text-[10px] font-bold uppercase tracking-wider text-emerald-700 dark:text-emerald-400">Live Auditing</span>
            </div>
        </div>

        <!-- Filters & Search -->
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
            <form action="{{ route('admin.deposits') }}" method="GET" class="relative group w-full lg:max-w-md">
                <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400 group-focus-within:text-primary transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                <input type="text" name="search" placeholder="Search customer, reference or amount..." value="{{ request('search') }}"
                    class="h-11 w-full pl-10 pr-4 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl text-sm font-medium outline-none focus:ring-4 focus:ring-primary/10 transition-all dark:text-white">
            </form>

            <div class="flex gap-2 p-1 bg-slate-100 dark:bg-slate-800/50 rounded-xl w-fit overflow-x-auto">
                <a href="{{ route('admin.deposits') }}"
                    class="px-4 py-2 rounded-lg text-xs font-bold transition-all {{ !request('status') ? 'bg-white dark:bg-slate-900 text-slate-900 dark:text-white shadow-sm' : 'text-slate-500 hover:text-slate-700 dark:hover:text-slate-300' }}">
                    All Logs
                </a>
                @foreach(['pending', 'approved', 'rejected'] as $status)
                    <a href="{{ route('admin.deposits', ['status' => $status]) }}"
                        class="px-4 py-2 rounded-lg text-xs font-bold capitalize transition-all {{ request('status') === $status ? 'bg-white dark:bg-slate-900 text-slate-900 dark:text-white shadow-sm' : 'text-slate-500 hover:text-slate-700 dark:hover:text-slate-300' }}">
                        {{ $status === 'pending' ? 'Validating' : $status }}
                    </a>
                @endforeach
            </div>
        </div>

        <!-- Deposits Table -->
        <div class="bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 rounded-2xl overflow-hidden shadow-sm">

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-slate-50 dark:bg-slate-800/50 border-b border-slate-100 dark:border-slate-800">
                        <tr>
                            <th class="px-6 py-4 text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">Date & Time</th>
                            <th class="px-6 py-4 text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">Customer</th>
                            <th class="px-6 py-4 text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest text-right">Amount</th>
                            <th class="px-6 py-4 text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">Proof/Gateway</th>
                            <th class="px-6 py-4 text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest text-center">Status</th>
                            <th class="px-6 py-4 text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50 dark:divide-slate-800">
                        @forelse($deposits as $d)
                            <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-colors group">
                                <td class="px-6 py-4">
                                    <span class="font-bold text-sm text-slate-900 dark:text-white block">{{ $d->created_at->format('d M, Y') }}</span>
                                    <span class="text-[10px] text-slate-500 dark:text-slate-500 mt-1 uppercase">{{ $d->created_at->format('h:i A') }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-lg bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-500 dark:text-slate-400 font-bold text-[10px]">
                                            {{ strtoupper(substr($d->user->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="font-bold text-sm text-slate-900 dark:text-white leading-none">{{ $d->user->name }}</p>
                                            <p class="text-[10px] text-slate-500 dark:text-slate-500 mt-1">{{ $d->user->email }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <p class="text-sm font-bold text-slate-900 dark:text-white">GHC {{ number_format($d->amount, 2) }}</p>
                                </td>
                                <td class="px-6 py-4">
                                    @if($d->proof_image === 'paystack')
                                        <span class="px-2 py-0.5 bg-indigo-50 dark:bg-indigo-900/20 text-indigo-700 dark:text-indigo-400 rounded text-[10px] font-bold uppercase border border-indigo-100 dark:border-indigo-800/50">Paystack</span>
                                    @elseif($d->proof_image)
                                        <a href="{{ asset('storage/' . $d->proof_image) }}" target="_blank"
                                            class="inline-flex items-center gap-1.5 text-primary hover:text-primary/80 text-[10px] font-bold uppercase hover:underline">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            View Slip
                                        </a>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @php
                                        $statuses = [
                                            'pending' => 'bg-amber-50 dark:bg-amber-900/20 text-amber-600',
                                            'approved' => 'bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600',
                                            'rejected' => 'bg-rose-50 dark:bg-rose-900/20 text-rose-600',
                                        ];
                                        $sc = $statuses[$d->status] ?? 'bg-slate-50 dark:bg-slate-800 text-slate-600';
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[10px] font-bold uppercase tracking-tight {{ $sc }}">
                                        {{ $d->status === 'pending' ? 'Validating' : $d->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center">
                                        @if($d->status === 'pending')
                                            <button @click="openProcess({{ $d->toJson() }})"
                                                class="h-8 px-3 bg-slate-900 dark:bg-primary text-white rounded-lg font-bold text-[10px] uppercase shadow-sm hover:opacity-90 transition-all">
                                                Process
                                            </button>
                                        @else
                                            <span class="text-[10px] font-bold text-slate-300 dark:text-slate-700 uppercase tracking-widest italic">Archived</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-24 text-center text-slate-400 dark:text-slate-600">
                                    <svg class="w-12 h-12 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                    <p class="font-medium text-sm">No deposits found in the ledger</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($deposits->isNotEmpty())
                <div class="px-6 py-4 border-t border-slate-50 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/20 flex items-center justify-between">
                    <div class="text-xs font-bold text-slate-500 dark:text-slate-500 uppercase tracking-widest italic">Ledger Entries: {{ $deposits->total() }}</div>
                    <div>{{ $deposits->links() }}</div>
                </div>
            @endif
        </div>

        {{-- Verification Modal --}}
        <div x-show="modalOpen" class="fixed inset-0 z-[100] flex items-center justify-center p-4" x-cloak>
            <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" @click="modalOpen = false"></div>
            <div class="relative w-full max-w-lg bg-white dark:bg-slate-900 rounded-3xl overflow-hidden shadow-2xl animate-in zoom-in-95 duration-200">
                <div class="px-6 py-4 border-b border-slate-50 dark:border-slate-800 flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white">Verify Financial Deposit</h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Authorization required for wallet funding</p>
                    </div>
                    <button @click="modalOpen = false" class="p-2 text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 rounded-xl transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <div class="p-6 space-y-6">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-slate-50 dark:bg-slate-800/50 p-4 rounded-2xl border border-slate-100 dark:border-slate-800">
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block mb-1">Customer</span>
                            <p class="text-sm font-bold text-slate-900 dark:text-white" x-text="deposit.user.name"></p>
                        </div>
                        <div class="bg-slate-50 dark:bg-slate-800/50 p-4 rounded-2xl border border-slate-100 dark:border-slate-800">
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block mb-1">Amount</span>
                            <p class="text-sm font-bold text-primary" x-text="'GHC ' + Number(deposit.amount).toFixed(2)"></p>
                        </div>
                    </div>

                    <div x-show="deposit.proof_image && deposit.proof_image !== 'paystack'" class="space-y-1.5">
                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Transaction Proof</label>
                        <div class="bg-slate-100 dark:bg-slate-800 rounded-2xl overflow-hidden aspect-video relative group border border-slate-200 dark:border-slate-700">
                            <img :src="'{{ asset('storage') }}/' + deposit.proof_image" class="w-full h-full object-cover">
                            <a :href="'{{ asset('storage') }}/' + deposit.proof_image" target="_blank"
                                class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm opacity-0 group-hover:opacity-100 flex items-center justify-center transition-all text-white font-bold text-xs uppercase tracking-widest">
                                Expand Evidence
                            </a>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3 pt-4 border-t border-slate-50 dark:border-slate-800">
                        <button onclick="handleDeposit('reject')" 
                            class="h-11 bg-rose-50 dark:bg-rose-900/20 text-rose-600 dark:text-rose-400 rounded-xl font-bold text-xs uppercase hover:bg-rose-100 dark:hover:bg-rose-900/30 transition-all border border-rose-100 dark:border-rose-800/50">
                            Reject Request
                        </button>
                        <button onclick="handleDeposit('approve')" 
                            class="h-11 bg-slate-900 dark:bg-primary text-white rounded-xl font-bold text-xs uppercase shadow-lg shadow-primary/20 hover:opacity-90 active:scale-95 transition-all">
                            Approve Funding
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            async function handleDeposit(action) {
                const depositId = window.Alpine.find(document.querySelector('[x-data]')).deposit.id;
                if(!confirm(`Confirm financial ${action} for deposit #${depositId}?`)) return;

                try {
                    const response = await fetch(`{{ url('admin/deposits') }}/${depositId}/${action}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        }
                    });

                    if(response.ok) {
                        window.location.reload();
                    } else {
                        const data = await response.json();
                        alert(data.message || 'Transaction Security Failure');
                    }
                } catch(e) {
                    alert('Network Communication Error');
                }
            }
        </script>
    @endpush
@endsection