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
    <div class="max-w-7xl mx-auto px-4 py-12 md:py-20 space-y-16">
        {{-- Store Branding --}}
        <div class="text-center space-y-6">
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
                class="text-4xl md:text-6xl font-black tracking-tight text-slate-900 dark:text-white uppercase leading-none animate-in fade-in slide-in-from-bottom-4 duration-700">
                {{ $reseller->name }}'s <span class="text-primary">Data Hub</span>
            </h1>
            <p
                class="max-w-2xl mx-auto text-lg text-slate-500 dark:text-slate-400 font-medium animate-in fade-in slide-in-from-bottom-6 duration-1000">
                Select your preferred network and bundle size below to receive instant data delivery. Secure, fast, and
                reliable.
            </p>
        </div>

        {{-- Product Grid --}}
        <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            @foreach($bundles as $bundle)
                <div
                    class="group relative bg-white dark:bg-slate-900 rounded-[2.5rem] border border-slate-100 dark:border-slate-800 overflow-hidden shadow-sm hover:shadow-2xl hover:-translate-y-2 transition-all duration-500">
                    {{-- Image Section --}}
                    <div
                        class="aspect-[4/3] bg-slate-50 dark:bg-slate-800/50 relative flex items-center justify-center overflow-hidden">
                        @if($bundle->image_url)
                            <img src="{{ $bundle->image_url }}"
                                class="w-full h-full object-cover transition-transform group-hover:scale-110 duration-700">
                        @else
                            <div
                                class="flex flex-col items-center gap-2 opacity-20 group-hover:opacity-40 transition-opacity text-slate-400">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                        @endif

                        {{-- Network Badge --}}
                        <div class="absolute top-4 left-4">
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
                                class="px-3 py-1.5 rounded-xl text-[10px] font-black tracking-widest uppercase shadow-xl backdrop-blur-md {{ $nc }}">
                                {{ $bundle->network }}
                            </span>
                        </div>
                    </div>

                    <div class="p-8 space-y-6">
                        <div>
                            <h3
                                class="text-xl font-black text-slate-900 dark:text-white leading-tight uppercase tracking-tight">
                                {{ $bundle->name }}
                            </h3>
                            <p class="text-xs font-bold text-slate-400 mt-1 uppercase tracking-widest">
                                {{ $bundle->data_amount }} Data Allocation</p>
                        </div>

                        <div class="pt-6 border-t border-slate-50 dark:border-slate-800 flex items-center justify-between">
                            <div>
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Price</p>
                                <p class="text-2xl font-black text-primary tracking-tighter tabular-nums">
                                    ₵{{ number_format($bundle->display_price, 2) }}</p>
                            </div>
                            <a href="{{ url('/login?redirect=purchase&bundle=' . $bundle->id . '&ref=' . $reseller->referral_code) }}"
                                class="h-12 px-6 bg-slate-900 dark:bg-white text-white dark:text-slate-900 rounded-2xl font-black text-[10px] uppercase tracking-widest hover:bg-primary dark:hover:bg-primary dark:hover:text-white transition-all shadow-xl shadow-slate-900/10 dark:shadow-none flex items-center justify-center">
                                Buy Now
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Footer --}}
        <div class="pt-20 border-t border-slate-100 dark:border-slate-800 text-center space-y-4">
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em]">Managed by {{ $reseller->name }}
            </p>
            <p class="text-xs text-slate-500 dark:text-slate-500 font-bold uppercase tracking-widest">Powered by
                {{ config('app.name') }} Integration Engine</p>
        </div>
    </div>
</body>

</html>