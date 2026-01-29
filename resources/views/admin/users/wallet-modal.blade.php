{{-- Wallet Adjustment Modal --}}
<div x-show="walletModalOpen" class="fixed inset-0 z-[100] flex items-center justify-center p-4" x-cloak>
    <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" @click="walletModalOpen = false"></div>
    <div
        class="relative w-full max-w-md bg-white dark:bg-slate-900 rounded-3xl overflow-hidden shadow-2xl animate-in zoom-in-95 duration-200">
        {{-- Modal Header --}}
        <div class="px-6 py-4 border-b border-slate-50 dark:border-slate-800 flex items-center justify-between">
            <div>
                <h3 class="text-lg font-bold text-slate-900 dark:text-white">Adjust Wallet Balance</h3>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Credit or debit user account</p>
            </div>
            <button @click="walletModalOpen = false"
                class="p-2 text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 rounded-xl transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
        </div>

        {{-- User Info --}}
        <div class="px-6 py-4 bg-slate-50 dark:bg-slate-800/50 border-b border-slate-100 dark:border-slate-800">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-bold text-slate-900 dark:text-white" x-text="walletUser.name"></p>
                    <p class="text-xs text-slate-500 mt-0.5">User ID: <span x-text="walletUser.id"></span></p>
                </div>
                <div class="text-right">
                    <p class="text-xs text-slate-500 dark:text-slate-400">Current Balance</p>
                    <p class="text-lg font-black text-primary tabular-nums">GHS <span
                            x-text="parseFloat(walletUser.balance).toFixed(2)"></span></p>
                </div>
            </div>
        </div>

        <form @submit.prevent="submitWalletAdjustment" class="p-6 space-y-6">
            {{-- Transaction Type --}}
            <div class="space-y-2">
                <label
                    class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em]">Transaction
                    Type</label>
                <div class="flex gap-3">
                    <button type="button" @click="walletData.type = 'credit'"
                        class="flex-1 h-12 rounded-xl font-bold text-sm transition-all flex items-center justify-center gap-2"
                        :class="walletData.type === 'credit' ? 'bg-emerald-500 text-white shadow-lg shadow-emerald-500/30' : 'bg-slate-100 dark:bg-slate-800 text-slate-500'">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4">
                            </path>
                        </svg>
                        Credit
                    </button>
                    <button type="button" @click="walletData.type = 'debit'"
                        class="flex-1 h-12 rounded-xl font-bold text-sm transition-all flex items-center justify-center gap-2"
                        :class="walletData.type === 'debit' ? 'bg-rose-500 text-white shadow-lg shadow-rose-500/30' : 'bg-slate-100 dark:bg-slate-800 text-slate-500'">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                        </svg>
                        Debit
                    </button>
                </div>
            </div>

            {{-- Amount --}}
            <div class="space-y-1.5">
                <label
                    class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em]">Amount
                    (GHS)</label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-lg font-bold text-slate-400">₵</span>
                    <input type="number" x-model="walletData.amount" step="0.01" min="0.01" required placeholder="0.00"
                        class="w-full h-14 pl-10 pr-4 bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-lg font-bold focus:ring-2 focus:ring-primary/20 transition-all dark:text-white tabular-nums">
                </div>
            </div>

            {{-- Note --}}
            <div class="space-y-1.5">
                <label
                    class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em]">Transaction
                    Note</label>
                <textarea x-model="walletData.note" required rows="3" placeholder="Reason for adjustment..."
                    class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-sm font-medium focus:ring-2 focus:ring-primary/20 transition-all dark:text-white resize-none"></textarea>
            </div>

            {{-- Submit Button --}}
            <button type="submit" :disabled="walletData.isSubmitting"
                class="w-full h-12 rounded-2xl font-bold shadow-lg transition-all active:scale-95 disabled:opacity-50"
                :class="walletData.type === 'credit' ? 'bg-emerald-500 text-white shadow-emerald-500/30 hover:bg-emerald-600' : 'bg-rose-500 text-white shadow-rose-500/30 hover:bg-rose-600'">
                <span x-show="!walletData.isSubmitting"
                    x-text="walletData.type === 'credit' ? 'Credit Account' : 'Debit Account'"></span>
                <span x-show="walletData.isSubmitting">Processing...</span>
            </button>
        </form>
    </div>
</div>