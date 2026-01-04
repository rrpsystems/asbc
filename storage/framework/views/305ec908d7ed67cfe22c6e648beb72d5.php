<div
    class="flex flex-col min-h-[calc(100vh-4rem)] pb-3 pl-6 pr-6 bg-white dark:bg-gray-600 border border-gray-300 dark:border-gray-100 rounded-md shadow-md shadow-black/5">
    <div class="container flex-grow mx-auto">
        <!-- Header -->
        <div class="flex flex-col items-center justify-between my-4 sm:flex-row">
            <div>
                <h3 class="mb-2 text-2xl font-bold text-gray-800 dark:text-gray-200">Central de Alertas</h3>

                <!-- Stats Cards -->
                <div class="flex flex-wrap gap-2 mt-3">
                    <div class="flex items-center gap-2 px-3 py-1 bg-red-100 rounded-lg dark:bg-red-900/30">
                        <svg class="w-4 h-4 text-red-600 dark:text-red-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-sm font-semibold text-red-800 dark:text-red-300">Crítico: <?php echo e($stats['critical']); ?></span>
                    </div>

                    <div class="flex items-center gap-2 px-3 py-1 bg-orange-100 rounded-lg dark:bg-orange-900/30">
                        <svg class="w-4 h-4 text-orange-600 dark:text-orange-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-sm font-semibold text-orange-800 dark:text-orange-300">Alto: <?php echo e($stats['high']); ?></span>
                    </div>

                    <div class="flex items-center gap-2 px-3 py-1 bg-yellow-100 rounded-lg dark:bg-yellow-900/30">
                        <svg class="w-4 h-4 text-yellow-600 dark:text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-sm font-semibold text-yellow-800 dark:text-yellow-300">Médio: <?php echo e($stats['medium']); ?></span>
                    </div>

                    <div class="flex items-center gap-2 px-3 py-1 bg-blue-100 rounded-lg dark:bg-blue-900/30">
                        <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-sm font-semibold text-blue-800 dark:text-blue-300">Baixo: <?php echo e($stats['low']); ?></span>
                    </div>
                </div>
            </div>

            <div class="flex gap-2 mt-4 sm:mt-0">
                <button wire:click="markAllAsRead"
                    class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-white transition-all duration-200 bg-purple-600 rounded-lg shadow-sm hover:bg-purple-700 hover:shadow-md">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Marcar Todos como Lidos
                </button>

                <?php if (isset($component)) { $__componentOriginal5266464ff7b66ba0b126f4b6bc32a5f5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5266464ff7b66ba0b126f4b6bc32a5f5 = $attributes; } ?>
<?php $component = TallStackUi\View\Components\Button\Button::resolve(['icon' => 'funnel','color' => 'purple','position' => 'left'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\TallStackUi\View\Components\Button\Button::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:click' => 'openFilter']); ?>Filtros <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5266464ff7b66ba0b126f4b6bc32a5f5)): ?>
<?php $attributes = $__attributesOriginal5266464ff7b66ba0b126f4b6bc32a5f5; ?>
<?php unset($__attributesOriginal5266464ff7b66ba0b126f4b6bc32a5f5); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5266464ff7b66ba0b126f4b6bc32a5f5)): ?>
<?php $component = $__componentOriginal5266464ff7b66ba0b126f4b6bc32a5f5; ?>
<?php unset($__componentOriginal5266464ff7b66ba0b126f4b6bc32a5f5); ?>
<?php endif; ?>

                <button wire:click="resetFilter"
                    class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-gray-700 transition-all duration-200 bg-white border border-gray-300 rounded-lg shadow-sm hover:bg-gray-50 dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                        </path>
                    </svg>
                    Limpar
                </button>
            </div>
        </div>

        <!-- Alerts Table -->
        <div class="overflow-x-auto bg-white shadow-md dark:bg-gray-800 rounded-lg">
            <?php if (isset($component)) { $__componentOriginal7fdb3552722b7d40f4be207e2e79dc5a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7fdb3552722b7d40f4be207e2e79dc5a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.tables.table','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tables.table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
                 <?php $__env->slot('header', null, []); ?> 
                    <?php if (isset($component)) { $__componentOriginal1a45183cace1701b97cb7f3ffb189fb0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1a45183cace1701b97cb7f3ffb189fb0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.tables.th','data' => ['label' => 'Severidade','column' => 'severity','direction' => $direction,'sort' => $sort]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tables.th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Severidade','column' => 'severity','direction' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($direction),'sort' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($sort)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1a45183cace1701b97cb7f3ffb189fb0)): ?>
