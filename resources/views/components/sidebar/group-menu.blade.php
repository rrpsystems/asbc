@props(['name' => 'default', 'routename' => 'dashboard', 'dropdown'])

@php
    $isActive = Str::startsWith($this->currentRouteName, $routename);
@endphp

<li class="mb-1 group {{ $isActive ? 'active' : '' }}"
    x-data="{ isOpen: {{ $isActive ? 'true' : 'false' }} }">

    <button type="button"
        class="flex items-center w-full py-2 px-4 text-gray-300 hover:bg-gray-950 hover:text-gray-100 rounded-md transition-colors duration-150 group-[.active]:bg-gray-800 group-[.active]:text-white"
        :class="{ 'bg-gray-950 text-gray-100': isOpen }"
        @click="isOpen = !isOpen">
        @isset($icon)
            {{ $icon }}
        @else
            <x-icons.home class="mr-3 text-lg" h=18 w=18 />
        @endisset
        <span class="text-sm">{{ $name }}</span>
        <span class="ml-auto transition-transform duration-150" :class="{ 'rotate-90': isOpen }">
            <x-icons.chevron-right h=16 w=16 />
        </span>
    </button>

    <ul x-show="isOpen"
        x-transition:enter="transition ease-out duration-150"
        x-transition:enter-start="opacity-0 -translate-y-1"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-100"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-1"
        class="pl-7 mt-2"
        style="display: none;">
        {{ $slot }}
    </ul>
</li>
