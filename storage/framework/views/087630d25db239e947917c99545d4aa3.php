<div x-data="{
        open: $persist(true).as('sidebar-open'),
        dropdowns: {},
        init() {
            this.$watch('open', () => {
                document.body.classList.toggle('sidebar-closed', !this.open);
            });
        },
        toggleDropdown(name) {
            this.dropdowns[name] = !this.dropdowns[name];
        },
        isDropdownOpen(name) {
            return this.dropdowns[name] === true;
        }
    }" @toggle-sidebar.window="open = !open" @resize.window.debounce="if (window.innerWidth < 768) open = false">

    <!-- Sidebar -->
    <aside
        class="fixed top-0 left-0 z-50 w-64 h-full p-4 overflow-y-auto transition-transform duration-200 ease-in-out bg-gray-900"
        :class="{ '-translate-x-full': !open }">

        <a href="<?php echo e(route('dashboard')); ?>" class="flex items-center pb-4 border-b border-b-gray-800">
            <img class="object-cover w-12 h-12" src="<?php echo e(asset('img/logo_1.png')); ?>" alt="logo">
            <span class="ml-3 text-lg font-bold text-white">RRP Systems</span>
        </a>

        <ul class="mt-4" x-data>

            <?php if (isset($component)) { $__componentOriginal01bf3b01a557c75eb9cd135a2177f1b0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal01bf3b01a557c75eb9cd135a2177f1b0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sidebar.menu','data' => ['name' => 'Dashboard','href' => route('dashboard'),'routename' => 'dashboard']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar.menu'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'Dashboard','href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('dashboard')),'routename' => 'dashboard']); ?>
                <?php if (isset($component)) { $__componentOriginal4710407deeab122b4cc56ae776da2d23 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4710407deeab122b4cc56ae776da2d23 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.home','data' => ['class' => 'mr-3 text-lg','h' => '18','w' => '18']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.home'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mr-3 text-lg','h' => '18','w' => '18']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal4710407deeab122b4cc56ae776da2d23)): ?>
<?php $attributes = $__attributesOriginal4710407deeab122b4cc56ae776da2d23; ?>
<?php unset($__attributesOriginal4710407deeab122b4cc56ae776da2d23); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal4710407deeab122b4cc56ae776da2d23)): ?>
<?php $component = $__componentOriginal4710407deeab122b4cc56ae776da2d23; ?>
<?php unset($__componentOriginal4710407deeab122b4cc56ae776da2d23); ?>
<?php endif; ?>
             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal01bf3b01a557c75eb9cd135a2177f1b0)): ?>
<?php $attributes = $__attributesOriginal01bf3b01a557c75eb9cd135a2177f1b0; ?>
<?php unset($__attributesOriginal01bf3b01a557c75eb9cd135a2177f1b0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal01bf3b01a557c75eb9cd135a2177f1b0)): ?>
<?php $component = $__componentOriginal01bf3b01a557c75eb9cd135a2177f1b0; ?>
<?php unset($__componentOriginal01bf3b01a557c75eb9cd135a2177f1b0); ?>
<?php endif; ?>

            <?php if (isset($component)) { $__componentOriginal01bf3b01a557c75eb9cd135a2177f1b0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal01bf3b01a557c75eb9cd135a2177f1b0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sidebar.menu','data' => ['name' => 'Financeiro','href' => route('dashboard.financial'),'routename' => 'dashboard.financial']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar.menu'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'Financeiro','href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('dashboard.financial')),'routename' => 'dashboard.financial']); ?>
                <?php if (isset($component)) { $__componentOriginal4710407deeab122b4cc56ae776da2d23 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4710407deeab122b4cc56ae776da2d23 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.home','data' => ['class' => 'mr-3 text-lg','h' => '18','w' => '18']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.home'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mr-3 text-lg','h' => '18','w' => '18']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal4710407deeab122b4cc56ae776da2d23)): ?>
<?php $attributes = $__attributesOriginal4710407deeab122b4cc56ae776da2d23; ?>
<?php unset($__attributesOriginal4710407deeab122b4cc56ae776da2d23); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal4710407deeab122b4cc56ae776da2d23)): ?>
<?php $component = $__componentOriginal4710407deeab122b4cc56ae776da2d23; ?>
<?php unset($__componentOriginal4710407deeab122b4cc56ae776da2d23); ?>
<?php endif; ?>
             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal01bf3b01a557c75eb9cd135a2177f1b0)): ?>
