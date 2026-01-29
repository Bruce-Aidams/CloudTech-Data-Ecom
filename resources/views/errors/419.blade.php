<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>419 - Page Expired | {{ config('app.name') }}</title>

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
        @keyframes rotate {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
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

        .animate-rotate-slow {
            animation: rotate 8s linear infinite;
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
            <div class="absolute inset-0 bg-amber-500/10 rounded-full blur-3xl animate-pulse"></div>
            <div
                class="relative w-32 h-32 mx-auto bg-gradient-to-br from-amber-500 via-orange-500 to-amber-600 rounded-[2rem] shadow-2xl shadow-amber-500/30 flex items-center justify-center">
                <svg class="w-16 h-16 text-white animate-rotate-slow" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>

        <!-- Error Code -->
        <div class="space-y-4">
            <h1
                class="text-8xl md:text-9xl font-black tracking-tighter bg-gradient-to-r from-amber-600 to-orange-600 bg-clip-text text-transparent">
                419</h1>
            <h2 class="text-3xl md:text-4xl font-black tracking-tight text-slate-800">Page Expired</h2>
            <p class="text-lg font-bold text-slate-500 max-w-md mx-auto">
                Your session has timed out. Let's refresh your connection and get you back in.
            </p>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <button onclick="window.location.reload()"
                class="px-8 py-3 bg-gradient-to-r from-amber-600 via-orange-500 to-amber-600 text-white font-black rounded-2xl hover:scale-105 transition-all duration-300 shadow-xl shadow-amber-600/25">
                <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                    </path>
                </svg>
                Refresh Session
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
        <div class="bg-white border border-slate-100 rounded-[2rem] p-6 text-left shadow-xl shadow-slate-200/40">
            <h3 class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Why did this happen?</h3>
            <ul class="text-xs font-bold text-slate-600 space-y-1">
                <li>• You were inactive for too long</li>
                <li>• Your form submission took longer than expected</li>
                <li>• Your security token expired</li>
            </ul>
        </div>
    </div>
</body>

</html>