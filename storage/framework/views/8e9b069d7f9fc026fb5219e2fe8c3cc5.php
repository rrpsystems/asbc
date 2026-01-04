<?php extract((new \Illuminate\Support\Collection($attributes->getAttributes()))->mapWithKeys(function ($value, $key) { return [Illuminate\Support\Str::camel(str_replace([':', '.'], ' ', $key)) => $value]; })->all(), EXTR_SKIP); ?>

<?php if (isset($component)) { $__componentOriginal3e2044a19f40eadc55449a43f8ef8a6c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3e2044a19f40eadc55449a43f8ef8a6c = $attributes; } ?>
<?php $component = TallStackUi\View\Components\Floating::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui-floating'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\TallStackUi\View\Components\Floating::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['attributes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($attributes)]); ?>
 <?php $__env->slot('footer', null, []); ?> <?php echo e($footer); ?> <?php $__env->endSlot(); ?>
<?php echo e($slot ?? ""); ?>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3e2044a19f40eadc55449a43f8ef8a6c)): ?>
<?php $attributes = $__attributesOriginal3e2044a19f40eadc55449a43f8ef8a6c; ?>
<?php unset($__attributesOriginal3e2044a19f40eadc55449a43f8ef8a6c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3e2044a19f40eadc55449a43f8ef8a6c)): ?>
<?php $component = $__componentOriginal3e2044a19f40eadc55449a43f8ef8a6c; ?>
<?php unset($__componentOriginal3e2044a19f40eadc55449a43f8ef8a6c); ?>
<?php endif; ?><?php /**PATH C:\Users\Rafael Benedicto\Documents\Herd\asbc\storage\framework\views/a12b1fa9dc38cf1559de0006d19ce9ba.blade.php ENDPATH**/ ?>