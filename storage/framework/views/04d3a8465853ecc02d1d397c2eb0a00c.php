

<?php $__env->startSection('content'); ?>
    <div class="flex flex-col min-h-screen bg-background dark:bg-slate-950 transition-colors duration-500">
        <main class="flex-1 pt-16">
            <!-- Hero Section -->
            <section class="relative overflow-hidden py-16 md:py-24 lg:py-40">
                <!-- Abstract Background Elements -->
                <div
                    class="absolute top-0 right-0 w-[400px] md:w-[800px] h-[400px] md:h-[800px] bg-primary/5 rounded-full blur-[80px] md:blur-[120px] -z-10 animate-pulse">
                </div>
                <div
                    class="absolute bottom-0 left-0 w-[300px] md:w-[500px] h-[300px] md:h-[500px] bg-indigo-500/5 rounded-full blur-[60px] md:blur-[100px] -z-10">
                </div>

                <div class="container mx-auto px-4 md:px-6">
                    <div class="flex flex-col items-center text-center space-y-6 md:space-y-10 max-w-4xl mx-auto"
                        x-data="{ show: false }" x-init="setTimeout(() => show = true, 100)">

                        <div x-show="show" x-transition:enter="transition ease-out duration-700"
                            x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
                            class="inline-flex items-center gap-2 px-3 py-1.5 md:px-4 md:py-2 rounded-full bg-primary/10 border border-primary/20 text-primary text-[10px] md:text-xs font-black uppercase tracking-widest">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                            Instant Delivery
                        </div>

                        <div class="space-y-4 md:space-y-6">
                            <h1 x-show="show" x-transition:enter="transition ease-out duration-700 delay-200"
                                x-transition:enter-start="opacity-0 translate-y-8"
                                x-transition:enter-end="opacity-100 translate-y-0"
                                class="text-3xl sm:text-4xl md:text-7xl font-black tracking-tight leading-[1.1] text-foreground">
                                The smartest way to <br />
                                <span
                                    class="bg-clip-text text-transparent bg-gradient-to-r from-primary via-indigo-500 to-purple-600 italic">refill
                                    your data.</span>
                            </h1>
                            <p x-show="show" x-transition:enter="transition ease-out duration-700 delay-400"
                                x-transition:enter-start="opacity-0 translate-y-8"
                                x-transition:enter-end="opacity-100 translate-y-0"
                                class="text-sm md:text-xl text-muted-foreground max-w-2xl mx-auto leading-relaxed font-medium">
                                Experience ultra-cheap, automated data bundles for all networks. Secure,
                                reliable, and processed in milliseconds.
                            </p>
                        </div>

                        <div x-show="show" x-transition:enter="transition ease-out duration-700 delay-600"
                            x-transition:enter-start="opacity-0 translate-y-8"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            class="flex flex-col sm:flex-row items-center gap-3 md:gap-4 w-full sm:w-auto">
                            <a href="<?php echo e(url('/register')); ?>"
                                class="h-12 md:h-14 px-8 md:px-10 rounded-xl md:rounded-2xl bg-primary text-white text-base md:text-lg font-bold shadow-2xl shadow-primary/30 w-full sm:w-auto flex items-center justify-center group hover:scale-105 transition-all">
                                Get Started
                                <svg class="w-4 h-4 md:w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                        d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                </svg>
                            </a>
                        </div>

                        <!-- Network logos showcase -->
                        <div x-show="show" x-transition:enter="transition ease-out duration-700 delay-800"
                            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                            class="pt-4 md:pt-8 w-full">
                            <p
                                class="text-[9px] md:text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-6 md:mb-8">
                                Trusted
                                networks</p>
                            <div class="flex flex-wrap justify-center items-center gap-6 md:gap-20">
                                <div
                                    class="flex flex-col items-center gap-2 group/net transition-all duration-500 hover:scale-110">
                                    <div
                                        class="w-12 h-12 md:w-14 md:h-14 rounded-xl md:rounded-2xl bg-yellow-400 flex items-center justify-center shadow-lg shadow-yellow-400/20 group-hover/net:rotate-12 transition-transform">
                                        <span class="font-black text-black text-xs md:text-base">MTN</span>
                                    </div>
                                </div>

                                <div
                                    class="flex flex-col items-center gap-2 group/net transition-all duration-500 hover:scale-110">
                                    <div
                                        class="w-12 h-12 md:w-14 md:h-14 rounded-xl md:rounded-2xl bg-red-600 flex items-center justify-center shadow-lg shadow-red-600/20 group-hover/net:-rotate-12 transition-transform">
                                        <span class="font-black text-white text-[10px] md:text-xs">Telecel</span>
                                    </div>
                                </div>

                                <div
                                    class="flex flex-col items-center gap-2 group/net transition-all duration-500 hover:scale-110">
                                    <div
                                        class="w-12 h-12 md:w-14 md:h-14 rounded-xl md:rounded-2xl bg-gradient-to-br from-indigo-500 to-blue-600 flex items-center justify-center shadow-lg shadow-blue-500/20 group-hover/net:rotate-12 transition-transform">
                                        <span class="font-black text-white text-[8px] md:text-[10px]">AirtelTigo</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>


            <!-- Features Grid -->
            <section id="features" class="py-24 bg-slate-50/50 dark:bg-slate-900/50">
                <div class="container mx-auto px-4 md:px-6">
                    <div class="text-center max-w-2xl mx-auto mb-16 space-y-4">
                        <h2 class="text-3xl md:text-5xl font-black tracking-tight text-foreground">Built for
                            Performance.</h2>
                        <p class="text-muted-foreground">Our platform is engineered with the latest
                            technologies to ensure your deals are handled with peak efficiency.</p>
                    </div>

                    <div class="grid grid-cols-2 gap-3 sm:gap-6 lg:grid-cols-3">
                        <?php if (isset($component)) { $__componentOriginal8a1da09f823c4dc4ebcb3f0fdc9afbe8 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8a1da09f823c4dc4ebcb3f0fdc9afbe8 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.feature-card','data' => ['title' => 'Automatic Fulfillment','description' => 'No waiting games. Our internal API engine processes your data requests the moment payment is confirmed.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('feature-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Automatic Fulfillment','description' => 'No waiting games. Our internal API engine processes your data requests the moment payment is confirmed.']); ?>
                             <?php $__env->slot('icon', null, []); ?> 
                                <svg class="w-6 h-6 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                             <?php $__env->endSlot(); ?>
                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8a1da09f823c4dc4ebcb3f0fdc9afbe8)): ?>
