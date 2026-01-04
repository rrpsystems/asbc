<div 
    class="flex flex-col min-h-[calc(100vh-4rem)] pb-3 pl-6 pr-6 bg-white dark:bg-gray-600 border border-gray-300 dark:border-gray-100 rounded-md shadow-md shadow-black/5">
    <div class="container flex-grow mx-auto">
        <div class="flex flex-col items-center justify-between my-4 sm:flex-row">
            <div>
                <h3 class="mb-2 text-2xl font-bold text-gray-800 dark:text-gray-200">Lista de CDRs</h3>

                <!-- Filtros Ativos -->
                <div class="flex flex-wrap gap-2 mt-2">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($filters['data_inicial']) && !empty($filters['data_final'])): ?>
                        <span class="inline-flex items-center gap-1 px-3 py-1 text-xs font-medium text-blue-700 bg-blue-100 rounded-full dark:bg-blue-900/30 dark:text-blue-400">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <?php echo e(date('d/m/Y', strtotime($filters['data_inicial']))); ?> - <?php echo e(date('d/m/Y', strtotime($filters['data_final']))); ?>

                        </span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($filters['customer']) && !in_array('All', $filters['customer'] ?? [])): ?>
                        <span class="inline-flex items-center gap-1 px-3 py-1 text-xs font-medium text-purple-700 bg-purple-100 rounded-full dark:bg-purple-900/30 dark:text-purple-400">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <?php echo e(count($filters['customer'])); ?> Cliente(s)
                        </span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($filters['tarifa']) && !in_array('All', $filters['tarifa'] ?? [])): ?>
                        <span class="inline-flex items-center gap-1 px-3 py-1 text-xs font-medium text-green-700 bg-green-100 rounded-full dark:bg-green-900/30 dark:text-green-400">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                            </svg>
                            <?php echo e(count($filters['tarifa'])); ?> Tarifa(s)
                        </span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($filters['numero'])): ?>
                        <span class="inline-flex items-center gap-1 px-3 py-1 text-xs font-medium text-orange-700 bg-orange-100 rounded-full dark:bg-orange-900/30 dark:text-orange-400">
                            Número: <?php echo e($filters['numero']); ?>

                            <button wire:click="$set('filters.numero', '')" class="ml-1">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                            </button>
                        </span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>

            <div class="flex gap-2 mt-4 sm:mt-0">
                <!-- Botão Exportar -->
                <div class="relative inline-block text-left" x-data="{ open: false }">
                    <button @click="open = !open" class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-white transition-all duration-200 bg-green-600 rounded-lg shadow-sm hover:bg-green-700 hover:shadow-md">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Exportar
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                    <div x-show="open" @click.away="open = false" class="absolute right-0 z-10 w-48 mt-2 origin-top-right bg-white divide-y divide-gray-100 rounded-md shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none dark:bg-gray-800" style="display: none;">
                        <div class="py-1">
                            <button wire:click="exportExcel" @click="open = false" class="flex items-center w-full gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700">
                                <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 2a2 2 0 00-2 2v8a2 2 0 002 2h6a2 2 0 002-2V6.414A2 2 0 0016.414 5L14 2.586A2 2 0 0012.586 2H9z"></path>
                                    <path d="M3 8a2 2 0 012-2v10h8a2 2 0 01-2 2H5a2 2 0 01-2-2V8z"></path>
                                </svg>
                                Excel (.xlsx)
                            </button>
                            <button wire:click="exportCsv" @click="open = false" class="flex items-center w-full gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700">
                                <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"></path>
                                </svg>
                                CSV (.csv)
                            </button>
                        </div>
                    </div>
                </div>

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
                <button wire:click="resetFilter" class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-gray-700 transition-all duration-200 bg-white border border-gray-300 rounded-lg shadow-sm hover:bg-gray-50 dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                    Limpar
                </button>
            </div>
        </div>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.tables.th','data' => ['label' => 'Data/Hora','column' => 'id','direction' => $direction,'sort' => $sort]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tables.th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Data/Hora','column' => 'id','direction' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($direction),'sort' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($sort)]); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.tables.th','data' => ['label' => 'DID','column' => 'did_id','direction' => $direction,'sort' => $sort]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tables.th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'DID','column' => 'did_id','direction' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($direction),'sort' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($sort)]); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.tables.th','data' => ['label' => 'Cliente','column' => 'customer_id','direction' => $direction,'sort' => $sort]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tables.th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Cliente','column' => 'customer_id','direction' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($direction),'sort' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($sort)]); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.tables.th','data' => ['label' => 'Numero','column' => 'numero','direction' => $direction,'sort' => $sort]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tables.th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Numero','column' => 'numero','direction' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($direction),'sort' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($sort)]); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.tables.th','data' => ['label' => 'Tarifa','column' => 'tarifa','direction' => $direction,'sort' => $sort]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tables.th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Tarifa','column' => 'tarifa','direction' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($direction),'sort' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($sort)]); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.tables.th','data' => ['label' => 'T. Cobra','column' => 'tempo_cobrado','direction' => $direction,'sort' => $sort]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tables.th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'T. Cobra','column' => 'tempo_cobrado','direction' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($direction),'sort' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($sort)]); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.tables.th','data' => ['label' => 'V. Compra','column' => 'valor_compra','direction' => $direction,'sort' => $sort]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tables.th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'V. Compra','column' => 'valor_compra','direction' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($direction),'sort' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($sort)]); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.tables.th','data' => ['label' => 'V. Venda','column' => 'valor_venda','direction' => $direction,'sort' => $sort]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tables.th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'V. Venda','column' => 'valor_venda','direction' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($direction),'sort' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($sort)]); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.tables.th','data' => ['label' => 'Ramal','column' => 'ramal','direction' => $direction,'sort' => $sort]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tables.th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Ramal','column' => 'ramal','direction' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($direction),'sort' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($sort)]); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.tables.th','data' => ['label' => 'Duração','column' => 'billsec','direction' => $direction,'sort' => $sort]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tables.th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Duração','column' => 'billsec','direction' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($direction),'sort' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($sort)]); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.tables.th','data' => ['label' => 'Desconexão','column' => 'desligamento','direction' => $direction,'sort' => $sort]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tables.th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Desconexão','column' => 'desligamento','direction' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($direction),'sort' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($sort)]); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.tables.th','data' => ['label' => 'status']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tables.th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'status']); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.tables.th','data' => ['label' => 'Detalhes']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tables.th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Detalhes']); ?>
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
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $cdrs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cdr): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <?php if (isset($component)) { $__componentOriginal0afb9ddc62f38bdedc90bd74b54448d7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0afb9ddc62f38bdedc90bd74b54448d7 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.tables.tr','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tables.tr'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
                            <?php if (isset($component)) { $__componentOriginal7a6665ff7d6099983543eacca6edd279 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7a6665ff7d6099983543eacca6edd279 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.tables.td','data' => ['class' => 'py-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tables.td'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'py-2']); ?><?php echo e(date('d/m/Y H:i', strtotime($cdr->calldate))); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal7a6665ff7d6099983543eacca6edd279)): ?>
<?php $attributes = $__attributesOriginal7a6665ff7d6099983543eacca6edd279; ?>
<?php unset($__attributesOriginal7a6665ff7d6099983543eacca6edd279); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal7a6665ff7d6099983543eacca6edd279)): ?>
<?php $component = $__componentOriginal7a6665ff7d6099983543eacca6edd279; ?>
<?php unset($__componentOriginal7a6665ff7d6099983543eacca6edd279); ?>
<?php endif; ?>

                            <?php if (isset($component)) { $__componentOriginal7a6665ff7d6099983543eacca6edd279 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7a6665ff7d6099983543eacca6edd279 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.tables.td','data' => ['class' => 'py-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tables.td'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'py-2']); ?><?php echo e($cdr->did_id); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal7a6665ff7d6099983543eacca6edd279)): ?>
<?php $attributes = $__attributesOriginal7a6665ff7d6099983543eacca6edd279; ?>
<?php unset($__attributesOriginal7a6665ff7d6099983543eacca6edd279); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal7a6665ff7d6099983543eacca6edd279)): ?>
<?php $component = $__componentOriginal7a6665ff7d6099983543eacca6edd279; ?>
<?php unset($__componentOriginal7a6665ff7d6099983543eacca6edd279); ?>
<?php endif; ?>

                            <?php if (isset($component)) { $__componentOriginal7a6665ff7d6099983543eacca6edd279 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7a6665ff7d6099983543eacca6edd279 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.tables.td','data' => ['class' => 'py-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tables.td'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'py-2']); ?><?php echo e(Str::limit($cdr->customer->razaosocial ?? $cdr->customer_id, 20)); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal7a6665ff7d6099983543eacca6edd279)): ?>
<?php $attributes = $__attributesOriginal7a6665ff7d6099983543eacca6edd279; ?>
<?php unset($__attributesOriginal7a6665ff7d6099983543eacca6edd279); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal7a6665ff7d6099983543eacca6edd279)): ?>
<?php $component = $__componentOriginal7a6665ff7d6099983543eacca6edd279; ?>
<?php unset($__componentOriginal7a6665ff7d6099983543eacca6edd279); ?>
<?php endif; ?>

                            <?php if (isset($component)) { $__componentOriginal7a6665ff7d6099983543eacca6edd279 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7a6665ff7d6099983543eacca6edd279 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.tables.td','data' => ['class' => 'py-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tables.td'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'py-2']); ?><?php echo e(format_phone($cdr->attributes['numero'] ?? $cdr->numero, $cdr->tarifa)); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal7a6665ff7d6099983543eacca6edd279)): ?>
<?php $attributes = $__attributesOriginal7a6665ff7d6099983543eacca6edd279; ?>
<?php unset($__attributesOriginal7a6665ff7d6099983543eacca6edd279); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal7a6665ff7d6099983543eacca6edd279)): ?>
<?php $component = $__componentOriginal7a6665ff7d6099983543eacca6edd279; ?>
<?php unset($__componentOriginal7a6665ff7d6099983543eacca6edd279); ?>
<?php endif; ?>

                            <?php if (isset($component)) { $__componentOriginal7a6665ff7d6099983543eacca6edd279 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7a6665ff7d6099983543eacca6edd279 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.tables.td','data' => ['class' => 'py-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tables.td'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'py-2']); ?><?php echo e($cdr->tarifa); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal7a6665ff7d6099983543eacca6edd279)): ?>
<?php $attributes = $__attributesOriginal7a6665ff7d6099983543eacca6edd279; ?>
<?php unset($__attributesOriginal7a6665ff7d6099983543eacca6edd279); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal7a6665ff7d6099983543eacca6edd279)): ?>
<?php $component = $__componentOriginal7a6665ff7d6099983543eacca6edd279; ?>
<?php unset($__componentOriginal7a6665ff7d6099983543eacca6edd279); ?>
<?php endif; ?>
                            <?php if (isset($component)) { $__componentOriginal7a6665ff7d6099983543eacca6edd279 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7a6665ff7d6099983543eacca6edd279 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.tables.td','data' => ['class' => 'py-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tables.td'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'py-2']); ?><?php echo e(\Carbon\Carbon::createFromFormat('U', $cdr->tempo_cobrado ?? '0')->format('H:i:s')); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal7a6665ff7d6099983543eacca6edd279)): ?>
<?php $attributes = $__attributesOriginal7a6665ff7d6099983543eacca6edd279; ?>
<?php unset($__attributesOriginal7a6665ff7d6099983543eacca6edd279); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal7a6665ff7d6099983543eacca6edd279)): ?>
<?php $component = $__componentOriginal7a6665ff7d6099983543eacca6edd279; ?>
<?php unset($__componentOriginal7a6665ff7d6099983543eacca6edd279); ?>
<?php endif; ?>
                            <?php if (isset($component)) { $__componentOriginal7a6665ff7d6099983543eacca6edd279 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7a6665ff7d6099983543eacca6edd279 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.tables.td','data' => ['class' => 'py-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tables.td'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'py-2']); ?><?php echo e(number_format($cdr->valor_compra ?? '0', 3, ',', '.')); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal7a6665ff7d6099983543eacca6edd279)): ?>
<?php $attributes = $__attributesOriginal7a6665ff7d6099983543eacca6edd279; ?>
<?php unset($__attributesOriginal7a6665ff7d6099983543eacca6edd279); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal7a6665ff7d6099983543eacca6edd279)): ?>
<?php $component = $__componentOriginal7a6665ff7d6099983543eacca6edd279; ?>
<?php unset($__componentOriginal7a6665ff7d6099983543eacca6edd279); ?>
<?php endif; ?>
                            <?php if (isset($component)) { $__componentOriginal7a6665ff7d6099983543eacca6edd279 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7a6665ff7d6099983543eacca6edd279 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.tables.td','data' => ['class' => 'py-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tables.td'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'py-2']); ?><?php echo e(number_format($cdr->valor_venda ?? '0', 3, ',', '.')); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal7a6665ff7d6099983543eacca6edd279)): ?>
<?php $attributes = $__attributesOriginal7a6665ff7d6099983543eacca6edd279; ?>
<?php unset($__attributesOriginal7a6665ff7d6099983543eacca6edd279); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal7a6665ff7d6099983543eacca6edd279)): ?>
<?php $component = $__componentOriginal7a6665ff7d6099983543eacca6edd279; ?>
<?php unset($__componentOriginal7a6665ff7d6099983543eacca6edd279); ?>
<?php endif; ?>

                            <?php if (isset($component)) { $__componentOriginal7a6665ff7d6099983543eacca6edd279 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7a6665ff7d6099983543eacca6edd279 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.tables.td','data' => ['class' => 'py-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tables.td'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'py-2']); ?><?php echo e($cdr->ramal); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal7a6665ff7d6099983543eacca6edd279)): ?>
<?php $attributes = $__attributesOriginal7a6665ff7d6099983543eacca6edd279; ?>
<?php unset($__attributesOriginal7a6665ff7d6099983543eacca6edd279); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal7a6665ff7d6099983543eacca6edd279)): ?>
<?php $component = $__componentOriginal7a6665ff7d6099983543eacca6edd279; ?>
<?php unset($__componentOriginal7a6665ff7d6099983543eacca6edd279); ?>
<?php endif; ?>

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
                                <?php echo e(\Carbon\Carbon::createFromFormat('U', $cdr->billsec ?? '0')->format('H:i:s')); ?>

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

                            <?php if (isset($component)) { $__componentOriginal7a6665ff7d6099983543eacca6edd279 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7a6665ff7d6099983543eacca6edd279 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.tables.td','data' => ['class' => 'py-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tables.td'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'py-2']); ?><?php echo e($cdr->desligamento); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal7a6665ff7d6099983543eacca6edd279)): ?>
<?php $attributes = $__attributesOriginal7a6665ff7d6099983543eacca6edd279; ?>
<?php unset($__attributesOriginal7a6665ff7d6099983543eacca6edd279); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal7a6665ff7d6099983543eacca6edd279)): ?>
<?php $component = $__componentOriginal7a6665ff7d6099983543eacca6edd279; ?>
<?php unset($__componentOriginal7a6665ff7d6099983543eacca6edd279); ?>
<?php endif; ?>

                            <?php if (isset($component)) { $__componentOriginal7a6665ff7d6099983543eacca6edd279 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7a6665ff7d6099983543eacca6edd279 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.tables.td','data' => ['class' => 'py-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tables.td'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'py-2']); ?><?php echo e($cdr->status); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal7a6665ff7d6099983543eacca6edd279)): ?>
<?php $attributes = $__attributesOriginal7a6665ff7d6099983543eacca6edd279; ?>
<?php unset($__attributesOriginal7a6665ff7d6099983543eacca6edd279); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal7a6665ff7d6099983543eacca6edd279)): ?>
<?php $component = $__componentOriginal7a6665ff7d6099983543eacca6edd279; ?>
<?php unset($__componentOriginal7a6665ff7d6099983543eacca6edd279); ?>
<?php endif; ?>
                            <?php if (isset($component)) { $__componentOriginal7a6665ff7d6099983543eacca6edd279 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7a6665ff7d6099983543eacca6edd279 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.tables.td','data' => ['class' => 'py-2','wire:click' => 'openDetails('.e($cdr->id).')','wire:key' => ''.e($cdr->uniqueid).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tables.td'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'py-2','wire:click' => 'openDetails('.e($cdr->id).')','wire:key' => ''.e($cdr->uniqueid).'']); ?>
                                <?php if (isset($component)) { $__componentOriginalcf0c10903472319464d99a08725e554d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalcf0c10903472319464d99a08725e554d = $attributes; } ?>
