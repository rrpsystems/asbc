<div>
    <?php if (isset($component)) { $__componentOriginal93360b397272e82c601608cfc5cba0d9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal93360b397272e82c601608cfc5cba0d9 = $attributes; } ?>
<?php $component = TallStackUi\View\Components\Modal::resolve(['size' => '4xl','wire' => 'filterModal','persistent' => true] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui-modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\TallStackUi\View\Components\Modal::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
         <?php $__env->slot('title', null, []); ?> 
            <div class="flex items-center justify-between">
                <span class="text-xl font-bold">Filtros CDR</span>
                <?php if (isset($component)) { $__componentOriginal5266464ff7b66ba0b126f4b6bc32a5f5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5266464ff7b66ba0b126f4b6bc32a5f5 = $attributes; } ?>
<?php $component = TallStackUi\View\Components\Button\Button::resolve(['color' => 'pink','sm' => true] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\TallStackUi\View\Components\Button\Button::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:click' => 'resetFilter']); ?>
                     <?php $__env->slot('left', null, []); ?> 
                        <?php if (isset($component)) { $__componentOriginalcf0c10903472319464d99a08725e554d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalcf0c10903472319464d99a08725e554d = $attributes; } ?>
<?php $component = TallStackUi\View\Components\Icon::resolve(['icon' => 'arrow-path'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui-icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\TallStackUi\View\Components\Icon::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-4 h-4']); ?>
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

        <div class="p-4">

            <div class="space-y-3 min-h-72">
                <div class="grid grid-cols-4 gap-3">

                    <div class="flex col-span-4 gap-3">
                        <div class="w-3/6">
                            <?php if (isset($component)) { $__componentOriginala76d052063cf1aadc0c1f858e8546a68 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala76d052063cf1aadc0c1f858e8546a68 = $attributes; } ?>
<?php $component = TallStackUi\View\Components\Form\Date::resolve(['label' => 'Data Inicial','format' => 'DD/MM/YYYY','maxDate' => now()] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui-date'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\TallStackUi\View\Components\Form\Date::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'data_inicial']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala76d052063cf1aadc0c1f858e8546a68)): ?>
<?php $attributes = $__attributesOriginala76d052063cf1aadc0c1f858e8546a68; ?>
<?php unset($__attributesOriginala76d052063cf1aadc0c1f858e8546a68); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala76d052063cf1aadc0c1f858e8546a68)): ?>
<?php $component = $__componentOriginala76d052063cf1aadc0c1f858e8546a68; ?>
<?php unset($__componentOriginala76d052063cf1aadc0c1f858e8546a68); ?>
<?php endif; ?>
                        </div>
                        <div class="w-3/6">
                            <?php if (isset($component)) { $__componentOriginala76d052063cf1aadc0c1f858e8546a68 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala76d052063cf1aadc0c1f858e8546a68 = $attributes; } ?>
<?php $component = TallStackUi\View\Components\Form\Date::resolve(['label' => 'Data Final','format' => 'DD/MM/YYYY','maxDate' => now()] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui-date'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\TallStackUi\View\Components\Form\Date::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'data_final']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala76d052063cf1aadc0c1f858e8546a68)): ?>
<?php $attributes = $__attributesOriginala76d052063cf1aadc0c1f858e8546a68; ?>
<?php unset($__attributesOriginala76d052063cf1aadc0c1f858e8546a68); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala76d052063cf1aadc0c1f858e8546a68)): ?>
<?php $component = $__componentOriginala76d052063cf1aadc0c1f858e8546a68; ?>
<?php unset($__componentOriginala76d052063cf1aadc0c1f858e8546a68); ?>
<?php endif; ?>
                        </div>
                    </div>

                    <div class="flex col-span-4 gap-3">
                        <div class="w-full">
                            <?php if (isset($component)) { $__componentOriginala430b17f53e054e8e8f4eba8f1e2ea14 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala430b17f53e054e8e8f4eba8f1e2ea14 = $attributes; } ?>
<?php $component = TallStackUi\View\Components\Form\Select\Styled::resolve(['label' => 'Tarifa','options' => $tarifas,'select' => 'label:label|value:value','searchable' => true,'multiple' => true] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui-select.styled'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\TallStackUi\View\Components\Form\Select\Styled::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'tarifa']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala430b17f53e054e8e8f4eba8f1e2ea14)): ?>
<?php $attributes = $__attributesOriginala430b17f53e054e8e8f4eba8f1e2ea14; ?>
<?php unset($__attributesOriginala430b17f53e054e8e8f4eba8f1e2ea14); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala430b17f53e054e8e8f4eba8f1e2ea14)): ?>
<?php $component = $__componentOriginala430b17f53e054e8e8f4eba8f1e2ea14; ?>
<?php unset($__componentOriginala430b17f53e054e8e8f4eba8f1e2ea14); ?>
<?php endif; ?>
                        </div>
                    </div>

                    <div class="col-span-4">
                        <div class="w-full">
                            <?php if (isset($component)) { $__componentOriginala430b17f53e054e8e8f4eba8f1e2ea14 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala430b17f53e054e8e8f4eba8f1e2ea14 = $attributes; } ?>
<?php $component = TallStackUi\View\Components\Form\Select\Styled::resolve(['label' => 'Cliente','options' => $customers,'select' => 'label:label|value:value','searchable' => true,'multiple' => true] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui-select.styled'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\TallStackUi\View\Components\Form\Select\Styled::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'customer']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala430b17f53e054e8e8f4eba8f1e2ea14)): ?>
<?php $attributes = $__attributesOriginala430b17f53e054e8e8f4eba8f1e2ea14; ?>
<?php unset($__attributesOriginala430b17f53e054e8e8f4eba8f1e2ea14); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala430b17f53e054e8e8f4eba8f1e2ea14)): ?>
<?php $component = $__componentOriginala430b17f53e054e8e8f4eba8f1e2ea14; ?>
<?php unset($__componentOriginala430b17f53e054e8e8f4eba8f1e2ea14); ?>
<?php endif; ?>
                        </div>
                    </div>
                    <div class="col-span-4">
                        <div class="w-full">
                            <?php if (isset($component)) { $__componentOriginala430b17f53e054e8e8f4eba8f1e2ea14 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala430b17f53e054e8e8f4eba8f1e2ea14 = $attributes; } ?>
