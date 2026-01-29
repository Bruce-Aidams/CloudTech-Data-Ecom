<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo e(config('app.name', 'CloudTech Admin')); ?> - <?php echo $__env->yieldContent('title', 'Admin'); ?></title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Geist:wght@100..900&display=swap" rel="stylesheet">

    <!-- Styles -->
    <!-- Styles & Scripts -->
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Scripts -->
    <script>
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>

<body
    class="antialiased bg-slate-50 dark:bg-slate-950 text-slate-900 dark:text-slate-100 transition-colors duration-300 min-h-screen"
    x-data="{ 
          sidebarOpen: false,
          isCollapsed: localStorage.getItem('admin_compact_sidebar') === 'true'
      }" x-init="
          $watch('isCollapsed', val => localStorage.setItem('admin_compact_sidebar', val));
      ">

    <div class="min-h-screen bg-slate-50/50 dark:bg-slate-950/50 overflow-x-hidden">

        <?php if (isset($component)) { $__componentOriginal6fc2d165f80d597f34aa0f8014c366d2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal6fc2d165f80d597f34aa0f8014c366d2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin-sidebar','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin-sidebar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal6fc2d165f80d597f34aa0f8014c366d2)): ?>
<?php $attributes = $__attributesOriginal6fc2d165f80d597f34aa0f8014c366d2; ?>
<?php unset($__attributesOriginal6fc2d165f80d597f34aa0f8014c366d2); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal6fc2d165f80d597f34aa0f8014c366d2)): ?>
<?php $component = $__componentOriginal6fc2d165f80d597f34aa0f8014c366d2; ?>
<?php unset($__componentOriginal6fc2d165f80d597f34aa0f8014c366d2); ?>
<?php endif; ?>

        <div class="flex flex-col min-h-screen transition-all duration-300"
            :class="isCollapsed ? 'lg:pl-20' : 'lg:pl-64'">

            <?php if (isset($component)) { $__componentOriginal06600c18cadf0581659ec97dd74972b4 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal06600c18cadf0581659ec97dd74972b4 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin-navbar','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin-navbar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal06600c18cadf0581659ec97dd74972b4)): ?>
<?php $attributes = $__attributesOriginal06600c18cadf0581659ec97dd74972b4; ?>
<?php unset($__attributesOriginal06600c18cadf0581659ec97dd74972b4); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal06600c18cadf0581659ec97dd74972b4)): ?>
<?php $component = $__componentOriginal06600c18cadf0581659ec97dd74972b4; ?>
<?php unset($__componentOriginal06600c18cadf0581659ec97dd74972b4); ?>
<?php endif; ?>

            <main class="flex-1 p-4 md:p-8 lg:p-10 overflow-x-hidden animate-fade-in-up">
                <div class="max-w-7xl mx-auto">
                    <?php echo $__env->yieldContent('content'); ?>
                </div>
            </main>
            <?php if (isset($component)) { $__componentOriginalabfd08d099e5120d99fc78cfc4d6eb8e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalabfd08d099e5120d99fc78cfc4d6eb8e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.toaster','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('toaster'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalabfd08d099e5120d99fc78cfc4d6eb8e)): ?>
<?php $attributes = $__attributesOriginalabfd08d099e5120d99fc78cfc4d6eb8e; ?>
<?php unset($__attributesOriginalabfd08d099e5120d99fc78cfc4d6eb8e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalabfd08d099e5120d99fc78cfc4d6eb8e)): ?>
<?php $component = $__componentOriginalabfd08d099e5120d99fc78cfc4d6eb8e; ?>
<?php unset($__componentOriginalabfd08d099e5120d99fc78cfc4d6eb8e); ?>
<?php endif; ?>
        </div>

        <!-- Overlay for mobile -->
        <div x-show="sidebarOpen" x-cloak @click="sidebarOpen = false"
            class="fixed inset-0 bg-slate-900/40 z-40 lg:hidden backdrop-blur-sm transition-opacity"
            x-transition:enter="duration-300 ease-out" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="duration-200 ease-in"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        </div>
    </div>

    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>

</html><?php /**PATH C:\Users\Bruce\Desktop\Projects\Megaai2\Megaai\cloudtech\resources\views/layouts/admin.blade.php ENDPATH**/ ?>