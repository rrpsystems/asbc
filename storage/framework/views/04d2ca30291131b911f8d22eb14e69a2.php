<div>
    <?php if (isset($component)) { $__componentOriginal93360b397272e82c601608cfc5cba0d9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal93360b397272e82c601608cfc5cba0d9 = $attributes; } ?>
<?php $component = TallStackUi\View\Components\Modal::resolve(['wire' => 'filterModal','title' => 'Filtros de Alertas','size' => '4xl'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui-modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\TallStackUi\View\Components\Modal::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>

        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
            <!-- Severidade -->
            <div>
                <?php if (isset($component)) { $__componentOriginal3b3e4396eff4bda93b0d7cf3b85ceff0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3b3e4396eff4bda93b0d7cf3b85ceff0 = $attributes; } ?>
<?php $component = TallStackUi\View\Components\Form\Label::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\TallStackUi\View\Components\Form\Label::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>Severidade <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3b3e4396eff4bda93b0d7cf3b85ceff0)): ?>
<?php $attributes = $__attributesOriginal3b3e4396eff4bda93b0d7cf3b85ceff0; ?>
<?php unset($__attributesOriginal3b3e4396eff4bda93b0d7cf3b85ceff0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3b3e4396eff4bda93b0d7cf3b85ceff0)): ?>
<?php $component = $__componentOriginal3b3e4396eff4bda93b0d7cf3b85ceff0; ?>
<?php unset($__componentOriginal3b3e4396eff4bda93b0d7cf3b85ceff0); ?>
<?php endif; ?>
                <?php if (isset($component)) { $__componentOriginal8b33442a849cb32586ce03c449909109 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8b33442a849cb32586ce03c449909109 = $attributes; } ?>
<?php $component = TallStackUi\View\Components\Form\Select\Native::resolve(['options' => $severities,'select' => 'label:label|value:value'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui-select.native'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\TallStackUi\View\Components\Form\Select\Native::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'selectedSeverity','multiple' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8b33442a849cb32586ce03c449909109)): ?>
<?php $attributes = $__attributesOriginal8b33442a849cb32586ce03c449909109; ?>
<?php unset($__attributesOriginal8b33442a849cb32586ce03c449909109); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8b33442a849cb32586ce03c449909109)): ?>
<?php $component = $__componentOriginal8b33442a849cb32586ce03c449909109; ?>
<?php unset($__componentOriginal8b33442a849cb32586ce03c449909109); ?>
<?php endif; ?>
            </div>

            <!-- Tipo -->
            <div>
                <?php if (isset($component)) { $__componentOriginal3b3e4396eff4bda93b0d7cf3b85ceff0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3b3e4396eff4bda93b0d7cf3b85ceff0 = $attributes; } ?>
<?php $component = TallStackUi\View\Components\Form\Label::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\TallStackUi\View\Components\Form\Label::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>Tipo de Alerta <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3b3e4396eff4bda93b0d7cf3b85ceff0)): ?>
<?php $attributes = $__attributesOriginal3b3e4396eff4bda93b0d7cf3b85ceff0; ?>
<?php unset($__attributesOriginal3b3e4396eff4bda93b0d7cf3b85ceff0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3b3e4396eff4bda93b0d7cf3b85ceff0)): ?>
<?php $component = $__componentOriginal3b3e4396eff4bda93b0d7cf3b85ceff0; ?>
<?php unset($__componentOriginal3b3e4396eff4bda93b0d7cf3b85ceff0); ?>
<?php endif; ?>
                <?php if (isset($component)) { $__componentOriginal8b33442a849cb32586ce03c449909109 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8b33442a849cb32586ce03c449909109 = $attributes; } ?>
<?php $component = TallStackUi\View\Components\Form\Select\Native::resolve(['options' => $types,'select' => 'label:label|value:value'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui-select.native'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\TallStackUi\View\Components\Form\Select\Native::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'selectedType','multiple' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8b33442a849cb32586ce03c449909109)): ?>
<?php $attributes = $__attributesOriginal8b33442a849cb32586ce03c449909109; ?>
<?php unset($__attributesOriginal8b33442a849cb32586ce03c449909109); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8b33442a849cb32586ce03c449909109)): ?>
<?php $component = $__componentOriginal8b33442a849cb32586ce03c449909109; ?>
<?php unset($__componentOriginal8b33442a849cb32586ce03c449909109); ?>
<?php endif; ?>
            </div>

            <!-- Mostrar Resolvidos -->
            <div class="md:col-span-2">
                <?php if (isset($component)) { $__componentOriginal467f4ddac21088da030cab622342783d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal467f4ddac21088da030cab622342783d = $attributes; } ?>
<?php $component = TallStackUi\View\Components\Form\Checkbox::resolve(['label' => 'Mostrar alertas resolvidos'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui-checkbox'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\TallStackUi\View\Components\Form\Checkbox::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'showResolved']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal467f4ddac21088da030cab622342783d)): ?>
<?php $attributes = $__attributesOriginal467f4ddac21088da030cab622342783d; ?>
<?php unset($__attributesOriginal467f4ddac21088da030cab622342783d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal467f4ddac21088da030cab622342783d)): ?>
<?php $component = $__componentOriginal467f4ddac21088da030cab622342783d; ?>
<?php unset($__componentOriginal467f4ddac21088da030cab622342783d); ?>
<?php endif; ?>
            </div>
        </div>

         <?php $__env->slot('footer', null, []); ?> 
            <div class="flex justify-end gap-2">
                <?php if (isset($component)) { $__componentOriginal5266464ff7b66ba0b126f4b6bc32a5f5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5266464ff7b66ba0b126f4b6bc32a5f5 = $attributes; } ?>
<?php $component = TallStackUi\View\Components\Button\Button::resolve(['text' => 'Cancelar','color' => 'white'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\TallStackUi\View\Components\Button\Button::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:click' => 'closeFilterModal']); ?>
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
<?php $component = TallStackUi\View\Components\Button\Button::resolve(['text' => 'Aplicar Filtros','color' => 'primary'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\TallStackUi\View\Components\Button\Button::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:click' => 'filter']); ?>
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
<?php /**PATH C:\Users\Rafael Benedicto\Documents\Herd\asbc\resources\views/livewire/alerts/filter.blade.php ENDPATH**/ ?>