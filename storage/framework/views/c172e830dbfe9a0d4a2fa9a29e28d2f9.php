<?php extract((new \Illuminate\Support\Collection($attributes->getAttributes()))->mapWithKeys(function ($value, $key) { return [Illuminate\Support\Str::camel(str_replace([':', '.'], ' ', $key)) => $value]; })->all(), EXTR_SKIP); ?>
<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['label','error']));

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

foreach (array_filter((['label','error']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>
<?php if (isset($component)) { $__componentOriginal3b3e4396eff4bda93b0d7cf3b85ceff0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3b3e4396eff4bda93b0d7cf3b85ceff0 = $attributes; } ?>
<?php $component = TallStackUi\View\Components\Form\Label::resolve(['label' => $label,'error' => $error] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\TallStackUi\View\Components\Form\Label::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['attributes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($attributes)]); ?>

<?php echo e($slot ?? ""); ?>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3b3e4396eff4bda93b0d7cf3b85ceff0)): ?>
<?php $attributes = $__attributesOriginal3b3e4396eff4bda93b0d7cf3b85ceff0; ?>
<?php unset($__attributesOriginal3b3e4396eff4bda93b0d7cf3b85ceff0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3b3e4396eff4bda93b0d7cf3b85ceff0)): ?>
<?php $component = $__componentOriginal3b3e4396eff4bda93b0d7cf3b85ceff0; ?>
<?php unset($__componentOriginal3b3e4396eff4bda93b0d7cf3b85ceff0); ?>
<?php endif; ?><?php /**PATH C:\Users\Rafael Benedicto\Documents\Herd\asbc\storage\framework\views/c5304f61bc3e9c0eee1ec21971ad3ed6.blade.php ENDPATH**/ ?>