<?php $attributes = $__attributesOriginal1a45183cace1701b97cb7f3ffb189fb0; ?>
<?php unset($__attributesOriginal1a45183cace1701b97cb7f3ffb189fb0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1a45183cace1701b97cb7f3ffb189fb0)): ?>
<?php $component = $__componentOriginal1a45183cace1701b97cb7f3ffb189fb0; ?>
<?php unset($__componentOriginal1a45183cace1701b97cb7f3ffb189fb0); ?>
<?php endif; ?>
                    <?php if (isset($component)) { $__componentOriginal1a45183cace1701b97cb7f3ffb189fb0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1a45183cace1701b97cb7f3ffb189fb0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.tables.th','data' => ['label' => 'Tipo','column' => 'type','direction' => $direction,'sort' => $sort]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tables.th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Tipo','column' => 'type','direction' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($direction),'sort' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($sort)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1a45183cace1701b97cb7f3ffb189fb0)): ?>
<?php $attributes = $__attributesOriginal1a45183cace1701b97cb7f3ffb189fb0; ?>
<?php unset($__attributesOriginal1a45183cace1701b97cb7f3ffb189fb0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1a45183cace1701b97cb7f3ffb189fb0)): ?>
<?php $component = $__componentOriginal1a45183cace1701b97cb7f3ffb189fb0; ?>
<?php unset($__componentOriginal1a45183cace1701b97cb7f3ffb189fb0); ?>
<?php endif; ?>
                    <?php if (isset($component)) { $__componentOriginal1a45183cace1701b97cb7f3ffb189fb0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1a45183cace1701b97cb7f3ffb189fb0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.tables.th','data' => ['label' => 'Título','column' => 'title','direction' => $direction,'sort' => $sort]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tables.th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Título','column' => 'title','direction' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($direction),'sort' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($sort)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1a45183cace1701b97cb7f3ffb189fb0)): ?>
<?php $attributes = $__attributesOriginal1a45183cace1701b97cb7f3ffb189fb0; ?>
<?php unset($__attributesOriginal1a45183cace1701b97cb7f3ffb189fb0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1a45183cace1701b97cb7f3ffb189fb0)): ?>
<?php $component = $__componentOriginal1a45183cace1701b97cb7f3ffb189fb0; ?>
<?php unset($__componentOriginal1a45183cace1701b97cb7f3ffb189fb0); ?>
<?php endif; ?>
                    <?php if (isset($component)) { $__componentOriginal1a45183cace1701b97cb7f3ffb189fb0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1a45183cace1701b97cb7f3ffb189fb0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.tables.th','data' => ['label' => 'Cliente/Operadora']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tables.th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Cliente/Operadora']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1a45183cace1701b97cb7f3ffb189fb0)): ?>
<?php $attributes = $__attributesOriginal1a45183cace1701b97cb7f3ffb189fb0; ?>
<?php unset($__attributesOriginal1a45183cace1701b97cb7f3ffb189fb0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1a45183cace1701b97cb7f3ffb189fb0)): ?>
<?php $component = $__componentOriginal1a45183cace1701b97cb7f3ffb189fb0; ?>
<?php unset($__componentOriginal1a45183cace1701b97cb7f3ffb189fb0); ?>
<?php endif; ?>
                    <?php if (isset($component)) { $__componentOriginal1a45183cace1701b97cb7f3ffb189fb0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1a45183cace1701b97cb7f3ffb189fb0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.tables.th','data' => ['label' => 'Data','column' => 'created_at','direction' => $direction,'sort' => $sort]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tables.th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Data','column' => 'created_at','direction' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($direction),'sort' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($sort)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1a45183cace1701b97cb7f3ffb189fb0)): ?>
