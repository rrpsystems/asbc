<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['name' => 'default', 'routename' => 'dashboard', 'dropdown']));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['name' => 'default', 'routename' => 'dashboard', 'dropdown']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    $isActive = Str::startsWith($this->currentRouteName, $routename);
?>

<li class="mb-1 group <?php echo e($isActive ? 'active' : ''); ?>"
    x-data="{ isOpen: <?php echo e($isActive ? 'true' : 'false'); ?> }">

    <button type="button"
        class="flex items-center w-full py-2 px-4 text-gray-300 hover:bg-gray-950 hover:text-gray-100 rounded-md transition-colors duration-150 group-[.active]:bg-gray-800 group-[.active]:text-white"
        :class="{ 'bg-gray-950 text-gray-100': isOpen }"
        @click="isOpen = !isOpen">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($icon)): ?>
            <?php echo e($icon); ?>

        <?php else: ?>
            <?php if (isset($component)) { $__componentOriginal4710407deeab122b4cc56ae776da2d23 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4710407deeab122b4cc56ae776da2d23 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.home','data' => ['class' => 'mr-3 text-lg','h' => '18','w' => '18']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.home'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mr-3 text-lg','h' => '18','w' => '18']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal4710407deeab122b4cc56ae776da2d23)): ?>
<?php $attributes = $__attributesOriginal4710407deeab122b4cc56ae776da2d23; ?>
<?php unset($__attributesOriginal4710407deeab122b4cc56ae776da2d23); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal4710407deeab122b4cc56ae776da2d23)): ?>
<?php $component = $__componentOriginal4710407deeab122b4cc56ae776da2d23; ?>
<?php unset($__componentOriginal4710407deeab122b4cc56ae776da2d23); ?>
<?php endif; ?>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        <span class="text-sm"><?php echo e($name); ?></span>
        <span class="ml-auto transition-transform duration-150" :class="{ 'rotate-90': isOpen }">
            <?php if (isset($component)) { $__componentOriginal1b695c529ad5a6b01ccc95952ff01e01 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1b695c529ad5a6b01ccc95952ff01e01 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.chevron-right','data' => ['h' => '16','w' => '16']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.chevron-right'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['h' => '16','w' => '16']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1b695c529ad5a6b01ccc95952ff01e01)): ?>
<?php $attributes = $__attributesOriginal1b695c529ad5a6b01ccc95952ff01e01; ?>
<?php unset($__attributesOriginal1b695c529ad5a6b01ccc95952ff01e01); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1b695c529ad5a6b01ccc95952ff01e01)): ?>
<?php $component = $__componentOriginal1b695c529ad5a6b01ccc95952ff01e01; ?>
<?php unset($__componentOriginal1b695c529ad5a6b01ccc95952ff01e01); ?>
<?php endif; ?>
        </span>
    </button>

    <ul x-show="isOpen"
        x-transition:enter="transition ease-out duration-150"
        x-transition:enter-start="opacity-0 -translate-y-1"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-100"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-1"
        class="pl-7 mt-2"
        style="display: none;">
        <?php echo e($slot); ?>

    </ul>
</li>
<?php /**PATH C:\Users\Rafael Benedicto\Documents\Herd\asbc\resources\views/components/sidebar/group-menu.blade.php ENDPATH**/ ?>