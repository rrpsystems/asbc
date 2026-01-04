<div class="space-y-3 min-h-72">
    <div class="grid grid-cols-4 gap-3">

        <div class="col-span-3">
            <?php if (isset($component)) { $__componentOriginal023cbb78830bf629e0440d3a52ed07da = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal023cbb78830bf629e0440d3a52ed07da = $attributes; } ?>
<?php $component = TallStackUi\View\Components\Form\Input::resolve(['label' => 'Razão Social *','icon' => 'building-office'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\TallStackUi\View\Components\Form\Input::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'razaosocial']); ?>
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
        <div class="col-span-1 pt-8 pl-3">
            <?php if (isset($component)) { $__componentOriginal02abd057b69f64a9db284ef3c3872abe = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal02abd057b69f64a9db284ef3c3872abe = $attributes; } ?>
<?php $component = TallStackUi\View\Components\Form\Toggle::resolve(['color' => 'green','label' => 'Ativo','position' => 'left'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui-toggle'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\TallStackUi\View\Components\Form\Toggle::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'ativo']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal02abd057b69f64a9db284ef3c3872abe)): ?>
<?php $attributes = $__attributesOriginal02abd057b69f64a9db284ef3c3872abe; ?>
<?php unset($__attributesOriginal02abd057b69f64a9db284ef3c3872abe); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal02abd057b69f64a9db284ef3c3872abe)): ?>
<?php $component = $__componentOriginal02abd057b69f64a9db284ef3c3872abe; ?>
<?php unset($__componentOriginal02abd057b69f64a9db284ef3c3872abe); ?>
<?php endif; ?>
        </div>


        <div class="col-span-2">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($customer->id)): ?>
                <?php if (isset($component)) { $__componentOriginal023cbb78830bf629e0440d3a52ed07da = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal023cbb78830bf629e0440d3a52ed07da = $attributes; } ?>
