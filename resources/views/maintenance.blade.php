@extends('layouts.guest')

@section('title', 'Under Maintenance')

@section('content')
    <div class="relative w-full min-h-screen flex items-center justify-center overflow-hidden p-4" x-data="{ show: false }"
        x-init="setTimeout(() => show = true, 100)">

        {{-- Animated Background Blobs --}}
        <div
            class="absolute top-[-10%] right-[-10%] w-[50%] h-[50%] bg-primary/10 rounded-full blur-[120px] animate-pulse pointer-events-none">
        </div>
        <div class="absolute bottom-[-10%] left-[-10%] w-[50%] h-[50%] bg-sky-500/10 rounded-full blur-[120px] animate-pulse pointer-events-none"
            style="animation-delay: 1s;"></div>

        <div class="max-w-2xl w-full text-center space-y-8 relative z-10 transition-all duration-700 transform"
            :class="show ? 'opacity-100 scale-100' : 'opacity-0 scale-90'">

            <div class="flex justify-center">
                <div class="relative">
                    {{-- Main Icon Card --}}
                    <div
                        class="bg-white dark:bg-slate-900 p-8 rounded-[2.5rem] shadow-2xl ring-1 ring-slate-200 dark:ring-slate-800 animate-float">
                        <svg class="w-20 h-20 text-primary animate-wiggle" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z" />
                        </svg>
                    </div>

                    {{-- Floating Badge --}}
                    <div
                        class="absolute -top-4 -right-4 bg-amber-500 text-white p-3 rounded-2xl shadow-lg ring-4 ring-white dark:ring-slate-950 animate-bounce-slow">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="space-y-4">
                <h1 class="text-4xl md:text-6xl font-black tracking-tighter text-slate-900 dark:text-white">
                    Under Maintenance
                </h1>
                <p class="text-xl text-slate-500 dark:text-slate-400 font-medium max-w-lg mx-auto leading-relaxed">
                    We're currently performing some scheduled upgrades to improve your experience. We'll be back online
                    shortly.
                </p>
            </div>

            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <div
                    class="flex items-center gap-2 px-6 py-3 bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm">
                    <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                    <span class="text-sm font-black uppercase tracking-widest text-slate-700 dark:text-slate-300">Safe &
                        Secure</span>
                </div>
            </div>

            <div class="pt-8">
                <a href="{{ route('login') }}"
                    class="inline-flex items-center justify-center h-12 px-8 rounded-2xl font-black uppercase tracking-widest text-xs border border-slate-200 dark:border-slate-800 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors text-slate-900 dark:text-white">
                    Admin Login
                </a>
            </div>

            <p class="text-[10px] font-black uppercase tracking-[0.3em] text-slate-400 pt-12">
                &copy; {{ date('Y') }} {{ config('app.name') }} &bull; Better Every Day
            </p>
        </div>
    </div>

    <style>
        @keyframes float {

            0%,
            100% {
                transform: translateY(0px) rotate(0deg);
            }

            25% {
                transform: translateY(-5px) rotate(2deg);
            }

            75% {
                transform: translateY(5px) rotate(-2deg);
            }
        }

        @keyframes wiggle {

            0%,
            100% {
                transform: rotate(0deg);
            }

            25% {
                transform: rotate(10deg);
            }

            75% {
                transform: rotate(-10deg);
            }
        }

        .animate-float {
            animation: float 6s ease-in-out infinite;
        }

        .animate-wiggle {
            animation: wiggle 2s ease-in-out infinite;
        }

        .animate-bounce-slow {
            animation: bounce 3s infinite;
        }
    </style>
@endsection