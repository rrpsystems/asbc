<?php
    $personalize = $classes();
?>

<div wire:ignore.self x-cloak x-data="{ themeSwitch() { this.$el.dispatchEvent(new CustomEvent('theme', {detail: { darkTheme: darkTheme }})); } }">
    <button type="button"
            role="switch"
            aria-checked="false"
            x-on:click="darkTheme = !darkTheme; themeSwitch()"
            <?php echo e($attributes->only('x-on:change')); ?>

            <?php if(!$onlyIcons): ?> x-bind:class="{ '<?php echo e($personalize['switch.on']); ?>': darkTheme === true, '<?php echo e($personalize['switch.off']); ?>': darkTheme === false }" <?php endif; ?>
            class="<?php echo \Illuminate\Support\Arr::toCssClasses([$personalize['button'], $personalize['switch.button'] => !$onlyIcons, $personalize['switch.sizes.' . $size] => !$onlyIcons]); ?>">
         <div class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                $personalize['switch.wrapper'] => !$onlyIcons, 
                $personalize['switch.icons.sizes.' . $size] => !$onlyIcons, 
                $personalize['simple.wrapper'] => $onlyIcons,
                $personalize['simple.icons.sizes.' . $size] => $onlyIcons,
              ]); ?>"
              <?php if(!$onlyIcons): ?> x-bind:class="{ '<?php echo e($personalize['switch.translate.' . $size]); ?>': darkTheme === true, 'translate-x-0': darkTheme === false }" <?php endif; ?>>
            <span class="<?php echo e($personalize['wrapper']); ?>"
                  aria-hidden="true"
                  x-bind:class="{ 'opacity-0 duration-100 ease-out': darkTheme === true, 'opacity-100 duration-200 ease-in': darkTheme === false }">
               <?php if (isset($component)) { $__componentOriginal511d4862ff04963c3c16115c05a86a9d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal511d4862ff04963c3c16115c05a86a9d = $attributes; } ?>
<?php $component = Illuminate\View\DynamicComponent::resolve(['component' => TallStackUi::prefix('icon')] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dynamic-component'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\DynamicComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => TallStackUi::icon($onlyIcons ? 'moon' : 'sun'),'internal' => true,'class' => \Illuminate\Support\Arr::toCssClasses([
                                        $personalize['colors.moon'] => !$onlyIcons,
                                        $personalize['colors.sun'] => $onlyIcons,
                                        $personalize['switch.icons.sizes.' . $size],
                                        $personalize['simple.icons.sizes.' . $size] => $onlyIcons
                                    ])]); ?>
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
            </span>
            <span class="<?php echo e($personalize['wrapper']); ?>"
                  aria-hidden="true"
                  x-bind:class="{ 'opacity-100 duration-200 ease-in': darkTheme === true, 'opacity-0 duration-100 ease-out': darkTheme === false }">
               <?php if (isset($component)) { $__componentOriginal511d4862ff04963c3c16115c05a86a9d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal511d4862ff04963c3c16115c05a86a9d = $attributes; } ?>
<?php $component = Illuminate\View\DynamicComponent::resolve(['component' => TallStackUi::prefix('icon')] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dynamic-component'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\DynamicComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => TallStackUi::icon($onlyIcons ? 'sun' : 'moon'),'internal' => true,'class' => \Illuminate\Support\Arr::toCssClasses([
                                        $personalize['colors.sun'] => !$onlyIcons,
                                        $personalize['colors.moon'] => $onlyIcons,
                                        $personalize['switch.icons.sizes.' . $size],
                                        $personalize['simple.icons.sizes.' . $size] => $onlyIcons
                                    ])]); ?>
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
            </span>
        </div>
    </button>
</div>
<?php /**PATH C:\Users\Rafael Benedicto\Documents\Herd\asbc\vendor\tallstackui\tallstackui\src/resources/views/components/theme-switch.blade.php ENDPATH**/ ?>