<div class="sticky top-0 left-0 z-30 flex items-center px-6 py-2 bg-white shadow-md shadow-black/5" x-data>

    <button type="button" class="text-lg text-gray-600 transition-colors sidebar-toggle hover:text-gray-900"
            @click="$dispatch('toggle-sidebar')">
        <?php if (isset($component)) { $__componentOriginal0f76eee19490ce4ef90a90abe538c05c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0f76eee19490ce4ef90a90abe538c05c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.menu','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.menu'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0f76eee19490ce4ef90a90abe538c05c)): ?>
<?php $attributes = $__attributesOriginal0f76eee19490ce4ef90a90abe538c05c; ?>
<?php unset($__attributesOriginal0f76eee19490ce4ef90a90abe538c05c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0f76eee19490ce4ef90a90abe538c05c)): ?>
<?php $component = $__componentOriginal0f76eee19490ce4ef90a90abe538c05c; ?>
<?php unset($__componentOriginal0f76eee19490ce4ef90a90abe538c05c); ?>
<?php endif; ?>
    </button>

    <!-- Breadcrumb -->
    <ol class="inline-flex items-center ml-4 space-x-1 text-sm md:space-x-2 rtl:space-x-reverse">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($bradcrumb[0])): ?>
            <li class="inline-flex items-center">
                <span
                    class="inline-flex items-center text-sm font-medium text-gray-400 dark:text-gray-400 <?php echo e($bradcrumb[1] ?? 'text-gray-500'); ?>">
                    <?php echo e($bradcrumb[0]); ?>

                </span>
            </li>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($bradcrumb[1])): ?>
            <li>
                <div class="flex items-center">
                    <svg class="block w-3 h-3 mx-1 text-gray-400 rtl:rotate-180 " aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 9 4-4-4-4" />
                    </svg>
                    <span
                        class="text-sm font-medium text-gray-400 ms-1 md:ms-2 dark:text-gray-400 <?php echo e($bradcrumb[2] ?? 'text-gray-500'); ?>"><?php echo e($bradcrumb[1]); ?></span>
                </div>
            </li>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($bradcrumb[2])): ?>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg class="w-3 h-3 mx-1 text-gray-400 rtl:rotate-180" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 9 4-4-4-4" />
                    </svg>
                    <span
                        class="text-sm font-medium text-gray-500 ms-1 md:ms-2 dark:text-gray-400"><?php echo e($bradcrumb[2]); ?></span>
                </div>
            </li>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    </ol>

    <ul class="flex items-center ml-auto">

        <!-- Alert Notification -->
        <li class="mr-2">
            <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('alerts.notification');

$key = null;

$key ??= \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::generateKey('lw-2155067187-0', null);

$__html = app('livewire')->mount($__name, $__params, $key);

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
        </li>

        <li class="ml-3 dropdown">
            <button type="button" class="flex items-center dropdown-toggle ">
                <span class="mr-3 font-medium text-gray-400">
                    <?php echo e(Auth::user()->name ?? 'Usuario Logado'); ?>

                </span>
            </button>

        </li>

        <li class="mr-1 dropdown">
            <button type="button" title="Sair" wire:click="logout"
                class="flex items-center justify-center w-4 h-4 mx-2 text-gray-400 rounded dropdown-toggle hover:bg-gray-50 hover:text-gray-600">
                <?php if (isset($component)) { $__componentOriginal88de01fd0a2dfb43f9ff296f6277e232 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal88de01fd0a2dfb43f9ff296f6277e232 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.logout','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.logout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal88de01fd0a2dfb43f9ff296f6277e232)): ?>
<?php $attributes = $__attributesOriginal88de01fd0a2dfb43f9ff296f6277e232; ?>
<?php unset($__attributesOriginal88de01fd0a2dfb43f9ff296f6277e232); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal88de01fd0a2dfb43f9ff296f6277e232)): ?>
<?php $component = $__componentOriginal88de01fd0a2dfb43f9ff296f6277e232; ?>
<?php unset($__componentOriginal88de01fd0a2dfb43f9ff296f6277e232); ?>
<?php endif; ?>
            </button>
            <div
                class="z-30 hidden w-full max-w-xs bg-white border border-gray-100 rounded-md shadow-md dropdown-menu shadow-black/5">
            </div>
        </li>

        <li class="dropdown" title="Tema">
            <?php if (isset($component)) { $__componentOriginal15e1a646097229bdd04b70e6243b6419 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal15e1a646097229bdd04b70e6243b6419 = $attributes; } ?>
<?php $component = TallStackUi\View\Components\ThemeSwitch::resolve(['onlyIcons' => true] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui-theme-switch'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\TallStackUi\View\Components\ThemeSwitch::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal15e1a646097229bdd04b70e6243b6419)): ?>
<?php $attributes = $__attributesOriginal15e1a646097229bdd04b70e6243b6419; ?>
<?php unset($__attributesOriginal15e1a646097229bdd04b70e6243b6419); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal15e1a646097229bdd04b70e6243b6419)): ?>
<?php $component = $__componentOriginal15e1a646097229bdd04b70e6243b6419; ?>
<?php unset($__componentOriginal15e1a646097229bdd04b70e6243b6419); ?>
<?php endif; ?>
        </li>
    </ul>
</div>
<?php /**PATH C:\Users\Rafael Benedicto\Documents\Herd\asbc\resources\views/livewire/template/navbar.blade.php ENDPATH**/ ?>