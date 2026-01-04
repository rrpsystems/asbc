<?php extract((new \Illuminate\Support\Collection($attributes->getAttributes()))->mapWithKeys(function ($value, $key) { return [Illuminate\Support\Str::camel(str_replace([':', '.'], ' ', $key)) => $value]; })->all(), EXTR_SKIP); ?>
<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['id','property','error','label','position','alignment','invalidate']));

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

foreach (array_filter((['id','property','error','label','position','alignment','invalidate']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>
<?php if (isset($component)) { $__componentOriginalcc0f7e5363c5ab989dbe9dbcd36c59a8 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalcc0f7e5363c5ab989dbe9dbcd36c59a8 = $attributes; } ?>
<?php $component = TallStackUi\View\Components\Wrapper\Radio::resolve(['id' => $id,'property' => $property,'error' => $error,'label' => $label,'position' => $position,'alignment' => $alignment,'invalidate' => $invalidate] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui-wrapper.radio'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\TallStackUi\View\Components\Wrapper\Radio::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['attributes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($attributes)]); ?>

<?php echo e($slot ?? ""); ?>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalcc0f7e5363c5ab989dbe9dbcd36c59a8)): ?>
<?php $attributes = $__attributesOriginalcc0f7e5363c5ab989dbe9dbcd36c59a8; ?>
<?php unset($__attributesOriginalcc0f7e5363c5ab989dbe9dbcd36c59a8); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalcc0f7e5363c5ab989dbe9dbcd36c59a8)): ?>
<?php $component = $__componentOriginalcc0f7e5363c5ab989dbe9dbcd36c59a8; ?>
<?php unset($__componentOriginalcc0f7e5363c5ab989dbe9dbcd36c59a8); ?>
<?php endif; ?><?php /**PATH C:\Users\Rafael Benedicto\Documents\Herd\asbc\storage\framework\views/e5711959bea529309f3eaab7a7ffefc2.blade.php ENDPATH**/ ?>