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
<?php if (isset($component)) { $__componentOriginal45f54b43bdd427afcfeb5388b7e038ce = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal45f54b43bdd427afcfeb5388b7e038ce = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'tallstack-ui::components.icon.heroicons.outline.chevron-down','data' => ['class' => $class]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tallstack-ui::icon.heroicons.outline.chevron-down'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($class)]); ?>

<?php echo e($slot ?? ""); ?>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal45f54b43bdd427afcfeb5388b7e038ce)): ?>
<?php $attributes = $__attributesOriginal45f54b43bdd427afcfeb5388b7e038ce; ?>
<?php unset($__attributesOriginal45f54b43bdd427afcfeb5388b7e038ce); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal45f54b43bdd427afcfeb5388b7e038ce)): ?>
<?php $component = $__componentOriginal45f54b43bdd427afcfeb5388b7e038ce; ?>
<?php unset($__componentOriginal45f54b43bdd427afcfeb5388b7e038ce); ?>
<?php endif; ?><?php /**PATH C:\Users\Rafael Benedicto\Documents\Herd\asbc\storage\framework\views/83593a3ed4a6ed06ce785460a1bcaea5.blade.php ENDPATH**/ ?>