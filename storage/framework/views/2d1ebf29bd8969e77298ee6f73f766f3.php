<?php extract((new \Illuminate\Support\Collection($attributes->getAttributes()))->mapWithKeys(function ($value, $key) { return [Illuminate\Support\Str::camel(str_replace([':', '.'], ' ', $key)) => $value]; })->all(), EXTR_SKIP); ?>
<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['id','property','error','label','hint','invalidate']));

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

foreach (array_filter((['id','property','error','label','hint','invalidate']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>
<?php if (isset($component)) { $__componentOriginal4a633c6a8875f99a515c7f793637fe6e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4a633c6a8875f99a515c7f793637fe6e = $attributes; } ?>
<?php $component = TallStackUi\View\Components\Wrapper\Input::resolve(['id' => $id,'property' => $property,'error' => $error,'label' => $label,'hint' => $hint,'invalidate' => $invalidate] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui-wrapper.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\TallStackUi\View\Components\Wrapper\Input::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['attributes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($attributes)]); ?>

<?php echo e($slot ?? ""); ?>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal4a633c6a8875f99a515c7f793637fe6e)): ?>
<?php $attributes = $__attributesOriginal4a633c6a8875f99a515c7f793637fe6e; ?>
<?php unset($__attributesOriginal4a633c6a8875f99a515c7f793637fe6e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal4a633c6a8875f99a515c7f793637fe6e)): ?>
<?php $component = $__componentOriginal4a633c6a8875f99a515c7f793637fe6e; ?>
<?php unset($__componentOriginal4a633c6a8875f99a515c7f793637fe6e); ?>
<?php endif; ?><?php /**PATH C:\Users\Rafael Benedicto\Documents\Herd\asbc\storage\framework\views/f3f4564ba4477358e8e5a97e3e981314.blade.php ENDPATH**/ ?>