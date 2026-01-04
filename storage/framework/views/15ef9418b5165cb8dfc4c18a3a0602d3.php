<div class="flex flex-col min-h-[calc(100vh-4rem)] pb-3 pl-6 pr-6 bg-white dark:bg-gray-600 border border-gray-300 dark:border-gray-100 rounded-md shadow-md shadow-black/5">
    <div x-init="$dispatch('bradcrumb', { menu: ['Configurações', 'Revendas', 'Nova Revenda'] })"></div>

    <div class="container flex-grow mx-auto">
        <!-- Header -->
        <div class="flex items-center justify-between my-4">
            <h3 class="text-2xl font-bold text-gray-800 dark:text-gray-200">
                Nova Revenda
            </h3>
            <a href="<?php echo e(route('config.reseller')); ?>" class="px-4 py-2 text-white bg-gray-600 rounded-lg hover:bg-gray-700">
                <svg class="inline-block w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Voltar
            </a>
        </div>

        <!-- Formulário -->
        <form wire:submit.prevent="save">
            <div class="p-6 space-y-6 bg-white dark:bg-gray-800 rounded-lg shadow-lg">

                <!-- Informações Básicas -->
                <div class="border-b border-gray-200 dark:border-gray-700 pb-4">
                    <h4 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-4">Informações Básicas</h4>

                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Nome <span class="text-red-500">*</span>
                            </label>
                            <?php if (isset($component)) { $__componentOriginal023cbb78830bf629e0440d3a52ed07da = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal023cbb78830bf629e0440d3a52ed07da = $attributes; } ?>
<?php $component = TallStackUi\View\Components\Form\Input::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\TallStackUi\View\Components\Form\Input::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'nome','placeholder' => 'Nome da revenda']); ?>
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
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['nome'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-xs text-red-600 dark:text-red-400"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Razão Social
                            </label>
                            <?php if (isset($component)) { $__componentOriginal023cbb78830bf629e0440d3a52ed07da = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal023cbb78830bf629e0440d3a52ed07da = $attributes; } ?>
<?php $component = TallStackUi\View\Components\Form\Input::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\TallStackUi\View\Components\Form\Input::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'razao_social','placeholder' => 'Razão social completa']); ?>
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
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['razao_social'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-xs text-red-600 dark:text-red-400"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                CNPJ
                            </label>
                            <?php if (isset($component)) { $__componentOriginal023cbb78830bf629e0440d3a52ed07da = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal023cbb78830bf629e0440d3a52ed07da = $attributes; } ?>
<?php $component = TallStackUi\View\Components\Form\Input::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\TallStackUi\View\Components\Form\Input::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'cnpj','placeholder' => '00.000.000/0000-00']); ?>
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
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['cnpj'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-xs text-red-600 dark:text-red-400"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                E-mail <span class="text-red-500">*</span>
                            </label>
                            <?php if (isset($component)) { $__componentOriginal023cbb78830bf629e0440d3a52ed07da = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal023cbb78830bf629e0440d3a52ed07da = $attributes; } ?>
<?php $component = TallStackUi\View\Components\Form\Input::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\TallStackUi\View\Components\Form\Input::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'email','type' => 'email','placeholder' => 'contato@revenda.com.br']); ?>
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
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-xs text-red-600 dark:text-red-400"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Telefone
                            </label>
                            <?php if (isset($component)) { $__componentOriginal023cbb78830bf629e0440d3a52ed07da = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal023cbb78830bf629e0440d3a52ed07da = $attributes; } ?>
<?php $component = TallStackUi\View\Components\Form\Input::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\TallStackUi\View\Components\Form\Input::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'telefone','placeholder' => '(00) 00000-0000']); ?>
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
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['telefone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-xs text-red-600 dark:text-red-400"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Endereço -->
                <div class="border-b border-gray-200 dark:border-gray-700 pb-4">
                    <h4 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-4">Endereço</h4>

                    <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Logradouro</label>
                            <?php if (isset($component)) { $__componentOriginal023cbb78830bf629e0440d3a52ed07da = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal023cbb78830bf629e0440d3a52ed07da = $attributes; } ?>
<?php $component = TallStackUi\View\Components\Form\Input::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\TallStackUi\View\Components\Form\Input::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'endereco','placeholder' => 'Rua, Avenida, etc.']); ?>
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

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Número</label>
                            <?php if (isset($component)) { $__componentOriginal023cbb78830bf629e0440d3a52ed07da = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal023cbb78830bf629e0440d3a52ed07da = $attributes; } ?>
