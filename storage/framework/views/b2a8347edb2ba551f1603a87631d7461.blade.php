<?php extract((new \Illuminate\Support\Collection($attributes->getAttributes()))->mapWithKeys(function ($value, $key) { return [Illuminate\Support\Str::camel(str_replace([':', '.'], ' ', $key)) => $value]; })->all(), EXTR_SKIP); ?>
@props(['class','outline'])
<x-tallstack-ui::icon.heroicons.outline.check-circle :class="$class" :outline="$outline" >

{{ $slot ?? "" }}
</x-tallstack-ui::icon.heroicons.outline.check-circle>