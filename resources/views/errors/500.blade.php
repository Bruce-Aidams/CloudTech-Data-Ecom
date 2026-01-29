<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>500 - Server Error | {{ config('app.name') }}</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/geist@1.3.0/dist/core.css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Geist', 'Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        @keyframes glitch {

            0%,
            100% {
                transform: translate(0);
            }

            20% {
                transform: translate(-2px, 2px);
            }

            40% {
                transform: translate(-2px, -2px);
            }

            60% {
                transform: translate(2px, 2px);
            }

            80% {
                transform: translate(2px, -2px);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-glitch {
            animation: glitch 0.3s ease-in-out infinite;
        }

        .animate-fade-in-up {
            animation: fadeInUp 0.6s ease-out forwards;
        }
    </style>
</head>

<body class="antialiased bg-[#f8f9ff] text-slate-900 min-h-screen flex items-center justify-center p-4">
    <div class="max-w-2xl w-full text-center space-y-8 animate-fade-in-up">
        <!-- Animated Icon -->
        <div class="relative inline-block">
            <div class="absolute inset-0 bg-red-500/10 rounded-full blur-3xl animate-pulse"></div>
            <div
                class="relative w-32 h-32 mx-auto bg-gradient-to-br from-red-600 to-rose-700 rounded-[2rem] shadow-2xl shadow-red-500/30 flex items-center justify-center">
                <svg class="w-16 h-16 text-white animate-glitch" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                    </path>
                </svg>
            </div>
        </div>

        <!-- Error Code -->
        <div class="space-y-4">
            <h1
                class="text-8xl md:text-9xl font-black tracking-tighter bg-gradient-to-r from-red-600 to-rose-600 bg-clip-text text-transparent">
                500</h1>
            <h2 class="text-3xl md:text-4xl font-black tracking-tight text-slate-800">Internal Server Error</h2>
            <p class="text-lg font-bold text-slate-500 max-w-md mx-auto">
                Oops! Something went wrong on our end. Our team has been notified and we're working on fixing it.
            </p>
        </div>

        <!-- Error Details (only in debug mode) -->
        @if(config('app.debug') && isset($exception))
            <div class="bg-white border border-slate-100 rounded-[2rem] p-6 text-left shadow-xl shadow-slate-200/40">
                <h3 class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Debug Information:</h3>
                <pre class="text-xs font-mono text-slate-600 overflow-x-auto">{{ $exception->getMessage() }}</pre>
            </div>
        @endif

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <button onclick="window.location.reload()"
                class="px-8 py-3 bg-gradient-to-r from-red-600 to-rose-600 text-white font-black rounded-2xl hover:scale-105 transition-all duration-300 shadow-xl shadow-red-600/25">
                <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                    </path>
                </svg>
                Retry Request
            </button>
            <a href="{{ url('/') }}"
                class="px-8 py-3 bg-white border border-slate-100 text-slate-700 font-black rounded-2xl hover:bg-slate-50 transition-all duration-300 shadow-xl shadow-slate-200/50">
                <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                    </path>
                </svg>
                Back Home
            </a>
        </div>

        <!-- Additional Help -->
        <div
            class="flex items-center justify-center gap-2 text-[10px] font-black uppercase tracking-widest text-slate-400">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            Contact support if the issue persists.
        </div>
    </div>
</body>

</html>