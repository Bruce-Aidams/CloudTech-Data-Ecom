<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>403 - Access Forbidden | {{ config('app.name') }}</title>

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
        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-20px);
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

        .animate-float {
            animation: float 3s ease-in-out infinite;
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
            <div class="absolute inset-0 bg-rose-500/10 rounded-full blur-3xl animate-pulse"></div>
            <div
                class="relative w-32 h-32 mx-auto bg-gradient-to-br from-rose-500 to-red-600 rounded-[2rem] shadow-2xl shadow-rose-500/30 flex items-center justify-center animate-float">
                <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                    </path>
                </svg>
            </div>
        </div>

        <!-- Error Code -->
        <div class="space-y-4">
            <h1
                class="text-8xl md:text-9xl font-black tracking-tighter bg-gradient-to-r from-rose-600 to-red-600 bg-clip-text text-transparent">
                403</h1>
            <h2 class="text-3xl md:text-4xl font-black tracking-tight text-slate-800">Access Forbidden</h2>
            <p class="text-lg font-bold text-slate-500 max-w-md mx-auto">
                Sorry, you don't have permission to access this resource. This area is restricted.
            </p>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="{{ url()->previous() }}"
                class="px-8 py-3 bg-white border border-slate-100 text-slate-700 font-black rounded-2xl hover:bg-slate-50 transition-all duration-300 shadow-xl shadow-slate-200/50">
                <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Go Back
            </a>
            <a href="{{ url('/') }}"
                class="px-8 py-3 bg-gradient-to-r from-rose-600 to-red-600 text-white font-black rounded-2xl hover:scale-105 transition-all duration-300 shadow-xl shadow-rose-600/25">
                <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                    </path>
                </svg>
                Go Home
            </a>
        </div>

        <!-- Additional Help -->
        <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">
            If you believe this is an error, please contact support.
        </p>
    </div>
</body>

</html>