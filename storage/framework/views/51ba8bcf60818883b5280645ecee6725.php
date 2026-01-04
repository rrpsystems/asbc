<?php extract((new \Illuminate\Support\Collection($attributes->getAttributes()))->mapWithKeys(function ($value, $key) { return [Illuminate\Support\Str::camel(str_replace([':', '.'], ' ', $key)) => $value]; })->all(), EXTR_SKIP); ?>
<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['invalidate']));

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

foreach (array_filter((['invalidate']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>
<?php if (isset($component)) { $__componentOriginal023cbb78830bf629e0440d3a52ed07da = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal023cbb78830bf629e0440d3a52ed07da = $attributes; } ?>
<?php $component = TallStackUi\View\Components\Form\Input::resolve(['invalidate' => $invalidate] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\TallStackUi\View\Components\Form\Input::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['attributes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($attributes)]); ?>

<?php echo e($slot ?? ""); ?>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal023cbb78830bf629e0440d3a52ed07da)): ?>
<?php $attributes = $__attributesOriginal023cbb78830bf629e0440d3a52ed07da; ?>
<?php unset($__attributesOriginal023cbb78830bf629e0440d3a52ed07da); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal023cbb78830bf629e0440d3a52ed07da)): ?>
<?php $component = $__componentOriginal023cbb78830bf629e0440d3a52ed07da; ?>
<?php unset($__componentOriginal023cbb78830bf629e0440d3a52ed07da); ?>
<?php endif; ?><?php /**PATH C:\Users\Rafael Benedicto\Documents\Herd\asbc\storage\framework\views/d393e16b3ce5cbbe450f13ca8fd3a90e.blade.php ENDPATH**/ ?>