<?php $component = TallStackUi\View\Components\Form\Input::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\TallStackUi\View\Components\Form\Input::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'numero','placeholder' => '123']); ?>
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

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Complemento</label>
                            <?php if (isset($component)) { $__componentOriginal023cbb78830bf629e0440d3a52ed07da = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal023cbb78830bf629e0440d3a52ed07da = $attributes; } ?>
<?php $component = TallStackUi\View\Components\Form\Input::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\TallStackUi\View\Components\Form\Input::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'complemento','placeholder' => 'Sala, Andar, etc.']); ?>
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

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Cidade</label>
                            <?php if (isset($component)) { $__componentOriginal023cbb78830bf629e0440d3a52ed07da = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal023cbb78830bf629e0440d3a52ed07da = $attributes; } ?>
<?php $component = TallStackUi\View\Components\Form\Input::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\TallStackUi\View\Components\Form\Input::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'cidade','placeholder' => 'Cidade']); ?>
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

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">UF</label>
                            <?php if (isset($component)) { $__componentOriginal023cbb78830bf629e0440d3a52ed07da = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal023cbb78830bf629e0440d3a52ed07da = $attributes; } ?>
<?php $component = TallStackUi\View\Components\Form\Input::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\TallStackUi\View\Components\Form\Input::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'uf','placeholder' => 'SP','maxlength' => '2']); ?>
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

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">CEP</label>
                            <?php if (isset($component)) { $__componentOriginal023cbb78830bf629e0440d3a52ed07da = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal023cbb78830bf629e0440d3a52ed07da = $attributes; } ?>
<?php $component = TallStackUi\View\Components\Form\Input::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\TallStackUi\View\Components\Form\Input::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'cep','placeholder' => '00000-000']); ?>
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
                </div>

                <!-- Markups Percentuais -->
                <div class="border-b border-gray-200 dark:border-gray-700 pb-4">
                    <h4 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-2">Markups Percentuais</h4>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Percentual a ser aplicado sobre o valor de venda</p>

                    <div class="grid grid-cols-1 gap-4 md:grid-cols-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Chamadas (%) <span class="text-red-500">*</span>
                            </label>
                            <?php if (isset($component)) { $__componentOriginal023cbb78830bf629e0440d3a52ed07da = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal023cbb78830bf629e0440d3a52ed07da = $attributes; } ?>
