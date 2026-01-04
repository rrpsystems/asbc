<?php extract((new \Illuminate\Support\Collection($attributes->getAttributes()))->mapWithKeys(function ($value, $key) { return [Illuminate\Support\Str::camel(str_replace([':', '.'], ' ', $key)) => $value]; })->all(), EXTR_SKIP); ?>
<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['class','xShow']));

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

foreach (array_filter((['class','xShow']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>
<?php if (isset($component)) { $__componentOriginal9b4f73c4edd8c855cec8177668b358cc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9b4f73c4edd8c855cec8177668b358cc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'tallstack-ui::components.icon.heroicons.outline.eye-slash','data' => ['class' => $class,'xShow' => $xShow]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tallstack-ui::icon.heroicons.outline.eye-slash'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($class),'x-show' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($xShow)]); ?>

<?php echo e($slot ?? ""); ?>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9b4f73c4edd8c855cec8177668b358cc)): ?>
<?php $attributes = $__attributesOriginal9b4f73c4edd8c855cec8177668b358cc; ?>
<?php unset($__attributesOriginal9b4f73c4edd8c855cec8177668b358cc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9b4f73c4edd8c855cec8177668b358cc)): ?>
<?php $component = $__componentOriginal9b4f73c4edd8c855cec8177668b358cc; ?>
<?php unset($__componentOriginal9b4f73c4edd8c855cec8177668b358cc); ?>
<?php endif; ?><?php /**PATH C:\Users\Rafael Benedicto\Documents\Herd\asbc\storage\framework\views/68cbbe2b45198d77e6e6e436240bbe13.blade.php ENDPATH**/ ?>