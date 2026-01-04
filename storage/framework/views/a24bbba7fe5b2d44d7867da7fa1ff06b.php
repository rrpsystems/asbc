<div
    class="flex flex-col min-h-[calc(100vh-4rem)] pb-3 pl-6 pr-6 bg-white dark:bg-gray-600 border border-gray-300 dark:border-gray-100 rounded-md shadow-md shadow-black/5">
    <div class="container flex-grow mx-auto">
        <div class="flex flex-col items-center justify-between my-4 sm:flex-row">
            <h3 class="mb-4 text-2xl font-bold text-gray-800 dark:text-gray-200 sm:mb-0">Lista de Operadoras</h3>
            <div class="flex flex-wrap gap-2 mt-4 sm:mt-0">
                <button wire:click="clearFilters"
                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600 dark:hover:bg-gray-600">
                    <?php if (isset($component)) { $__componentOriginalcf0c10903472319464d99a08725e554d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalcf0c10903472319464d99a08725e554d = $attributes; } ?>
<?php $component = TallStackUi\View\Components\Icon::resolve(['name' => 'x-mark'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui-icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\TallStackUi\View\Components\Icon::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-4 h-4 mr-2']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalcf0c10903472319464d99a08725e554d)): ?>
<?php $attributes = $__attributesOriginalcf0c10903472319464d99a08725e554d; ?>
<?php unset($__attributesOriginalcf0c10903472319464d99a08725e554d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalcf0c10903472319464d99a08725e554d)): ?>
<?php $component = $__componentOriginalcf0c10903472319464d99a08725e554d; ?>
<?php unset($__componentOriginalcf0c10903472319464d99a08725e554d); ?>
<?php endif; ?>
                    Limpar
                </button>
                <button wire:click="openFilterModal"
                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600 dark:hover:bg-gray-600">
                    <?php if (isset($component)) { $__componentOriginalcf0c10903472319464d99a08725e554d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalcf0c10903472319464d99a08725e554d = $attributes; } ?>
<?php $component = TallStackUi\View\Components\Icon::resolve(['name' => 'adjustments-horizontal'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui-icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\TallStackUi\View\Components\Icon::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-4 h-4 mr-2']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalcf0c10903472319464d99a08725e554d)): ?>
<?php $attributes = $__attributesOriginalcf0c10903472319464d99a08725e554d; ?>
<?php unset($__attributesOriginalcf0c10903472319464d99a08725e554d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalcf0c10903472319464d99a08725e554d)): ?>
<?php $component = $__componentOriginalcf0c10903472319464d99a08725e554d; ?>
<?php unset($__componentOriginalcf0c10903472319464d99a08725e554d); ?>
<?php endif; ?>
                    Filtros
                </button>
                <?php if (isset($component)) { $__componentOriginal973402a8b59140e32bbb0552a9b42959 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal973402a8b59140e32bbb0552a9b42959 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.buttons.group','data' => ['btnCreate' => 'carrier-create']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('buttons.group'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['btnCreate' => 'carrier-create']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal973402a8b59140e32bbb0552a9b42959)): ?>
<?php $attributes = $__attributesOriginal973402a8b59140e32bbb0552a9b42959; ?>
<?php unset($__attributesOriginal973402a8b59140e32bbb0552a9b42959); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal973402a8b59140e32bbb0552a9b42959)): ?>
<?php $component = $__componentOriginal973402a8b59140e32bbb0552a9b42959; ?>
<?php unset($__componentOriginal973402a8b59140e32bbb0552a9b42959); ?>
<?php endif; ?>
            </div>
        </div>

        
        <div class="grid grid-cols-1 gap-4 mb-6 md:grid-cols-2 lg:grid-cols-4">
            
            <div class="relative overflow-hidden bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg shadow-lg">
                <div class="p-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-blue-100">Total de Operadoras</p>
                            <p class="text-3xl font-bold text-white"><?php echo e(number_format($stats->total, 0, ',', '.')); ?></p>
                        </div>
                        <div class="p-3 bg-white bg-opacity-30 rounded-lg">
                            <?php if (isset($component)) { $__componentOriginalcf0c10903472319464d99a08725e554d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalcf0c10903472319464d99a08725e554d = $attributes; } ?>
<?php $component = TallStackUi\View\Components\Icon::resolve(['name' => 'building-office-2'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui-icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\TallStackUi\View\Components\Icon::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-8 h-8 text-white']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalcf0c10903472319464d99a08725e554d)): ?>
<?php $attributes = $__attributesOriginalcf0c10903472319464d99a08725e554d; ?>
<?php unset($__attributesOriginalcf0c10903472319464d99a08725e554d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalcf0c10903472319464d99a08725e554d)): ?>
<?php $component = $__componentOriginalcf0c10903472319464d99a08725e554d; ?>
<?php unset($__componentOriginalcf0c10903472319464d99a08725e554d); ?>
<?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="relative overflow-hidden bg-gradient-to-br from-green-500 to-green-600 rounded-lg shadow-lg">
                <div class="p-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-green-100">Operadoras Ativas</p>
                            <p class="text-3xl font-bold text-white"><?php echo e(number_format($stats->ativos, 0, ',', '.')); ?></p>
                        </div>
                        <div class="p-3 bg-white bg-opacity-30 rounded-lg">
                            <?php if (isset($component)) { $__componentOriginalcf0c10903472319464d99a08725e554d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalcf0c10903472319464d99a08725e554d = $attributes; } ?>
<?php $component = TallStackUi\View\Components\Icon::resolve(['name' => 'check-circle'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui-icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\TallStackUi\View\Components\Icon::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-8 h-8 text-white']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalcf0c10903472319464d99a08725e554d)): ?>
<?php $attributes = $__attributesOriginalcf0c10903472319464d99a08725e554d; ?>
<?php unset($__attributesOriginalcf0c10903472319464d99a08725e554d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalcf0c10903472319464d99a08725e554d)): ?>
<?php $component = $__componentOriginalcf0c10903472319464d99a08725e554d; ?>
<?php unset($__componentOriginalcf0c10903472319464d99a08725e554d); ?>
<?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="relative overflow-hidden bg-gradient-to-br from-red-500 to-red-600 rounded-lg shadow-lg">
                <div class="p-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-red-100">Operadoras Inativas</p>
                            <p class="text-3xl font-bold text-white"><?php echo e(number_format($stats->inativos, 0, ',', '.')); ?></p>
                        </div>
                        <div class="p-3 bg-white bg-opacity-30 rounded-lg">
                            <?php if (isset($component)) { $__componentOriginalcf0c10903472319464d99a08725e554d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalcf0c10903472319464d99a08725e554d = $attributes; } ?>
<?php $component = TallStackUi\View\Components\Icon::resolve(['name' => 'x-circle'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui-icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\TallStackUi\View\Components\Icon::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-8 h-8 text-white']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalcf0c10903472319464d99a08725e554d)): ?>
<?php $attributes = $__attributesOriginalcf0c10903472319464d99a08725e554d; ?>
<?php unset($__attributesOriginalcf0c10903472319464d99a08725e554d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalcf0c10903472319464d99a08725e554d)): ?>
<?php $component = $__componentOriginalcf0c10903472319464d99a08725e554d; ?>
<?php unset($__componentOriginalcf0c10903472319464d99a08725e554d); ?>
<?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="relative overflow-hidden bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg shadow-lg">
                <div class="p-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-purple-100">Total de Canais Ativos</p>
                            <p class="text-3xl font-bold text-white"><?php echo e(number_format($stats->canais_total, 0, ',', '.')); ?></p>
                        </div>
                        <div class="p-3 bg-white bg-opacity-30 rounded-lg">
                            <?php if (isset($component)) { $__componentOriginalcf0c10903472319464d99a08725e554d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalcf0c10903472319464d99a08725e554d = $attributes; } ?>
<?php $component = TallStackUi\View\Components\Icon::resolve(['name' => 'signal'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui-icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\TallStackUi\View\Components\Icon::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-8 h-8 text-white']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalcf0c10903472319464d99a08725e554d)): ?>
<?php $attributes = $__attributesOriginalcf0c10903472319464d99a08725e554d; ?>
<?php unset($__attributesOriginalcf0c10903472319464d99a08725e554d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalcf0c10903472319464d99a08725e554d)): ?>
<?php $component = $__componentOriginalcf0c10903472319464d99a08725e554d; ?>
<?php unset($__componentOriginalcf0c10903472319464d99a08725e554d); ?>
<?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        
        <?php if (isset($component)) { $__componentOriginal93360b397272e82c601608cfc5cba0d9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal93360b397272e82c601608cfc5cba0d9 = $attributes; } ?>
<?php $component = TallStackUi\View\Components\Modal::resolve(['wire' => 'filterModal','size' => 'xl'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui-modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\TallStackUi\View\Components\Modal::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
             <?php $__env->slot('title', null, []); ?> 
                <span class="text-xl font-bold">Filtros Avançados</span>
             <?php $__env->endSlot(); ?>

            <div class="space-y-4">
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Status</label>
                        <select wire:model.live="filterStatus"
                            class="w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-cyan-500">
                            <option value="">Todos</option>
                            <option value="1">Ativos</option>
                            <option value="0">Inativos</option>
                        </select>
                    </div>

                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Franquia Compartilhada</label>
                        <select wire:model.live="filterFranquiaCompartilhada"
                            class="w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-cyan-500">
                            <option value="">Todos</option>
                            <option value="1">Sim</option>
                            <option value="0">Não</option>
                        </select>
                    </div>
                </div>
            </div>

             <?php $__env->slot('footer', null, []); ?> 
                <div class="flex justify-end gap-2">
                    <?php if (isset($component)) { $__componentOriginal5266464ff7b66ba0b126f4b6bc32a5f5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5266464ff7b66ba0b126f4b6bc32a5f5 = $attributes; } ?>
<?php $component = TallStackUi\View\Components\Button\Button::resolve(['color' => 'stone'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\TallStackUi\View\Components\Button\Button::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:click' => '$set(\'filterModal\', false)']); ?>
                        Fechar
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5266464ff7b66ba0b126f4b6bc32a5f5)): ?>
<?php $attributes = $__attributesOriginal5266464ff7b66ba0b126f4b6bc32a5f5; ?>
<?php unset($__attributesOriginal5266464ff7b66ba0b126f4b6bc32a5f5); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5266464ff7b66ba0b126f4b6bc32a5f5)): ?>
<?php $component = $__componentOriginal5266464ff7b66ba0b126f4b6bc32a5f5; ?>
<?php unset($__componentOriginal5266464ff7b66ba0b126f4b6bc32a5f5); ?>
<?php endif; ?>
                    <?php if (isset($component)) { $__componentOriginal5266464ff7b66ba0b126f4b6bc32a5f5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5266464ff7b66ba0b126f4b6bc32a5f5 = $attributes; } ?>
<?php $component = TallStackUi\View\Components\Button\Button::resolve(['color' => 'red'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\TallStackUi\View\Components\Button\Button::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:click' => 'clearFilters']); ?>
                        Limpar Filtros
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5266464ff7b66ba0b126f4b6bc32a5f5)): ?>
<?php $attributes = $__attributesOriginal5266464ff7b66ba0b126f4b6bc32a5f5; ?>
<?php unset($__attributesOriginal5266464ff7b66ba0b126f4b6bc32a5f5); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5266464ff7b66ba0b126f4b6bc32a5f5)): ?>
<?php $component = $__componentOriginal5266464ff7b66ba0b126f4b6bc32a5f5; ?>
<?php unset($__componentOriginal5266464ff7b66ba0b126f4b6bc32a5f5); ?>
<?php endif; ?>
                </div>
             <?php $__env->endSlot(); ?>
         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal93360b397272e82c601608cfc5cba0d9)): ?>
