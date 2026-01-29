

<?php $__env->startSection('title', 'Usage Reports'); ?>

<?php $__env->startSection('content'); ?>
    <div class="max-w-7xl mx-auto space-y-12 animate-in fade-in slide-in-from-bottom-4 duration-700 pb-20">
        
        <div>
            <h2 class="text-3xl font-black tracking-tight text-slate-900 dark:text-white uppercase">Activity Analytics</h2>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Detailed statistics of your orders and usage
                performance.</p>
        </div>

        
        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-4">
            <?php
                $statCards = [
                    [
                        'title' => 'Total Orders',
                        'value' => $stats['total'],
                        'color' => 'indigo',
                        'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />'
                    ],
                    [
                        'title' => 'Delivered',
                        'value' => $stats['delivered'],
                        'color' => 'emerald',
                        'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />'
                    ],
                    [
                        'title' => 'Validating',
                        'value' => $stats['validating'],
                        'color' => 'amber',
                        'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />'
                    ],
                    [
                        'title' => 'Failed',
                        'value' => $stats['failed'],
                        'color' => 'rose',
                        'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />'
                    ],
                ];
            ?>

            <?php $__currentLoopData = $statCards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $card): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div
                    class="group relative rounded-[2rem] bg-gradient-to-br from-<?php echo e($card['color']); ?>-600 to-<?php echo e($card['color']); ?>-700 p-8 shadow-sm transition-all hover:-translate-y-1 duration-500 overflow-hidden text-white">
                    <div
                        class="absolute -right-4 -bottom-4 w-24 h-24 bg-gradient-to-br from-<?php echo e($card['color']); ?>-500/10 to-transparent rounded-full blur-2xl group-hover:scale-150 transition-transform duration-700">
                    </div>

                    <div class="relative z-10 flex items-center justify-between mb-8">
                        <div
                            class="w-12 h-12 rounded-2xl bg-white/10 backdrop-blur-md text-white flex items-center justify-center shadow-lg">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24"><?php echo $card['icon']; ?></svg>
                        </div>
                    </div>

                    <div class="relative z-10">
                        <p class="text-[10px] font-black uppercase tracking-[0.2em] text-white/50 leading-none mb-2">
                            <?php echo e($card['title']); ?>

                        </p>
                        <h3 class="text-4xl font-black text-white tracking-tighter tabular-nums">
                            <?php echo e($card['value']); ?>

                        </h3>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <div class="grid gap-8 lg:grid-cols-7">
            
            <div
                class="lg:col-span-4 bg-white dark:bg-slate-900 rounded-[2.5rem] border border-slate-100 dark:border-slate-800 p-10 shadow-sm relative overflow-hidden group">
                <div
                    class="absolute top-0 right-0 w-64 h-64 bg-primary/5 rounded-full blur-3xl -mr-32 -mt-32 group-hover:bg-primary/10 transition-colors">
                </div>

                <div class="flex items-center justify-between mb-12 relative z-10">
                    <div>
                        <h3 class="text-[10px] font-black uppercase tracking-[.3em] text-slate-400 dark:text-slate-600">
                            Order Activity</h3>
                        <p class="text-sm font-bold text-slate-900 dark:text-white mt-1">30-Day Activity Breakdown</p>
                    </div>
                    <div
                        class="flex items-center gap-2 text-emerald-500 bg-emerald-50 dark:bg-emerald-900/20 px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-widest">
                        System Active
                    </div>
                </div>

                <div class="h-[350px] w-full relative z-10">
                    <canvas id="temporalChart"></canvas>
                </div>
            </div>

            
            <div
                class="lg:col-span-3 bg-white dark:bg-slate-900 rounded-[2.5rem] border border-slate-100 dark:border-slate-800 p-10 shadow-sm relative overflow-hidden group">
                <div
                    class="absolute bottom-0 left-0 w-64 h-64 bg-slate-50 dark:bg-slate-800/50 rounded-tr-full pointer-events-none transition-all group-hover:scale-110">
                </div>

                <div class="mb-12 relative z-10">
                    <h3 class="text-[10px] font-black uppercase tracking-[.3em] text-slate-400 dark:text-slate-600">
                        Status Overview</h3>
                    <p class="text-sm font-bold text-slate-900 dark:text-white mt-1">Overall Order Distribution</p>
                </div>

                <div class="space-y-12 relative z-10">
                    <div class="relative h-60 w-full flex items-center justify-center">
                        <canvas id="integrityChart"></canvas>
                        <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none">
                            <span
                                class="text-4xl font-black text-slate-900 dark:text-white tracking-tighter tabular-nums"><?php echo e($stats['total'] > 0 ? round(($stats['delivered'] / $stats['total']) * 100) : 0); ?>%</span>
                            <span class="text-[10px] uppercase font-black text-slate-400 tracking-[0.2em] mt-1">Success
                                Rate</span>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div
                            class="p-6 rounded-3xl bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-700">
                            <div class="flex items-center gap-2 mb-2">
                                <div class="w-1.5 h-1.5 rounded-full bg-emerald-500"></div>
                                <span
                                    class="text-[9px] font-black uppercase tracking-widest text-slate-400">Delivered</span>
                            </div>
                            <p class="text-2xl font-black text-slate-900 dark:text-white tracking-tighter tabular-nums">
                                <?php echo e($stats['delivered']); ?>

                            </p>
                        </div>
                        <div
                            class="p-6 rounded-3xl bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-700">
                            <div class="flex items-center gap-2 mb-2">
                                <div class="w-1.5 h-1.5 rounded-full bg-amber-500"></div>
                                <span
                                    class="text-[9px] font-black uppercase tracking-widest text-slate-400">Validating</span>
                            </div>
                            <p class="text-2xl font-black text-slate-900 dark:text-white tracking-tighter tabular-nums">
                                <?php echo e($stats['validating']); ?>

                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php $__env->startPush('scripts'); ?>
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                Chart.defaults.font.family = "'Geist', 'Inter', sans-serif";
                Chart.defaults.font.weight = '900';
                Chart.defaults.color = 'rgb(148 163 184)';

                const isDark = document.documentElement.classList.contains('dark');
                const gridColor = isDark ? 'rgba(255,255,255,0.03)' : 'rgba(0,0,0,0.03)';
                const tickColor = isDark ? 'rgb(100 116 139)' : 'rgb(148 163 184)';

                // Order Activity
                const temporalCtx = document.getElementById('temporalChart').getContext('2d');
                const gradient = temporalCtx.createLinearGradient(0, 0, 0, 400);
                gradient.addColorStop(0, 'rgba(99, 102, 241, 0.2)');
                gradient.addColorStop(1, 'rgba(99, 102, 241, 0)');

                new Chart(temporalCtx, {
                    type: 'line',
                    data: {
                        labels: <?php echo json_encode($stats['daily_orders']->keys()); ?>,
                        datasets: [{
                            data: <?php echo json_encode($stats['daily_orders']->values()); ?>,
                            borderColor: '#6366f1',
                            backgroundColor: gradient,
                            borderWidth: 4,
                            fill: true,
                            tension: 0.4,
                            pointRadius: 0,
                            pointHoverRadius: 6,
                            pointHoverBackgroundColor: '#6366f1',
                            pointHoverBorderColor: '#fff',
                            pointHoverBorderWidth: 3,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { legend: { display: false } },
                        scales: {
                            y: { grid: { color: gridColor }, ticks: { font: { size: 9 }, color: tickColor, padding: 10 } },
                            x: { grid: { display: false }, ticks: { font: { size: 9 }, color: tickColor, padding: 10 } }
                        }
                    }
                });

                // Status Overview
                const integrityCtx = document.getElementById('integrityChart').getContext('2d');
                new Chart(integrityCtx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Delivered', 'Validating', 'Failed'],
                        datasets: [{
                            data: [<?php echo e($stats['delivered']); ?>, <?php echo e($stats['validating']); ?>, <?php echo e($stats['failed']); ?>],
                            backgroundColor: ['#10b981', '#f59e0b', '#f43f5e'],
                            borderWidth: 0,
                            spacing: 12,
                            borderRadius: 12,
                            cutout: '85%'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { legend: { display: false } }
                    }
                });
            });
        </script>
    <?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Bruce\Desktop\Projects\Megaai2\Megaai\cloudtech\resources\views/dashboard/analytics.blade.php ENDPATH**/ ?>