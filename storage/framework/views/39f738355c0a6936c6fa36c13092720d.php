<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['name' => 'default', 'routename' => 'dashboard']));

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

foreach (array_filter((['name' => 'default', 'routename' => 'dashboard']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<li class="mb-1 group  <?php echo e($this->currentRouteName == $routename ? 'active' : ''); ?>">
    <a <?php echo e($attributes); ?> wire:navigate
        class="flex items-center py-2 px-4 text-gray-300 hover:bg-gray-950 hover:text-gray-100 rounded-md
         group-[.active]:bg-gray-800 group-[.active]:text-white ">
        <?php echo e($slot); ?>

        <span class="text-sm"><?php echo e($name); ?></span>
    </a>
</li>
<?php /**PATH C:\Users\Rafael Benedicto\Documents\Herd\asbc\resources\views/components/sidebar/menu.blade.php ENDPATH**/ ?>