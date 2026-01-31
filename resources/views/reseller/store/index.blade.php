<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $reseller->name }}'s Data Hub - {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Geist:wght@100..900&display=swap" rel="stylesheet">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="antialiased bg-slate-50 dark:bg-slate-950 text-slate-900 dark:text-slate-100 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 md:px-6 py-8 md:py-20 space-y-8 md:space-y-16">
        {{-- Store Branding --}}
        <div class="text-center space-y-4 md:space-y-6">
            <div
                class="inline-flex items-center gap-3 px-4 py-2 bg-primary/10 text-primary rounded-full text-[10px] font-black uppercase tracking-[0.2em] animate-in fade-in slide-in-from-top-4 duration-1000">
                <span class="relative flex h-2 w-2">
                    <span
                        class="animate-ping absolute inline-flex h-full w-full rounded-full bg-primary opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-primary"></span>
                </span>
                Official Reseller Store
            </div>
            <h1
                class="text-3xl md:text-6xl font-black tracking-tight text-slate-900 dark:text-white uppercase leading-none animate-in fade-in slide-in-from-bottom-4 duration-700">
                {{ $reseller->name }}'s <span class="text-primary block md:inline">Data Hub</span>
            </h1>
            <p
                class="max-w-2xl mx-auto text-sm md:text-lg text-slate-500 dark:text-slate-400 font-medium animate-in fade-in slide-in-from-bottom-6 duration-1000 px-4">
                Select your preferred network and bundle size below to receive instant data delivery. Secure, fast, and
                reliable.
            </p>
        </div>

        {{-- Product Grid --}}
        <div class="grid gap-4 md:gap-6 grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 px-2 md:px-0">
            @foreach($bundles as $bundle)
                <div
                    class="group relative bg-white dark:bg-slate-900 rounded-3xl border border-slate-100 dark:border-slate-800 overflow-hidden shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    {{-- Image Section --}}
                    <div
                        class="aspect-[4/3] bg-slate-50 dark:bg-slate-800/50 relative flex items-center justify-center overflow-hidden">
                        @if($bundle->image_url)
                            <img src="{{ $bundle->image_url }}"
                                class="w-full h-full object-cover transition-transform group-hover:scale-105 duration-500">
                        @else
                            <div
                                class="flex flex-col items-center gap-2 opacity-20 group-hover:opacity-40 transition-opacity text-slate-400">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                        @endif

                        {{-- Network Badge --}}
                        <div class="absolute top-3 left-3">
                            @php
                                $net = strtoupper($bundle->network);
                                $netColors = [
                                    'MTN' => 'bg-yellow-400 text-yellow-950',
                                    'TELECEL' => 'bg-red-500 text-white',
                                    'AT' => 'bg-blue-600 text-white',
                                    'AIRTELTIGO' => 'bg-blue-600 text-white',
                                ];
                                $nc = $netColors[$net] ?? 'bg-slate-900 text-white';
                            @endphp
                            <span
                                class="px-2.5 py-1 rounded-lg text-[9px] font-black tracking-widest uppercase shadow-sm backdrop-blur-md {{ $nc }}">
                                {{ $bundle->network }}
                            </span>
                        </div>
                    </div>

                    <div class="p-4 md:p-5 space-y-4">
                        <div>
                            <h3
                                class="text-lg font-black text-blue-900 dark:text-white leading-tight group-hover:text-primary transition-colors">
                                {{ $bundle->name }}
                            </h3>
                            <p class="text-[9px] font-bold text-slate-400 mt-1 uppercase tracking-widest">
                                {{ $bundle->data_amount }} Data
                            </p>
                        </div>

                        <div class="pt-4 border-t border-slate-50 dark:border-slate-800 space-y-3">
                            <div class="flex items-center justify-between">
                                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Price</p>
                                <p class="text-lg font-black text-primary tracking-tighter tabular-nums">
                                    ₵{{ number_format($bundle->display_price, 2) }}</p>
                            </div>
                            <!-- Buy Button triggers Modal -->
                            <button
                                onclick="openCheckoutModal({{ $bundle->id }}, '{{ addslashes($bundle->name) }}', {{ $bundle->display_price }})"
                                class="w-full h-9 md:h-10 bg-slate-900 dark:bg-white text-white dark:text-slate-900 rounded-xl font-black text-[9px] uppercase tracking-widest hover:bg-primary dark:hover:bg-primary dark:hover:text-white transition-all shadow-md active:scale-95 flex items-center justify-center gap-2">
                                <span>Buy Now</span>
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Guest Checkout Modal (Alpine.js) --}}
        <div x-data="{ 
                open: false, 
                step: 'input', 
                bundleId: null, 
                bundleName: '', 
                price: 0, 
                email: '', 
                phone: '',
                get isValidPhone() {
                    const pattern = /^0(20|23|24|25|26|27|28|50|53|54|55|56|57|59)\d{7}$/;
                    return pattern.test(this.phone);
                },
                get isValidEmail() {
                    return /^\S+@\S+\.\S+$/.test(this.email);
                },
                reset() {
                    this.step = 'input';
                    this.email = '';
                    this.phone = '';
                }
            }"
            @open-checkout.window="open = true; reset(); bundleId = $event.detail.id; bundleName = $event.detail.name; price = $event.detail.price"
            class="relative z-[100]" aria-labelledby="modal-title" role="dialog" aria-modal="true" x-show="open"
            x-cloak>

            <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity"
                x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>

            <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                    <div class="relative transform overflow-hidden rounded-[2rem] bg-white dark:bg-slate-900 text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-md border border-slate-100 dark:border-slate-800"
                        x-transition:enter="ease-out duration-300"
                        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                        x-transition:leave="ease-in duration-200"
                        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        @click.away="open = false">

                        <div class="bg-gradient-to-br from-primary/10 to-transparent p-6 md:p-8">
                            <div class="flex items-center justify-between mb-6">
                                <div>
                                    <h3 class="text-xl font-black text-slate-900 dark:text-white uppercase tracking-tight"
                                        id="modal-title">
                                        <span x-show="step === 'input'">Secure Checkout</span>
                                        <span x-show="step === 'confirm'">Verify Details</span>
                                    </h3>
                                    <p class="text-[10px] font-bold text-slate-500 dark:text-slate-400 mt-1 uppercase tracking-wider"
                                        x-text="bundleName"></p>
                                </div>
                                <div class="text-right">
                                    <p class="text-[9px] font-black uppercase tracking-widest text-slate-400">Total</p>
                                    <p class="text-2xl font-black text-primary tabular-nums">₵<span
                                            x-text="price.toFixed(2)"></span></p>
                                </div>
                            </div>

                            {{-- Step 1: Input --}}
                            <div x-show="step === 'input'" class="space-y-4">
                                <div class="space-y-1.5">
                                    <label
                                        class="text-[9px] font-black uppercase tracking-widest text-slate-500 ml-1">Email
                                        Address</label>
                                    <input type="email" x-model="email" placeholder="customer@example.com"
                                        class="w-full h-12 px-5 bg-white dark:bg-slate-950 border-none rounded-xl text-sm font-bold text-slate-900 dark:text-white shadow-sm focus:ring-2 focus:ring-primary/20 transition-all placeholder:font-normal placeholder:text-slate-400">
                                </div>

                                <div class="space-y-1.5">
                                    <label
                                        class="text-[9px] font-black uppercase tracking-widest text-slate-500 ml-1">Recipient
                                        Number</label>
                                    <input type="tel" x-model="phone" maxlength="10" placeholder="024XXXXXXX"
                                        @input="phone = phone.replace(/\D/g, '')"
                                        :class="phone.length > 0 && !isValidPhone ? 'ring-2 ring-red-500' : ''"
                                        class="w-full h-12 px-5 bg-white dark:bg-slate-950 border-none rounded-xl text-sm font-bold text-slate-900 dark:text-white shadow-sm focus:ring-2 focus:ring-primary/20 transition-all placeholder:font-normal placeholder:text-slate-400 font-mono tracking-wide">
                                    <p x-show="phone.length > 0 && !isValidPhone"
                                        class="text-[9px] font-bold text-red-500 mt-1 ml-1 uppercase tracking-tight">
                                        Enter a valid 10-digit Ghana number (e.g. 024...)
                                    </p>
                                </div>

                                <div class="pt-4">
                                    <button @click="isValidPhone && isValidEmail ? step = 'confirm' : null"
                                        :class="isValidPhone && isValidEmail ? 'bg-slate-900 dark:bg-white text-white dark:text-slate-900 hover:bg-primary dark:hover:bg-primary dark:hover:text-white' : 'bg-slate-200 dark:bg-slate-800 text-slate-400 cursor-not-allowed'"
                                        class="w-full h-14 rounded-xl font-black text-[11px] uppercase tracking-widest transition-all shadow-xl active:scale-95 flex items-center justify-center gap-2 group/pay">
                                        <span>Continue to Verify</span>
                                        <svg class="w-4 h-4 transition-transform group-hover/pay:translate-x-1"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                                d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            {{-- Step 2: Confirm --}}
                            <div x-show="step === 'confirm'" x-cloak class="space-y-6">
                                <div
                                    class="bg-white/50 dark:bg-slate-950/50 rounded-2xl p-4 border border-slate-100 dark:border-slate-800 space-y-3">
                                    <div class="flex justify-between items-center">
                                        <span
                                            class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Recipient</span>
                                        <span class="text-sm font-black text-slate-900 dark:text-white font-mono"
                                            x-text="phone"></span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span
                                            class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Email</span>
                                        <span class="text-sm font-bold text-slate-600 dark:text-slate-300"
                                            x-text="email"></span>
                                    </div>
                                </div>

                                <div class="flex gap-3">
                                    <button @click="step = 'input'"
                                        class="flex-1 h-14 bg-slate-100 dark:bg-slate-800 text-slate-900 dark:text-white rounded-xl font-black text-[11px] uppercase tracking-widest hover:bg-slate-200 dark:hover:bg-slate-700 transition-all active:scale-95">
                                        Edit Details
                                    </button>

                                    <form action="{{ route('store.purchase') }}" method="POST" class="flex-[2]">
                                        @csrf
                                        <input type="hidden" name="reseller_code"
                                            value="{{ $reseller->referral_code }}">
                                        <input type="hidden" name="bundle_id" :value="bundleId">
                                        <input type="hidden" name="email" :value="email">
                                        <input type="hidden" name="phone" :value="phone">

                                        <button type="submit"
                                            class="w-full h-14 bg-primary text-white rounded-xl font-black text-[11px] uppercase tracking-widest hover:bg-primary/90 transition-all shadow-xl active:scale-95 flex items-center justify-center gap-2">
                                            <span>Pay ₵<span x-text="price.toFixed(2)"></span></span>
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <button type="button" @click="open = false"
                                class="w-full mt-3 py-2 text-[9px] font-black uppercase tracking-widest text-slate-400 hover:text-slate-900 dark:hover:text-white transition-colors">
                                Cancel Transaction
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Success Prompt (Post-Payment) --}}
        @if(session('success'))
            <div x-data="{ show: true }" x-show="show" x-cloak class="relative z-[110]">
                <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity"
                    x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>

                <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                    <div class="flex min-h-full items-center justify-center p-4">
                        <div class="relative transform overflow-hidden rounded-[2.5rem] bg-white dark:bg-slate-900 p-8 text-center shadow-2xl transition-all sm:max-w-sm w-full border border-slate-100 dark:border-slate-800"
                            x-transition:enter="ease-out duration-300"
                            x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                            x-transition:leave="ease-in duration-200"
                            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                            x-transition:leave-end="opacity-0 scale-95 translate-y-4">
                            <div
                                class="w-20 h-20 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center mx-auto mb-6">
                                <svg class="w-10 h-10 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <h3 class="text-2xl font-black text-slate-900 dark:text-white uppercase tracking-tight mb-2">
                                Payment Received!</h3>
                            <p class="text-sm font-bold text-slate-500 dark:text-slate-400 mb-8 px-4 leading-relaxed">
                                {{ session('success') }}
                            </p>
                            <button @click="show = false"
                                class="w-full h-14 bg-slate-900 dark:bg-white text-white dark:text-slate-900 rounded-2xl font-black text-[11px] uppercase tracking-widest hover:bg-primary dark:hover:bg-primary dark:hover:text-white transition-all shadow-xl active:scale-95">
                                Great, Thanks!
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- Toast Notification --}}
        <div x-data="{ 
                show: false, 
                message: '', 
                type: 'success',
                init() {
                    @if(session('success'))
                        this.trigger('{{ session('success') }}', 'success');
                    @endif
                    @if(session('error'))
                        this.trigger('{{ session('error') }}', 'error');
                    @endif
                },
                trigger(msg, type = 'success') {
                    this.message = msg;
                    this.type = type;
                    this.show = true;
                    setTimeout(() => { this.show = false }, 5000);
                }
            }" x-show="show" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 translate-y-4"
            class="fixed bottom-8 left-1/2 -translate-x-1/2 z-[120] min-w-[300px]" x-cloak>
            <div :class="type === 'success' ? 'bg-slate-900 dark:bg-white text-white dark:text-slate-900' : 'bg-red-500 text-white'"
                class="px-6 py-4 rounded-2xl shadow-2xl flex items-center gap-3 border border-white/10">
                <div x-show="type === 'success'"
                    class="w-6 h-6 bg-green-500/20 rounded-full flex items-center justify-center">
                    <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <div x-show="type === 'error'"
                    class="w-6 h-6 bg-white/20 rounded-full flex items-center justify-center">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </div>
                <p class="text-[11px] font-black uppercase tracking-widest" x-text="message"></p>
            </div>
        </div>

        <script>
            function openCheckoutModal(id, name, price) {
                window.dispatchEvent(new CustomEvent('open-checkout', { detail: { id, name, price } }));
            }
        </script>

        {{-- Footer --}}
        <div class="pt-12 md:pt-20 border-t border-slate-100 dark:border-slate-800 text-center space-y-4">
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em]">Managed by {{ $reseller->name }}
            </p>
            <p class="text-xs text-slate-500 dark:text-slate-500 font-bold uppercase tracking-widest">Powered by
                {{ config('app.name') }} Integration Engine
            </p>
        </div>
    </div>
</body>

</html>