<?php $component = TallStackUi\View\Components\Form\Select\Styled::resolve(['label' => 'DID','options' => $dids,'select' => 'label:label|value:value','searchable' => true,'multiple' => true] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui-select.styled'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\TallStackUi\View\Components\Form\Select\Styled::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'did']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala430b17f53e054e8e8f4eba8f1e2ea14)): ?>
<?php $attributes = $__attributesOriginala430b17f53e054e8e8f4eba8f1e2ea14; ?>
<?php unset($__attributesOriginala430b17f53e054e8e8f4eba8f1e2ea14); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala430b17f53e054e8e8f4eba8f1e2ea14)): ?>
<?php $component = $__componentOriginala430b17f53e054e8e8f4eba8f1e2ea14; ?>
<?php unset($__componentOriginala430b17f53e054e8e8f4eba8f1e2ea14); ?>
<?php endif; ?>
                        </div>
                    </div>
                    <div class="col-span-4">
                        <div class="w-full">
                            <?php if (isset($component)) { $__componentOriginala430b17f53e054e8e8f4eba8f1e2ea14 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala430b17f53e054e8e8f4eba8f1e2ea14 = $attributes; } ?>
<?php $component = TallStackUi\View\Components\Form\Select\Styled::resolve(['label' => 'Operadora','options' => $carriers,'select' => 'label:label|value:value','searchable' => true,'multiple' => true] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui-select.styled'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\TallStackUi\View\Components\Form\Select\Styled::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'carrier']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala430b17f53e054e8e8f4eba8f1e2ea14)): ?>
<?php $attributes = $__attributesOriginala430b17f53e054e8e8f4eba8f1e2ea14; ?>
<?php unset($__attributesOriginala430b17f53e054e8e8f4eba8f1e2ea14); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala430b17f53e054e8e8f4eba8f1e2ea14)): ?>
<?php $component = $__componentOriginala430b17f53e054e8e8f4eba8f1e2ea14; ?>
<?php unset($__componentOriginala430b17f53e054e8e8f4eba8f1e2ea14); ?>
<?php endif; ?>
                        </div>
                    </div>

                    <div class="flex col-span-4 gap-3">
                        <div class="w-3/6">
                            <?php if (isset($component)) { $__componentOriginal023cbb78830bf629e0440d3a52ed07da = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal023cbb78830bf629e0440d3a52ed07da = $attributes; } ?>
<?php $component = TallStackUi\View\Components\Form\Input::resolve(['label' => 'Numero','icon' => 'phone'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\TallStackUi\View\Components\Form\Input::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'numero']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal023cbb78830bf629e0440d3a52ed07da)): ?>
<?php $attributes = $__attributesOriginal023cbb78830bf629e0440d3a52ed07da; ?>
<?php unset($__attributesOriginal023cbb78830bf629e0440d3a52ed07da); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal023cbb78830bf629e0440d3a52ed07da)): ?>
<?php $component = $__componentOriginal023cbb78830bf629e0440d3a52ed07da; ?>
<?php unset($__componentOriginal023cbb78830bf629e0440d3a52ed07da); ?>
<?php endif; ?>
                        </div>
                        <div class="col-span-1">
                            <?php if (isset($component)) { $__componentOriginal023cbb78830bf629e0440d3a52ed07da = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal023cbb78830bf629e0440d3a52ed07da = $attributes; } ?>
