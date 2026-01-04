{{-- Componente de Summary Card Padronizado --}}
@props([
    'title' => '',
    'value' => '',
    'icon' => 'chart-bar',
    'color' => 'blue',
    'gradient' => true
])

@php
    $gradientClasses = $gradient
        ? "bg-gradient-to-br from-{$color}-500 to-{$color}-600"
        : "bg-{$color}-500";

    $textColorClass = "text-{$color}-100";
@endphp

<div class="relative overflow-hidden {{ $gradientClasses }} rounded-lg shadow-lg">
    <div class="p-5">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium {{ $textColorClass }}">{{ $title }}</p>
                <p class="text-3xl font-bold text-white">{{ $value }}</p>
            </div>
            <div class="p-3 bg-white bg-opacity-30 rounded-lg">
                <x-ui-icon name="{{ $icon }}" class="w-8 h-8 text-white" />
            </div>
        </div>
    </div>
</div>
