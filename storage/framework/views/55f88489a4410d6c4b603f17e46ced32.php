


<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['label' => null, 'column' => null, 'sort' => null, 'direction' => null]));

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

foreach (array_filter((['label' => null, 'column' => null, 'sort' => null, 'direction' => null]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>


<th <?php echo e($attributes->class([
    'px-4 py-3 text-sm font-medium tracking-wider text-left uppercase whitespace-nowrap',
    'border-b-4 border-cyan-400' => $column == $sort && $column != null,
])); ?>

    <?php if(isset($column)): ?>
    wire:click="sortBy('<?php echo e($column); ?>')"
    <?php endif; ?>>

    <span class="flex items-center justify-start ml-2 text-gray-300 whitespace-nowrap">
        <?php echo e($label); ?>


        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($column)): ?>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($column == $sort && $direction == 'asc'): ?>
                <?php if (isset($component)) { $__componentOriginala59b3f9596324d942df3108585e3d4f2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala59b3f9596324d942df3108585e3d4f2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.asc','data' => ['w2' => true,'h2' => true,'class' => 'ml-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.asc'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['w-2' => true,'h-2' => true,'class' => 'ml-2']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala59b3f9596324d942df3108585e3d4f2)): ?>
<?php $attributes = $__attributesOriginala59b3f9596324d942df3108585e3d4f2; ?>
<?php unset($__attributesOriginala59b3f9596324d942df3108585e3d4f2); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala59b3f9596324d942df3108585e3d4f2)): ?>
<?php $component = $__componentOriginala59b3f9596324d942df3108585e3d4f2; ?>
<?php unset($__componentOriginala59b3f9596324d942df3108585e3d4f2); ?>
<?php endif; ?>
            <?php elseif($column == $sort && $direction == 'desc'): ?>
                <?php if (isset($component)) { $__componentOriginal19b8379c13ff2d7771219acf6c6df1a1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal19b8379c13ff2d7771219acf6c6df1a1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.desc','data' => ['w2' => true,'h2' => true,'class' => 'ml-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.desc'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['w-2' => true,'h-2' => true,'class' => 'ml-2']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal19b8379c13ff2d7771219acf6c6df1a1)): ?>
<?php $attributes = $__attributesOriginal19b8379c13ff2d7771219acf6c6df1a1; ?>
<?php unset($__attributesOriginal19b8379c13ff2d7771219acf6c6df1a1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal19b8379c13ff2d7771219acf6c6df1a1)): ?>
<?php $component = $__componentOriginal19b8379c13ff2d7771219acf6c6df1a1; ?>
<?php unset($__componentOriginal19b8379c13ff2d7771219acf6c6df1a1); ?>
<?php endif; ?>
            <?php else: ?>
                <?php if (isset($component)) { $__componentOriginalb123afd308cf57aff4bb58bb964cfd25 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb123afd308cf57aff4bb58bb964cfd25 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.asc-desc','data' => ['w2' => true,'h2' => true,'class' => 'ml-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.asc-desc'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['w-2' => true,'h-2' => true,'class' => 'ml-2']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalb123afd308cf57aff4bb58bb964cfd25)): ?>
<?php $attributes = $__attributesOriginalb123afd308cf57aff4bb58bb964cfd25; ?>
<?php unset($__attributesOriginalb123afd308cf57aff4bb58bb964cfd25); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb123afd308cf57aff4bb58bb964cfd25)): ?>
<?php $component = $__componentOriginalb123afd308cf57aff4bb58bb964cfd25; ?>
<?php unset($__componentOriginalb123afd308cf57aff4bb58bb964cfd25); ?>
<?php endif; ?>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    </span>
</th>

<?php /**PATH C:\Users\Rafael Benedicto\Documents\Herd\asbc\resources\views/components/tables/th.blade.php ENDPATH**/ ?>