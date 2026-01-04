<?php extract((new \Illuminate\Support\Collection($attributes->getAttributes()))->mapWithKeys(function ($value, $key) { return [Illuminate\Support\Str::camel(str_replace([':', '.'], ' ', $key)) => $value]; })->all(), EXTR_SKIP); ?>
@props(['class','dusk'])
<x-tallstack-ui::icon.heroicons.outline.x-mark :class="$class" :dusk="$dusk" >

{{ $slot ?? "" }}
</x-tallstack-ui::icon.heroicons.outline.x-mark>