<?php
    $personalize = $classes();
?>

<div x-show="<?php echo e($attributes->get('x-show', 'show')); ?>" 
     x-cloak
     x-on:click.outside="<?php echo e($attributes->get('x-show', 'show')); ?> = false"
     x-on:keydown.escape.window="<?php echo e($attributes->get('x-show', 'show')); ?> = false"
     x-intersect:leave="<?php echo e($attributes->get('x-show', 'show')); ?> = false"
     <?php echo e($anchor()); ?>="<?php echo e($attributes->get('x-anchor', '$refs.anchor')); ?>"
     <?php echo e($attributes->whereStartsWith('x-on')); ?>

     <?php if(count($attributes->whereStartsWith('x-transition')->getAttributes()) === 0 || $transition?->isEmpty()): ?>
         x-transition:enter="transition duration-100 ease-out"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-75"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-2"
     <?php elseif($transition?->isNotEmpty()): ?> <?php echo e($transition); ?> <?php else: ?> <?php echo $attributes->except(['x-show', 'x-anchor', 'class']); ?> <?php endif; ?>
    <?php echo e($attributes->except(['floating', 'x-anchor'])->merge(['class' => $attributes->get('floating', $personalize['wrapper'])])); ?>>
    <?php echo e($slot); ?>

    <?php echo e($footer); ?>

</div>
<?php /**PATH C:\Users\Rafael Benedicto\Documents\Herd\asbc\vendor\tallstackui\tallstackui\src/resources/views/components/floating.blade.php ENDPATH**/ ?>