<?php extract((new \Illuminate\Support\Collection($attributes->getAttributes()))->mapWithKeys(function ($value, $key) { return [Illuminate\Support\Str::camel(str_replace([':', '.'], ' ', $key)) => $value]; })->all(), EXTR_SKIP); ?>
@props(['class'])
<x-tallstack-ui::icon.heroicons.outline.sun :class="$class" >

{{ $slot ?? "" }}
</x-tallstack-ui::icon.heroicons.outline.sun>