<?php $component = TallStackUi\View\Components\Form\Input::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\TallStackUi\View\Components\Form\Input::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'markup_chamadas','type' => 'number','step' => '0.01','min' => '0','max' => '100','placeholder' => '0.00']); ?>
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
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['markup_chamadas'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-xs text-red-600 dark:text-red-400"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Produtos (%) <span class="text-red-500">*</span>
                            </label>
                            <?php if (isset($component)) { $__componentOriginal023cbb78830bf629e0440d3a52ed07da = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal023cbb78830bf629e0440d3a52ed07da = $attributes; } ?>
<?php $component = TallStackUi\View\Components\Form\Input::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\TallStackUi\View\Components\Form\Input::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'markup_produtos','type' => 'number','step' => '0.01','min' => '0','max' => '100','placeholder' => '0.00']); ?>
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
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['markup_produtos'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-xs text-red-600 dark:text-red-400"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Planos (%) <span class="text-red-500">*</span>
                            </label>
                            <?php if (isset($component)) { $__componentOriginal023cbb78830bf629e0440d3a52ed07da = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal023cbb78830bf629e0440d3a52ed07da = $attributes; } ?>
<?php $component = TallStackUi\View\Components\Form\Input::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\TallStackUi\View\Components\Form\Input::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'markup_planos','type' => 'number','step' => '0.01','min' => '0','max' => '100','placeholder' => '0.00']); ?>
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
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['markup_planos'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-xs text-red-600 dark:text-red-400"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                DIDs (%) <span class="text-red-500">*</span>
                            </label>
                            <?php if (isset($component)) { $__componentOriginal023cbb78830bf629e0440d3a52ed07da = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal023cbb78830bf629e0440d3a52ed07da = $attributes; } ?>
<?php $component = TallStackUi\View\Components\Form\Input::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\TallStackUi\View\Components\Form\Input::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'markup_dids','type' => 'number','step' => '0.01','min' => '0','max' => '100','placeholder' => '0.00']); ?>
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
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['markup_dids'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-xs text-red-600 dark:text-red-400"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Valores Fixos (Opcional) -->
                <div class="border-b border-gray-200 dark:border-gray-700 pb-4">
                    <h4 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-2">Valores Fixos (Opcional)</h4>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Se preenchido, sobrescreve o markup percentual</p>

                    <div class="grid grid-cols-1 gap-4 md:grid-cols-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Valor Fixo Chamada (R$/min)
                            </label>
                            <?php if (isset($component)) { $__componentOriginal023cbb78830bf629e0440d3a52ed07da = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal023cbb78830bf629e0440d3a52ed07da = $attributes; } ?>
<?php $component = TallStackUi\View\Components\Form\Input::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\TallStackUi\View\Components\Form\Input::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'valor_fixo_chamada','type' => 'number','step' => '0.0001','min' => '0','placeholder' => '0.0000']); ?>
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
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['valor_fixo_chamada'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-xs text-red-600 dark:text-red-400"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Valor Fixo Produto (R$)
                            </label>
                            <?php if (isset($component)) { $__componentOriginal023cbb78830bf629e0440d3a52ed07da = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal023cbb78830bf629e0440d3a52ed07da = $attributes; } ?>
<?php $component = TallStackUi\View\Components\Form\Input::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\TallStackUi\View\Components\Form\Input::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'valor_fixo_produto','type' => 'number','step' => '0.01','min' => '0','placeholder' => '0.00']); ?>
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
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['valor_fixo_produto'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-xs text-red-600 dark:text-red-400"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Valor Fixo Plano (R$)
                            </label>
                            <?php if (isset($component)) { $__componentOriginal023cbb78830bf629e0440d3a52ed07da = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal023cbb78830bf629e0440d3a52ed07da = $attributes; } ?>
<?php $component = TallStackUi\View\Components\Form\Input::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\TallStackUi\View\Components\Form\Input::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'valor_fixo_plano','type' => 'number','step' => '0.01','min' => '0','placeholder' => '0.00']); ?>
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
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['valor_fixo_plano'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-xs text-red-600 dark:text-red-400"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Valor Fixo DID (R$)
                            </label>
                            <?php if (isset($component)) { $__componentOriginal023cbb78830bf629e0440d3a52ed07da = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal023cbb78830bf629e0440d3a52ed07da = $attributes; } ?>
<?php $component = TallStackUi\View\Components\Form\Input::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\TallStackUi\View\Components\Form\Input::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'valor_fixo_did','type' => 'number','step' => '0.01','min' => '0','placeholder' => '0.00']); ?>
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
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['valor_fixo_did'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-xs text-red-600 dark:text-red-400"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Observações e Status -->
                <div>
                    <h4 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-4">Controle</h4>

                    <div class="grid grid-cols-1 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Observações
                            </label>
                            <textarea
                                wire:model="observacoes"
                                rows="3"
                                class="w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 px-3 py-2 text-sm"
                                placeholder="Informações adicionais sobre a revenda..."
                            ></textarea>
                        </div>

                        <div class="flex items-center">
                            <label class="flex items-center cursor-pointer">
                                <input type="checkbox" wire:model="ativo" class="mr-2 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Revenda ativa</span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Botões -->
                <div class="flex justify-end gap-3 pt-4 border-t border-gray-200 dark:border-gray-700">
                    <a href="<?php echo e(route('config.reseller')); ?>" class="px-4 py-2 text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600">
                        Cancelar
                    </a>
                    <button type="submit" class="px-4 py-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700">
                        <svg class="inline-block w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Salvar Revenda
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<?php /**PATH C:\Users\Rafael Benedicto\Documents\Herd\asbc\resources\views/livewire/resellers/create.blade.php ENDPATH**/ ?>