<?php $component = TallStackUi\View\Components\Icon::resolve(['name' => 'eye'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui-icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\TallStackUi\View\Components\Icon::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-5 h-5 cursor-pointer hover:text-gray-100 dark:hover:text-blue-500']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalcf0c10903472319464d99a08725e554d)): ?>
<?php $attributes = $__attributesOriginalcf0c10903472319464d99a08725e554d; ?>
<?php unset($__attributesOriginalcf0c10903472319464d99a08725e554d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalcf0c10903472319464d99a08725e554d)): ?>
<?php $component = $__componentOriginalcf0c10903472319464d99a08725e554d; ?>
<?php unset($__componentOriginalcf0c10903472319464d99a08725e554d); ?>
<?php endif; ?> <?php echo $__env->renderComponent(); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.empty-state','data' => ['colspan' => '7','icon' => 'phone','message' => 'Nenhum CDR encontrado','hint' => 'Tente ajustar os filtros de busca ou período']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('empty-state'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['colspan' => '7','icon' => 'phone','message' => 'Nenhum CDR encontrado','hint' => 'Tente ajustar os filtros de busca ou período']); ?>
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
    <?php echo e($cdrs->links('vendor.livewire.paginate')); ?>

    <?php echo $__env->make('livewire.cdrs.filter', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <?php echo $__env->make('livewire.cdrs.details', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</div><?php /**PATH C:\Users\Rafael Benedicto\Documents\Herd\asbc\resources\views/livewire/cdrs/index.blade.php ENDPATH**/ ?>