@extends('layouts.dashboard')

@section('title', 'Bulk Order')

@section('content')
    <div x-data="{
                                bundles: {{ $bundles->toJson() }},
                                networks: {{ $networks->toJson() }},
                                selectedNetwork: '',
                                selectedBundleId: '',
                                inputMethod: 'manual', 
                                phoneNumbers: '',
                                csvFile: null,
                                parsedNumbers: [],
                                validNumbers: [],
                                invalidNumbers: [],
                                processing: false,

                                get filteredBundles() {
                                    if (!this.selectedNetwork) return [];
                                    return this.bundles.filter(b => b.network.toLowerCase() === this.selectedNetwork.toLowerCase());
                                },

                                get selectedBundle() {
                                    return this.bundles.find(b => b.id == this.selectedBundleId) || null;
                                },

                                get totalCost() {
                                    if (!this.selectedBundle || this.validNumbers.length === 0) return 0;
                                    return (parseFloat(this.selectedBundle.price) * this.validNumbers.length).toFixed(2);
                                },

                                get prefixes() {
                                    const net = this.selectedNetwork.toUpperCase();
                                    switch (net) {
                                        case 'MTN': return ['024', '054', '055', '059', '053', '025'];
                                        case 'TELECEL': return ['020', '050'];
                                        case 'AIRTELTIGO': return ['027', '057', '026', '056'];
                                        default: return [];
                                    }
                                },

                                validatePhoneNumber(phone) {
                                    const digits = phone.replace(/\D/g, '');
                                    if (digits.length !== 10) return false;
                                    return this.prefixes.some(prefix => digits.startsWith(prefix));
                                },

                                parsePhoneNumbers() {
                                    if (this.inputMethod === 'manual') {
                                        const lines = this.phoneNumbers.split('\n').map(l => l.trim()).filter(l => l);
                                        this.parsedNumbers = [...new Set(lines)];
                                    }

                                    this.validNumbers = this.parsedNumbers.filter(num => this.validatePhoneNumber(num));
                                    this.invalidNumbers = this.parsedNumbers.filter(num => !this.validatePhoneNumber(num));
                                },

                                handleCSVUpload(event) {
                                    const file = event.target.files[0];
                                    if (!file) return;

                                    const reader = new FileReader();
                                    reader.onload = (e) => {
                                        const text = e.target.result;
                                        const lines = text.split('\n').map(l => l.trim()).filter(l => l);
                                        this.parsedNumbers = [...new Set(lines.map(line => line.split(',')[0].trim()))];
                                        this.parsePhoneNumbers();
                                    };
                                    reader.readAsText(file);
                                },

                                async submitBulkOrder() {
                                    if (this.validNumbers.length === 0 || !this.selectedBundle) return;

                                    this.processing = true;

                                    try {
                                        const response = await fetch('{{ route('orders.bulk.process') }}', {
                                            method: 'POST',
                                            headers: {
                                                'Content-Type': 'application/json',
                                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                            },
                                            body: JSON.stringify({
                                                bundle_id: this.selectedBundleId,
                                                phone_numbers: this.validNumbers
                                            })
                                        });

                                        const data = await response.json();

                                        if (data.success) {
                                            window.location.href = '{{ route('orders.index') }}';
                                        } else {
                                            alert(data.message || 'An error occurred');
                                        }
                                    } catch (error) {
                                        alert('An error occurred while processing your order');
                                    } finally {
                                        this.processing = false;
                                    }
                                }
                            }" class="max-w-6xl mx-auto space-y-8 animate-in fade-in slide-in-from-bottom-4 duration-700">

        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="flex items-center gap-4">
                <div
                    class="w-12 h-12 rounded-xl bg-purple-500/10 flex items-center justify-center text-purple-500 ring-1 ring-purple-500/20">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                        </path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-3xl font-black tracking-tight text-blue-900 dark:text-white uppercase">Bulk Order</h2>
                    <p class="text-sm text-slate-500 dark:text-slate-400 font-medium mt-1">Place orders for multiple
                        recipients at once.</p>
                </div>
            </div>
        </div>

        <!-- Main Form -->
        <div class="grid lg:grid-cols-3 gap-8">
            <!-- Left Column - Configuration -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Network Selection -->
                <div
                    class="rounded-3xl border border-border/50 bg-card/50 backdrop-blur-xl p-8 shadow-2xl shadow-slate-200/20 dark:shadow-none">
                    <h3 class="text-sm font-black uppercase tracking-widest text-slate-400 mb-6 px-2">1. Select Network</h3>
                    <div class="grid grid-cols-3 gap-4">
                        <template x-for="network in networks" :key="network">
                            <button
                                @click="selectedNetwork = network; selectedBundleId = ''; parsedNumbers = []; validNumbers = []; invalidNumbers = []"
                                :class="selectedNetwork === network ? 'ring-2 ring-primary bg-primary/10 border-primary' : 'hover:bg-slate-50 dark:hover:bg-slate-800 border-border/50'"
                                class="flex flex-col items-center justify-center p-4 rounded-2xl border transition-all duration-300 group">
                                <span class="text-sm font-black text-foreground group-hover:scale-105 transition-transform"
                                    x-text="network"></span>
                            </button>
                        </template>
                    </div>
                </div>

                <!-- Bundle Selection -->
                <div class="rounded-3xl border border-border/50 bg-card/50 backdrop-blur-xl p-8 shadow-2xl shadow-slate-200/20 dark:shadow-none"
                    x-show="selectedNetwork">
                    <h3 class="text-sm font-black uppercase tracking-widest text-slate-400 mb-6 px-2">2. Select Bundle</h3>
                    <div class="grid sm:grid-cols-2 gap-4 max-h-[30rem] overflow-y-auto pr-2 custom-scrollbar">
                        <template x-for="bundle in filteredBundles" :key="bundle.id">
                            <button @click="selectedBundleId = bundle.id"
                                :class="selectedBundleId == bundle.id ? 'ring-2 ring-primary bg-primary/10 border-primary' : 'hover:bg-slate-50 dark:hover:bg-slate-800 border-border/50'"
                                class="flex flex-col items-start p-6 rounded-2xl border transition-all duration-300 text-left relative overflow-hidden group">
                                <div class="relative z-10">
                                    <div class="font-black text-sm text-foreground mb-1" x-text="bundle.name"></div>
                                    <div class="text-[10px] font-bold text-muted-foreground uppercase tracking-widest"
                                        x-text="bundle.data_amount"></div>
                                    <div class="text-xl font-black mt-4 text-primary">GHS<span
                                            x-text="parseFloat(bundle.price).toFixed(2)"></span></div>
                                </div>
                                <div
                                    class="absolute top-0 right-0 p-4 opacity-5 transform group-hover:scale-110 transition-transform">
                                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 10V3L4 14h7v7l9-11h-7z" />
                                    </svg>
                                </div>
                            </button>
                        </template>
                    </div>
                </div>

                <!-- Phone Number Input -->
                <div class="rounded-3xl border border-border/50 bg-card/50 backdrop-blur-xl p-8 shadow-2xl shadow-slate-200/20 dark:shadow-none"
                    x-show="selectedBundleId">
                    <h3 class="text-sm font-black uppercase tracking-widest text-slate-400 mb-6 px-2">3. Add Recipients</h3>

                    <!-- Input Method Toggle -->
                    <div class="flex gap-2 mb-6 bg-slate-100 dark:bg-slate-800 p-1.5 rounded-2xl w-fit">
                        <button @click="inputMethod = 'manual'"
                            :class="inputMethod === 'manual' ? 'bg-white dark:bg-slate-700 shadow-md text-primary' : 'text-slate-500 hover:text-foreground'"
                            class="px-6 py-2 rounded-xl text-xs font-black uppercase tracking-widest transition-all">
                            Manual Entry
                        </button>
                        <button @click="inputMethod = 'csv'"
                            :class="inputMethod === 'csv' ? 'bg-white dark:bg-slate-700 shadow-md text-primary' : 'text-slate-500 hover:text-foreground'"
                            class="px-6 py-2 rounded-xl text-xs font-black uppercase tracking-widest transition-all">
                            CSV Upload
                        </button>
                    </div>

                    <!-- Manual Entry -->
                    <div x-show="inputMethod === 'manual'" class="space-y-4">
                        <textarea x-model="phoneNumbers" @input="parsePhoneNumbers"
                            placeholder="Enter phone numbers (one per line)&#10;Example:&#10;0241234567&#10;0551234567"
                            class="w-full h-80 rounded-2xl border-border bg-slate-50/50 dark:bg-slate-800/50 p-6 text-sm font-mono focus:ring-2 focus:ring-primary/20 outline-none transition-all placeholder:text-slate-400 resize-none"></textarea>
                        <div class="flex items-center gap-2 p-4 bg-primary/5 rounded-xl border border-primary/10">
                            <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p class="text-[10px] font-bold text-primary uppercase tracking-widest">Valid prefixes: <span
                                    x-text="prefixes.join(', ')"></span></p>
                        </div>
                    </div>

                    <!-- CSV Upload -->
                    <div x-show="inputMethod === 'csv'" class="space-y-4">
                        <div
                            class="border-2 border-dashed border-border rounded-3xl p-12 text-center hover:bg-slate-50/50 dark:hover:bg-slate-800/50 transition-all group flex flex-col items-center justify-center min-h-[20rem] relative">
                            <input type="file" accept=".csv" @change="handleCSVUpload"
                                class="absolute inset-0 opacity-0 cursor-pointer" id="csvUpload">
                            <div
                                class="w-20 h-20 bg-primary/10 rounded-full flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                                <svg class="w-10 h-10 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                </svg>
                            </div>
                            <h4 class="text-sm font-black text-foreground">Click to upload CSV</h4>
                            <p class="text-xs text-muted-foreground mt-2 font-medium">Phone numbers should be in the first
                                column</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column - Summary -->
            <div class="space-y-6">
                <div
                    class="rounded-3xl border border-border/50 bg-card/50 backdrop-blur-xl p-8 sticky top-24 shadow-2xl shadow-slate-200/20 dark:shadow-none">
                    <h3 class="text-sm font-black uppercase tracking-widest text-slate-400 mb-8 px-2">Order Summary</h3>

                    <div class="space-y-6">
                        <div class="flex justify-between items-center px-2">
                            <span class="text-xs font-bold text-muted-foreground uppercase tracking-widest">Network</span>
                            <span class="text-sm font-black text-foreground" x-text="selectedNetwork || '---'"></span>
                        </div>
                        <div class="flex justify-between items-start px-2">
                            <span class="text-xs font-bold text-muted-foreground uppercase tracking-widest">Bundle</span>
                            <span class="text-sm font-black text-foreground text-right max-w-[10rem]"
                                x-text="selectedBundle ? selectedBundle.name : '---'"></span>
                        </div>
                        <div
                            class="flex justify-between items-center px-4 py-3 bg-emerald-50 dark:bg-emerald-900/10 rounded-xl border border-emerald-100 dark:border-emerald-900/20">
                            <span
                                class="text-xs font-bold text-emerald-600 dark:text-emerald-400 uppercase tracking-widest">Valid
                                Items</span>
                            <span class="text-sm font-black text-emerald-600 dark:text-emerald-400"
                                x-text="validNumbers.length"></span>
                        </div>
                        <template x-if="invalidNumbers.length > 0">
                            <div
                                class="flex justify-between items-center px-4 py-3 bg-rose-50 dark:bg-rose-900/10 rounded-xl border border-rose-100 dark:border-rose-900/20">
                                <span
                                    class="text-xs font-bold text-rose-600 dark:text-rose-400 uppercase tracking-widest">Invalid
                                    Items</span>
                                <span class="text-sm font-black text-rose-600 dark:text-rose-400"
                                    x-text="invalidNumbers.length"></span>
                            </div>
                        </template>

                        <div class="pt-6 border-t border-border mt-8">
                            <div class="flex flex-col items-center text-center">
                                <span class="text-xs font-bold text-muted-foreground uppercase tracking-widest mb-2">Grand
                                    Total</span>
                                <div class="text-4xl font-black text-primary tracking-tighter">GHS<span
                                        x-text="totalCost"></span></div>
                            </div>
                        </div>

                        <button @click="submitBulkOrder"
                            :disabled="validNumbers.length === 0 || !selectedBundle || processing"
                            class="w-full h-14 bg-primary text-white rounded-2xl font-black text-sm uppercase tracking-widest shadow-xl shadow-primary/25 hover:bg-primary/90 active:scale-95 disabled:opacity-50 disabled:active:scale-100 transition-all duration-300 mt-8 flex items-center justify-center gap-3">
                            <svg x-show="processing" class="animate-spin h-5 w-5 text-white" fill="none"
                                viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                                </circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                            <span x-text="processing ? 'Processing...' : 'Place Bulk Order'"></span>
                        </button>

                        <div class="flex items-center justify-center gap-2 mt-4 opacity-50">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                            <span class="text-[10px] font-black uppercase tracking-widest">Protected by CloudTech</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection