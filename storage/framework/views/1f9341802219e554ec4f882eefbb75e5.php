<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo e(config('app.name', 'CloudTech')); ?> - <?php echo $__env->yieldContent('title', 'Smart Data Bundles'); ?></title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Geist:wght@100..900&display=swap" rel="stylesheet">

    <!-- Styles & Scripts -->
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>

<body
    class="antialiased min-h-screen bg-background text-foreground selection:bg-primary/20 selection:text-primary transition-colors duration-300">

    <!-- Sonner Toasts -->
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
    



    <div class="flex flex-col min-h-screen">
        <?php if (! ($hideNav ?? false)): ?>
            <?php echo $__env->make('partials.navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php endif; ?>

        <main class="flex-1 flex flex-col animate-fade-in-up">
            <?php echo $__env->yieldContent('content'); ?>
        </main>

        <?php if (! ($hideNav ?? false)): ?>
            <?php echo $__env->make('partials.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php endif; ?>
    </div>

    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>

</html><?php /**PATH C:\Users\Bruce\Desktop\Projects\Megaai2\Megaai\cloudtech\resources\views/layouts/app.blade.php ENDPATH**/ ?>