<?php $attributes = $__attributesOriginal93360b397272e82c601608cfc5cba0d9; ?>
<?php unset($__attributesOriginal93360b397272e82c601608cfc5cba0d9); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal93360b397272e82c601608cfc5cba0d9)): ?>
<?php $component = $__componentOriginal93360b397272e82c601608cfc5cba0d9; ?>
<?php unset($__componentOriginal93360b397272e82c601608cfc5cba0d9); ?>
<?php endif; ?>

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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.tables.th','data' => ['label' => 'Contrato','column' => 'id','direction' => $direction,'sort' => $sort]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tables.th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Contrato','column' => 'id','direction' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($direction),'sort' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($sort)]); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.tables.th','data' => ['label' => 'Operadora','column' => 'operadora','direction' => $direction,'sort' => $sort]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tables.th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Operadora','column' => 'operadora','direction' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($direction),'sort' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($sort)]); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.tables.th','data' => ['label' => 'Proxy/Porta']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tables.th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Proxy/Porta']); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.tables.th','data' => ['label' => 'Canais','column' => 'canais','direction' => $direction,'sort' => $sort]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tables.th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Canais','column' => 'canais','direction' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($direction),'sort' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($sort)]); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.tables.th','data' => ['label' => 'Valor Mensal','column' => 'valor_plano_mensal','direction' => $direction,'sort' => $sort]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tables.th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Valor Mensal','column' => 'valor_plano_mensal','direction' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($direction),'sort' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($sort)]); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.tables.th','data' => ['label' => 'Data Inicial','column' => 'data_inicio','direction' => $direction,'sort' => $sort]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tables.th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Data Inicial','column' => 'data_inicio','direction' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($direction),'sort' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($sort)]); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.tables.th','data' => ['label' => 'Status','column' => 'ativo','direction' => $direction,'sort' => $sort]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tables.th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Status','column' => 'ativo','direction' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($direction),'sort' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($sort)]); ?>
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
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $carriers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $carrier): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
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
<?php $component->withAttributes(['class' => 'py-2']); ?>
                                <span class="font-semibold text-gray-700 dark:text-gray-300"><?php echo e($carrier->id); ?></span>
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
<?php $component->withAttributes(['class' => 'py-2']); ?>
                                <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                    <?php echo e($carrier->operadora); ?>

                                </div>
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
<?php $component->withAttributes(['class' => 'py-2']); ?>
                                <div class="text-sm">
                                    <div class="font-mono text-gray-900 dark:text-gray-100"><?php echo e($carrier->proxy); ?></div>
                                    <div class="text-gray-500 dark:text-gray-400">Porta: <?php echo e($carrier->porta); ?></div>
                                </div>
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
<?php $component->withAttributes(['class' => 'py-2']); ?>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                    <?php echo e($carrier->canais); ?> canais
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
                                <div class="text-sm">
                                    <div class="font-semibold text-green-600 dark:text-green-400">
                                        R$ <?php echo e(number_format($carrier->valor_plano_mensal, 2, ',', '.')); ?>

                                    </div>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($carrier->franquia_compartilhada): ?>
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200">
                                            <?php if (isset($component)) { $__componentOriginalcf0c10903472319464d99a08725e554d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalcf0c10903472319464d99a08725e554d = $attributes; } ?>
