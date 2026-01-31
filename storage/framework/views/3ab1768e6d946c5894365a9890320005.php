

<?php $__env->startSection('title', 'Buy Data'); ?>

<?php $__env->startSection('content'); ?>
    <div x-data="purchasePage"
        class="max-w-6xl mx-auto space-y-6 pb-20 animate-in fade-in slide-in-from-bottom-4 duration-700">

        
        <div x-show="confirmModal.visible" style="display: none;"
            class="fixed inset-0 z-[100] flex items-center justify-center bg-black/50 backdrop-blur-sm p-4"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

            <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-2xl max-w-sm w-full p-6 transform scale-100"
                @click.away="confirmModal.visible = false" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                x-transition:enter-end="opacity-100 scale-100 translate-y-0">

                <div
                    class="w-12 h-12 rounded-full bg-primary/10 text-primary flex items-center justify-center mb-4 mx-auto">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                        </path>
                    </svg>
                </div>

                <h3 class="text-lg font-bold text-center text-slate-900 dark:text-white mb-2">Confirm Purchase?</h3>
                <p class="text-sm text-center text-slate-500 mb-6">
                    You are about to purchase <span class="font-bold text-slate-800 dark:text-slate-200"
                        x-text="confirmModal.bundleName"></span>
                    for <span class="font-mono font-bold" x-text="phone"></span>.
                </p>

                <div class="flex gap-3">
                    <button @click="confirmModal.visible = false"
                        class="flex-1 py-3 px-4 rounded-xl font-bold bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors">
                        Cancel
                    </button>
                    <button @click="processPurchase"
                        class="flex-1 py-3 px-4 rounded-xl font-bold bg-primary text-white shadow-lg shadow-primary/25 hover:shadow-primary/40 transition-all active:scale-95">
                        Confirm
                    </button>
                </div>
            </div>
        </div>

        
        <div x-show="confirmModal.visible" style="display: none;"
            class="fixed inset-0 z-[100] flex items-center justify-center bg-black/50 backdrop-blur-sm p-4"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

            <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-2xl max-w-sm w-full p-6 transform scale-100"
                @click.away="confirmModal.visible = false" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                x-transition:enter-end="opacity-100 scale-100 translate-y-0">

                <div
                    class="w-12 h-12 rounded-full bg-primary/10 text-primary flex items-center justify-center mb-4 mx-auto">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                        </path>
                    </svg>
                </div>

                <h3 class="text-lg font-bold text-center text-slate-900 dark:text-white mb-2">Confirm Purchase?</h3>
                <p class="text-sm text-center text-slate-500 mb-6">
                    You are about to purchase <span class="font-bold text-slate-800 dark:text-slate-200"
                        x-text="confirmModal.bundleName"></span>
                    for <span class="font-mono font-bold" x-text="phone"></span>.
                </p>

                <div class="flex gap-3">
                    <button @click="confirmModal.visible = false"
                        class="flex-1 py-3 px-4 rounded-xl font-bold bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors">
                        Cancel
                    </button>
                    <button @click="processPurchase"
                        class="flex-1 py-3 px-4 rounded-xl font-bold bg-primary text-white shadow-lg shadow-primary/25 hover:shadow-primary/40 transition-all active:scale-95">
                        Confirm
                    </button>
                </div>
            </div>
        </div>

        
        <div x-show="toast.visible" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 translate-y-2"
            class="fixed top-6 right-6 z-50 p-4 rounded-xl shadow-2xl flex items-center gap-3 min-w-[300px]"
            :class="toast.type === 'error' ? 'bg-red-500 text-white' : 'bg-emerald-500 text-white'" style="display: none;">
            <div x-show="toast.type === 'error'">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div x-show="toast.type === 'success'">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <div>
                <h4 class="font-bold text-sm" x-text="toast.type === 'error' ? 'Error' : 'Success'"></h4>
                <p class="text-xs opacity-90" x-text="toast.message"></p>
            </div>
        </div>

        
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center transition-colors duration-500 shadow-sm"
                    :class="getNetworkColor(selectedNetwork, 'bg')">
                    <svg class="w-6 h-6" :class="getNetworkColor(selectedNetwork, 'text')" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z">
                        </path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-3xl font-bold tracking-tight text-blue-900 dark:text-white">Buy Data Bundle</h2>
                    <p class="text-slate-500 dark:text-slate-400 font-medium">Select a package and enter recipient details.
                    </p>
                </div>
            </div>
        </div>

        <div class="grid gap-6 md:grid-cols-5">
            
            <div class="md:col-span-3">
                <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm h-full overflow-hidden transition-colors duration-500"
                    :class="getNetworkColor(selectedNetwork, 'border')">
                    <div class="p-6 border-b border-slate-200 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/50">
                        <h3 class="text-lg font-bold text-blue-900 dark:text-white">Order Details</h3>
                        <p class="text-sm text-slate-500">Follow the steps to complete your purchase.</p>
                    </div>
                    <div class="p-6">
                        <form @submit.prevent="handleSubmit" class="space-y-6">

                            
                            <div class="space-y-2" x-ref="step1">
                                <label
                                    class="text-sm font-semibold flex items-center gap-2 text-slate-700 dark:text-slate-300">
                                    <div
                                        class="w-6 h-6 bg-slate-100 dark:bg-slate-800 rounded-md flex items-center justify-center text-[10px] font-bold">
                                        1</div>
                                    Select Network
                                </label>
                                <div class="grid grid-cols-3 gap-3">
                                    <template x-for="net in networks" :key="net">
                                        <button type="button" @click="selectNetwork(net)"
                                            class="relative group py-4 px-2 rounded-xl border-2 transition-all duration-300 flex flex-col items-center gap-2 overflow-hidden"
                                            :class="selectedNetwork === net ? getNetworkColor(net, 'active-btn') : 'border-slate-100 dark:border-slate-800 bg-slate-50 dark:bg-slate-800/50 hover:border-slate-300'">

                                            <div class="w-8 h-8 rounded-full flex items-center justify-center transition-colors font-black text-xs"
                                                :class="selectedNetwork === net ? 'bg-white/20 text-white' : 'bg-slate-200 dark:bg-slate-700 text-slate-500'">
                                                <span x-text="net.substring(0,1)"></span>
                                            </div>
                                            <span class="text-xs font-black uppercase tracking-widest relative z-10"
                                                :class="selectedNetwork === net ? 'text-white' : 'text-slate-500'">
                                                <span x-text="net"></span>
                                            </span>

                                            <div
                                                class="absolute inset-0 opacity-0 group-hover:opacity-10 transition-opacity bg-current">
                                            </div>
                                        </button>
                                    </template>
                                </div>
                            </div>

                            
                            <div class="space-y-2 transition-all duration-300" x-ref="step2"
                                :class="!selectedNetwork ? 'opacity-50 pointer-events-none' : ''">
                                <label
                                    class="text-sm font-semibold flex items-center gap-2 text-slate-700 dark:text-slate-300">
                                    <div
                                        class="w-6 h-6 bg-slate-100 dark:bg-slate-800 rounded-md flex items-center justify-center text-[10px] font-bold">
                                        2</div>
                                    Select Data Bundle
                                </label>
                                <div class="relative group">
                                    <select x-model="selectedBundleId" :disabled="!selectedNetwork"
                                        class="w-full h-14 pl-4 pr-10 bg-slate-50 dark:bg-slate-800 border-2 border-slate-200 dark:border-slate-700 rounded-xl focus:ring-4 focus:ring-primary/10 outline-none appearance-none transition-all font-bold text-sm cursor-pointer"
                                        :class="getNetworkColor(selectedNetwork, 'focus-border')">
                                        <option value="" disabled selected
                                            x-text="selectedNetwork ? 'Choose an ' + selectedNetwork + ' package...' : 'Select a network first'">
                                        </option>
                                        <template x-for="bundle in filteredBundles" :key="bundle.id">
                                            <option :value="bundle.id"
                                                x-text="bundle.name + ' (' + bundle.data_amount + ') - GHS ' + parseFloat(bundle.price).toFixed(2)">
                                            </option>
                                        </template>
                                    </select>
                                    <div
                                        class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            
                            <div class="space-y-2 transition-all duration-300" x-ref="step3"
                                :class="!selectedBundleId ? 'opacity-50 pointer-events-none' : ''">
                                <label
                                    class="text-sm font-semibold flex items-center gap-2 text-slate-700 dark:text-slate-300">
                                    <div
                                        class="w-6 h-6 bg-slate-100 dark:bg-slate-800 rounded-md flex items-center justify-center text-[10px] font-bold">
                                        3</div>
                                    Recipient Phone Number
                                </label>
                                <div class="relative group">
                                    <input type="tel" x-model="phone" @input="validatePhone" placeholder="0XXXXXXXXX"
                                        maxlength="10"
                                        class="w-full h-14 pl-4 pr-10 bg-slate-50 dark:bg-slate-800 border-2 rounded-xl outline-none transition-all font-mono font-bold text-lg tracking-wider"
                                        :class="phoneState.colorClass">

                                    <div class="absolute right-4 top-1/2 -translate-y-1/2 transition-colors duration-300"
                                        :class="phoneState.iconColor">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path x-show="phoneState.valid" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            <path x-show="!phoneState.valid" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                    </div>
                                </div>

                                <div class="flex justify-between items-start">
                                    <div x-show="selectedNetwork" class="text-[10px] text-slate-500 transition-all">
                                        Valid Prefixes: <span class="font-bold"
                                            x-text="getNetworkPrefixes(selectedNetwork)"></span>
                                    </div>
                                    <div x-show="phone.length > 0" class="text-[10px] font-bold"
                                        :class="phoneState.valid ? 'text-emerald-500' : 'text-red-500'"
                                        x-text="phoneState.message">
                                    </div>
                                </div>
                            </div>



                            
                            <div class="space-y-4 pt-4 border-t border-slate-100 dark:border-slate-800 transition-all duration-300"
                                :class="!phoneState.valid ? 'opacity-50 pointer-events-none grayscale' : ''">
                                <label
                                    class="text-sm font-semibold flex items-center gap-2 text-slate-700 dark:text-slate-300">
                                    <div
                                        class="w-6 h-6 bg-slate-100 dark:bg-slate-800 rounded-md flex items-center justify-center text-[10px] font-bold">
                                        4</div>
                                    Select Payment Method
                                </label>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    
                                    <div @click="paymentMethod = 'wallet'"
                                        class="cursor-pointer relative overflow-hidden rounded-2xl border transition-all duration-300 group"
                                        :class="paymentMethod === 'wallet' ? getNetworkColor(selectedNetwork, 'active-payment') : 'border-slate-200 dark:border-slate-800 hover:border-slate-300'">

                                        <div class="p-5 flex items-start gap-4 z-10 relative">
                                            <div class="w-10 h-10 rounded-xl flex items-center justify-center transition-colors shadow-sm"
                                                :class="paymentMethod === 'wallet' ? getNetworkColor(selectedNetwork, 'icon-active') : 'bg-slate-100 dark:bg-slate-800 text-slate-500'">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z">
                                                    </path>
                                                </svg>
                                            </div>
                                            <div class="flex-1">
                                                <div class="flex justify-between items-start">
                                                    <div>
                                                        <h4 class="font-bold text-blue-900 dark:text-white text-sm">My
                                                            Wallet</h4>
                                                        <p
                                                            class="text-[10px] font-medium text-slate-500 dark:text-slate-400 mt-0.5">
                                                            Instant Payment</p>
                                                    </div>
                                                    <div x-show="paymentMethod === 'wallet'"
                                                        class="animate-in zoom-in duration-300"
                                                        :class="getNetworkColor(selectedNetwork, 'text')">
                                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd"
                                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                                clip-rule="evenodd"></path>
                                                        </svg>
                                                    </div>
                                                </div>

                                                <div
                                                    class="mt-3 flex items-center justify-between p-2 rounded-lg bg-slate-50 dark:bg-slate-900/50 border border-slate-100 dark:border-slate-700/50">
                                                    <span
                                                        class="text-[10px] uppercase font-bold text-slate-400 tracking-wider">Balance</span>
                                                    <span
                                                        class="text-sm font-mono font-black text-slate-700 dark:text-slate-200">GHS
                                                        <?php echo e(number_format(auth()->user()->wallet_balance, 2)); ?></span>
                                                </div>

                                                <div x-show="selectedBundle && <?php echo e(auth()->user()->wallet_balance); ?> < parseFloat(selectedBundle.price)"
                                                    class="mt-2 text-[10px] text-red-500 font-bold flex items-center gap-1 animate-pulse">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M12 9v2m0 4h.01M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                                        </path>
                                                    </svg>
                                                    Insufficient Funds
                                                </div>
                                            </div>
                                        </div>
                                        <div
                                            class="absolute -bottom-4 -right-4 w-24 h-24 bg-primary/5 rounded-full blur-2xl group-hover:bg-primary/10 transition-colors">
                                        </div>
                                    </div>

                                    
                                    <div @click="paymentMethod = 'paystack'"
                                        class="cursor-pointer relative overflow-hidden rounded-2xl border transition-all duration-300 group"
                                        :class="paymentMethod === 'paystack' ? getNetworkColor(selectedNetwork, 'active-payment') : 'border-slate-200 dark:border-slate-800 hover:border-slate-300'">

                                        <div class="p-5 flex items-start gap-4 z-10 relative">
                                            <div class="w-10 h-10 rounded-xl flex items-center justify-center transition-colors shadow-sm"
                                                :class="paymentMethod === 'paystack' ? getNetworkColor(selectedNetwork, 'icon-active') : 'bg-slate-100 dark:bg-slate-800 text-slate-500'">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z">
                                                    </path>
                                                </svg>
                                            </div>
                                            <div class="flex-1">
                                                <div class="flex justify-between items-start">
                                                    <div>
                                                        <h4 class="font-bold text-blue-900 dark:text-white text-sm">Pay
                                                            Online</h4>
                                                        <p
                                                            class="text-[10px] font-medium text-slate-500 dark:text-slate-400 mt-0.5">
                                                            Mobile Money & Cards</p>
                                                    </div>
                                                    <div x-show="paymentMethod === 'paystack'"
                                                        class="animate-in zoom-in duration-300"
                                                        :class="getNetworkColor(selectedNetwork, 'text')">
                                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd"
                                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                                clip-rule="evenodd"></path>
                                                        </svg>
                                                    </div>
                                                </div>

                                                <div class="mt-3 flex gap-2">
                                                    <div
                                                        class="h-6 px-2 bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-700 rounded flex items-center justify-center">
                                                        <span
                                                            class="text-[8px] font-bold text-slate-600 dark:text-slate-400 uppercase">Momo</span>
                                                    </div>
                                                    <div
                                                        class="h-6 px-2 bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-700 rounded flex items-center justify-center">
                                                        <span
                                                            class="text-[8px] font-bold text-slate-600 dark:text-slate-400 uppercase">Visa</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div
                                            class="absolute -bottom-4 -right-4 w-24 h-24 bg-sky-500/10 rounded-full blur-2xl group-hover:bg-sky-500/20 transition-colors">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            
                            <div x-show="selectedBundleId" x-transition:enter="transition ease-out duration-300"
                                x-transition:enter-start="opacity-0 translate-y-4"
                                x-transition:enter-end="opacity-100 translate-y-0" class="md:hidden pb-6">
                                <div class="relative overflow-hidden rounded-2xl p-6 text-white shadow-xl transition-colors duration-500"
                                    :class="getNetworkColor(selectedNetwork, 'card-bg')">

                                    
                                    <div class="flex justify-between items-start mb-6 border-b border-white/20 pb-4">
                                        <div>
                                            <h4 class="text-[10px] font-black uppercase tracking-[0.2em] opacity-80 mb-1">
                                                Order Summary</h4>
                                            <h3 class="text-xl font-bold">Invoice Preview</h3>
                                        </div>
                                        <button type="button"
                                            @click="selectedNetwork = ''; selectedBundleId = ''; phone = ''; window.scrollTo({top: 0, behavior: 'smooth'})"
                                            class="px-3 py-1 bg-white/10 hover:bg-white/20 rounded-lg text-[10px] font-bold uppercase tracking-wider transition-colors flex items-center gap-1 backdrop-blur-sm border border-white/10">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                </path>
                                            </svg>
                                            Clear
                                        </button>
                                    </div>

                                    <div class="space-y-4">
                                        
                                        <div class="flex justify-between items-center group cursor-pointer"
                                            @click="$refs.step1.scrollIntoView({behavior: 'smooth', block: 'center'})">
                                            <div>
                                                <p class="text-[10px] font-bold uppercase opacity-60">Network</p>
                                                <p class="font-bold text-sm" x-text="selectedNetwork || '---'"></p>
                                            </div>
                                            <div
                                                class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                </svg>
                                            </div>
                                        </div>

                                        
                                        <div class="flex justify-between items-center group cursor-pointer"
                                            @click="$refs.step2.scrollIntoView({behavior: 'smooth', block: 'center'}); $refs.step2.classList.add('ring-2', 'ring-primary/20'); setTimeout(() => $refs.step2.classList.remove('ring-2', 'ring-primary/20'), 1000)">
                                            <div class="flex-1 pr-4">
                                                <p class="text-[10px] font-bold uppercase opacity-60">Package</p>
                                                <p class="font-bold text-sm truncate"
                                                    x-text="selectedBundle ? selectedBundle.name : '---'"></p>
                                            </div>
                                            <div
                                                class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                </svg>
                                            </div>
                                        </div>

                                        
                                        <div class="flex justify-between items-center group cursor-pointer"
                                            @click="$refs.step3.scrollIntoView({behavior: 'smooth', block: 'center'})">
                                            <div>
                                                <p class="text-[10px] font-bold uppercase opacity-60">Recipient</p>
                                                <p class="font-mono font-bold text-lg" x-text="phone || '---'"></p>
                                            </div>
                                            <div
                                                class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                </svg>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-6 pt-4 border-t border-white/20 flex justify-between items-center">
                                        <span class="text-xs font-bold opacity-80">Total Payable</span>
                                        <span class="text-2xl font-black">GHS <span
                                                x-text="selectedBundle ? parseFloat(selectedBundle.price).toFixed(2) : '0.00'"></span></span>
                                    </div>
                                </div>
                            </div>

                            
                            <button type="submit"
                                :disabled="isLoading || !selectedBundleId || !phoneState.valid || (paymentMethod === 'wallet' && selectedBundle && <?php echo e(auth()->user()->wallet_balance); ?> < parseFloat(selectedBundle.price))"
                                class="w-full h-16 text-lg shadow-xl transition-all active:scale-[0.98] rounded-2xl font-black text-white flex items-center justify-center gap-3 group disabled:opacity-50 disabled:cursor-not-allowed disabled:shadow-none"
                                :class="isLoading ? 'bg-slate-400 cursor-wait' : getNetworkColor(selectedNetwork, 'btn')">
                                <span x-show="!isLoading"
                                    x-text="paymentMethod === 'paystack' ? 'Pay Now' : 'Proceed to Payment'"></span>
                                <span x-show="isLoading" class="flex items-center gap-2">
                                    <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                            stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor"
                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                        </path>
                                    </svg>
                                    Processing...
                                </span>
                                <svg x-show="!isLoading" class="w-6 h-6 group-hover:translate-x-1 transition-transform"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            
            <div class="hidden md:block md:col-span-2 space-y-6">
                
                <div class="text-white rounded-2xl overflow-hidden relative shadow-2xl min-h-[300px] flex flex-col justify-between border-none transition-colors duration-500"
                    :class="getNetworkColor(selectedNetwork, 'card-bg')">

                    
                    <div
                        class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2 pointer-events-none">
                    </div>
                    <div
                        class="absolute bottom-0 left-0 w-48 h-48 bg-black/10 rounded-full blur-2xl translate-y-1/4 -translate-x-1/4 pointer-events-none">
                    </div>

                    <div class="p-8 relative z-10">
                        <div class="flex justify-between items-start mb-8">
                            <div>
                                <h4 class="text-xs font-black uppercase tracking-[0.2em] opacity-60 mb-2">Invoice Preview
                                </h4>
                                <h3 class="text-2xl font-bold">New Order</h3>
                            </div>
                            <button type="button"
                                @click="selectedNetwork = ''; selectedBundleId = ''; phone = ''; window.scrollTo({top: 0, behavior: 'smooth'})"
                                class="w-8 h-8 rounded-xl bg-white/20 hover:bg-white/30 flex items-center justify-center transition-colors backdrop-blur-md"
                                title="Clear Order">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                    </path>
                                </svg>
                            </button>
                        </div>

                        <div class="space-y-6">
                            
                            <div class="space-y-1 cursor-pointer group"
                                @click="$refs.step1.scrollIntoView({behavior: 'smooth', block: 'center'})">
                                <div class="flex items-center gap-2">
                                    <p class="text-xs font-bold uppercase opacity-60">Network Provider</p>
                                    <svg class="w-3 h-3 opacity-0 group-hover:opacity-100 transition-opacity" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                        </path>
                                    </svg>
                                </div>
                                <p class="text-lg font-bold group-hover:underline decoration-white/30 underline-offset-4 decoration-2 transition-all"
                                    x-text="selectedNetwork || '---'"></p>
                            </div>

                            
                            <div class="space-y-1 cursor-pointer group"
                                @click="$refs.step2.scrollIntoView({behavior: 'smooth', block: 'center'}); $refs.step2.classList.add('ring-2', 'ring-primary/20'); setTimeout(() => $refs.step2.classList.remove('ring-2', 'ring-primary/20'), 1000)">
                                <div class="flex items-center gap-2">
                                    <p class="text-xs font-bold uppercase opacity-60">Package Bundle</p>
                                    <svg class="w-3 h-3 opacity-0 group-hover:opacity-100 transition-opacity" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                        </path>
                                    </svg>
                                </div>
                                <p class="text-lg font-bold truncate group-hover:underline decoration-white/30 underline-offset-4 decoration-2 transition-all"
                                    x-text="selectedBundle ? selectedBundle.name : '---'">
                                </p>
                            </div>

                            
                            <div class="space-y-1 cursor-pointer group"
                                @click="$refs.step3.scrollIntoView({behavior: 'smooth', block: 'center'})">
                                <div class="flex items-center gap-2">
                                    <p class="text-xs font-bold uppercase opacity-60">Recipient</p>
                                    <svg class="w-3 h-3 opacity-0 group-hover:opacity-100 transition-opacity" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                        </path>
                                    </svg>
                                </div>
                                <p class="text-xl font-mono font-bold group-hover:underline decoration-white/30 underline-offset-4 decoration-2 transition-all"
                                    x-text="phone || '---'"></p>
                            </div>
                        </div>
                    </div>

                    <div class="p-8 bg-black/20 backdrop-blur-sm relative z-10">
                        <div class="flex justify-between items-center">
                            <span class="text-sm font-bold opacity-80">Total Payable</span>
                            <span class="text-3xl font-black">GHS <span
                                    x-text="selectedBundle ? parseFloat(selectedBundle.price).toFixed(2) : '0.00'"></span></span>
                        </div>
                    </div>
                </div>

                
                <div
                    class="bg-white dark:bg-slate-900 rounded-xl shadow-sm border border-slate-200 dark:border-slate-800 p-6 flex gap-5">
                    <div
                        class="w-12 h-12 bg-indigo-50 dark:bg-indigo-900/20 rounded-2xl flex items-center justify-center text-indigo-500 shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed">
                        <p class="font-bold text-slate-900 dark:text-white mb-1">Verify Recipient Details</p>
                        Please double-check the recipient's phone number. <span class="text-red-500 font-bold">Data bundles
                            cannot be reversed</span> once processed onto a wrong number.
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php $__env->startPush('scripts'); ?>
        <script src="https://js.paystack.co/v1/inline.js"></script>
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('purchasePage', () => ({
                    bundles: <?php echo $bundles->toJson(); ?>,
                    networks: <?php echo $networks->toJson(); ?>,
                    selectedNetwork: '',
                    selectedBundleId: '',
                    phone: '',
                    isLoading: false,
                    paymentMethod: 'wallet',
                    toast: { visible: false, message: '', type: 'success' },
                    confirmModal: { visible: false, bundleName: '' },
                    phoneState: { valid: false, message: '', colorClass: 'border-slate-200 dark:border-slate-700', iconColor: 'text-slate-400' },

                    get filteredBundles() {
                        if (!this.selectedNetwork) return [];
                        return this.bundles.filter(b => (b.network || '').toUpperCase() === this.selectedNetwork.toUpperCase());
                    },

                    get selectedBundle() {
                        return this.bundles.find(b => b.id == this.selectedBundleId) || null;
                    },

                    showToast(message, type = 'success') {
                        this.toast.message = message;
                        this.toast.type = type;
                        this.toast.visible = true;
                        setTimeout(() => this.toast.visible = false, 3000);
                    },

                    getNetworkColor(network, type) {
                        const net = (network || '').toUpperCase();
                        let colors = {
                            'bg': 'bg-primary/10',
                            'text': 'text-primary',
                            'border': 'border-slate-200 dark:border-slate-800',
                            'active-btn': 'border-primary bg-primary/5 text-primary',
                            'active-payment': 'border-primary ring-1 ring-primary bg-primary/5 dark:bg-primary/10',
                            'icon-active': 'bg-primary text-white shadow-primary/20',
                            'focus-border': 'focus:border-primary',
                            'btn': 'bg-primary shadow-primary/30 hover:shadow-primary/40',
                            'card-bg': 'bg-slate-900'
                        };

                        if (net === 'MTN') {
                            colors = {
                                'bg': 'bg-yellow-400/10',
                                'text': 'text-yellow-800',
                                'border': 'border-yellow-200 dark:border-yellow-900/30',
                                'active-btn': 'border-yellow-400 bg-yellow-400 text-black shadow-lg shadow-yellow-400/20',
                                'icon-active': 'bg-yellow-400 text-black shadow-yellow-400/20',
                                'active-payment': 'border-yellow-400 ring-1 ring-yellow-400 bg-yellow-400/10',
                                'focus-border': 'focus:border-yellow-400 focus:ring-yellow-400/20',
                                'btn': 'bg-yellow-400 text-black hover:bg-yellow-300 shadow-yellow-400/30 hover:shadow-yellow-400/40',
                                'card-bg': 'bg-gradient-to-br from-yellow-500 to-yellow-600 text-black'
                            };
                        } else if (net === 'TELECEL') {
                            colors = {
                                'bg': 'bg-red-500/10',
                                'text': 'text-red-500',
                                'border': 'border-red-200 dark:border-red-900/30',
                                'active-btn': 'border-red-600 bg-red-600 text-white shadow-lg shadow-red-600/20',
                                'icon-active': 'bg-red-600 text-white shadow-red-600/20',
                                'active-payment': 'border-red-600 ring-1 ring-red-600 bg-red-600/5 dark:bg-red-600/10',
                                'focus-border': 'focus:border-red-500 focus:ring-red-500/20',
                                'btn': 'bg-red-600 text-white hover:bg-red-500 shadow-red-600/30 hover:shadow-red-600/40',
                                'card-bg': 'bg-gradient-to-br from-red-600 to-red-700'
                            };
                        } else if (net === 'AT' || net === 'AIRTELTIGO') {
                            colors = {
                                'bg': 'bg-blue-600/10',
                                'text': 'text-blue-600',
                                'border': 'border-blue-200 dark:border-blue-900/30',
                                'active-btn': 'border-blue-600 bg-blue-600 text-white shadow-lg shadow-blue-600/20',
                                'icon-active': 'bg-blue-600 text-white shadow-blue-600/20',
                                'active-payment': 'border-blue-600 ring-1 ring-blue-600 bg-blue-600/5 dark:bg-blue-600/10',
                                'focus-border': 'focus:border-blue-500 focus:ring-blue-500/20',
                                'btn': 'bg-blue-600 text-white hover:bg-blue-500 shadow-blue-600/30 hover:shadow-blue-600/40',
                                'card-bg': 'bg-gradient-to-br from-blue-600 to-blue-700'
                            };
                        }

                        // Return default class if type not found (fallback)
                        return colors[type] || '';
                    },

                    getNetworkPrefixes(network) {
                        const net = (network || '').toUpperCase();
                        switch (net) {
                            case "MTN": return "024, 054, 055, 059, 053, 025";
                            case "TELECEL": return "020, 050";
                            case "AIRTELTIGO": case "AT": return "027, 057, 026, 056";
                            default: return "";
                        }
                    },

                    selectNetwork(net) {
                        this.selectedNetwork = net;
                        this.selectedBundleId = '';
                        this.validatePhone(); // Re-validate phone when network changes
                    },

                    validatePhone() {
                        const phoneDigits = this.phone.replace(/\D/g, '');

                        if (phoneDigits.length === 0) {
                            this.phoneState = { valid: false, message: '', colorClass: 'border-slate-200 dark:border-slate-700', iconColor: 'text-slate-400' };
                            return;
                        }

                        if (phoneDigits.length !== 10) {
                            this.phoneState = { valid: false, message: 'Must be 10 digits', colorClass: 'border-red-500 focus:ring-red-500/10', iconColor: 'text-red-500' };
                            return;
                        }

                        if (!this.selectedNetwork) {
                            this.phoneState = { valid: false, message: 'Select network first', colorClass: 'border-slate-200', iconColor: 'text-slate-400' };
                            return;
                        }

                        const validPrefixes = this.getNetworkPrefixes(this.selectedNetwork).split(', ').map(p => p.trim());
                        const hasValidPrefix = validPrefixes.some(prefix => this.phone.startsWith(prefix));

                        if (hasValidPrefix) {
                            this.phoneState = { valid: true, message: 'Valid Number', colorClass: 'border-emerald-500 ring-2 ring-emerald-500/10', iconColor: 'text-emerald-500' };
                        } else {
                            this.phoneState = { valid: false, message: 'Invalid ' + this.selectedNetwork + ' Prefix', colorClass: 'border-red-500 ring-2 ring-red-500/10', iconColor: 'text-red-500' };
                        }
                    },

                    handleSubmit() {
                        // Final Validation Check
                        this.validatePhone();
                        if (!this.selectedNetwork) { this.showToast('Please select a network first.', 'error'); return; }
                        if (!this.selectedBundleId) { this.showToast('Please select a bundle.', 'error'); return; }
                        if (!this.phoneState.valid) { this.showToast(this.phoneState.message || 'Invalid Phone Number', 'error'); return; }

                        // Check Wallet Balance if Wallet selected
                        if (this.paymentMethod === 'wallet') {
                            const balance = <?php echo e(auth()->user()->wallet_balance); ?>;
                            const price = parseFloat(this.selectedBundle.price);
                            if (balance < price) {
                                this.showToast('Insufficient wallet balance.', 'error');
                                return;
                            }
                        }

                        // Show Confirmation Modal
                        this.confirmModal.bundleName = this.selectedBundle.name;
                        this.confirmModal.visible = true;
                    },

                    async processPurchase() {
                        this.confirmModal.visible = false;
                        if (this.isLoading) return;
                        this.isLoading = true;

                        try {
                            const response = await fetch('<?php echo e(route('orders.store')); ?>', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'Accept': 'application/json',
                                    'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
                                },
                                body: JSON.stringify({
                                    bundle_id: this.selectedBundleId,
                                    recipient_phone: this.phone,
                                    payment_method: this.paymentMethod
                                })
                            });

                            const data = await response.json();

                            if (!response.ok) throw new Error(data.message || 'Purchase failed');

                            if (this.paymentMethod === 'paystack') {
                                this.showToast('Redirecting to Payment...', 'success');
                                // Use Standard Redirect instead of Inline Modal to avoid script errors
                                setTimeout(() => {
                                    window.location.href = data.data.authorization_url;
                                }, 1000);
                            } else {
                                this.showToast('Order placed successfully!', 'success');
                                setTimeout(() => {
                                    window.location.href = data.redirect || '<?php echo e(route('orders.index')); ?>';
                                }, 1000);
                            }

                        } catch (e) {
                            this.showToast(e.message, 'error');
                            this.isLoading = false;
                        }
                    }
                }));
            });
        </script>
    <?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Bruce\Desktop\Projects\Megaai2\Megaai\cloudtech\resources\views/dashboard/orders/new.blade.php ENDPATH**/ ?>