<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>404 - Page Not Found | <?php echo e(config('app.name')); ?></title>

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
    <script>
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
    <style>
        @keyframes float {

            0%,
            100% {
                transform: translateY(0px) rotate(0deg);
            }

            50% {
                transform: translateY(-20px) rotate(5deg);
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
            animation: float 4s ease-in-out infinite;
        }

        .animate-fade-in-up {
            animation: fadeInUp 0.6s ease-out forwards;
        }
    </style>
</head>

<body
    class="antialiased bg-gray-50 text-slate-900 dark:bg-slate-900 dark:text-white min-h-screen flex items-center justify-center p-4 transition-colors duration-300">
    <div class="max-w-2xl w-full text-center space-y-8 animate-fade-in-up">
        <!-- Animated Icon -->
        <div class="relative inline-block">
            <div class="absolute inset-0 bg-indigo-500/10 rounded-full blur-3xl animate-pulse"></div>
            <div
                class="relative w-32 h-32 mx-auto bg-gradient-to-br from-indigo-600 to-purple-600 rounded-[2rem] shadow-2xl shadow-indigo-500/30 flex items-center justify-center animate-float">
                <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>

        <!-- Error Code -->
        <div class="space-y-4">
            <h1
                class="text-8xl md:text-9xl font-black tracking-tighter bg-gradient-to-r from-indigo-600 via-violet-600 to-purple-600 bg-clip-text text-transparent">
                404</h1>
            <h2 class="text-3xl md:text-4xl font-black tracking-tight text-slate-800 dark:text-white">Page Not Found</h2>
            <p class="text-lg font-bold text-slate-500 dark:text-slate-400 max-w-md mx-auto">
                Oops! The page you're looking for seems to have wandered off. Let's get you back on track.
            </p>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="<?php echo e(url()->previous()); ?>"
                class="px-8 py-3 bg-white dark:bg-slate-800 border border-slate-100 dark:border-slate-700 text-slate-700 dark:text-slate-200 font-black rounded-2xl hover:bg-slate-50 dark:hover:bg-slate-700 transition-all duration-300 shadow-xl shadow-slate-200/50 dark:shadow-none">
                <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Go Back
            </a>
            <a href="<?php echo e(url('/')); ?>"
                class="px-8 py-3 bg-gradient-to-r from-indigo-600 via-violet-600 to-purple-600 text-white font-black rounded-2xl hover:scale-105 transition-all duration-300 shadow-xl shadow-indigo-600/25">
                <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                    </path>
                </svg>
                Go Home
            </a>
        </div>

        <!-- Search Suggestion -->
        <div class="pt-4">
            <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 dark:text-slate-500 mb-4">Try searching for
                what you
                need:</p>
            <form action="<?php echo e(url('/search')); ?>" method="GET" class="max-w-md mx-auto">
                <div class="relative">
                    <input type="text" name="q" placeholder="Search..."
                        class="w-full h-12 px-6 bg-white dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-2xl focus:outline-none focus:border-indigo-500 text-slate-700 dark:text-slate-200 font-bold placeholder-slate-300 dark:placeholder-slate-600 shadow-lg shadow-slate-200/20 dark:shadow-none">
                    <button type="submit"
                        class="absolute right-2 top-1/2 -translate-y-1/2 p-2 bg-indigo-600 text-white rounded-xl hover:bg-indigo-700 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>

</html><?php /**PATH C:\Users\Bruce\Desktop\Projects\Megaai2\Megaai\cloudtech\resources\views/errors/404.blade.php ENDPATH**/ ?>