<?php $attributes = $__attributesOriginal1a45183cace1701b97cb7f3ffb189fb0; ?>
<?php unset($__attributesOriginal1a45183cace1701b97cb7f3ffb189fb0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1a45183cace1701b97cb7f3ffb189fb0)): ?>
<?php $component = $__componentOriginal1a45183cace1701b97cb7f3ffb189fb0; ?>
<?php unset($__componentOriginal1a45183cace1701b97cb7f3ffb189fb0); ?>
<?php endif; ?>
                    <?php if (isset($component)) { $__componentOriginal1a45183cace1701b97cb7f3ffb189fb0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1a45183cace1701b97cb7f3ffb189fb0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.tables.th','data' => ['label' => 'Status']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tables.th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Status']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1a45183cace1701b97cb7f3ffb189fb0)): ?>
<?php $attributes = $__attributesOriginal1a45183cace1701b97cb7f3ffb189fb0; ?>
<?php unset($__attributesOriginal1a45183cace1701b97cb7f3ffb189fb0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1a45183cace1701b97cb7f3ffb189fb0)): ?>
<?php $component = $__componentOriginal1a45183cace1701b97cb7f3ffb189fb0; ?>
<?php unset($__componentOriginal1a45183cace1701b97cb7f3ffb189fb0); ?>
<?php endif; ?>
                    <?php if (isset($component)) { $__componentOriginal1a45183cace1701b97cb7f3ffb189fb0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1a45183cace1701b97cb7f3ffb189fb0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.tables.th','data' => ['label' => 'Ações']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tables.th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Ações']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1a45183cace1701b97cb7f3ffb189fb0)): ?>
<?php $attributes = $__attributesOriginal1a45183cace1701b97cb7f3ffb189fb0; ?>
<?php unset($__attributesOriginal1a45183cace1701b97cb7f3ffb189fb0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1a45183cace1701b97cb7f3ffb189fb0)): ?>
<?php $component = $__componentOriginal1a45183cace1701b97cb7f3ffb189fb0; ?>
<?php unset($__componentOriginal1a45183cace1701b97cb7f3ffb189fb0); ?>
<?php endif; ?>
                 <?php $__env->endSlot(); ?>

                 <?php $__env->slot('body', null, []); ?> 
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $alerts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $alert): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <?php if (isset($component)) { $__componentOriginal0afb9ddc62f38bdedc90bd74b54448d7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0afb9ddc62f38bdedc90bd74b54448d7 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.tables.tr','data' => ['class' => ''.e(!$alert->isRead() ? 'bg-blue-50 dark:bg-blue-900/10' : '').'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tables.tr'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => ''.e(!$alert->isRead() ? 'bg-blue-50 dark:bg-blue-900/10' : '').'']); ?>
                            <!-- Severity Badge -->
                            <?php if (isset($component)) { $__componentOriginal7a6665ff7d6099983543eacca6edd279 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7a6665ff7d6099983543eacca6edd279 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.tables.td','data' => ['class' => 'py-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tables.td'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'py-2']); ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($alert->severity === 'critical'): ?>
                                    <span
                                        class="inline-flex items-center px-2 py-1 text-xs font-semibold text-red-800 bg-red-100 rounded-full dark:bg-red-900/30 dark:text-red-300">
                                        Crítico
                                    </span>
                                <?php elseif($alert->severity === 'high'): ?>
                                    <span
                                        class="inline-flex items-center px-2 py-1 text-xs font-semibold text-orange-800 bg-orange-100 rounded-full dark:bg-orange-900/30 dark:text-orange-300">
                                        Alto
                                    </span>
                                <?php elseif($alert->severity === 'medium'): ?>
                                    <span
                                        class="inline-flex items-center px-2 py-1 text-xs font-semibold text-yellow-800 bg-yellow-100 rounded-full dark:bg-yellow-900/30 dark:text-yellow-300">
                                        Médio
                                    </span>
                                <?php else: ?>
                                    <span
                                        class="inline-flex items-center px-2 py-1 text-xs font-semibold text-blue-800 bg-blue-100 rounded-full dark:bg-blue-900/30 dark:text-blue-300">
                                        Baixo
                                    </span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal7a6665ff7d6099983543eacca6edd279)): ?>
