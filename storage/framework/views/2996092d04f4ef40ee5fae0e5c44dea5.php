<?php
    $personalize = $classes();
?>

<label <?php if($id): ?> for="<?php echo e($id); ?>" <?php endif; ?> class="<?php echo \Illuminate\Support\Arr::toCssClasses([$personalize['text'], $personalize['error'] => $error && !$invalidate]); ?>" <?php echo e($attributes); ?>>
    <?php echo $word; ?>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($asterisk): ?>
        <span class="<?php echo e($personalize['asterisk']); ?>">*</span>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</label>
<?php /**PATH C:\Users\Rafael Benedicto\Documents\Herd\asbc\vendor\tallstackui\tallstackui\src/resources/views/components/form/label.blade.php ENDPATH**/ ?>