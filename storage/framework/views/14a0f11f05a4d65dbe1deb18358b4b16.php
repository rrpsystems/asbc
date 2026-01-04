<div class="space-y-4">
    <!-- Tipo de Produto -->
    <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Tipo de Produto *</label>
        <select wire:model="tipo_produto" class="w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-cyan-500">
            <option value="">Selecione o tipo de produto</option>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $tiposProduto; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tipo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($tipo['value']); ?>"><?php echo e($tipo['label']); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </select>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['tipo_produto'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-xs text-red-600 dark:text-red-400"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

    <!-- Descrição -->
    <div>
        <?php if (isset($component)) { $__componentOriginal023cbb78830bf629e0440d3a52ed07da = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal023cbb78830bf629e0440d3a52ed07da = $attributes; } ?>
<?php $component = TallStackUi\View\Components\Form\Input::resolve(['label' => 'Descrição','hint' => 'Informação adicional sobre o produto'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\TallStackUi\View\Components\Form\Input::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'descricao','placeholder' => 'Ex: PABX Cloud - Plano Premium']); ?>
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

    <!-- Quantidade e Status -->
    <div class="grid grid-cols-2 gap-4">
        <div>
            <?php if (isset($component)) { $__componentOriginal1ca7fa5cd5029849fd5af7ac4bad6c1c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1ca7fa5cd5029849fd5af7ac4bad6c1c = $attributes; } ?>
<?php $component = TallStackUi\View\Components\Form\Number::resolve(['label' => 'Quantidade *','min' => '1'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui-number'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\TallStackUi\View\Components\Form\Number::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'quantidade']); ?>
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
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['quantidade'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-xs text-red-600 dark:text-red-400"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
        <div class="flex items-center pt-6">
            <?php if (isset($component)) { $__componentOriginal02abd057b69f64a9db284ef3c3872abe = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal02abd057b69f64a9db284ef3c3872abe = $attributes; } ?>
<?php $component = TallStackUi\View\Components\Form\Toggle::resolve(['label' => 'Ativo','lg' => true] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
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
    </div>

    <!-- Valores -->
    <div class="grid grid-cols-2 gap-4">
        <div>
            <?php if (isset($component)) { $__componentOriginal023cbb78830bf629e0440d3a52ed07da = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal023cbb78830bf629e0440d3a52ed07da = $attributes; } ?>
<?php $component = TallStackUi\View\Components\Form\Input::resolve(['label' => 'Valor Custo Unitário (R$) *','hint' => 'Quanto você paga por unidade'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\TallStackUi\View\Components\Form\Input::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'valor_custo_unitario','placeholder' => '0,00','type' => 'number','step' => '0.01']); ?>
                 <?php $__env->slot('prefix', null, []); ?> 
                    <?php if (isset($component)) { $__componentOriginalcf0c10903472319464d99a08725e554d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalcf0c10903472319464d99a08725e554d = $attributes; } ?>
<?php $component = TallStackUi\View\Components\Icon::resolve(['name' => 'currency-dollar'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui-icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\TallStackUi\View\Components\Icon::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-5 h-5 text-gray-400']); ?>
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
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['valor_custo_unitario'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-xs text-red-600 dark:text-red-400"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
        <div>
            <?php if (isset($component)) { $__componentOriginal023cbb78830bf629e0440d3a52ed07da = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal023cbb78830bf629e0440d3a52ed07da = $attributes; } ?>
<?php $component = TallStackUi\View\Components\Form\Input::resolve(['label' => 'Valor Venda Unitário (R$) *','hint' => 'Quanto cobra do cliente'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\TallStackUi\View\Components\Form\Input::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'valor_venda_unitario','placeholder' => '0,00','type' => 'number','step' => '0.01']); ?>
                 <?php $__env->slot('prefix', null, []); ?> 
                    <?php if (isset($component)) { $__componentOriginalcf0c10903472319464d99a08725e554d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalcf0c10903472319464d99a08725e554d = $attributes; } ?>
<?php $component = TallStackUi\View\Components\Icon::resolve(['name' => 'currency-dollar'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui-icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\TallStackUi\View\Components\Icon::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-5 h-5 text-gray-400']); ?>
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
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['valor_venda_unitario'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-xs text-red-600 dark:text-red-400"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </div>

    <!-- Resumo de Valores -->
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($quantidade > 0 && ($valor_custo_unitario > 0 || $valor_venda_unitario > 0)): ?>
        <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
            <h4 class="mb-2 text-sm font-semibold text-gray-700 dark:text-gray-300">Resumo Mensal</h4>
            <div class="grid grid-cols-3 gap-4 text-sm">
                <div>
                    <p class="text-gray-600 dark:text-gray-400">Custo Total</p>
                    <p class="font-bold text-orange-600 dark:text-orange-400">
                        R$ <?php echo e(number_format($quantidade * $valor_custo_unitario, 2, ',', '.')); ?>

                    </p>
                </div>
                <div>
                    <p class="text-gray-600 dark:text-gray-400">Receita Total</p>
                    <p class="font-bold text-green-600 dark:text-green-400">
                        R$ <?php echo e(number_format($quantidade * $valor_venda_unitario, 2, ',', '.')); ?>

                    </p>
                </div>
                <div>
                    <p class="text-gray-600 dark:text-gray-400">Lucro</p>
                    <p class="font-bold <?php echo e(($quantidade * $valor_venda_unitario) - ($quantidade * $valor_custo_unitario) >= 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400'); ?>">
                        R$ <?php echo e(number_format(($quantidade * $valor_venda_unitario) - ($quantidade * $valor_custo_unitario), 2, ',', '.')); ?>

                    </p>
                </div>
            </div>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <!-- Data de Ativação -->
    <div>
        <?php if (isset($component)) { $__componentOriginal023cbb78830bf629e0440d3a52ed07da = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal023cbb78830bf629e0440d3a52ed07da = $attributes; } ?>
<?php $component = TallStackUi\View\Components\Form\Input::resolve(['label' => 'Data de Ativação'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\TallStackUi\View\Components\Form\Input::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'data_ativacao','type' => 'date']); ?>
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
<?php /**PATH C:\Users\Rafael Benedicto\Documents\Herd\asbc\resources\views/livewire/customers/products/form.blade.php ENDPATH**/ ?>