<?php $attributes = $__attributesOriginal01bf3b01a557c75eb9cd135a2177f1b0; ?>
<?php unset($__attributesOriginal01bf3b01a557c75eb9cd135a2177f1b0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal01bf3b01a557c75eb9cd135a2177f1b0)): ?>
<?php $component = $__componentOriginal01bf3b01a557c75eb9cd135a2177f1b0; ?>
<?php unset($__componentOriginal01bf3b01a557c75eb9cd135a2177f1b0); ?>
<?php endif; ?>

            <?php if (isset($component)) { $__componentOriginal01bf3b01a557c75eb9cd135a2177f1b0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal01bf3b01a557c75eb9cd135a2177f1b0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sidebar.menu','data' => ['name' => 'Alertas','href' => route('alerts.index'),'routename' => 'alerts.index']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar.menu'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'Alertas','href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('alerts.index')),'routename' => 'alerts.index']); ?>
                <svg class="mr-3 w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                    </path>
                </svg>
             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal01bf3b01a557c75eb9cd135a2177f1b0)): ?>
<?php $attributes = $__attributesOriginal01bf3b01a557c75eb9cd135a2177f1b0; ?>
<?php unset($__attributesOriginal01bf3b01a557c75eb9cd135a2177f1b0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal01bf3b01a557c75eb9cd135a2177f1b0)): ?>
<?php $component = $__componentOriginal01bf3b01a557c75eb9cd135a2177f1b0; ?>
<?php unset($__componentOriginal01bf3b01a557c75eb9cd135a2177f1b0); ?>
<?php endif; ?>

            <?php if (isset($component)) { $__componentOriginal01bf3b01a557c75eb9cd135a2177f1b0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal01bf3b01a557c75eb9cd135a2177f1b0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sidebar.menu','data' => ['name' => 'Manutenção','href' => route('maintenance.index'),'routename' => 'maintenance.index']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar.menu'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'Manutenção','href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('maintenance.index')),'routename' => 'maintenance.index']); ?>
                <svg class="mr-3 w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                    </path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z">
                    </path>
                </svg>
             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal01bf3b01a557c75eb9cd135a2177f1b0)): ?>
<?php $attributes = $__attributesOriginal01bf3b01a557c75eb9cd135a2177f1b0; ?>
<?php unset($__attributesOriginal01bf3b01a557c75eb9cd135a2177f1b0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal01bf3b01a557c75eb9cd135a2177f1b0)): ?>
<?php $component = $__componentOriginal01bf3b01a557c75eb9cd135a2177f1b0; ?>
<?php unset($__componentOriginal01bf3b01a557c75eb9cd135a2177f1b0); ?>
<?php endif; ?>

            <?php if (isset($component)) { $__componentOriginal379f0a8072f4a1b8a73318715bfd527b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal379f0a8072f4a1b8a73318715bfd527b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sidebar.group-menu','data' => ['name' => 'Relatórios','routename' => 'report','dropdown' => $dropdown]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar.group-menu'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'Relatórios','routename' => 'report','dropdown' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($dropdown)]); ?>
                 <?php $__env->slot('icon', null, []); ?> 
                    <?php if (isset($component)) { $__componentOriginalff5dc5bc18553a11eefe676d1fcebd57 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalff5dc5bc18553a11eefe676d1fcebd57 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.box','data' => ['class' => 'mr-3 text-lg','h' => '18','w' => '18']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.box'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mr-3 text-lg','h' => '18','w' => '18']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalff5dc5bc18553a11eefe676d1fcebd57)): ?>
<?php $attributes = $__attributesOriginalff5dc5bc18553a11eefe676d1fcebd57; ?>
<?php unset($__attributesOriginalff5dc5bc18553a11eefe676d1fcebd57); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalff5dc5bc18553a11eefe676d1fcebd57)): ?>
<?php $component = $__componentOriginalff5dc5bc18553a11eefe676d1fcebd57; ?>
<?php unset($__componentOriginalff5dc5bc18553a11eefe676d1fcebd57); ?>
<?php endif; ?>
                 <?php $__env->endSlot(); ?>

                <?php if (isset($component)) { $__componentOriginal8568627e7eb13624e91818f56accc404 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8568627e7eb13624e91818f56accc404 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sidebar.group-item','data' => ['name' => 'Faturas','href' => route('report.invoice'),'routename' => 'report/invoice']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar.group-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'Faturas','href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('report.invoice')),'routename' => 'report/invoice']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8568627e7eb13624e91818f56accc404)): ?>
