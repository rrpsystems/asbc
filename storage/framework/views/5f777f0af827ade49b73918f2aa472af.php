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
    <div class="<?php echo \Illuminate\Support\Arr::toCssClasses([
            $personalize['input.wrapper'],
            $personalize['input.color.base'] => !$error,
            $personalize['input.color.background'] => !$attributes->get('disabled') && !$attributes->get('readonly'),
            $personalize['input.color.disabled'] => $attributes->get('disabled') || $attributes->get('readonly'),
            $personalize['error'] => $error === true
        ]); ?>" x-data="tallstackui_formNumber(<?php echo $entangle; ?>, <?php echo \Illuminate\Support\Js::from($min)->toHtml() ?>, <?php echo \Illuminate\Support\Js::from($max)->toHtml() ?>, <?php echo \Illuminate\Support\Js::from($delay)->toHtml() ?>, <?php echo \Illuminate\Support\Js::from($step)->toHtml() ?>)">
        <div class="<?php echo \Illuminate\Support\Arr::toCssClasses([$personalize['buttons.wrapper'], 'justify-between' => $centralized]); ?>">
            <input <?php if($id): ?> id="<?php echo e($id); ?>" <?php endif; ?>
               type="number"
               inputmode="numeric"
               <?php if($min): ?> min="<?php echo e($min); ?>" <?php endif; ?>
               <?php if($max): ?> max="<?php echo e($max); ?>" <?php endif; ?>
               <?php if($step): ?> step="<?php echo e($step); ?>" <?php endif; ?>
               <?php if($selectable): ?> x-on:keydown="$event.preventDefault()" <?php endif; ?>
               <?php echo e($attributes->class([
                    $personalize['input.base'],
                    'text-center' => $centralized,
                    'caret-transparent' => $selectable,
                    'appearance-number-none'
                ])); ?>

               dusk="tallstackui_form_number_input"
               x-on:blur="validate()"
               x-ref="input">
            <button <?php if(!$attributes->get('disabled', $attributes->get('readonly', false))): ?> x-on:click="decrement()" <?php endif; ?>
                    x-on:mousedown="interval = setInterval(() => decrement(), delay * 100);"
                    x-on:touchstart="if (!interval) interval = setInterval(() => decrement(), delay * 100);"
                    x-on:touchend="if (interval) { clearInterval(interval); interval = null; }"
                    x-on:mouseup="if (interval) { clearInterval(interval); interval = null; }"
                    x-on:mouseleave="if (interval) { clearInterval(interval); interval = null; }"
                    x-ref="minus"
                    type="button"
                    <?php if($attributes->get('disabled', $attributes->get('readonly', false))): echo 'disabled'; endif; ?>
                    dusk="tallstackui_form_number_decrement"
                    class="<?php echo \Illuminate\Support\Arr::toCssClasses([$personalize['buttons.left.base'], 'order-first' => $centralized]); ?>">
                <?php if (isset($component)) { $__componentOriginal511d4862ff04963c3c16115c05a86a9d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal511d4862ff04963c3c16115c05a86a9d = $attributes; } ?>
<?php $component = Illuminate\View\DynamicComponent::resolve(['component' => TallStackUi::prefix('icon')] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dynamic-component'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\DynamicComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => $icons['left'],'internal' => true,'class' => \Illuminate\Support\Arr::toCssClasses([$personalize['buttons.left.size'], $personalize['buttons.left.color'] => !$error, $personalize['buttons.left.error'] => $error])]); ?>
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
            </button>
            <button <?php if(!$attributes->get('disabled', $attributes->get('readonly', false))): ?> x-on:click="increment()" <?php endif; ?>
                    x-on:mousedown="interval = setInterval(() => increment(), delay * 100);"
                    x-on:touchstart="if (!interval) interval = setInterval(() => increment(), delay * 100);"
                    x-on:touchend="if (interval) { clearInterval(interval); interval = null; }"
                    x-on:mouseup="if (interval) { clearInterval(interval); interval = null; }"
                    x-on:mouseleave="if (interval) { clearInterval(interval); interval = null; }"
                    x-ref="plus"
                    type="button"
                    <?php if($attributes->get('disabled', $attributes->get('readonly', false))): echo 'disabled'; endif; ?>
                    dusk="tallstackui_form_number_increment"
                    class="<?php echo \Illuminate\Support\Arr::toCssClasses([$personalize['buttons.right.base'], 'border-l border-gray-200 dark:border-gray-600' => !$centralized]); ?>">
                <?php if (isset($component)) { $__componentOriginal511d4862ff04963c3c16115c05a86a9d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal511d4862ff04963c3c16115c05a86a9d = $attributes; } ?>
<?php $component = Illuminate\View\DynamicComponent::resolve(['component' => TallStackUi::prefix('icon')] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dynamic-component'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\DynamicComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => $icons['right'],'internal' => true,'class' => \Illuminate\Support\Arr::toCssClasses([$personalize['buttons.right.size'], $personalize['buttons.right.color'] => !$error, $personalize['buttons.right.error'] => $error])]); ?>
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
            </button>
        </div>
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
<?php /**PATH C:\Users\Rafael Benedicto\Documents\Herd\asbc\vendor\tallstackui\tallstackui\src/resources/views/components/form/number.blade.php ENDPATH**/ ?>