<?php $attributes = $__attributesOriginal7a6665ff7d6099983543eacca6edd279; ?>
<?php unset($__attributesOriginal7a6665ff7d6099983543eacca6edd279); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal7a6665ff7d6099983543eacca6edd279)): ?>
<?php $component = $__componentOriginal7a6665ff7d6099983543eacca6edd279; ?>
<?php unset($__componentOriginal7a6665ff7d6099983543eacca6edd279); ?>
<?php endif; ?>

                            <!-- Type -->
                            <?php if (isset($component)) { $__componentOriginal7a6665ff7d6099983543eacca6edd279 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7a6665ff7d6099983543eacca6edd279 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.tables.td','data' => ['class' => 'py-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tables.td'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'py-2']); ?>
                                <span class="text-sm text-gray-600 dark:text-gray-400">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php switch($alert->type):
                                        case ('franchise_exceeded'): ?>
                                            Franquia Excedida
                                        <?php break; ?>

                                        <?php case ('franchise_warning'): ?>
                                            Aviso Franquia
                                        <?php break; ?>

                                        <?php case ('tarifacao_error'): ?>
                                            Erro Tarifação
                                        <?php break; ?>

                                        <?php case ('peak_channels'): ?>
                                            Pico de Canais
                                        <?php break; ?>

                                        <?php case ('fraud_detected'): ?>
                                            Fraude Detectada
                                        <?php break; ?>

                                        <?php case ('high_cost'): ?>
                                            Custo Elevado
                                        <?php break; ?>

                                        <?php case ('carrier_failure'): ?>
                                            Falha Operadora
                                        <?php break; ?>

                                        <?php default: ?>
                                            <?php echo e($alert->type); ?>

                                    <?php endswitch; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </span>
                             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal7a6665ff7d6099983543eacca6edd279)): ?>
<?php $attributes = $__attributesOriginal7a6665ff7d6099983543eacca6edd279; ?>
<?php unset($__attributesOriginal7a6665ff7d6099983543eacca6edd279); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal7a6665ff7d6099983543eacca6edd279)): ?>
<?php $component = $__componentOriginal7a6665ff7d6099983543eacca6edd279; ?>
<?php unset($__componentOriginal7a6665ff7d6099983543eacca6edd279); ?>
<?php endif; ?>

                            <!-- Title -->
                            <?php if (isset($component)) { $__componentOriginal7a6665ff7d6099983543eacca6edd279 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7a6665ff7d6099983543eacca6edd279 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.tables.td','data' => ['class' => 'py-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tables.td'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'py-2']); ?>
                                <span class="font-medium text-gray-900 dark:text-gray-100">
                                    <?php echo e($alert->title); ?>

                                </span>
                             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal7a6665ff7d6099983543eacca6edd279)): ?>
