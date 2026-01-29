<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Security Verification - {{ config('app.name') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Geist:wght@100..900&family=JetBrains+Mono:wght@400;700&display=swap"
        rel="stylesheet">

    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script>
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    <style>
        body {
            font-family: 'Geist', sans-serif;
        }

        .font-mono {
            font-family: 'JetBrains Mono', monospace;
        }

        @keyframes scan {

            0%,
            100% {
                transform: translateY(-100%);
                opacity: 0;
            }

            50% {
                transform: translateY(100%);
                opacity: 1;
            }
        }
    </style>
</head>

<body
    class="bg-slate-50 dark:bg-slate-950 text-slate-900 dark:text-white overflow-hidden antialiased selection:bg-blue-500/30">

    <div class="fixed inset-0 z-50 flex flex-col items-center justify-center p-6 transition-colors duration-300" x-data="{ 
            progress: 0, 
            status: 'INITIALIZING',
            logs: [],
            completed: false,
            
            async init() {
                // Cryptographic sequence simulation (2.5s total)
                const sequence = [
                    { p: 15, msg: 'ESTABLISHING SECURE HANDSHAKE...', t: 400 },
                    { p: 30, msg: 'VERIFYING BIOMETRIC SIGNATURE...', t: 800 },
                    { p: 55, msg: 'DECRYPTING ADMIN PRIVILEGES', t: 1200 },
                    { p: 70, msg: 'SYNCING LEDGER NODES...', t: 1600 },
                    { p: 85, msg: 'AUDITING SESSION INTEGRITY...', t: 2000 },
                    { p: 100, msg: 'ACCESS GRANTED', t: 2200 }
                ];

                for (const step of sequence) {
                    setTimeout(() => {
                        this.progress = step.p;
                        this.status = step.msg;
                        this.logs.unshift(step.msg);
                        if (step.p === 100) this.completed = true;
                    }, step.t);
                }

                setTimeout(() => {
                    window.location.href = '{{ $redirect_to }}';
                }, 2500);
            }
         }">

        <!-- Background Grid Effect -->
        <div class="absolute inset-0 bg-[linear-gradient(to_right,#80808012_1px,transparent_1px),linear-gradient(to_bottom,#80808012_1px,transparent_1px)] bg-[size:24px_24px]"></div>
        <div class="absolute inset-0 bg-[radial-gradient(circle_800px_at_50%_50%,#3b82f61a,transparent)]"></div>

        <!-- Central Shield Scanner -->
        <div class="relative w-48 h-48 mb-12 flex items-center justify-center">
            <!-- Pulsing Rings -->
            <div class="absolute inset-0 rounded-full border-2 border-blue-500/10 animate-[ping_2s_cubic-bezier(0,0,0.2,1)_infinite]"></div>
            <div class="absolute inset-4 rounded-full border border-blue-500/20 animate-[ping_3s_cubic-bezier(0,0,0.2,1)_infinite_0.5s]"></div>
            
            <!-- Hexagon/Shield Container -->
            <div class="relative z-10 w-24 h-24 flex items-center justify-center transition-all duration-500" :class="completed ? 'scale-110' : 'scale-100'">
                <!-- Shield Icon -->
                <svg class="w-20 h-20 transition-colors duration-300" :class="completed ? 'text-emerald-500 drop-shadow-[0_0_15px_rgba(16,185,129,0.5)]' : 'text-slate-300 dark:text-slate-600'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                </svg>
                
                <!-- Scanning Overlay (Hidden when complete) -->
                <div class="absolute inset-0 overflow-hidden" x-show="!completed" x-transition.opacity>
                    <div class="w-full h-1 bg-blue-500/50 shadow-[0_0_10px_rgba(59,130,246,0.8)] animate-[scan_1.5s_ease-in-out_infinite]"></div>
                </div>
            </div>
        </div>

        <!-- Status Details -->
        <div class="w-full max-w-md space-y-8 relative z-10">
            <div class="text-center space-y-3">
                <h2 class="text-2xl font-bold text-slate-900 dark:text-white tracking-tight" x-text="completed ? 'Verified' : 'Security Check'"></h2>
                <div class="flex items-center justify-center gap-2 h-6">
                    <span x-show="!completed" class="relative flex h-2 w-2">
                      <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                      <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-500"></span>
                    </span>
                    <p class="text-[10px] font-mono font-bold text-slate-500 dark:text-slate-400 tracking-[0.2em] uppercase" x-text="status"></p>
                </div>
            </div>

            <!-- Progress Bar -->
            <div class="relative h-1 w-full bg-slate-200 dark:bg-slate-800 rounded-full overflow-hidden shadow-inner">
                <div class="absolute inset-y-0 left-0 transition-all duration-300 ease-out shadow-[0_0_20px_rgba(59,130,246,0.6)]"
                     :class="completed ? 'bg-emerald-500 shadow-[0_0_20px_rgba(16,185,129,0.6)]' : 'bg-blue-600'"
                     :style="{ width: progress + '%' }"></div>
            </div>

            <!-- Terminal Output -->
            <div class="h-32 w-full bg-gray-50/50 dark:bg-black/20 backdrop-blur-sm rounded-xl border border-slate-200 dark:border-white/5 p-4 overflow-hidden font-mono text-[10px] space-y-1.5 shadow-sm">
                <template x-for="(log, index) in logs" :key="index">
                    <div class="flex gap-2 transition-all duration-300" :class="index === 0 ? 'text-blue-600 dark:text-blue-400 opacity-100 font-bold' : 'text-slate-400 dark:text-slate-600 opacity-60'">
                        <span>></span>
                        <span x-text="log"></span>
                    </div>
                </template>
            </div>
        </div>
    </div>
</body>

</html>