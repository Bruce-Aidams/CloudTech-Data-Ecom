<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>503 - Service Unavailable | {{ config('app.name') }}</title>

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
        @keyframes wrench {

            0%,
            100% {
                transform: rotate(-10deg);
            }

            50% {
                transform: rotate(10deg);
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

        .animate-wrench {
            animation: wrench 1s ease-in-out infinite;
        }

        .animate-fade-in-up {
            animation: fadeInUp 0.6s ease-out forwards;
        }
    </style>
</head>

<body
    class="antialiased bg-[#f8f9ff] dark:bg-slate-900 text-slate-900 dark:text-white min-h-screen flex items-center justify-center p-4 transition-colors duration-300">
    <div class="max-w-2xl w-full text-center space-y-8 animate-fade-in-up">
        <!-- Animated Icon -->
        <div class="relative inline-block">
            <div class="absolute inset-0 bg-blue-500/10 rounded-full blur-3xl animate-pulse"></div>
            <div
                class="relative w-32 h-32 mx-auto bg-gradient-to-br from-blue-600 via-cyan-500 to-blue-600 rounded-[2rem] shadow-2xl shadow-blue-500/30 flex items-center justify-center">
                <svg class="w-16 h-16 text-white animate-wrench" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                    </path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
            </div>
        </div>

        <!-- Error Code -->
        <div class="space-y-4">
            <h1
                class="text-8xl md:text-9xl font-black tracking-tighter bg-gradient-to-r from-blue-600 to-cyan-600 bg-clip-text text-transparent">
                503</h1>
            <h2 class="text-3xl md:text-4xl font-black tracking-tight text-slate-800 dark:text-white">We'll Be Right
                Back</h2>
            <p class="text-lg font-bold text-slate-500 dark:text-slate-400 max-w-md mx-auto">
                We're currently performing scheduled maintenance to make things even better. We'll be back online
                shortly!
            </p>
        </div>

        <!-- Maintenance Info -->
        <div class="bg-white border border-slate-100 rounded-[2rem] p-6 shadow-xl shadow-slate-200/40">
            <div class="flex items-center justify-center gap-3 mb-3">
                <div class="flex gap-1">
                    <div class="w-2.5 h-2.5 bg-blue-600 rounded-full animate-bounce" style="animation-delay: 0s;"></div>
                    <div class="w-2.5 h-2.5 bg-blue-600 rounded-full animate-bounce" style="animation-delay: 0.2s;">
                    </div>
                    <div class="w-2.5 h-2.5 bg-blue-600 rounded-full animate-bounce" style="animation-delay: 0.4s;">
                    </div>
                </div>
            </div>
            <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">Maintenance in Progress</p>
            <p class="text-xs font-bold text-slate-600 mt-2">
                @if(isset($message))
                    {{ $message }}
                @else
                    Our team is working hard to improve your experience. Thank you for your patience!
                @endif
            </p>
        </div>

        <!-- Action Button -->
        <div class="flex justify-center">
            <button onclick="window.location.reload()"
                class="px-8 py-3 bg-gradient-to-r from-blue-600 via-cyan-500 to-blue-600 text-white font-black rounded-2xl hover:scale-105 transition-all duration-300 shadow-xl shadow-blue-600/25">
                <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                    </path>
                </svg>
                Refresh Status
            </button>
        </div>

        <!-- Social Links -->
        <div class="pt-4 space-y-4">
            <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">Stay updated on our status:</p>
            <div class="flex items-center justify-center gap-6">
                <a href="#" class="text-slate-400 hover:text-blue-600 transition-all hover:scale-110">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.84 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z" />
                    </svg>
                </a>
                <a href="#" class="text-slate-400 hover:text-blue-600 transition-all hover:scale-110">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                    </svg>
                </a>
            </div>
        </div>
    </div>
</body>

</html>