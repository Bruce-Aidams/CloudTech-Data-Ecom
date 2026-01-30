<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>Store Offline | <?php echo e(config('app.name')); ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: '#696cff',
                        'primary-focus': '#5f61e6',
                    }
                }
            }
        }
    </script>
    <style>
        [x-cloak] {
            display: none !important;
        }

        body {
            font-family: 'Public Sans', sans-serif;
        }
    </style>
</head>

<body class="bg-[#f5f5f9] dark:bg-slate-950 min-h-screen flex items-center justify-center p-6">
    <div class="max-w-md w-full text-center space-y-8 animate-in fade-in zoom-in duration-700">
        <!-- Icon -->
        <div class="relative inline-flex items-center justify-center">
            <div class="absolute inset-0 bg-primary/20 blur-3xl rounded-full"></div>
            <div
                class="relative w-24 h-24 bg-white dark:bg-slate-900 rounded-[2rem] shadow-xl flex items-center justify-center border border-slate-100 dark:border-slate-800">
                <svg class="w-12 h-12 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                </svg>
            </div>
            <!-- Lock Badge -->
            <div
                class="absolute -bottom-2 -right-2 w-8 h-8 bg-amber-500 text-white rounded-lg shadow-lg flex items-center justify-center">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                        clip-rule="evenodd" />
                </svg>
            </div>
        </div>

        <div class="space-y-3">
            <h1 class="text-4xl font-black text-slate-900 dark:text-white uppercase tracking-tight leading-tight">
                Store is <span class="text-primary italic">Offline</span>
            </h1>
            <p class="text-slate-500 dark:text-slate-400 font-medium">
                The storefront for <span
                    class="font-bold text-slate-700 dark:text-slate-200"><?php echo e($reseller->name); ?></span> is currently
                inactive or under maintenance.
            </p>
        </div>

        <div
            class="p-6 bg-white/50 dark:bg-slate-900/50 backdrop-blur-md rounded-[2rem] border border-white dark:border-slate-800 shadow-sm">
            <p class="text-xs font-black uppercase tracking-[0.2em] text-slate-400 mb-2">Notice</p>
            <p class="text-sm text-slate-600 dark:text-slate-300 font-medium">
                Please contact the reseller directly or try again later. If you are the owner, you can enable your store
                from the <a href="<?php echo e(route('login')); ?>" class="text-primary hover:underline font-bold">Reseller Hub</a>.
            </p>
        </div>

        <div class="pt-4">
            <a href="/"
                class="inline-flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-slate-400 hover:text-primary transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Return to Homepage
            </a>
        </div>

        <div class="pt-12 border-t border-slate-200/50 dark:border-slate-800/50">
            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest leading-loose">
                Powered by <?php echo e(config('app.name')); ?> Integration Engine<br>
                Professional Wholesale Data Distribution
            </p>
        </div>
    </div>
</body>

</html><?php /**PATH C:\Users\Bruce\Desktop\Projects\Megaai2\Megaai\cloudtech\resources\views/reseller/store/disabled.blade.php ENDPATH**/ ?>