<?php $attributes = $__attributesOriginal7a6665ff7d6099983543eacca6edd279; ?>
<?php unset($__attributesOriginal7a6665ff7d6099983543eacca6edd279); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal7a6665ff7d6099983543eacca6edd279)): ?>
<?php $component = $__componentOriginal7a6665ff7d6099983543eacca6edd279; ?>
<?php unset($__componentOriginal7a6665ff7d6099983543eacca6edd279); ?>
<?php endif; ?>

                            <!-- Related Entity -->
                            <?php if (isset($component)) { $__componentOriginal7a6665ff7d6099983543eacca6edd279 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7a6665ff7d6099983543eacca6edd279 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.tables.td','data' => ['class' => 'py-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tables.td'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'py-2']); ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($alert->customer): ?>
                                    <span class="text-sm text-gray-600 dark:text-gray-400">
                                        <?php echo e(\Illuminate\Support\Str::limit($alert->customer->razaosocial, 25)); ?>

                                    </span>
                                <?php elseif($alert->carrier): ?>
                                    <span class="text-sm text-gray-600 dark:text-gray-400">
                                        <?php echo e($alert->carrier->operadora); ?>

                                    </span>
                                <?php else: ?>
                                    <span class="text-sm text-gray-400 dark:text-gray-500">-</span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal7a6665ff7d6099983543eacca6edd279)): ?>
<?php $attributes = $__attributesOriginal7a6665ff7d6099983543eacca6edd279; ?>
<?php unset($__attributesOriginal7a6665ff7d6099983543eacca6edd279); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal7a6665ff7d6099983543eacca6edd279)): ?>
<?php $component = $__componentOriginal7a6665ff7d6099983543eacca6edd279; ?>
<?php unset($__componentOriginal7a6665ff7d6099983543eacca6edd279); ?>
<?php endif; ?>

                            <!-- Date -->
                            <?php if (isset($component)) { $__componentOriginal7a6665ff7d6099983543eacca6edd279 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7a6665ff7d6099983543eacca6edd279 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.tables.td','data' => ['class' => 'py-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tables.td'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'py-2']); ?>
                                <span class="text-sm text-gray-600 dark:text-gray-400">
                                    <?php echo e($alert->created_at->format('d/m/Y H:i')); ?>

                                </span>
                             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal7a6665ff7d6099983543eacca6edd279)): ?>
<?php $attributes = $__attributesOriginal7a6665ff7d6099983543eacca6edd279; ?>
<?php unset($__attributesOriginal7a6665ff7d6099983543eacca6edd279); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal7a6665ff7d6099983543eacca6edd279)): ?>
<?php $component = $__componentOriginal7a6665ff7d6099983543eacca6edd279; ?>
<?php unset($__componentOriginal7a6665ff7d6099983543eacca6edd279); ?>
<?php endif; ?>

                            <!-- Status -->
                            <?php if (isset($component)) { $__componentOriginal7a6665ff7d6099983543eacca6edd279 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7a6665ff7d6099983543eacca6edd279 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.tables.td','data' => ['class' => 'py-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tables.td'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'py-2']); ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($alert->isResolved()): ?>
                                    <span
                                        class="inline-flex items-center px-2 py-1 text-xs font-medium text-green-800 bg-green-100 rounded-full dark:bg-green-900/30 dark:text-green-300">
                                        Resolvido
                                    </span>
                                <?php elseif($alert->isRead()): ?>
                                    <span
                                        class="inline-flex items-center px-2 py-1 text-xs font-medium text-gray-800 bg-gray-100 rounded-full dark:bg-gray-700 dark:text-gray-300">
                                        Lido
                                    </span>
                                <?php else: ?>
                                    <span
                                        class="inline-flex items-center px-2 py-1 text-xs font-medium text-blue-800 bg-blue-100 rounded-full dark:bg-blue-900/30 dark:text-blue-300">
                                        Novo
                                    </span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal7a6665ff7d6099983543eacca6edd279)): ?>
