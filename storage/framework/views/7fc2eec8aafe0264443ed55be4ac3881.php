<?php
    $personalize = $classes();
?>

<<?php echo e($tag); ?> <?php if($href): ?> href="<?php echo $href; ?>" <?php else: ?> role="button" <?php endif; ?> <?php echo e($attributes->except('type')->class([
        $personalize['wrapper.class'],
        $personalize['wrapper.sizes.' . $size],
        $colors['background'],
        $personalize['wrapper.border.radius.rounded'] => !$square && !$round,
        $personalize['wrapper.border.radius.circle'] => !$square && $round !== null,
    ])); ?> type="<?php echo e($attributes->get('type', $submit ? 'submit' : 'button')); ?>" <?php if($livewire && $loading): ?> wire:loading.attr="disabled" wire:loading.class="!cursor-wait" <?php endif; ?> <?php if($tooltip): ?> x-tooltip="<?php echo e($tooltip); ?>" <?php endif; ?>>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($livewire && $loading && $position === 'left'): ?>
        <?php if (isset($component)) { $__componentOriginalc04097038db3b0d406796d5abe088a72 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc04097038db3b0d406796d5abe088a72 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'tallstack-ui::components.icon.generic.loading-button','data' => ['loading' => $loading,'delay' => $delay,'class' => \Illuminate\Support\Arr::toCssClasses([
                'animate-spin',
                $personalize['icon.sizes.' . $size],
                $colors['icon'],
            ])]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tallstack-ui::icon.generic.loading-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['loading' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($loading),'delay' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($delay),'class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(\Illuminate\Support\Arr::toCssClasses([
                'animate-spin',
                $personalize['icon.sizes.' . $size],
                $colors['icon'],
            ]))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc04097038db3b0d406796d5abe088a72)): ?>
<?php $attributes = $__attributesOriginalc04097038db3b0d406796d5abe088a72; ?>
<?php unset($__attributesOriginalc04097038db3b0d406796d5abe088a72); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc04097038db3b0d406796d5abe088a72)): ?>
<?php $component = $__componentOriginalc04097038db3b0d406796d5abe088a72; ?>
<?php unset($__componentOriginalc04097038db3b0d406796d5abe088a72); ?>
<?php endif; ?>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($left): ?>
        <?php echo $left; ?>

    <?php elseif($icon && $position === 'left'): ?>
        <?php if (isset($component)) { $__componentOriginal511d4862ff04963c3c16115c05a86a9d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal511d4862ff04963c3c16115c05a86a9d = $attributes; } ?>
<?php $component = Illuminate\View\DynamicComponent::resolve(['component' => TallStackUi::prefix('icon')] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dynamic-component'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\DynamicComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['internal' => true,'icon' => $icon,'class' => \Illuminate\Support\Arr::toCssClasses([$personalize['icon.sizes.' . $size], $colors['icon']])]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal511d4862ff04963c3c16115c05a86a9d)): ?>
<?php $attributes = $__attributesOriginal511d4862ff04963c3c16115c05a86a9d; ?>
<?php unset($__attributesOriginal511d4862ff04963c3c16115c05a86a9d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal511d4862ff04963c3c16115c05a86a9d)): ?>
<?php $component = $__componentOriginal511d4862ff04963c3c16115c05a86a9d; ?>
<?php unset($__componentOriginal511d4862ff04963c3c16115c05a86a9d); ?>
<?php endif; ?>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    <?php echo e($text ?? $slot); ?>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($right): ?>
        <?php echo $right; ?>

    <?php elseif($icon && $position === 'right'): ?>
        <?php if (isset($component)) { $__componentOriginal511d4862ff04963c3c16115c05a86a9d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal511d4862ff04963c3c16115c05a86a9d = $attributes; } ?>
<?php $component = Illuminate\View\DynamicComponent::resolve(['component' => TallStackUi::prefix('icon')] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dynamic-component'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\DynamicComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['internal' => true,'icon' => $icon,'class' => \Illuminate\Support\Arr::toCssClasses([$personalize['icon.sizes.' . $size], $colors['icon']])]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal511d4862ff04963c3c16115c05a86a9d)): ?>
<?php $attributes = $__attributesOriginal511d4862ff04963c3c16115c05a86a9d; ?>
<?php unset($__attributesOriginal511d4862ff04963c3c16115c05a86a9d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal511d4862ff04963c3c16115c05a86a9d)): ?>
<?php $component = $__componentOriginal511d4862ff04963c3c16115c05a86a9d; ?>
<?php unset($__componentOriginal511d4862ff04963c3c16115c05a86a9d); ?>
<?php endif; ?>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($livewire && $loading && $position === 'right'): ?>
        <?php if (isset($component)) { $__componentOriginalc04097038db3b0d406796d5abe088a72 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc04097038db3b0d406796d5abe088a72 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'tallstack-ui::components.icon.generic.loading-button','data' => ['loading' => $loading,'delay' => $delay,'class' => \Illuminate\Support\Arr::toCssClasses([
            'animate-spin',
            $personalize['icon.sizes.' . $size],
            $colors['icon'],
        ])]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tallstack-ui::icon.generic.loading-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['loading' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($loading),'delay' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($delay),'class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(\Illuminate\Support\Arr::toCssClasses([
            'animate-spin',
            $personalize['icon.sizes.' . $size],
            $colors['icon'],
        ]))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc04097038db3b0d406796d5abe088a72)): ?>
<?php $attributes = $__attributesOriginalc04097038db3b0d406796d5abe088a72; ?>
<?php unset($__attributesOriginalc04097038db3b0d406796d5abe088a72); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc04097038db3b0d406796d5abe088a72)): ?>
<?php $component = $__componentOriginalc04097038db3b0d406796d5abe088a72; ?>
<?php unset($__componentOriginalc04097038db3b0d406796d5abe088a72); ?>
<?php endif; ?>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</<?php echo e($tag); ?>>
<?php /**PATH C:\Users\Rafael Benedicto\Documents\Herd\asbc\vendor\tallstackui\tallstackui\src/resources/views/components/button/button.blade.php ENDPATH**/ ?>