<?php $attributes = $__attributesOriginal8a1da09f823c4dc4ebcb3f0fdc9afbe8; ?>
<?php unset($__attributesOriginal8a1da09f823c4dc4ebcb3f0fdc9afbe8); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8a1da09f823c4dc4ebcb3f0fdc9afbe8)): ?>
<?php $component = $__componentOriginal8a1da09f823c4dc4ebcb3f0fdc9afbe8; ?>
<?php unset($__componentOriginal8a1da09f823c4dc4ebcb3f0fdc9afbe8); ?>
<?php endif; ?>

                        <?php if (isset($component)) { $__componentOriginal8a1da09f823c4dc4ebcb3f0fdc9afbe8 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8a1da09f823c4dc4ebcb3f0fdc9afbe8 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.feature-card','data' => ['title' => 'Vault Security','description' => 'Industry-standard encryption and secure Paystack integration mean your funds and data are always protected.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('feature-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Vault Security','description' => 'Industry-standard encryption and secure Paystack integration mean your funds and data are always protected.']); ?>
                             <?php $__env->slot('icon', null, []); ?> 
                                <svg class="w-6 h-6 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.040L3 14.535a45.241 45.241 0 0012 8.192 45.241 45.241 0 0012-8.192l-.382-8.509z" />
                                </svg>
                             <?php $__env->endSlot(); ?>
                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8a1da09f823c4dc4ebcb3f0fdc9afbe8)): ?>
<?php $attributes = $__attributesOriginal8a1da09f823c4dc4ebcb3f0fdc9afbe8; ?>
<?php unset($__attributesOriginal8a1da09f823c4dc4ebcb3f0fdc9afbe8); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8a1da09f823c4dc4ebcb3f0fdc9afbe8)): ?>
<?php $component = $__componentOriginal8a1da09f823c4dc4ebcb3f0fdc9afbe8; ?>
<?php unset($__componentOriginal8a1da09f823c4dc4ebcb3f0fdc9afbe8); ?>
<?php endif; ?>

                        <?php if (isset($component)) { $__componentOriginal8a1da09f823c4dc4ebcb3f0fdc9afbe8 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8a1da09f823c4dc4ebcb3f0fdc9afbe8 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.feature-card','data' => ['title' => 'Smart Analytics','description' => 'Track your spending and data usage with real-time charts and detailed history reports.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('feature-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Smart Analytics','description' => 'Track your spending and data usage with real-time charts and detailed history reports.']); ?>
                             <?php $__env->slot('icon', null, []); ?> 
                                <svg class="w-6 h-6 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                </svg>
                             <?php $__env->endSlot(); ?>
                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8a1da09f823c4dc4ebcb3f0fdc9afbe8)): ?>