<?php $attributes = $__attributesOriginal8568627e7eb13624e91818f56accc404; ?>
<?php unset($__attributesOriginal8568627e7eb13624e91818f56accc404); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8568627e7eb13624e91818f56accc404)): ?>
<?php $component = $__componentOriginal8568627e7eb13624e91818f56accc404; ?>
<?php unset($__componentOriginal8568627e7eb13624e91818f56accc404); ?>
<?php endif; ?>
                <?php if (isset($component)) { $__componentOriginal8568627e7eb13624e91818f56accc404 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8568627e7eb13624e91818f56accc404 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sidebar.group-item','data' => ['name' => 'Operadoras','href' => route('report.carrier'),'routename' => 'report/carrier']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar.group-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'Operadoras','href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('report.carrier')),'routename' => 'report/carrier']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8568627e7eb13624e91818f56accc404)): ?>
<?php $attributes = $__attributesOriginal8568627e7eb13624e91818f56accc404; ?>
<?php unset($__attributesOriginal8568627e7eb13624e91818f56accc404); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8568627e7eb13624e91818f56accc404)): ?>
<?php $component = $__componentOriginal8568627e7eb13624e91818f56accc404; ?>
<?php unset($__componentOriginal8568627e7eb13624e91818f56accc404); ?>
<?php endif; ?>
                <?php if (isset($component)) { $__componentOriginal8568627e7eb13624e91818f56accc404 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8568627e7eb13624e91818f56accc404 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sidebar.group-item','data' => ['name' => 'Alocação de Custos','href' => route('report.cost-allocation'),'routename' => 'report/cost-allocation']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar.group-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'Alocação de Custos','href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('report.cost-allocation')),'routename' => 'report/cost-allocation']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8568627e7eb13624e91818f56accc404)): ?>
<?php $attributes = $__attributesOriginal8568627e7eb13624e91818f56accc404; ?>
<?php unset($__attributesOriginal8568627e7eb13624e91818f56accc404); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8568627e7eb13624e91818f56accc404)): ?>
<?php $component = $__componentOriginal8568627e7eb13624e91818f56accc404; ?>
<?php unset($__componentOriginal8568627e7eb13624e91818f56accc404); ?>
<?php endif; ?>
                <?php if (isset($component)) { $__componentOriginal8568627e7eb13624e91818f56accc404 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8568627e7eb13624e91818f56accc404 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sidebar.group-item','data' => ['name' => 'Qualidade de Tráfego (ASR/ACD)','href' => route('report.quality-analysis'),'routename' => 'report/quality-analysis']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar.group-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'Qualidade de Tráfego (ASR/ACD)','href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('report.quality-analysis')),'routename' => 'report/quality-analysis']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8568627e7eb13624e91818f56accc404)): ?>
<?php $attributes = $__attributesOriginal8568627e7eb13624e91818f56accc404; ?>
<?php unset($__attributesOriginal8568627e7eb13624e91818f56accc404); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8568627e7eb13624e91818f56accc404)): ?>
<?php $component = $__componentOriginal8568627e7eb13624e91818f56accc404; ?>
<?php unset($__componentOriginal8568627e7eb13624e91818f56accc404); ?>
<?php endif; ?>
                <?php if (isset($component)) { $__componentOriginal8568627e7eb13624e91818f56accc404 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8568627e7eb13624e91818f56accc404 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sidebar.group-item','data' => ['name' => 'Rentabilidade','href' => route('report.profitability'),'routename' => 'report/profitability']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar.group-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'Rentabilidade','href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('report.profitability')),'routename' => 'report/profitability']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8568627e7eb13624e91818f56accc404)): ?>
