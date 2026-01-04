<div>
    <?php if (isset($component)) { $__componentOriginal93360b397272e82c601608cfc5cba0d9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal93360b397272e82c601608cfc5cba0d9 = $attributes; } ?>
<?php $component = TallStackUi\View\Components\Modal::resolve(['wire' => 'detailsModal','title' => 'Detalhes do Alerta','size' => '3xl'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui-modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\TallStackUi\View\Components\Modal::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($selectedAlert): ?>
            <div class="space-y-4">
                <!-- Header with Severity -->
                <div class="flex items-start justify-between pb-4 border-b border-gray-200 dark:border-gray-700">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                            <?php echo e($selectedAlert->title); ?>

                        </h3>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            <?php echo e($selectedAlert->created_at->format('d/m/Y H:i:s')); ?>

                        </p>
                    </div>

                    <div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($selectedAlert->severity === 'critical'): ?>
                            <span
                                class="inline-flex items-center px-3 py-1 text-sm font-semibold text-red-800 bg-red-100 rounded-full dark:bg-red-900/30 dark:text-red-300">
                                Crítico
                            </span>
                        <?php elseif($selectedAlert->severity === 'high'): ?>
                            <span
                                class="inline-flex items-center px-3 py-1 text-sm font-semibold text-orange-800 bg-orange-100 rounded-full dark:bg-orange-900/30 dark:text-orange-300">
                                Alto
                            </span>
                        <?php elseif($selectedAlert->severity === 'medium'): ?>
                            <span
                                class="inline-flex items-center px-3 py-1 text-sm font-semibold text-yellow-800 bg-yellow-100 rounded-full dark:bg-yellow-900/30 dark:text-yellow-300">
                                Médio
                            </span>
                        <?php else: ?>
                            <span
                                class="inline-flex items-center px-3 py-1 text-sm font-semibold text-blue-800 bg-blue-100 rounded-full dark:bg-blue-900/30 dark:text-blue-300">
                                Baixo
                            </span>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>

                <!-- Message -->
                <div class="p-4 bg-gray-50 rounded-lg dark:bg-gray-700/50">
                    <p class="text-sm text-gray-700 dark:text-gray-300">
                        <?php echo e($selectedAlert->message); ?>

                    </p>
                </div>

                <!-- Related Entity Info -->
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($selectedAlert->customer || $selectedAlert->carrier): ?>
                    <div class="grid grid-cols-2 gap-4">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($selectedAlert->customer): ?>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Cliente</label>
                                <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                    <?php echo e($selectedAlert->customer->razaosocial); ?>

                                </p>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($selectedAlert->carrier): ?>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Operadora</label>
                                <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                    <?php echo e($selectedAlert->carrier->operadora); ?>

                                </p>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                <!-- Metadata -->
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($selectedAlert->metadata): ?>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Informações
                            Adicionais</label>
                        <div class="p-4 bg-gray-50 rounded-lg dark:bg-gray-700/50">
                            <dl class="space-y-2">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $selectedAlert->metadata; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="flex justify-between text-sm">
                                        <dt class="font-medium text-gray-600 dark:text-gray-400">
                                            <?php echo e(ucfirst(str_replace('_', ' ', $key))); ?>:
                                        </dt>
                                        <dd class="text-gray-900 dark:text-gray-100">
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(is_numeric($value)): ?>
                                                <?php echo e(number_format($value, 2, ',', '.')); ?>

                                            <?php else: ?>
                                                <?php echo e($value); ?>

                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </dd>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </dl>
                        </div>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                <!-- Status Info -->
                <div class="grid grid-cols-2 gap-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status de
                            Leitura</label>
                        <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($selectedAlert->isRead()): ?>
                                Lido em <?php echo e($selectedAlert->read_at->format('d/m/Y H:i')); ?>

                            <?php else: ?>
                                Não lido
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status de
                            Resolução</label>
                        <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($selectedAlert->isResolved()): ?>
                                Resolvido em <?php echo e($selectedAlert->resolved_at->format('d/m/Y H:i')); ?>

                            <?php else: ?>
                                Pendente
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </p>
                    </div>
                </div>
            </div>

             <?php $__env->slot('footer', null, []); ?> 
                <div class="flex justify-between w-full">
                    <?php if (isset($component)) { $__componentOriginal5266464ff7b66ba0b126f4b6bc32a5f5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5266464ff7b66ba0b126f4b6bc32a5f5 = $attributes; } ?>
<?php $component = TallStackUi\View\Components\Button\Button::resolve(['text' => 'Fechar','color' => 'white'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\TallStackUi\View\Components\Button\Button::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:click' => 'detailsModal = false']); ?>
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

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$selectedAlert->isResolved()): ?>
                        <?php if (isset($component)) { $__componentOriginal5266464ff7b66ba0b126f4b6bc32a5f5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5266464ff7b66ba0b126f4b6bc32a5f5 = $attributes; } ?>
<?php $component = TallStackUi\View\Components\Button\Button::resolve(['text' => 'Marcar como Resolvido','color' => 'green'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\TallStackUi\View\Components\Button\Button::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:click' => 'markAsResolved('.e($selectedAlert->id).')']); ?>
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
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
             <?php $__env->endSlot(); ?>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

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
</div>
<?php /**PATH C:\Users\Rafael Benedicto\Documents\Herd\asbc\resources\views/livewire/alerts/details.blade.php ENDPATH**/ ?>