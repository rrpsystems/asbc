<?php extract((new \Illuminate\Support\Collection($attributes->getAttributes()))->mapWithKeys(function ($value, $key) { return [Illuminate\Support\Str::camel(str_replace([':', '.'], ' ', $key)) => $value]; })->all(), EXTR_SKIP); ?>
<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['class']));

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

foreach (array_filter((['class']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>
<?php if (isset($component)) { $__componentOriginaldc58b62142cfb3427d7e9e344e7e59b4 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaldc58b62142cfb3427d7e9e344e7e59b4 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'tallstack-ui::components.icon.heroicons.outline.sun','data' => ['class' => $class]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tallstack-ui::icon.heroicons.outline.sun'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($class)]); ?>

<?php echo e($slot ?? ""); ?>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginaldc58b62142cfb3427d7e9e344e7e59b4)): ?>
<?php $attributes = $__attributesOriginaldc58b62142cfb3427d7e9e344e7e59b4; ?>
<?php unset($__attributesOriginaldc58b62142cfb3427d7e9e344e7e59b4); ?>
<?php endif; ?>
<?php if (isset($__componentOriginaldc58b62142cfb3427d7e9e344e7e59b4)): ?>
<?php $component = $__componentOriginaldc58b62142cfb3427d7e9e344e7e59b4; ?>
<?php unset($__componentOriginaldc58b62142cfb3427d7e9e344e7e59b4); ?>
<?php endif; ?><?php /**PATH C:\Users\Rafael Benedicto\Documents\Herd\asbc\storage\framework\views/b61477ec057c1350d26c8e61f3e1cf58.blade.php ENDPATH**/ ?>