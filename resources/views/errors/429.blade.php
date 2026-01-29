<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>429 - Too Many Requests | {{ config('app.name') }}</title>

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
        @keyframes pulse-scale {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
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

        .animate-pulse-scale {
            animation: pulse-scale 2s ease-in-out infinite;
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
            <div class="absolute inset-0 bg-orange-500/10 rounded-full blur-3xl animate-pulse"></div>
            <div
                class="relative w-32 h-32 mx-auto bg-gradient-to-br from-orange-500 to-red-600 rounded-[2rem] shadow-2xl shadow-orange-500/30 flex items-center justify-center animate-pulse-scale">
                <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                </svg>
            </div>
        </div>

        <!-- Error Code -->
        <div class="space-y-4">
            <h1
                class="text-8xl md:text-9xl font-black tracking-tighter bg-gradient-to-r from-orange-600 to-red-600 bg-clip-text text-transparent">
                429</h1>
            <h2 class="text-3xl md:text-4xl font-black tracking-tight text-slate-800">Slow Down!</h2>
            <p class="text-lg font-bold text-slate-500 max-w-md mx-auto">
                Whoa there! You're making too many requests. Please take a breath and try again in a moment.
            </p>
        </div>

        <!-- Countdown Timer -->
        <div class="bg-white border border-slate-100 rounded-[2rem] p-6 shadow-xl shadow-slate-200/40">
            <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Please wait...</p>
            <div id="countdown" class="text-5xl font-black text-orange-600 ">60</div>
            <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mt-2">seconds before you can try
                again</p>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <button onclick="window.location.reload()"
                class="px-8 py-3 bg-gradient-to-r from-orange-600 to-red-600 text-white font-black rounded-2xl hover:scale-105 transition-all duration-300 shadow-xl shadow-orange-600/25">
                <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                    </path>
                </svg>
                Try Again Now
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
    </div>

    <script>
        // Countdown timer
        let seconds = 60;
        const countdown = document.getElementById('countdown');
        const timer = setInterval(() => {
            seconds--;
            countdown.textContent = seconds;
            if (seconds <= 0) {
                clearInterval(timer);
                countdown.textContent = 'Ready!';
            }
        }, 1000);
    </script>
</body>

</html>