<?php
    $personalize = $classes();
?>

<?php if (isset($component)) { $__componentOriginal511d4862ff04963c3c16115c05a86a9d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal511d4862ff04963c3c16115c05a86a9d = $attributes; } ?>
<?php $component = Illuminate\View\DynamicComponent::resolve(['component' => TallStackUi::prefix('wrapper.input')] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dynamic-component'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\DynamicComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => $id,'property' => $property,'error' => $error,'label' => $label,'hint' => $hint,'invalidate' => $invalidate]); ?>
    <div x-data="tallstackui_formTextArea(<?php echo \Illuminate\Support\Js::from($resizeAuto)->toHtml() ?>, <?php echo \Illuminate\Support\Js::from($personalize['count.max'])->toHtml() ?>)">
        <div class="<?php echo \Illuminate\Support\Arr::toCssClasses([
            $personalize['input.wrapper'],
            $personalize['input.color.base'] => !$error,
            $personalize['input.color.background'] => !$attributes->get('disabled') && !$attributes->get('readonly'),
            $personalize['input.color.disabled'] => $attributes->get('disabled') || $attributes->get('readonly'),
            $personalize['error'] => $error,
        ]); ?>">
            <textarea <?php if($id): ?> id="<?php echo e($id); ?>" <?php endif; ?>
                    x-ref="textarea"
                    <?php if($count): ?> x-on:keyup="counter()" <?php endif; ?>
                    <?php if($resizeAuto): ?> x-on:input="resize()" <?php endif; ?>
                    <?php echo e($attributes->class([
                        'resize-none' => !$resize && !$resizeAuto,
                        $personalize['input.base'],
                    ])->merge(['rows' => 3])); ?>><?php echo e($attributes->get('value', $slot)); ?></textarea>
        </div>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($count): ?>
            <span class="<?php echo e($personalize['count.base']); ?>" x-ref="counter"></span>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
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
<?php /**PATH C:\Users\Rafael Benedicto\Documents\Herd\asbc\vendor\tallstackui\tallstackui\src/resources/views/components/form/textarea.blade.php ENDPATH**/ ?>