<?php $component = TallStackUi\View\Components\Form\Input::resolve(['label' => 'Cotrato *','icon' => 'document-text'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\TallStackUi\View\Components\Form\Input::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['disabled' => true,'wire:model' => 'contrato']); ?>
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
            <?php else: ?>
                <?php if (isset($component)) { $__componentOriginal023cbb78830bf629e0440d3a52ed07da = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal023cbb78830bf629e0440d3a52ed07da = $attributes; } ?>
<?php $component = TallStackUi\View\Components\Form\Input::resolve(['label' => 'Cotrato *','icon' => 'document-text'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\TallStackUi\View\Components\Form\Input::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'contrato']); ?>
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
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

        <div class="col-span-2">
            <?php if (isset($component)) { $__componentOriginal023cbb78830bf629e0440d3a52ed07da = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal023cbb78830bf629e0440d3a52ed07da = $attributes; } ?>
<?php $component = TallStackUi\View\Components\Form\Input::resolve(['label' => 'CNPJ *','icon' => 'identification'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\TallStackUi\View\Components\Form\Input::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['size' => 'xs','wire:model' => 'cnpj']); ?>
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


        <div class="col-span-4">
            <?php if (isset($component)) { $__componentOriginal023cbb78830bf629e0440d3a52ed07da = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal023cbb78830bf629e0440d3a52ed07da = $attributes; } ?>
<?php $component = TallStackUi\View\Components\Form\Input::resolve(['label' => 'Endereço *','icon' => 'map'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\TallStackUi\View\Components\Form\Input::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'endereco']); ?>
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

        <div class="col-span-2">
            <?php if (isset($component)) { $__componentOriginal023cbb78830bf629e0440d3a52ed07da = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal023cbb78830bf629e0440d3a52ed07da = $attributes; } ?>
<?php $component = TallStackUi\View\Components\Form\Input::resolve(['label' => 'Numero *','icon' => 'home'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
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
        <div class="col-span-2">
            <?php if (isset($component)) { $__componentOriginal023cbb78830bf629e0440d3a52ed07da = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal023cbb78830bf629e0440d3a52ed07da = $attributes; } ?>
<?php $component = TallStackUi\View\Components\Form\Input::resolve(['label' => 'Complemento','icon' => 'home'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\TallStackUi\View\Components\Form\Input::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'complemento']); ?>
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

        <div class="flex justify-between col-span-3 gap-3">
            <?php if (isset($component)) { $__componentOriginal023cbb78830bf629e0440d3a52ed07da = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal023cbb78830bf629e0440d3a52ed07da = $attributes; } ?>
<?php $component = TallStackUi\View\Components\Form\Input::resolve(['label' => 'CEP *','icon' => 'map-pin'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\TallStackUi\View\Components\Form\Input::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'cep']); ?>
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
            <?php if (isset($component)) { $__componentOriginal023cbb78830bf629e0440d3a52ed07da = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal023cbb78830bf629e0440d3a52ed07da = $attributes; } ?>
<?php $component = TallStackUi\View\Components\Form\Input::resolve(['label' => 'Cidade *','icon' => 'building-office'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\TallStackUi\View\Components\Form\Input::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'cidade']); ?>
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
<?php $component = TallStackUi\View\Components\Form\Input::resolve(['label' => 'UF *','icon' => 'flag'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\TallStackUi\View\Components\Form\Input::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'uf']); ?>
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

        <div class="flex col-span-4 gap-3">
            <div class="w-3/5"> <!-- 60% -->
                <?php if (isset($component)) { $__componentOriginal023cbb78830bf629e0440d3a52ed07da = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal023cbb78830bf629e0440d3a52ed07da = $attributes; } ?>
<?php $component = TallStackUi\View\Components\Form\Input::resolve(['label' => 'Email','icon' => 'envelope'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\TallStackUi\View\Components\Form\Input::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'email']); ?>
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
            <div class="w-2/5"> <!-- 40% -->
                <?php if (isset($component)) { $__componentOriginal023cbb78830bf629e0440d3a52ed07da = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal023cbb78830bf629e0440d3a52ed07da = $attributes; } ?>
<?php $component = TallStackUi\View\Components\Form\Input::resolve(['label' => 'Telefone','icon' => 'phone'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\TallStackUi\View\Components\Form\Input::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'telefone']); ?>
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


        <div class="relative flex items-center justify-center col-span-4">
            <div class="flex items-center w-full">
                <div class="flex-grow border-t border-gray-500"></div>
                <span class="mx-4 text-gray-500">Sistema</span>
                <div class="flex-grow border-t border-gray-500"></div>
            </div>
        </div>

        <div class="flex col-span-4 gap-3">
            <div class="w-3/6"> <!-- 40% -->
                <?php if (isset($component)) { $__componentOriginal023cbb78830bf629e0440d3a52ed07da = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal023cbb78830bf629e0440d3a52ed07da = $attributes; } ?>
<?php $component = TallStackUi\View\Components\Form\Input::resolve(['label' => 'Franquia *','icon' => 'phone-arrow-up-right'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\TallStackUi\View\Components\Form\Input::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'franquia_minutos']); ?>
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
            <div class="w-3/6"> <!-- 60% -->
                <?php if (isset($component)) { $__componentOriginal023cbb78830bf629e0440d3a52ed07da = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal023cbb78830bf629e0440d3a52ed07da = $attributes; } ?>
<?php $component = TallStackUi\View\Components\Form\Input::resolve(['label' => 'Valor *','icon' => 'currency-dollar'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\TallStackUi\View\Components\Form\Input::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'valor_plano']); ?>
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

        <div class="flex col-span-4 gap-3">
            <div class="w-3/5"> <!-- 40% -->
                <?php if (isset($component)) { $__componentOriginala76d052063cf1aadc0c1f858e8546a68 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala76d052063cf1aadc0c1f858e8546a68 = $attributes; } ?>
<?php $component = TallStackUi\View\Components\Form\Date::resolve(['label' => 'Data Inicial *','format' => 'DD/MM/YYYY'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui-date'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\TallStackUi\View\Components\Form\Date::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'data_inicio']); ?>
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
            <div class="w-2/5"> <!-- 60% -->
                <?php if (isset($component)) { $__componentOriginal1ca7fa5cd5029849fd5af7ac4bad6c1c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1ca7fa5cd5029849fd5af7ac4bad6c1c = $attributes; } ?>
<?php $component = TallStackUi\View\Components\Form\Number::resolve(['label' => 'Vencimento *','min' => '1','max' => '30'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui-number'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\TallStackUi\View\Components\Form\Number::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'vencimento']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1ca7fa5cd5029849fd5af7ac4bad6c1c)): ?>
<?php $attributes = $__attributesOriginal1ca7fa5cd5029849fd5af7ac4bad6c1c; ?>
<?php unset($__attributesOriginal1ca7fa5cd5029849fd5af7ac4bad6c1c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1ca7fa5cd5029849fd5af7ac4bad6c1c)): ?>
<?php $component = $__componentOriginal1ca7fa5cd5029849fd5af7ac4bad6c1c; ?>
<?php unset($__componentOriginal1ca7fa5cd5029849fd5af7ac4bad6c1c); ?>
<?php endif; ?>
            </div>
        </div>

        <div class="flex col-span-4 gap-3">
            <div class="w-3/5"> <!-- 40% -->
                <?php if (isset($component)) { $__componentOriginala41be919f39433f1c8a512d4cf9b9816 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala41be919f39433f1c8a512d4cf9b9816 = $attributes; } ?>
<?php $component = TallStackUi\View\Components\Form\Password::resolve(['label' => 'Senha Web *'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui-password'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\TallStackUi\View\Components\Form\Password::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'password']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala41be919f39433f1c8a512d4cf9b9816)): ?>
<?php $attributes = $__attributesOriginala41be919f39433f1c8a512d4cf9b9816; ?>
<?php unset($__attributesOriginala41be919f39433f1c8a512d4cf9b9816); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala41be919f39433f1c8a512d4cf9b9816)): ?>
<?php $component = $__componentOriginala41be919f39433f1c8a512d4cf9b9816; ?>
<?php unset($__componentOriginala41be919f39433f1c8a512d4cf9b9816); ?>
<?php endif; ?>
            </div>
            <div class="w-2/5"> <!-- 60% -->
                <?php if (isset($component)) { $__componentOriginal1ca7fa5cd5029849fd5af7ac4bad6c1c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1ca7fa5cd5029849fd5af7ac4bad6c1c = $attributes; } ?>
<?php $component = TallStackUi\View\Components\Form\Number::resolve(['label' => 'Canais *','min' => '1','max' => '30'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui-number'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\TallStackUi\View\Components\Form\Number::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'canais']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1ca7fa5cd5029849fd5af7ac4bad6c1c)): ?>
<?php $attributes = $__attributesOriginal1ca7fa5cd5029849fd5af7ac4bad6c1c; ?>
<?php unset($__attributesOriginal1ca7fa5cd5029849fd5af7ac4bad6c1c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1ca7fa5cd5029849fd5af7ac4bad6c1c)): ?>
<?php $component = $__componentOriginal1ca7fa5cd5029849fd5af7ac4bad6c1c; ?>
<?php unset($__componentOriginal1ca7fa5cd5029849fd5af7ac4bad6c1c); ?>
<?php endif; ?>
            </div>
        </div>

        <!-- Configurações SBC Padrão -->
        <div class="relative flex items-center justify-center col-span-4 mt-4">
            <div class="flex items-center w-full">
                <div class="flex-grow border-t border-gray-500"></div>
                <span class="mx-4 text-gray-500">🌐 Configurações SBC (Padrão)</span>
                <div class="flex-grow border-t border-gray-500"></div>
            </div>
        </div>

        <div class="col-span-4 p-3 text-sm rounded-lg bg-blue-50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-300">
            <strong>💡 Informação:</strong> Configure aqui o proxy/porta padrão deste cliente.
            Todos os DIDs herdarão essas configurações, mas podem ser sobrescritas individualmente se necessário.
        </div>

        <div class="col-span-3">
            <?php if (isset($component)) { $__componentOriginal023cbb78830bf629e0440d3a52ed07da = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal023cbb78830bf629e0440d3a52ed07da = $attributes; } ?>
<?php $component = TallStackUi\View\Components\Form\Input::resolve(['label' => 'Proxy Padrão (Endereço SBC)','icon' => 'server','hint' => 'Ex: sbc.rrpsystems.com.br'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\TallStackUi\View\Components\Form\Input::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'proxy_padrao']); ?>
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
<?php $component = TallStackUi\View\Components\Form\Input::resolve(['label' => 'Porta Padrão','icon' => 'bolt','hint' => 'Ex: 5060, 5099'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\TallStackUi\View\Components\Form\Input::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'porta_padrao']); ?>
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

        <!-- Separador de Bloqueios -->
        <div class="relative flex items-center justify-center col-span-4 mt-4">
            <div class="flex items-center w-full">
                <div class="flex-grow border-t border-gray-500"></div>
                <span class="mx-4 text-gray-500">🚫 Controle de Bloqueios</span>
                <div class="flex-grow border-t border-gray-500"></div>
            </div>
        </div>

        <div class="col-span-4 p-3 text-sm rounded-lg bg-orange-50 dark:bg-orange-900/20 text-orange-700 dark:text-orange-300">
            <strong>⚠️ Atenção:</strong> Os bloqueios aplicados aqui afetarão <strong>todos os DIDs</strong> deste cliente.
            O SBC consultará esses campos para permitir ou bloquear chamadas.
        </div>

        <div class="col-span-2 pt-8 pl-3">
            <?php if (isset($component)) { $__componentOriginal02abd057b69f64a9db284ef3c3872abe = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal02abd057b69f64a9db284ef3c3872abe = $attributes; } ?>
<?php $component = TallStackUi\View\Components\Form\Toggle::resolve(['color' => 'red','label' => 'Bloquear Entrada (Operadora → PABX)','position' => 'left'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui-toggle'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\TallStackUi\View\Components\Form\Toggle::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'bloqueio_entrada']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal02abd057b69f64a9db284ef3c3872abe)): ?>
<?php $attributes = $__attributesOriginal02abd057b69f64a9db284ef3c3872abe; ?>
<?php unset($__attributesOriginal02abd057b69f64a9db284ef3c3872abe); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal02abd057b69f64a9db284ef3c3872abe)): ?>
<?php $component = $__componentOriginal02abd057b69f64a9db284ef3c3872abe; ?>
<?php unset($__componentOriginal02abd057b69f64a9db284ef3c3872abe); ?>
<?php endif; ?>
        </div>

        <div class="col-span-2 pt-8 pl-3">
            <?php if (isset($component)) { $__componentOriginal02abd057b69f64a9db284ef3c3872abe = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal02abd057b69f64a9db284ef3c3872abe = $attributes; } ?>
<?php $component = TallStackUi\View\Components\Form\Toggle::resolve(['color' => 'red','label' => 'Bloquear Saída (PABX → Operadora)','position' => 'left'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui-toggle'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\TallStackUi\View\Components\Form\Toggle::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'bloqueio_saida']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal02abd057b69f64a9db284ef3c3872abe)): ?>
<?php $attributes = $__attributesOriginal02abd057b69f64a9db284ef3c3872abe; ?>
<?php unset($__attributesOriginal02abd057b69f64a9db284ef3c3872abe); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal02abd057b69f64a9db284ef3c3872abe)): ?>
<?php $component = $__componentOriginal02abd057b69f64a9db284ef3c3872abe; ?>
<?php unset($__componentOriginal02abd057b69f64a9db284ef3c3872abe); ?>
<?php endif; ?>
        </div>

        <div class="col-span-4">
            <?php if (isset($component)) { $__componentOriginalb7c42c7d49080293c8409b80e3801e0e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb7c42c7d49080293c8409b80e3801e0e = $attributes; } ?>
<?php $component = TallStackUi\View\Components\Form\Textarea::resolve(['label' => 'Motivo do Bloqueio','hint' => 'Ex: Inadimplência, Solicitação do cliente, Manutenção'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui-textarea'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\TallStackUi\View\Components\Form\Textarea::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'exclamation-circle','wire:model' => 'motivo_bloqueio','rows' => '2']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalb7c42c7d49080293c8409b80e3801e0e)): ?>
<?php $attributes = $__attributesOriginalb7c42c7d49080293c8409b80e3801e0e; ?>
<?php unset($__attributesOriginalb7c42c7d49080293c8409b80e3801e0e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb7c42c7d49080293c8409b80e3801e0e)): ?>
<?php $component = $__componentOriginalb7c42c7d49080293c8409b80e3801e0e; ?>
<?php unset($__componentOriginalb7c42c7d49080293c8409b80e3801e0e); ?>
<?php endif; ?>
        </div>

    </div>
</div>
<?php /**PATH C:\Users\Rafael Benedicto\Documents\Herd\asbc\resources\views/livewire/customers/form.blade.php ENDPATH**/ ?>