<?php $attributes = $__attributesOriginal8568627e7eb13624e91818f56accc404; ?>
<?php unset($__attributesOriginal8568627e7eb13624e91818f56accc404); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8568627e7eb13624e91818f56accc404)): ?>
<?php $component = $__componentOriginal8568627e7eb13624e91818f56accc404; ?>
<?php unset($__componentOriginal8568627e7eb13624e91818f56accc404); ?>
<?php endif; ?>
                <?php if (isset($component)) { $__componentOriginal8568627e7eb13624e91818f56accc404 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8568627e7eb13624e91818f56accc404 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sidebar.group-item','data' => ['name' => 'Previsão de Faturamento','href' => route('report.revenue-forecast'),'routename' => 'report/revenue-forecast']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar.group-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'Previsão de Faturamento','href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('report.revenue-forecast')),'routename' => 'report/revenue-forecast']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8568627e7eb13624e91818f56accc404)): ?>
<?php $attributes = $__attributesOriginal8568627e7eb13624e91818f56accc404; ?>
<?php unset($__attributesOriginal8568627e7eb13624e91818f56accc404); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8568627e7eb13624e91818f56accc404)): ?>
<?php $component = $__componentOriginal8568627e7eb13624e91818f56accc404; ?>
<?php unset($__componentOriginal8568627e7eb13624e91818f56accc404); ?>
<?php endif; ?>
                <?php if (isset($component)) { $__componentOriginal8568627e7eb13624e91818f56accc404 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8568627e7eb13624e91818f56accc404 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sidebar.group-item','data' => ['name' => 'Detecção de Fraude','href' => route('report.fraud-detection'),'routename' => 'report/fraud-detection']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar.group-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'Detecção de Fraude','href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('report.fraud-detection')),'routename' => 'report/fraud-detection']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8568627e7eb13624e91818f56accc404)): ?>
<?php $attributes = $__attributesOriginal8568627e7eb13624e91818f56accc404; ?>
<?php unset($__attributesOriginal8568627e7eb13624e91818f56accc404); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8568627e7eb13624e91818f56accc404)): ?>
<?php $component = $__componentOriginal8568627e7eb13624e91818f56accc404; ?>
<?php unset($__componentOriginal8568627e7eb13624e91818f56accc404); ?>
<?php endif; ?>
                <?php if (isset($component)) { $__componentOriginal8568627e7eb13624e91818f56accc404 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8568627e7eb13624e91818f56accc404 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sidebar.group-item','data' => ['name' => 'Análise de Rotas (LCR)','href' => route('report.route-analysis'),'routename' => 'report/route-analysis']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar.group-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'Análise de Rotas (LCR)','href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('report.route-analysis')),'routename' => 'report/route-analysis']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8568627e7eb13624e91818f56accc404)): ?>
<?php $attributes = $__attributesOriginal8568627e7eb13624e91818f56accc404; ?>
<?php unset($__attributesOriginal8568627e7eb13624e91818f56accc404); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8568627e7eb13624e91818f56accc404)): ?>
<?php $component = $__componentOriginal8568627e7eb13624e91818f56accc404; ?>
<?php unset($__componentOriginal8568627e7eb13624e91818f56accc404); ?>
<?php endif; ?>
                <?php if (isset($component)) { $__componentOriginal8568627e7eb13624e91818f56accc404 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8568627e7eb13624e91818f56accc404 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sidebar.group-item','data' => ['name' => 'Log CDR','href' => route('report.cdr'),'routename' => 'report/cdr']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar.group-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'Log CDR','href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('report.cdr')),'routename' => 'report/cdr']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8568627e7eb13624e91818f56accc404)): ?>
