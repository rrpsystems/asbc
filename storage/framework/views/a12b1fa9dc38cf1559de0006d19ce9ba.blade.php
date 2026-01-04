<?php extract((new \Illuminate\Support\Collection($attributes->getAttributes()))->mapWithKeys(function ($value, $key) { return [Illuminate\Support\Str::camel(str_replace([':', '.'], ' ', $key)) => $value]; })->all(), EXTR_SKIP); ?>

<x-ui-floating  {{ $attributes }}>
<x-slot name="footer" >{{ $footer }}</x-slot>
{{ $slot ?? "" }}
</x-ui-floating>