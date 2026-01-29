@extends('layouts.dashboard')

@section('title', 'Shopping Cart')

@section('content')
    <div x-data="{
                                                    paymentMethod: 'momo',
                                                    totalAmount: {{ $totalAmount }},
                                                    userEmail: '{{ auth()->user()->email ?? '' }}',
                                                    chargeType: '{{ $publicSettings['charge_type'] ?? 'percentage' }}',
                                                    chargeValue: {{ $publicSettings['charge_value'] ?? 0 }},
                                                    isLoading: false,
                                                    errorMessage: '',

                                                    enablePaystack: '{{ $publicSettings['enable_paystack'] ?? '1' }}' === '1',
                                                    enableMomo: '{{ $publicSettings['enable_momo_deposits'] ?? '1' }}' === '1',
                                                    enableManualTransfer: '{{ $publicSettings['enable_manual_transfer'] ?? '1' }}' === '1',

                                                    init() {
                                                        if (!this.enableMomo) {
                                                            if (this.enablePaystack) this.paymentMethod = 'paystack';
                                                            else if (this.enableManualTransfer) this.paymentMethod = 'transfer';
                                                        }
                                                    },

                                                    validateEmail(email) {
                                                        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.trim());
                                                    },
                                                    get chargeAmount() {
                                                        if (this.paymentMethod === 'transfer') return 0;
                                                        if (this.chargeType === 'percentage') {
                                                            return this.totalAmount * (this.chargeValue / 100);
                                                        }
                                                        return this.chargeValue;
                                                    },
                                                    get grandTotal() {
                                                        return this.totalAmount + this.chargeAmount;
                                                    },
                                                    getNetworkColor(network) {
                                                        network = network.toLowerCase();
                                                        if (network.includes('mtn')) return 'from-[#FFCC00] to-[#E5B800] text-black shadow-[#FFCC00]/20';
                                                        if (network.includes('telecel') || network.includes('vodafone')) return 'from-[#E60000] to-[#B30000] text-white shadow-red-500/20';
                                                        if (network.includes('airteltigo') || network.includes('at')) return 'from-[#0051A3] to-[#003D7A] text-white shadow-blue-500/20';
                                                        return 'from-slate-700 to-slate-900 text-white shadow-slate-500/20';
                                                    },

                                                    async handleCheckout(e) {
                                                        if (this.paymentMethod === 'transfer') {
                                                            e.target.submit();
                                                            return;
                                                        }

                                                        if (!this.validateEmail(this.userEmail)) {
                                                            alert('Please update your profile with a valid email address first.');
                                                            return;
                                                        }

                                                        this.isLoading = true;
                                                        this.errorMessage = '';

                                                        try {
                                                            const res = await fetch('{{ route('orders.bulk') }}', {
                                                                method: 'POST',
                                                                headers: {
                                                                    'Content-Type': 'application/json',
                                                                    'Accept': 'application/json',
                                                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                                                },
                                                                body: JSON.stringify({
                                                                    payment_method: this.paymentMethod
                                                                })
                                                            });

                                                            const data = await res.json();

                                                            if (!res.ok) {
                                                                throw new Error(data.message || 'Checkout failed');
                                                            }

                                                            // Inline Paystack
                                                            if (window.PaystackPop && data.status) {
                                                                const handler = PaystackPop.setup({
                                                                    key: '{{ $publicSettings['paystack_public'] ?? config('services.paystack.public_key') }}',
                                                                    access_code: data.data.access_code,
                                                                    callback: (response) => {
                                                                        this.isLoading = true;
                                                                        window.location.href = `{{ route('paystack.verify') }}?reference=${response.reference}`;
                                                                    },
                                                                    onClose: () => {
                                                                        this.isLoading = false;
                                                                    }
                                                                });
                                                                handler.openIframe();
                                                            } else {
                                                                // Fallback to URL if popup fails
                                                                window.location.href = data.data.authorization_url;
                                                            }
                                                        } catch (err) {
                                                            console.error('Checkout Error:', err);
                                                            alert(err.message || 'Connection failed. Please try again.');
                                                            this.isLoading = false;
                                                        }
                                                    }
                                                }"
        class="max-w-7xl mx-auto space-y-8 animate-in fade-in slide-in-from-bottom-6 duration-1000">

        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 px-4">
            <div>
                <h2 class="text-4xl font-black tracking-tight text-foreground flex items-center gap-3">
                    <span class="bg-primary/10 p-2.5 rounded-2xl">
                        <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                    </span>
                    <span
                        class="bg-clip-text text-transparent bg-gradient-to-r from-foreground via-foreground/80 to-foreground/50">My
                        Cart</span>
                </h2>
                <p class="text-muted-foreground font-medium mt-2 ml-14">You have <span
                        class="text-foreground font-bold">{{ count($cartItems) }}</span>
                    item{{ count($cartItems) !== 1 ? 's' : '' }} ready for checkout.</p>
            </div>
        </div>

        @if(empty($cartItems))
            <div
                class="flex flex-col items-center justify-center min-h-[550px] text-center p-12 rounded-[3.5rem] border border-dashed border-border/60 bg-card/30 backdrop-blur-2xl transition-all duration-700">
                <div class="relative group">
                    <div
                        class="absolute -inset-4 bg-primary/20 rounded-full blur-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-700">
                    </div>
                    <div
                        class="relative w-32 h-32 rounded-full bg-gradient-to-br from-primary/10 to-indigo-500/10 flex items-center justify-center mb-8 border border-primary/20 shadow-inner">
                        <svg class="h-14 w-14 text-primary opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                </div>
                <h3 class="text-3xl font-black tracking-tight text-foreground mb-4">Your Bag is Empty</h3>
                <p class="text-muted-foreground max-w-sm mx-auto font-medium leading-relaxed">It looks like you haven't added
                    any data bundles yet. Explore our amazing offers and start shopping.</p>
                <a href="{{ route('orders.new') }}"
                    class="mt-12 group relative inline-flex items-center justify-center px-10 py-5 font-black text-white transition-all duration-500 bg-primary rounded-[2rem] hover:bg-primary/90 hover:scale-105 hover:shadow-2xl hover:shadow-primary/30 active:scale-95">
                    <span class="mr-3">Shop Data Bundles</span>
                    <svg class="w-5 h-5 transition-transform duration-500 group-hover:translate-x-1" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </a>
            </div>
        @else
            <div class="grid gap-8 lg:grid-cols-12 items-start px-2">
                <!-- Cart Items List -->
                <div class="lg:col-span-8 space-y-8">
                    <div
                        class="flex items-center justify-between bg-card/40 backdrop-blur-md p-6 rounded-[2rem] border border-border/40 shadow-sm">
                        <div class="flex items-center gap-3">
                            <span class="flex h-3 w-3 rounded-full bg-emerald-500 animate-pulse"></span>
                            <h3 class="font-black text-xs uppercase tracking-[0.2em] text-muted-foreground">Active Selection
                            </h3>
                        </div>
                        <form action="{{ route('cart.clear') }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="group flex items-center gap-2 text-xs font-black uppercase tracking-widest text-rose-500 hover:text-rose-600 transition-all">
                                <svg class="w-4 h-4 transition-transform group-hover:rotate-12" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                Clear All
                            </button>
                        </form>
                    </div>

                    <div class="space-y-4">
                        @foreach($cartItems as $item)
                            <div
                                class="group relative rounded-[2.5rem] border border-border/40 bg-card/60 backdrop-blur-3xl p-8 hover:bg-card/80 hover:border-primary/20 transition-all duration-500 shadow-xl shadow-slate-200/5 dark:shadow-none overflow-hidden">
                                <!-- Background Gradient Subtle Glow -->
                                <div
                                    class="absolute top-0 right-0 w-32 h-32 bg-primary/5 rounded-full blur-3xl -mr-16 -mt-16 opacity-0 group-hover:opacity-100 transition-opacity duration-700">
                                </div>

                                <div class="relative flex flex-col sm:flex-row sm:items-center justify-between gap-8">
                                    <div class="flex items-center gap-8">
                                        <!-- Network Badge -->
                                        <div :class="getNetworkColor('{{ $item['network'] }}')"
                                            class="h-20 w-20 flex-shrink-0 rounded-[1.75rem] flex flex-col items-center justify-center font-black text-[10px] uppercase tracking-tighter shadow-xl transition-transform duration-500 group-hover:scale-110 group-hover:rotate-3 bg-gradient-to-br">
                                            <span class="text-lg leading-none mb-0.5">{{ substr($item['network'], 0, 1) }}</span>
                                            <span class="opacity-80">{{ substr($item['network'], 0, 3) }}</span>
                                        </div>

                                        <div class="space-y-1.5">
                                            <div class="flex items-center gap-3">
                                                <h4
                                                    class="font-black text-xl text-foreground group-hover:text-primary transition-colors tracking-tight">
                                                    {{ $item['name'] }}
                                                </h4>
                                                <span
                                                    class="px-2.5 py-1 rounded-full bg-primary/10 text-primary text-[10px] font-black uppercase tracking-widest border border-primary/20">Data</span>
                                            </div>
                                            <div class="flex flex-wrap items-center gap-3">
                                                <div class="flex items-center gap-2 text-muted-foreground">
                                                    <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                                    </svg>
                                                    <span
                                                        class="text-xs font-bold font-mono tracking-wider">{{ $item['recipient_phone'] }}</span>
                                                </div>
                                                <span class="w-1.5 h-1.5 rounded-full bg-border"></span>
                                                <span
                                                    class="text-xs font-black text-foreground/70 uppercase tracking-widest">{{ $item['network'] }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div
                                        class="flex items-center justify-between sm:justify-end gap-12 pt-6 sm:pt-0 border-t sm:border-t-0 border-border/40">
                                        <div class="text-right">
                                            <p class="text-xs font-black text-muted-foreground uppercase tracking-[0.2em] mb-1">
                                                Price</p>
                                            <p class="font-black text-3xl text-foreground tracking-tighter">
                                                <span
                                                    class="text-lg font-bold text-primary mr-1">GHS</span>{{ number_format($item['price'], 2) }}
                                            </p>
                                        </div>
                                        <form action="{{ route('cart.remove', $item['id']) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="w-14 h-14 rounded-2xl flex items-center justify-center bg-rose-500/5 text-rose-500 hover:bg-rose-500 hover:text-white transition-all duration-300 shadow-sm active:scale-95 group/del">
                                                <svg class="h-6 w-6 transition-transform duration-300 group-hover/del:scale-110"
                                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Add More Button -->
                    <a href="{{ route('orders.new') }}"
                        class="group relative flex items-center justify-center gap-5 p-10 border-2 border-dashed border-border/60 rounded-[3rem] text-muted-foreground hover:bg-primary/5 hover:text-primary hover:border-primary/40 transition-all duration-500 overflow-hidden">
                        <div
                            class="absolute inset-0 bg-gradient-to-r from-primary/0 via-primary/5 to-primary/0 translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-1000">
                        </div>
                        <div
                            class="relative w-12 h-12 rounded-2xl bg-muted/10 flex items-center justify-center group-hover:bg-primary/20 group-hover:scale-110 transition-all duration-500">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                            </svg>
                        </div>
                        <span class="relative text-sm font-black uppercase tracking-[0.2em]">Add More Bundles</span>
                    </a>
                </div>

                <!-- Checkout Summary -->
                <div class="lg:col-span-4 lg:sticky lg:top-24 space-y-8">
                    <div
                        class="relative rounded-[3rem] border border-border/40 bg-card/60 backdrop-blur-3xl p-10 shadow-2xl shadow-slate-200/10 dark:shadow-none overflow-hidden">
                        <div class="absolute top-0 right-0 w-40 h-40 bg-primary/5 rounded-full blur-[80px] -mr-20 -mt-20"></div>

                        <h3
                            class="text-sm font-black uppercase tracking-[0.2em] text-muted-foreground mb-10 flex items-center gap-2">
                            Summary
                            <span class="h-px flex-1 bg-border/40"></span>
                        </h3>

                        <div class="space-y-8">
                            <div class="space-y-4">
                                <div class="flex justify-between items-center px-2">
                                    <span
                                        class="text-xs font-bold text-muted-foreground uppercase tracking-widest">Subtotal</span>
                                    <span class="text-base font-black text-foreground">GHS
                                        {{ number_format($totalAmount, 2) }}</span>
                                </div>

                                <div x-show="paymentMethod !== 'transfer'" x-transition:enter="transition ease-out duration-300"
                                    x-transition:enter-start="opacity-0 -translate-y-2"
                                    x-transition:enter-end="opacity-100 translate-y-0"
                                    class="flex justify-between items-center px-2 bg-primary/5 rounded-2xl p-4 border border-primary/10">
                                    <span class="text-xs font-bold text-primary uppercase tracking-widest">Gateway Fee</span>
                                    <span class="text-base font-black text-primary"
                                        x-text="'GHS ' + chargeAmount.toFixed(2)"></span>
                                </div>
                            </div>

                            <div class="pt-8 border-t border-border/40">
                                <div
                                    class="bg-gradient-to-br from-slate-900 to-slate-950 dark:from-primary/10 dark:to-primary/5 p-8 rounded-[2.5rem] text-center shadow-lg border border-white/5 relative overflow-hidden group/total">
                                    <div
                                        class="absolute inset-0 bg-primary opacity-0 group-hover/total:opacity-5 transition-opacity duration-700">
                                    </div>
                                    <span
                                        class="text-xs font-bold text-slate-400 dark:text-primary/70 uppercase tracking-[0.3em] mb-3 block">Grand
                                        Total</span>
                                    <div
                                        class="text-4xl font-black text-white dark:text-foreground tracking-tighter flex items-center justify-center gap-2">
                                        <span class="text-xl font-bold opacity-60">GHS</span>
                                        <span x-text="grandTotal.toFixed(2)"></span>
                                    </div>
                                </div>
                            </div>

                            <!-- Payment Selection -->
                            <div class="space-y-6 pt-4">
                                <div
                                    class="flex items-center gap-2 text-[10px] font-black uppercase tracking-[0.2em] text-muted-foreground ml-2">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                    </svg>
                                    Preferred Payment Mode
                                </div>
                                <div class="grid grid-cols-3 gap-3">
                                    <button x-show="enableMomo" @click="paymentMethod = 'momo'"
                                        :class="paymentMethod === 'momo' ? 'bg-primary text-white shadow-lg shadow-primary/25 border-primary scale-105' : 'bg-card/40 border-border/40 text-muted-foreground hover:bg-card/80'"
                                        class="h-20 rounded-2xl border-2 flex flex-col items-center justify-center transition-all duration-300 group">
                                        <span
                                            class="text-[8px] font-black uppercase tracking-widest mb-1 opacity-60">Mobile</span>
                                        <span class="text-[10px] font-black uppercase tracking-widest">MOMO</span>
                                    </button>
                                    <button x-show="enablePaystack" @click="paymentMethod = 'paystack'"
                                        :class="paymentMethod === 'paystack' ? 'bg-[#00c3af] text-white shadow-lg shadow-[#00c3af]/25 border-[#00c3af] scale-105' : 'bg-card/40 border-border/40 text-muted-foreground hover:bg-card/80'"
                                        class="h-20 rounded-2xl border-2 flex flex-col items-center justify-center transition-all duration-300 group">
                                        <span
                                            class="text-[8px] font-black uppercase tracking-widest mb-1 opacity-60">Gateway</span>
                                        <span class="text-[10px] font-black uppercase tracking-widest">Paystack</span>
                                    </button>
                                    <button x-show="enableManualTransfer" @click="paymentMethod = 'transfer'"
                                        :class="paymentMethod === 'transfer' ? 'bg-slate-900 text-white shadow-lg shadow-slate-900/25 border-slate-900 scale-105' : 'bg-card/40 border-border/40 text-muted-foreground hover:bg-card/80'"
                                        class="h-20 rounded-2xl border-2 flex flex-col items-center justify-center transition-all duration-300 group">
                                        <span
                                            class="text-[8px] font-black uppercase tracking-widest mb-1 opacity-60">Manual</span>
                                        <span class="text-[10px] font-black uppercase tracking-widest">Transfer</span>
                                    </button>
                                </div>
                            </div>

                            <div x-show="!validateEmail(userEmail)"
                                class="mt-4 p-4 rounded-2xl bg-rose-50 dark:bg-rose-900/20 text-rose-600 text-[10px] font-black uppercase tracking-tight flex items-center gap-3">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                                <span>Invalid account email. Please update your profile to checkout.</span>
                            </div>

                            <form action="{{ route('orders.bulk') }}" method="POST" class="mt-4"
                                @submit.prevent="handleCheckout($event)">
                                @csrf
                                <input type="hidden" name="payment_method" x-model="paymentMethod">
                                <button type="submit" :disabled="isLoading"
                                    class="w-full group relative h-20 bg-primary disabled:bg-slate-200 text-white rounded-[2rem] font-black text-sm uppercase tracking-[0.2em] shadow-2xl shadow-primary/30 transition-all duration-500 hover:bg-primary/90 hover:scale-[1.02] active:scale-95 overflow-hidden flex items-center justify-center gap-3">
                                    <div
                                        class="absolute inset-0 bg-white/20 translate-y-full group-hover:translate-y-0 transition-transform duration-500">
                                    </div>
                                    <div x-show="isLoading"
                                        class="animate-spin w-5 h-5 border-2 border-white/30 border-t-white rounded-full"></div>
                                    <span class="relative"
                                        x-text="isLoading ? 'Contacting Gateway...' : 'Secure Checkout'"></span>
                                    <svg x-show="!isLoading" class="w-5 h-5 relative" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                </button>
                            </form>

                            <div
                                class="flex items-center justify-center gap-6 pt-4 grayscale opacity-40 hover:grayscale-0 hover:opacity-100 transition-all duration-500">
                                <img src="https://paystack.com/assets/img/login/paystack-logo.png" class="h-3 object-contain"
                                    alt="Paystack">
                                <span class="h-4 w-px bg-border/60"></span>
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                                        <path
                                            d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm0 10.99h7c-.53 4.12-3.28 7.79-7 8.94V12H5V6.3l7-3.11v8.8z" />
                                    </svg>
                                    <span class="text-[9px] font-black uppercase tracking-widest">SSL Secure</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Info -->
                    <div
                        class="px-8 flex items-center gap-4 text-muted-foreground/60 text-[10px] font-bold uppercase tracking-widest">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>Purchases are processed instantly but may take up to 2-5 minutes to reflect on the recipient's
                            phone.</span>
                    </div>
                </div>
            </div>
        @endif
    </div>
    @push('scripts')
        <script src="https://js.paystack.co/v1/inline.js"></script>
    @endpush
@endsection