<?php $attributes = $__attributesOriginal8568627e7eb13624e91818f56accc404; ?>
<?php unset($__attributesOriginal8568627e7eb13624e91818f56accc404); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8568627e7eb13624e91818f56accc404)): ?>
<?php $component = $__componentOriginal8568627e7eb13624e91818f56accc404; ?>
<?php unset($__componentOriginal8568627e7eb13624e91818f56accc404); ?>
<?php endif; ?>

             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal379f0a8072f4a1b8a73318715bfd527b)): ?>
<?php $attributes = $__attributesOriginal379f0a8072f4a1b8a73318715bfd527b; ?>
<?php unset($__attributesOriginal379f0a8072f4a1b8a73318715bfd527b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal379f0a8072f4a1b8a73318715bfd527b)): ?>
<?php $component = $__componentOriginal379f0a8072f4a1b8a73318715bfd527b; ?>
<?php unset($__componentOriginal379f0a8072f4a1b8a73318715bfd527b); ?>
<?php endif; ?>

            <?php if (isset($component)) { $__componentOriginal379f0a8072f4a1b8a73318715bfd527b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal379f0a8072f4a1b8a73318715bfd527b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sidebar.group-menu','data' => ['name' => 'Gestão','routename' => 'customers','dropdown' => $dropdown]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar.group-menu'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'Gestão','routename' => 'customers','dropdown' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($dropdown)]); ?>
                 <?php $__env->slot('icon', null, []); ?> 
                    <?php if (isset($component)) { $__componentOriginalff5dc5bc18553a11eefe676d1fcebd57 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalff5dc5bc18553a11eefe676d1fcebd57 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.box','data' => ['class' => 'mr-3 text-lg','h' => '18','w' => '18']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.box'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mr-3 text-lg','h' => '18','w' => '18']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalff5dc5bc18553a11eefe676d1fcebd57)): ?>
<?php $attributes = $__attributesOriginalff5dc5bc18553a11eefe676d1fcebd57; ?>
<?php unset($__attributesOriginalff5dc5bc18553a11eefe676d1fcebd57); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalff5dc5bc18553a11eefe676d1fcebd57)): ?>
<?php $component = $__componentOriginalff5dc5bc18553a11eefe676d1fcebd57; ?>
<?php unset($__componentOriginalff5dc5bc18553a11eefe676d1fcebd57); ?>
<?php endif; ?>
                 <?php $__env->endSlot(); ?>

                <?php if (isset($component)) { $__componentOriginal8568627e7eb13624e91818f56accc404 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8568627e7eb13624e91818f56accc404 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sidebar.group-item','data' => ['name' => 'Produtos/Serviços','href' => route('customers.products.list'),'routename' => 'customers/products']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar.group-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'Produtos/Serviços','href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('customers.products.list')),'routename' => 'customers/products']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8568627e7eb13624e91818f56accc404)): ?>
<?php $attributes = $__attributesOriginal8568627e7eb13624e91818f56accc404; ?>
<?php unset($__attributesOriginal8568627e7eb13624e91818f56accc404); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8568627e7eb13624e91818f56accc404)): ?>
<?php $component = $__componentOriginal8568627e7eb13624e91818f56accc404; ?>
<?php unset($__componentOriginal8568627e7eb13624e91818f56accc404); ?>
<?php endif; ?>

             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal379f0a8072f4a1b8a73318715bfd527b)): ?>
