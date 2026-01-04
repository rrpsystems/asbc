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
<?php if (isset($component)) { $__componentOriginal13a0538430c1031c9012c3c412b6bf9a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal13a0538430c1031c9012c3c412b6bf9a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'tallstack-ui::components.icon.heroicons.outline.chevron-left','data' => ['class' => $class]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tallstack-ui::icon.heroicons.outline.chevron-left'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($class)]); ?>

<?php echo e($slot ?? ""); ?>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal13a0538430c1031c9012c3c412b6bf9a)): ?>
<?php $attributes = $__attributesOriginal13a0538430c1031c9012c3c412b6bf9a; ?>
<?php unset($__attributesOriginal13a0538430c1031c9012c3c412b6bf9a); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal13a0538430c1031c9012c3c412b6bf9a)): ?>
<?php $component = $__componentOriginal13a0538430c1031c9012c3c412b6bf9a; ?>
<?php unset($__componentOriginal13a0538430c1031c9012c3c412b6bf9a); ?>
<?php endif; ?><?php /**PATH C:\Users\Rafael Benedicto\Documents\Herd\asbc\storage\framework\views/efb672f04caffc7dd6aa1c1c0d28db31.blade.php ENDPATH**/ ?>