<?php $component = TallStackUi\View\Components\Form\Input::resolve(['label' => 'Ramal','icon' => 'phone'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\TallStackUi\View\Components\Form\Input::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'ramal']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal023cbb78830bf629e0440d3a52ed07da)): ?>
<?php $attributes = $__attributesOriginal023cbb78830bf629e0440d3a52ed07da; ?>
<?php unset($__attributesOriginal023cbb78830bf629e0440d3a52ed07da); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal023cbb78830bf629e0440d3a52ed07da)): ?>
<?php $component = $__componentOriginal023cbb78830bf629e0440d3a52ed07da; ?>
<?php unset($__componentOriginal023cbb78830bf629e0440d3a52ed07da); ?>
<?php endif; ?>
                        </div>
                    </div>

                    <div class="col-span-4">
                        <div class="w-full">
                            <?php if (isset($component)) { $__componentOriginala430b17f53e054e8e8f4eba8f1e2ea14 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala430b17f53e054e8e8f4eba8f1e2ea14 = $attributes; } ?>
<?php $component = TallStackUi\View\Components\Form\Select\Styled::resolve(['label' => 'Status','options' => $status,'select' => 'label:label|value:value','searchable' => true,'multiple' => true] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui-select.styled'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\TallStackUi\View\Components\Form\Select\Styled::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'stat']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala430b17f53e054e8e8f4eba8f1e2ea14)): ?>
<?php $attributes = $__attributesOriginala430b17f53e054e8e8f4eba8f1e2ea14; ?>
<?php unset($__attributesOriginala430b17f53e054e8e8f4eba8f1e2ea14); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala430b17f53e054e8e8f4eba8f1e2ea14)): ?>
<?php $component = $__componentOriginala430b17f53e054e8e8f4eba8f1e2ea14; ?>
<?php unset($__componentOriginala430b17f53e054e8e8f4eba8f1e2ea14); ?>
<?php endif; ?>
                        </div>
                    </div>
                    <div class="col-span-4">
                        <div class="w-full">
                            <?php if (isset($component)) { $__componentOriginala430b17f53e054e8e8f4eba8f1e2ea14 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala430b17f53e054e8e8f4eba8f1e2ea14 = $attributes; } ?>
<?php $component = TallStackUi\View\Components\Form\Select\Styled::resolve(['label' => 'Desligamento','options' => $desligamentos,'select' => 'label:label|value:value','searchable' => true,'multiple' => true] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui-select.styled'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\TallStackUi\View\Components\Form\Select\Styled::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'desligamento']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala430b17f53e054e8e8f4eba8f1e2ea14)): ?>
<?php $attributes = $__attributesOriginala430b17f53e054e8e8f4eba8f1e2ea14; ?>
<?php unset($__attributesOriginala430b17f53e054e8e8f4eba8f1e2ea14); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala430b17f53e054e8e8f4eba8f1e2ea14)): ?>
<?php $component = $__componentOriginala430b17f53e054e8e8f4eba8f1e2ea14; ?>
<?php unset($__componentOriginala430b17f53e054e8e8f4eba8f1e2ea14); ?>
<?php endif; ?>
                        </div>
                    </div>

                </div>
            </div>
        </div>

         <?php $__env->slot('footer', null, []); ?> 
            <div class="flex items-center justify-between w-full gap-3">
                <?php if (isset($component)) { $__componentOriginal5266464ff7b66ba0b126f4b6bc32a5f5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5266464ff7b66ba0b126f4b6bc32a5f5 = $attributes; } ?>
<?php $component = TallStackUi\View\Components\Button\Button::resolve(['color' => 'secondary'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\TallStackUi\View\Components\Button\Button::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:click' => 'closeFilterModal','class' => 'px-4 py-2']); ?>
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
<?php $component = TallStackUi\View\Components\Button\Button::resolve(['color' => 'primary'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\TallStackUi\View\Components\Button\Button::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:click' => 'filter','class' => 'px-4 py-2']); ?>
                     <?php $__env->slot('left', null, []); ?> 
                        <?php if (isset($component)) { $__componentOriginalcf0c10903472319464d99a08725e554d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalcf0c10903472319464d99a08725e554d = $attributes; } ?>
<?php $component = TallStackUi\View\Components\Icon::resolve(['icon' => 'magnifying-glass'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui-icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\TallStackUi\View\Components\Icon::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-4 h-4']); ?>
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
                    Aplicar Filtros
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
<?php /**PATH C:\Users\Rafael Benedicto\Documents\Herd\asbc\resources\views/livewire/cdrs/filter.blade.php ENDPATH**/ ?>