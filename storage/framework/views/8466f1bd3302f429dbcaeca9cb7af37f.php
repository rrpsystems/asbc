<div
    class="flex flex-col min-h-[calc(100vh-4rem)] pb-3 pl-6 pr-6 bg-white dark:bg-gray-600 border border-gray-300 dark:border-gray-100 rounded-md shadow-md shadow-black/5">
    <div x-init="$dispatch('bradcrumb', { menu: ['Relatórios', 'Faturas', '<?php echo e($customer->nomefantasia ?? $customer->razaosocial); ?>'] })"></div>

    <div class="container flex-grow mx-auto">
        <!-- Header com botão voltar -->
        <div class="flex flex-col items-center justify-between my-4 sm:flex-row">
            <div class="flex items-center gap-4 mb-4 sm:mb-0">
                <a href="<?php echo e(route('customers.invoices.list')); ?>"
                   class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-600">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Voltar
                </a>
                <h3 class="text-2xl font-bold text-gray-800 dark:text-gray-200">
                    Faturas - <?php echo e($customer->nomefantasia ?? $customer->razaosocial); ?>

                </h3>
            </div>
            <button wire:click="refresh" class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-white transition-all duration-200 bg-blue-600 rounded-lg shadow-sm hover:bg-blue-700 hover:shadow-md">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
                Atualizar
            </button>
        </div>

        <!-- Cards de Estatísticas do Cliente -->
        <div class="grid grid-cols-1 gap-4 mb-6 md:grid-cols-2 lg:grid-cols-5">
            <!-- Total de Faturas -->
            <div class="p-4 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-lg shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-indigo-100">Total de Faturas</p>
                        <p class="text-2xl font-bold text-white"><?php echo e($totalFaturas); ?></p>
                    </div>
                    <div class="p-3 bg-white bg-opacity-20 rounded-full">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Faturas Abertas -->
            <div class="p-4 bg-gradient-to-br from-orange-500 to-orange-600 rounded-lg shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-orange-100">Abertas</p>
                        <p class="text-2xl font-bold text-white"><?php echo e($faturasAbertas); ?></p>
                    </div>
                    <div class="p-3 bg-white bg-opacity-20 rounded-full">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Faturas Fechadas -->
            <div class="p-4 bg-gradient-to-br from-teal-500 to-teal-600 rounded-lg shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-teal-100">Fechadas</p>
                        <p class="text-2xl font-bold text-white"><?php echo e($faturasFechadas); ?></p>
                    </div>
                    <div class="p-3 bg-white bg-opacity-20 rounded-full">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Receita Total -->
            <div class="p-4 bg-gradient-to-br from-green-500 to-green-600 rounded-lg shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-green-100">Receita Total</p>
                        <p class="text-xl font-bold text-white">R$ <?php echo e(number_format($receitaTotal, 2, ',', '.')); ?></p>
                    </div>
                    <div class="p-3 bg-white bg-opacity-20 rounded-full">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Média por Fatura -->
            <div class="p-4 bg-gradient-to-br from-cyan-500 to-cyan-600 rounded-lg shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-cyan-100">Média/Fatura</p>
                        <p class="text-xl font-bold text-white">R$ <?php echo e(number_format($mediaFatura, 2, ',', '.')); ?></p>
                    </div>
                    <div class="p-3 bg-white bg-opacity-20 rounded-full">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                </div>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.tables.th','data' => ['label' => 'Fatura','column' => 'id','direction' => $direction,'sort' => $sort]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tables.th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Fatura','column' => 'id','direction' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($direction),'sort' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($sort)]); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.tables.th','data' => ['label' => 'Competência']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tables.th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Competência']); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.tables.th','data' => ['label' => 'Vencimento']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tables.th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Vencimento']); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.tables.th','data' => ['label' => 'Plano (R$)']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tables.th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Plano (R$)']); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.tables.th','data' => ['label' => 'Excedente (R$)']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tables.th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Excedente (R$)']); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.tables.th','data' => ['label' => 'Total (R$)','column' => 'custo_total','direction' => $direction,'sort' => $sort]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tables.th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Total (R$)','column' => 'custo_total','direction' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($direction),'sort' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($sort)]); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.tables.th','data' => ['label' => 'Minutos','column' => 'minutos_total','direction' => $direction,'sort' => $sort]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tables.th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Minutos','column' => 'minutos_total','direction' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($direction),'sort' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($sort)]); ?>
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
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.tables.td','data' => ['class' => 'py-2 font-semibold']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tables.td'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'py-2 font-semibold']); ?>#<?php echo e(str_pad($invoice->id, 5, '0', STR_PAD_LEFT)); ?> <?php echo $__env->renderComponent(); ?>
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
<?php $component->withAttributes(['class' => 'py-2']); ?><?php echo e(str_pad($invoice->mes, 2, '0', STR_PAD_LEFT)); ?>/<?php echo e($invoice->ano); ?> <?php echo $__env->renderComponent(); ?>
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
<?php $component->withAttributes(['class' => 'py-2']); ?><?php echo e($invoice->dataVencimento($invoice->customer->vencimento . '/' . $invoice->mes . '/' . $invoice->ano)); ?> <?php echo $__env->renderComponent(); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.tables.td','data' => ['class' => 'py-2 text-blue-600 dark:text-blue-400']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tables.td'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'py-2 text-blue-600 dark:text-blue-400']); ?><?php echo e(number_format($invoice->valor_plano, 2, ',', '.')); ?> <?php echo $__env->renderComponent(); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.tables.td','data' => ['class' => 'py-2 '.e($invoice->custo_excedente > 0 ? 'text-orange-600 dark:text-orange-400 font-semibold' : '').'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tables.td'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'py-2 '.e($invoice->custo_excedente > 0 ? 'text-orange-600 dark:text-orange-400 font-semibold' : '').'']); ?>
                                <?php echo e(number_format($invoice->custo_excedente, 2, ',', '.')); ?>

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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.tables.td','data' => ['class' => 'py-2 font-bold text-green-600 dark:text-green-400']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tables.td'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'py-2 font-bold text-green-600 dark:text-green-400']); ?><?php echo e(number_format($invoice->custo_total, 2, ',', '.')); ?> <?php echo $__env->renderComponent(); ?>
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
                                <span class="text-sm"><?php echo e(round($invoice->minutos_total / 60, 0, PHP_ROUND_HALF_UP)); ?> min</span>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($invoice->minutos_excedentes > 0): ?>
                                    <span class="block text-xs text-orange-500">(+<?php echo e(round($invoice->minutos_excedentes / 60, 0, PHP_ROUND_HALF_UP)); ?> exc.)</span>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.tables.td','data' => ['class' => 'py-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tables.td'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'py-2']); ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($invoice->fechado): ?>
                                    <span class="px-2 py-1 text-xs font-semibold text-green-800 bg-green-100 rounded-full dark:bg-green-900 dark:text-green-200">Fechada</span>
                                <?php else: ?>
                                    <span class="px-2 py-1 text-xs font-semibold text-yellow-800 bg-yellow-100 rounded-full dark:bg-yellow-900 dark:text-yellow-200">Aberta</span>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.tables.td','data' => ['class' => 'py-2','wire:click' => 'openDetails('.e($invoice->id).')','wire:key' => ''.e($invoice->id).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tables.td'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'py-2','wire:click' => 'openDetails('.e($invoice->id).')','wire:key' => ''.e($invoice->id).'']); ?>
                                <button class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition-colors">
                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    Ver
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
                        <tr>
                            <td colspan="9" class="px-4 py-12 text-center text-gray-500 dark:text-gray-400">
                                <p class="text-lg">Nenhuma fatura encontrada para este cliente</p>
                            </td>
                        </tr>
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
    <?php echo e($invoices->links('vendor.livewire.paginate')); ?>

</div>
<?php /**PATH C:\Users\Rafael Benedicto\Documents\Herd\asbc\resources\views/livewire/invoices/customer-invoices.blade.php ENDPATH**/ ?>