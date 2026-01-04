<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo e(config('app.name', 'RRP Tarifador')); ?></title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    <script src="/tallstackui/script/tallstackui-k1gB9LkD.js" defer></script><link href="/tallstackui/style/tippy-BHH8rdGj.css" rel="stylesheet" type="text/css">
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <style>
        /* Transições suaves para o conteúdo principal */
        .main {
            transition: margin-left 0.2s ease-in-out, width 0.2s ease-in-out;
        }

        /* Quando sidebar está fechado, expandir conteúdo */
        body.sidebar-closed .main {
            margin-left: 0 !important;
            width: 100% !important;
        }

        /* Mobile sempre fullwidth */
        @media (max-width: 767px) {
            .main {
                margin-left: 0 !important;
                width: 100% !important;
            }
        }
    </style>

</head>

<body class="antialiased text-gray-800 font-sans" x-data="tallstackui_darkTheme()"
    x-bind:class="{ 'dark bg-gray-900': darkTheme, 'bg-gray-50': !darkTheme }">
    <?php if (isset($component)) { $__componentOriginalb17950647b5ba6f8890701dafbbcf7ff = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb17950647b5ba6f8890701dafbbcf7ff = $attributes; } ?>
<?php $component = TallStackUi\View\Components\Interaction\Toast::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui-toast'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\TallStackUi\View\Components\Interaction\Toast::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalb17950647b5ba6f8890701dafbbcf7ff)): ?>
<?php $attributes = $__attributesOriginalb17950647b5ba6f8890701dafbbcf7ff; ?>
<?php unset($__attributesOriginalb17950647b5ba6f8890701dafbbcf7ff); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb17950647b5ba6f8890701dafbbcf7ff)): ?>
<?php $component = $__componentOriginalb17950647b5ba6f8890701dafbbcf7ff; ?>
<?php unset($__componentOriginalb17950647b5ba6f8890701dafbbcf7ff); ?>
<?php endif; ?>
    <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('template.sidebar', []);

$key = null;

$key ??= \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::generateKey('lw-2154985327-0', null);

$__html = app('livewire')->mount($__name, $__params, $key);

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>

    <main class="w-full md:w-[calc(100%-256px)] md:ml-64 bg-gray-50 dark:bg-gray-900 min-h-screen main">
        <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('template.navbar', []);

$key = null;

$key ??= \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::generateKey('lw-2154985327-1', null);

$__html = app('livewire')->mount($__name, $__params, $key);

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>

        <div class="p-6 md:p-8">
            <?php echo e($slot); ?>

        </div>

    </main>

</body>

</html><?php /**PATH C:\Users\Rafael Benedicto\Documents\Herd\asbc\resources\views/layouts/app.blade.php ENDPATH**/ ?>