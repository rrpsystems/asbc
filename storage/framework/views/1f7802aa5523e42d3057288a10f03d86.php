<div>
    <?php if (isset($component)) { $__componentOriginal93360b397272e82c601608cfc5cba0d9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal93360b397272e82c601608cfc5cba0d9 = $attributes; } ?>
<?php $component = TallStackUi\View\Components\Modal::resolve(['persistent' => true,'size' => '4xl','wire' => 'modal'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui-modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\TallStackUi\View\Components\Modal::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>

         <?php $__env->slot('title', null, []); ?> 
            <span class="text-2xl font-bold">
                Nova Operadora
            </span>
         <?php $__env->endSlot(); ?>

        <div class="space-y-4">
            <?php echo $__env->make('livewire.carriers.form', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>

         <?php $__env->slot('footer', null, []); ?> 
            <div class="flex justify-end gap-3">
                <?php if (isset($component)) { $__componentOriginal5266464ff7b66ba0b126f4b6bc32a5f5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5266464ff7b66ba0b126f4b6bc32a5f5 = $attributes; } ?>
<?php $component = TallStackUi\View\Components\Button\Button::resolve(['color' => 'stone'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\TallStackUi\View\Components\Button\Button::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:click' => 'cancel']); ?>
                    Cancelar
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
<?php $component = TallStackUi\View\Components\Button\Button::resolve(['color' => 'green'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\TallStackUi\View\Components\Button\Button::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:click' => 'store']); ?>
                     <?php $__env->slot('left', null, []); ?> 
                        <?php if (isset($component)) { $__componentOriginalcf0c10903472319464d99a08725e554d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalcf0c10903472319464d99a08725e554d = $attributes; } ?>
<?php $component = TallStackUi\View\Components\Icon::resolve(['icon' => 'check'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui-icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\TallStackUi\View\Components\Icon::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
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
                     <?php $__env->endSlot(); ?>
                    Salvar
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
</div>
<?php /**PATH C:\Users\Rafael Benedicto\Documents\Herd\asbc\resources\views/livewire/carriers/create.blade.php ENDPATH**/ ?>