<?php $attributes = $__attributesOriginal8a1da09f823c4dc4ebcb3f0fdc9afbe8; ?>
<?php unset($__attributesOriginal8a1da09f823c4dc4ebcb3f0fdc9afbe8); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8a1da09f823c4dc4ebcb3f0fdc9afbe8)): ?>
<?php $component = $__componentOriginal8a1da09f823c4dc4ebcb3f0fdc9afbe8; ?>
<?php unset($__componentOriginal8a1da09f823c4dc4ebcb3f0fdc9afbe8); ?>
<?php endif; ?>

                        <?php if (isset($component)) { $__componentOriginal8a1da09f823c4dc4ebcb3f0fdc9afbe8 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8a1da09f823c4dc4ebcb3f0fdc9afbe8 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.feature-card','data' => ['title' => 'Ghana-First Native','description' => 'Full support for MTN, Telecel, and AT networks with localized prefixes and validation.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('feature-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Ghana-First Native','description' => 'Full support for MTN, Telecel, and AT networks with localized prefixes and validation.']); ?>
                             <?php $__env->slot('icon', null, []); ?> 
                                <svg class="w-6 h-6 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M10.5 1.5H8.25A2.25 2.25 0 006 3.75v16.5a2.25 2.25 0 002.25 2.25h7.5A2.25 2.25 0 0018 20.25V3.75a2.25 2.25 0 00-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3" />
                                </svg>
                             <?php $__env->endSlot(); ?>
                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8a1da09f823c4dc4ebcb3f0fdc9afbe8)): ?>
<?php $attributes = $__attributesOriginal8a1da09f823c4dc4ebcb3f0fdc9afbe8; ?>
<?php unset($__attributesOriginal8a1da09f823c4dc4ebcb3f0fdc9afbe8); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8a1da09f823c4dc4ebcb3f0fdc9afbe8)): ?>
<?php $component = $__componentOriginal8a1da09f823c4dc4ebcb3f0fdc9afbe8; ?>
<?php unset($__componentOriginal8a1da09f823c4dc4ebcb3f0fdc9afbe8); ?>
<?php endif; ?>

                        <?php if (isset($component)) { $__componentOriginal8a1da09f823c4dc4ebcb3f0fdc9afbe8 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8a1da09f823c4dc4ebcb3f0fdc9afbe8 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.feature-card','data' => ['title' => 'Agent Ecosystem','description' => 'Earn commissions by becoming an agent. Scale your business with our dedicated agent tools.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('feature-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Agent Ecosystem','description' => 'Earn commissions by becoming an agent. Scale your business with our dedicated agent tools.']); ?>
                             <?php $__env->slot('icon', null, []); ?> 
                                <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                             <?php $__env->endSlot(); ?>
                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8a1da09f823c4dc4ebcb3f0fdc9afbe8)): ?>
<?php $attributes = $__attributesOriginal8a1da09f823c4dc4ebcb3f0fdc9afbe8; ?>
<?php unset($__attributesOriginal8a1da09f823c4dc4ebcb3f0fdc9afbe8); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8a1da09f823c4dc4ebcb3f0fdc9afbe8)): ?>
<?php $component = $__componentOriginal8a1da09f823c4dc4ebcb3f0fdc9afbe8; ?>
<?php unset($__componentOriginal8a1da09f823c4dc4ebcb3f0fdc9afbe8); ?>
<?php endif; ?>

                        <?php if (isset($component)) { $__componentOriginal8a1da09f823c4dc4ebcb3f0fdc9afbe8 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8a1da09f823c4dc4ebcb3f0fdc9afbe8 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.feature-card','data' => ['title' => 'API Ready','description' => 'Integrate our services into your own apps with our robust, documented developer API.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('feature-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'API Ready','description' => 'Integrate our services into your own apps with our robust, documented developer API.']); ?>
                             <?php $__env->slot('icon', null, []); ?> 
                                <svg class="w-6 h-6 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                                </svg>
                             <?php $__env->endSlot(); ?>
                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8a1da09f823c4dc4ebcb3f0fdc9afbe8)): ?>