<?php $component = TallStackUi\View\Components\Icon::resolve(['name' => 'share'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui-icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\TallStackUi\View\Components\Icon::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-3 h-3 mr-1']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalcf0c10903472319464d99a08725e554d)): ?>
<?php $attributes = $__attributesOriginalcf0c10903472319464d99a08725e554d; ?>
<?php unset($__attributesOriginalcf0c10903472319464d99a08725e554d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalcf0c10903472319464d99a08725e554d)): ?>
<?php $component = $__componentOriginalcf0c10903472319464d99a08725e554d; ?>
<?php unset($__componentOriginalcf0c10903472319464d99a08725e554d); ?>
<?php endif; ?>
                                            Franquia Compartilhada
                                        </span>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
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
<?php $component->withAttributes(['class' => 'py-2']); ?>
                                <span class="text-sm text-gray-700 dark:text-gray-300">
                                    <?php echo e(date('d/m/Y', strtotime($carrier->data_inicio))); ?>

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
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($carrier->ativo): ?>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                        <?php if (isset($component)) { $__componentOriginalcf0c10903472319464d99a08725e554d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalcf0c10903472319464d99a08725e554d = $attributes; } ?>
<?php $component = TallStackUi\View\Components\Icon::resolve(['name' => 'check-circle'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui-icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\TallStackUi\View\Components\Icon::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-3 h-3 mr-1']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalcf0c10903472319464d99a08725e554d)): ?>
<?php $attributes = $__attributesOriginalcf0c10903472319464d99a08725e554d; ?>
<?php unset($__attributesOriginalcf0c10903472319464d99a08725e554d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalcf0c10903472319464d99a08725e554d)): ?>
<?php $component = $__componentOriginalcf0c10903472319464d99a08725e554d; ?>
<?php unset($__componentOriginalcf0c10903472319464d99a08725e554d); ?>
<?php endif; ?>
                                        Ativo
                                    </span>
                                <?php else: ?>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                        <?php if (isset($component)) { $__componentOriginalcf0c10903472319464d99a08725e554d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalcf0c10903472319464d99a08725e554d = $attributes; } ?>
<?php $component = TallStackUi\View\Components\Icon::resolve(['name' => 'x-circle'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui-icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\TallStackUi\View\Components\Icon::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-3 h-3 mr-1']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalcf0c10903472319464d99a08725e554d)): ?>
<?php $attributes = $__attributesOriginalcf0c10903472319464d99a08725e554d; ?>
<?php unset($__attributesOriginalcf0c10903472319464d99a08725e554d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalcf0c10903472319464d99a08725e554d)): ?>
<?php $component = $__componentOriginalcf0c10903472319464d99a08725e554d; ?>
<?php unset($__componentOriginalcf0c10903472319464d99a08725e554d); ?>
<?php endif; ?>
                                        Inativo
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
                            <?php if (isset($component)) { $__componentOriginal7a6665ff7d6099983543eacca6edd279 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7a6665ff7d6099983543eacca6edd279 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.tables.td','data' => ['class' => 'py-0']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tables.td'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'py-0']); ?>

                                <span x-on:click="$dispatch('carrier-update', <?php echo e($carrier); ?>)"
                                    wire:key='update-<?php echo e($carrier->id); ?>'
                                    class="inline-flex items-center font-medium text-yellow-500 transition cursor-pointer hover:text-yellow-700 duration- dark:text-yellow-500">
                                    <?php if (isset($component)) { $__componentOriginalcf0c10903472319464d99a08725e554d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalcf0c10903472319464d99a08725e554d = $attributes; } ?>
<?php $component = TallStackUi\View\Components\Icon::resolve(['name' => 'pencil-square'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui-icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\TallStackUi\View\Components\Icon::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-5 h-5 m-0']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalcf0c10903472319464d99a08725e554d)): ?>
<?php $attributes = $__attributesOriginalcf0c10903472319464d99a08725e554d; ?>
<?php unset($__attributesOriginalcf0c10903472319464d99a08725e554d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalcf0c10903472319464d99a08725e554d)): ?>
<?php $component = $__componentOriginalcf0c10903472319464d99a08725e554d; ?>
<?php unset($__componentOriginalcf0c10903472319464d99a08725e554d); ?>
<?php endif; ?>
                                    <span class="ml-1">Editar</span>
                                </span>

                                <span x-on:click="$dispatch('carrier-delete', <?php echo e($carrier); ?>)"
                                    wire:key='delete-<?php echo e($carrier->id); ?>'
                                    class="inline-flex items-center ml-4 font-medium text-red-500 transition cursor-pointer hover:text-red-700 duration- dark:text-red-500">
                                    <?php if (isset($component)) { $__componentOriginalcf0c10903472319464d99a08725e554d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalcf0c10903472319464d99a08725e554d = $attributes; } ?>
<?php $component = TallStackUi\View\Components\Icon::resolve(['name' => 'trash'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui-icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\TallStackUi\View\Components\Icon::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-5 h-5 m-0']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalcf0c10903472319464d99a08725e554d)): ?>
<?php $attributes = $__attributesOriginalcf0c10903472319464d99a08725e554d; ?>
<?php unset($__attributesOriginalcf0c10903472319464d99a08725e554d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalcf0c10903472319464d99a08725e554d)): ?>
<?php $component = $__componentOriginalcf0c10903472319464d99a08725e554d; ?>
<?php unset($__componentOriginalcf0c10903472319464d99a08725e554d); ?>
<?php endif; ?>
                                    <span class="ml-1">Excluir</span>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.empty-state','data' => ['colspan' => '8','icon' => 'building-office-2','message' => 'Nenhuma operadora encontrada','hint' => 'Tente ajustar os filtros ou cadastrar uma nova operadora']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('empty-state'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['colspan' => '8','icon' => 'building-office-2','message' => 'Nenhuma operadora encontrada','hint' => 'Tente ajustar os filtros ou cadastrar uma nova operadora']); ?>
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
    <?php echo e($carriers->links('vendor.livewire.paginate')); ?>

    <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('carriers.create', []);

$key = null;

$key ??= \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::generateKey('lw-991184762-0', null);

$__html = app('livewire')->mount($__name, $__params, $key);

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
    <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('carriers.update', []);

$key = null;

$key ??= \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::generateKey('lw-991184762-1', null);

$__html = app('livewire')->mount($__name, $__params, $key);

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
    <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('carriers.delete', []);

$key = null;

$key ??= \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::generateKey('lw-991184762-2', null);

$__html = app('livewire')->mount($__name, $__params, $key);

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
</div>
<?php /**PATH C:\Users\Rafael Benedicto\Documents\Herd\asbc\resources\views/livewire/carriers/index.blade.php ENDPATH**/ ?>