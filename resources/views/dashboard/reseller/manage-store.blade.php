@extends('layouts.dashboard')

@section('title', 'Manage My E-Store')

@section('content')
    <div class="space-y-8 pb-20 animate-in fade-in slide-in-from-bottom-4 duration-700">
        {{-- Header --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <h2
                    class="text-3xl font-black tracking-tight text-foreground bg-clip-text text-transparent bg-gradient-to-r from-primary to-indigo-600 uppercase">
                    Manage E-Store</h2>
                <p class="text-sm text-muted-foreground font-medium mt-1">Set your custom prices and maximize your profit
                    margins.</p>
            </div>

            <a href="{{ route('reseller.hub') }}"
                class="h-12 px-6 bg-white dark:bg-slate-900 text-slate-600 dark:text-slate-400 border border-slate-200 dark:border-slate-800 rounded-2xl font-black text-[10px] uppercase tracking-widest flex items-center gap-2 hover:bg-slate-50 dark:hover:bg-slate-800 transition-all active:scale-95 shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Hub
            </a>
        </div>

        {{-- Store Link Card --}}
        <div class="relative overflow-hidden group">
            <div
                class="absolute inset-0 bg-gradient-to-br from-primary/10 via-indigo-600/5 to-transparent rounded-[2.5rem]">
            </div>
            <div class="absolute top-0 right-0 p-12 opacity-10 group-hover:scale-110 transition-transform duration-700">
                <svg class="w-32 h-32 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                </svg>
            </div>

            <div class="relative z-10 p-10 space-y-6">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-1 bg-primary rounded-full"></div>
                    <h3 class="text-primary font-black uppercase tracking-[0.3em] text-[10px]">Your Digital Storefront</h3>
                </div>

                <div class="flex flex-col lg:flex-row items-center gap-4">
                    <div class="flex-1 w-full group/input relative">
                        <div class="absolute inset-y-0 left-6 flex items-center text-primary/40">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                            </svg>
                        </div>
                        <div
                            class="w-full h-16 bg-white/60 dark:bg-slate-900/60 backdrop-blur-md border border-primary/20 rounded-3xl pl-14 pr-6 flex items-center text-sm font-mono font-bold text-foreground overflow-hidden shadow-inner">
                            <span class="truncate">{{ route('store.show', $user->referral_code) }}</span>
                        </div>
                    </div>
                    <button onclick="copyToClipboard('{{ route('store.show', $user->referral_code) }}')"
                        class="h-16 px-10 bg-primary text-white rounded-3xl font-black text-xs uppercase tracking-widest shadow-xl shadow-primary/30 active:scale-95 transition-all whitespace-nowrap hover:bg-primary/90 flex items-center gap-3">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                        </svg>
                        Copy Link
                    </button>
                    <a href="{{ route('store.show', $user->referral_code) }}" target="_blank"
                        class="h-16 px-8 bg-white dark:bg-slate-800 text-foreground border border-slate-200 dark:border-slate-700 rounded-3xl font-black text-xs uppercase tracking-widest shadow-lg active:scale-95 transition-all whitespace-nowrap hover:bg-slate-50 dark:hover:bg-slate-700 flex items-center gap-3">
                        Preview
                    </a>
                </div>
                <p class="text-[10px] font-bold text-muted-foreground uppercase tracking-widest leading-relaxed max-w-2xl">
                    Share this link with your customers. Any purchase made through your storefront will use your customized
                    pricing, and profits will be credited to your commission balance automatically.</p>
            </div>
        </div>

        {{-- Bundle Pricing Grid --}}
        <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($bundles as $bundle)
                <div
                    class="group relative bg-white/40 dark:bg-slate-900/40 backdrop-blur-xl border border-white/20 dark:border-slate-800/50 rounded-[3rem] overflow-hidden shadow-2xl shadow-slate-200/20 dark:shadow-none hover:shadow-primary/10 transition-all duration-500">
                    {{-- Visual Header --}}
                    <div
                        class="aspect-[4/3] bg-slate-50 dark:bg-slate-800/50 relative flex items-center justify-center overflow-hidden">
                        @if($bundle->image_url)
                            <img src="{{ $bundle->image_url }}"
                                class="w-full h-full object-cover transition-transform group-hover:scale-110 duration-1000">
                        @else
                            <div
                                class="w-full h-full bg-gradient-to-br from-slate-100 to-slate-200 dark:from-slate-800 dark:to-slate-900 flex items-center justify-center">
                                <span
                                    class="text-6xl font-black opacity-[0.03] select-none">{{ strtoupper($bundle->network) }}</span>
                                <svg class="absolute w-20 h-20 text-slate-300 dark:text-slate-700 opacity-50" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                        @endif

                        <div class="absolute top-6 left-6">
                            <span
                                class="px-4 py-2 bg-white/90 dark:bg-slate-900/90 backdrop-blur-md rounded-2xl text-[10px] font-black uppercase tracking-widest shadow-xl border border-white/20 dark:border-slate-800/50 text-primary">
                                {{ $bundle->network }}
                            </span>
                        </div>

                        <div class="absolute bottom-6 right-6 text-right">
                            <p class="text-[9px] font-black uppercase text-muted-foreground mb-1 tracking-widest">Base Cost</p>
                            <div class="flex items-baseline justify-end gap-1">
                                <span class="text-[10px] font-black opacity-40 uppercase">GHC</span>
                                <p class="text-xl font-black text-foreground tabular-nums">
                                    GHC {{ number_format($bundle->cost_to_reseller, 2) }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="p-8 space-y-8">
                        <div>
                            <h4 class="text-lg font-black text-foreground uppercase tracking-tight leading-none">
                                {{ $bundle->name }}
                            </h4>
                            <p class="text-[10px] font-black text-primary mt-2 uppercase tracking-[0.2em]">
                                {{ $bundle->data_amount }} ALLOCATION
                            </p>
                        </div>

                        <form action="{{ route('reseller.store.update-price') }}" method="POST" class="space-y-6">
                            @csrf
                            <input type="hidden" name="bundle_id" value="{{ $bundle->id }}">

                            <div class="space-y-3">
                                <div class="flex items-center justify-between px-1">
                                    <label class="text-[10px] font-black text-muted-foreground uppercase tracking-widest">Store
                                        Price</label>
                                    <div
                                        class="flex items-center gap-1.5 px-3 py-1 bg-emerald-500/10 text-emerald-600 rounded-xl border border-emerald-500/10">
                                        <span class="text-[9px] font-black uppercase tracking-tight">Net Profit:</span>
                                        <span
                                            class="text-[11px] font-black tabular-nums">GHC {{ number_format($bundle->profit_per_unit, 2) }}</span>
                                    </div>
                                </div>
                                <div class="relative group/field">
                                    <div
                                        class="absolute left-5 top-1/2 -translate-y-1/2 font-black text-slate-300 group-focus-within/field:text-primary transition-colors">
                                        GHC</div>
                                    <input type="number" step="0.01" name="price"
                                        value="{{ number_format($bundle->custom_price, 2, '.', '') }}" required
                                        class="w-full h-15 bg-slate-50 dark:bg-slate-800/50 border-none rounded-2xl text-lg font-black tabular-nums focus:ring-2 focus:ring-primary/20 text-foreground px-10 shadow-inner group-hover/field:bg-slate-100 dark:group-hover/field:bg-slate-800 transition-colors">
                                </div>
                            </div>

                            <button type="submit"
                                class="w-full h-14 bg-foreground dark:bg-white text-background dark:text-foreground rounded-2xl font-black text-[11px] uppercase tracking-widest hover:bg-primary dark:hover:bg-primary dark:hover:text-white transition-all shadow-xl active:scale-95 shadow-slate-900/10 dark:shadow-none flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                                </svg>
                                Save Pricing
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Copy Confirmation Toast --}}
    <div id="copy-confirm"
        class="fixed bottom-10 left-1/2 -translate-x-1/2 z-[100] px-8 py-4 bg-slate-900 text-white rounded-2xl text-[10px] font-black uppercase tracking-widest shadow-2xl transition-all duration-500 translate-y-20 opacity-0 pointer-events-none">
        Store link copied to clipboard
    </div>

    <script>
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(() => {
                const toast = document.getElementById('copy-confirm');
                toast.classList.remove('translate-y-20', 'opacity-0');
                setTimeout(() => {
                    toast.classList.add('translate-y-20', 'opacity-0');
                }, 3000);
            });
        }
    </script>
@endsection