<?php $attributes = $__attributesOriginal8a1da09f823c4dc4ebcb3f0fdc9afbe8; ?>
<?php unset($__attributesOriginal8a1da09f823c4dc4ebcb3f0fdc9afbe8); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8a1da09f823c4dc4ebcb3f0fdc9afbe8)): ?>
<?php $component = $__componentOriginal8a1da09f823c4dc4ebcb3f0fdc9afbe8; ?>
<?php unset($__componentOriginal8a1da09f823c4dc4ebcb3f0fdc9afbe8); ?>
<?php endif; ?>
                    </div>
                </div>
            </section>

            <!-- Pricing / Products Section -->
            <section id="pricing" class="py-24 relative overflow-hidden">
                <div class="container mx-auto px-4 md:px-6">
                    <div class="text-center max-w-2xl mx-auto mb-16 space-y-4">
                        <h2 class="text-3xl md:text-5xl font-black tracking-tight text-foreground">Featured
                            Offers.</h2>
                        <p class="text-muted-foreground">Hand-picked data bundles with the best value for your
                            money. Instant activation guaranteed.</p>
                    </div>

                    <div class="grid grid-cols-2 gap-3 sm:gap-8 sm:grid-cols-2 lg:grid-cols-4">
                        <?php $__currentLoopData = $bundles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div
                                class="group relative bg-white dark:bg-slate-900 rounded-2xl md:rounded-[2.5rem] border border-slate-100 dark:border-slate-800 overflow-hidden shadow-sm hover:shadow-2xl hover:-translate-y-2 transition-all duration-500">
                                
                                <div
                                    class="aspect-[4/3] bg-slate-50 dark:bg-slate-800/50 relative flex items-center justify-center overflow-hidden">
                                    <?php if($product->image_url): ?>
                                        <img src="<?php echo e($product->image_url); ?>"
                                            class="w-full h-full object-cover transition-transform group-hover:scale-110 duration-700">
                                    <?php else: ?>
                                        <div
                                            class="flex flex-col items-center gap-2 opacity-20 group-hover:opacity-40 transition-opacity text-slate-400">
                                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                    <?php endif; ?>

                                    
                                    <div class="absolute top-2 left-2 md:top-4 md:left-4">
                                        <?php
                                            $net = strtoupper($product->network);
                                            $netColors = [
                                                'MTN' => 'bg-yellow-400 text-yellow-950',
                                                'TELECEL' => 'bg-red-500 text-white',
                                                'AT' => 'bg-blue-600 text-white',
                                                'AIRTELTIGO' => 'bg-blue-600 text-white',
                                            ];
                                            $nc = $netColors[$net] ?? 'bg-slate-900 text-white';
                                        ?>
                                        <span
                                            class="px-1.5 py-1 md:px-3 md:py-1.5 rounded-lg md:rounded-xl text-[8px] md:text-[10px] font-black tracking-widest uppercase shadow-xl backdrop-blur-md <?php echo e($nc); ?>">
                                            <?php echo e($product->network); ?>

                                        </span>
                                    </div>
                                </div>

                                <div class="p-4 md:p-8 space-y-4 md:space-y-6">
                                    <div>
                                        <h3
                                            class="text-sm md:text-xl font-black text-slate-900 dark:text-white leading-tight uppercase tracking-tight truncate">
                                            <?php echo e($product->name); ?>

                                        </h3>
                                        <p
                                            class="text-[10px] md:text-xs font-bold text-slate-400 mt-1 uppercase tracking-widest truncate">
                                            <?php echo e($product->data_amount); ?> Data Allocation
                                        </p>
                                    </div>

                                    <div
                                        class="pt-4 md:pt-6 border-t border-slate-50 dark:border-slate-800 flex flex-col md:flex-row items-start md:items-center justify-between gap-3 md:gap-0">
                                        <div>
                                            <p
                                                class="hidden md:block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">
                                                Price</p>
                                            <p
                                                class="text-lg md:text-2xl font-black text-primary tracking-tighter tabular-nums">
                                                ₵<?php echo e(number_format($product->price, 2)); ?></p>
                                        </div>
                                        <a href="<?php echo e(url('/login?redirect=purchase&bundle=' . $product->id)); ?>"
                                            class="w-full md:w-auto h-10 md:h-12 px-0 md:px-6 bg-slate-900 dark:bg-white text-white dark:text-slate-900 rounded-xl md:rounded-2xl font-black text-[10px] uppercase tracking-widest hover:bg-primary dark:hover:bg-primary dark:hover:text-white transition-all shadow-xl shadow-slate-900/10 dark:shadow-none flex items-center justify-center">
                                            Buy
                                            <span class="hidden md:inline ml-1">Now</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </section>
        </main>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Bruce\Desktop\Projects\Megaai2\Megaai\cloudtech\resources\views/home.blade.php ENDPATH**/ ?>