<?php $attributes = $__attributesOriginal379f0a8072f4a1b8a73318715bfd527b; ?>
<?php unset($__attributesOriginal379f0a8072f4a1b8a73318715bfd527b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal379f0a8072f4a1b8a73318715bfd527b)): ?>
<?php $component = $__componentOriginal379f0a8072f4a1b8a73318715bfd527b; ?>
<?php unset($__componentOriginal379f0a8072f4a1b8a73318715bfd527b); ?>
<?php endif; ?>

            <?php if (isset($component)) { $__componentOriginal379f0a8072f4a1b8a73318715bfd527b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal379f0a8072f4a1b8a73318715bfd527b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sidebar.group-menu','data' => ['name' => 'Configurações','routename' => 'config','dropdown' => $dropdown]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar.group-menu'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'Configurações','routename' => 'config','dropdown' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($dropdown)]); ?>
                 <?php $__env->slot('icon', null, []); ?> 
                    <?php if (isset($component)) { $__componentOriginal675d5ec13ccf645c64542fb04e9f331e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal675d5ec13ccf645c64542fb04e9f331e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.settings','data' => ['class' => 'mr-3 text-lg','h' => '18','w' => '18']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.settings'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mr-3 text-lg','h' => '18','w' => '18']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal675d5ec13ccf645c64542fb04e9f331e)): ?>
<?php $attributes = $__attributesOriginal675d5ec13ccf645c64542fb04e9f331e; ?>
<?php unset($__attributesOriginal675d5ec13ccf645c64542fb04e9f331e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal675d5ec13ccf645c64542fb04e9f331e)): ?>
<?php $component = $__componentOriginal675d5ec13ccf645c64542fb04e9f331e; ?>
<?php unset($__componentOriginal675d5ec13ccf645c64542fb04e9f331e); ?>
<?php endif; ?>
                 <?php $__env->endSlot(); ?>

                <?php if (isset($component)) { $__componentOriginal8568627e7eb13624e91818f56accc404 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8568627e7eb13624e91818f56accc404 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sidebar.group-item','data' => ['name' => 'Usuarios','href' => route('config.user'),'routename' => 'config/user']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar.group-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'Usuarios','href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('config.user')),'routename' => 'config/user']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8568627e7eb13624e91818f56accc404)): ?>
<?php $attributes = $__attributesOriginal8568627e7eb13624e91818f56accc404; ?>
<?php unset($__attributesOriginal8568627e7eb13624e91818f56accc404); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8568627e7eb13624e91818f56accc404)): ?>
<?php $component = $__componentOriginal8568627e7eb13624e91818f56accc404; ?>
<?php unset($__componentOriginal8568627e7eb13624e91818f56accc404); ?>
<?php endif; ?>
                <?php if (isset($component)) { $__componentOriginal8568627e7eb13624e91818f56accc404 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8568627e7eb13624e91818f56accc404 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sidebar.group-item','data' => ['name' => 'Clientes','href' => route('config.customer'),'routename' => 'config/customer']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar.group-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'Clientes','href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('config.customer')),'routename' => 'config/customer']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8568627e7eb13624e91818f56accc404)): ?>
<?php $attributes = $__attributesOriginal8568627e7eb13624e91818f56accc404; ?>
<?php unset($__attributesOriginal8568627e7eb13624e91818f56accc404); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8568627e7eb13624e91818f56accc404)): ?>
<?php $component = $__componentOriginal8568627e7eb13624e91818f56accc404; ?>
<?php unset($__componentOriginal8568627e7eb13624e91818f56accc404); ?>
<?php endif; ?>
                <?php if (isset($component)) { $__componentOriginal8568627e7eb13624e91818f56accc404 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8568627e7eb13624e91818f56accc404 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sidebar.group-item','data' => ['name' => 'Revendas','href' => route('config.reseller'),'routename' => 'config/reseller']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar.group-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'Revendas','href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('config.reseller')),'routename' => 'config/reseller']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8568627e7eb13624e91818f56accc404)): ?>
<?php $attributes = $__attributesOriginal8568627e7eb13624e91818f56accc404; ?>
<?php unset($__attributesOriginal8568627e7eb13624e91818f56accc404); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8568627e7eb13624e91818f56accc404)): ?>
<?php $component = $__componentOriginal8568627e7eb13624e91818f56accc404; ?>
<?php unset($__componentOriginal8568627e7eb13624e91818f56accc404); ?>
<?php endif; ?>
                <?php if (isset($component)) { $__componentOriginal8568627e7eb13624e91818f56accc404 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8568627e7eb13624e91818f56accc404 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sidebar.group-item','data' => ['name' => 'Operadoras','href' => route('config.carrier'),'routename' => 'config/carrier']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar.group-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'Operadoras','href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('config.carrier')),'routename' => 'config/carrier']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8568627e7eb13624e91818f56accc404)): ?>