<?php $attributes = $__attributesOriginal7a6665ff7d6099983543eacca6edd279; ?>
<?php unset($__attributesOriginal7a6665ff7d6099983543eacca6edd279); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal7a6665ff7d6099983543eacca6edd279)): ?>
<?php $component = $__componentOriginal7a6665ff7d6099983543eacca6edd279; ?>
<?php unset($__componentOriginal7a6665ff7d6099983543eacca6edd279); ?>
<?php endif; ?>

                            <!-- Actions -->
                            <?php if (isset($component)) { $__componentOriginal7a6665ff7d6099983543eacca6edd279 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7a6665ff7d6099983543eacca6edd279 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.tables.td','data' => ['class' => 'py-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tables.td'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'py-2']); ?>
                                <button wire:click="openDetails(<?php echo e($alert->id); ?>)"
                                    class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                        </path>
                                    </svg>
                                </button>
                             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal7a6665ff7d6099983543eacca6edd279)): ?>
<?php $attributes = $__attributesOriginal7a6665ff7d6099983543eacca6edd279; ?>
<?php unset($__attributesOriginal7a6665ff7d6099983543eacca6edd279); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal7a6665ff7d6099983543eacca6edd279)): ?>
<?php $component = $__componentOriginal7a6665ff7d6099983543eacca6edd279; ?>
<?php unset($__componentOriginal7a6665ff7d6099983543eacca6edd279); ?>
<?php endif; ?>
                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0afb9ddc62f38bdedc90bd74b54448d7)): ?>
<?php $attributes = $__attributesOriginal0afb9ddc62f38bdedc90bd74b54448d7; ?>
<?php unset($__attributesOriginal0afb9ddc62f38bdedc90bd74b54448d7); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0afb9ddc62f38bdedc90bd74b54448d7)): ?>
<?php $component = $__componentOriginal0afb9ddc62f38bdedc90bd74b54448d7; ?>
<?php unset($__componentOriginal0afb9ddc62f38bdedc90bd74b54448d7); ?>
<?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <?php if (isset($component)) { $__componentOriginal074a021b9d42f490272b5eefda63257c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal074a021b9d42f490272b5eefda63257c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.empty-state','data' => ['colspan' => '7','icon' => 'bell-alert','message' => 'Nenhum alerta encontrado','hint' => 'Os alertas serão exibidos aqui quando eventos importantes ocorrerem']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('empty-state'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['colspan' => '7','icon' => 'bell-alert','message' => 'Nenhum alerta encontrado','hint' => 'Os alertas serão exibidos aqui quando eventos importantes ocorrerem']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal074a021b9d42f490272b5eefda63257c)): ?>
<?php $attributes = $__attributesOriginal074a021b9d42f490272b5eefda63257c; ?>
<?php unset($__attributesOriginal074a021b9d42f490272b5eefda63257c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal074a021b9d42f490272b5eefda63257c)): ?>
<?php $component = $__componentOriginal074a021b9d42f490272b5eefda63257c; ?>
<?php unset($__componentOriginal074a021b9d42f490272b5eefda63257c); ?>
<?php endif; ?>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                 <?php $__env->endSlot(); ?>
             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal7fdb3552722b7d40f4be207e2e79dc5a)): ?>
<?php $attributes = $__attributesOriginal7fdb3552722b7d40f4be207e2e79dc5a; ?>
<?php unset($__attributesOriginal7fdb3552722b7d40f4be207e2e79dc5a); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal7fdb3552722b7d40f4be207e2e79dc5a)): ?>
<?php $component = $__componentOriginal7fdb3552722b7d40f4be207e2e79dc5a; ?>
<?php unset($__componentOriginal7fdb3552722b7d40f4be207e2e79dc5a); ?>
<?php endif; ?>
        </div>
    </div>

    <?php echo e($alerts->links('vendor.livewire.paginate')); ?>


    <?php echo $__env->make('livewire.alerts.filter', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('livewire.alerts.details', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</div>
<?php /**PATH C:\Users\Rafael Benedicto\Documents\Herd\asbc\resources\views/livewire/alerts/alerts-list.blade.php ENDPATH**/ ?>