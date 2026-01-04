<?php extract((new \Illuminate\Support\Collection($attributes->getAttributes()))->mapWithKeys(function ($value, $key) { return [Illuminate\Support\Str::camel(str_replace([':', '.'], ' ', $key)) => $value]; })->all(), EXTR_SKIP); ?>
@props(['label','error'])
<x-ui-label :label="$label" :error="$error" {{ $attributes }}>

{{ $slot ?? "" }}
</x-ui-label>