<?php $attributes = $__attributesOriginal8568627e7eb13624e91818f56accc404; ?>
<?php unset($__attributesOriginal8568627e7eb13624e91818f56accc404); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8568627e7eb13624e91818f56accc404)): ?>
<?php $component = $__componentOriginal8568627e7eb13624e91818f56accc404; ?>
<?php unset($__componentOriginal8568627e7eb13624e91818f56accc404); ?>
<?php endif; ?>
                <?php if (isset($component)) { $__componentOriginal8568627e7eb13624e91818f56accc404 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8568627e7eb13624e91818f56accc404 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sidebar.group-item','data' => ['name' => 'DIDs','href' => route('config.did'),'routename' => 'config/did']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar.group-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'DIDs','href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('config.did')),'routename' => 'config/did']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8568627e7eb13624e91818f56accc404)): ?>
<?php $attributes = $__attributesOriginal8568627e7eb13624e91818f56accc404; ?>
<?php unset($__attributesOriginal8568627e7eb13624e91818f56accc404); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8568627e7eb13624e91818f56accc404)): ?>
<?php $component = $__componentOriginal8568627e7eb13624e91818f56accc404; ?>
<?php unset($__componentOriginal8568627e7eb13624e91818f56accc404); ?>
<?php endif; ?>
                <?php if (isset($component)) { $__componentOriginal8568627e7eb13624e91818f56accc404 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8568627e7eb13624e91818f56accc404 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sidebar.group-item','data' => ['name' => 'Tarifas','href' => route('config.rate'),'routename' => 'config/rate']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar.group-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'Tarifas','href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('config.rate')),'routename' => 'config/rate']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8568627e7eb13624e91818f56accc404)): ?>
<?php $attributes = $__attributesOriginal8568627e7eb13624e91818f56accc404; ?>
<?php unset($__attributesOriginal8568627e7eb13624e91818f56accc404); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8568627e7eb13624e91818f56accc404)): ?>
<?php $component = $__componentOriginal8568627e7eb13624e91818f56accc404; ?>
<?php unset($__componentOriginal8568627e7eb13624e91818f56accc404); ?>
<?php endif; ?>
                <?php if (isset($component)) { $__componentOriginal8568627e7eb13624e91818f56accc404 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8568627e7eb13624e91818f56accc404 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sidebar.group-item','data' => ['name' => 'Áudios','href' => route('config.audio'),'routename' => 'config/audio']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar.group-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'Áudios','href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('config.audio')),'routename' => 'config/audio']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8568627e7eb13624e91818f56accc404)): ?>
<?php $attributes = $__attributesOriginal8568627e7eb13624e91818f56accc404; ?>
<?php unset($__attributesOriginal8568627e7eb13624e91818f56accc404); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8568627e7eb13624e91818f56accc404)): ?>
<?php $component = $__componentOriginal8568627e7eb13624e91818f56accc404; ?>
<?php unset($__componentOriginal8568627e7eb13624e91818f56accc404); ?>
<?php endif; ?>

             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal379f0a8072f4a1b8a73318715bfd527b)): ?>
<?php $attributes = $__attributesOriginal379f0a8072f4a1b8a73318715bfd527b; ?>
<?php unset($__attributesOriginal379f0a8072f4a1b8a73318715bfd527b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal379f0a8072f4a1b8a73318715bfd527b)): ?>
<?php $component = $__componentOriginal379f0a8072f4a1b8a73318715bfd527b; ?>
<?php unset($__componentOriginal379f0a8072f4a1b8a73318715bfd527b); ?>
<?php endif; ?>

        </ul>

    </aside>

    <!-- Overlay para mobile -->
    <div x-show="open && window.innerWidth < 768" x-transition:enter="transition-opacity ease-out duration-200"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity ease-in duration-150" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0" @click="open = false" class="fixed inset-0 z-40 bg-black/50 md:hidden">
    </div>

</div><?php /**PATH C:\Users\Rafael Benedicto\Documents\Herd\asbc\resources\views/livewire/template/sidebar.blade.php ENDPATH**/ ?>