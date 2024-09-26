@props(['name' => 'default', 'routename' => 'dashboard', 'dropdown'])

<li class="mb-1 group {{ Str::startsWith($this->currentRouteName, $routename) ? 'active' : '' }}">
    <a class="flex items-center py-2 px-4 text-gray-300 hover:bg-gray-950 hover:text-gray-100 rounded-md group-[.active]:bg-gray-800 group-[.active]:text-white
        {{ $dropdown == $name ? 'bg-gray-950 text-gray-100' : '' }} "
        wire:click="toogleDropdown('{{ $name }}')">
        @isset($icon)
            {{ $icon }}
        @else
            <x-icons.home class="mr-3 text-lg" h=18 w=18 />
        @endisset
        <span class="text-sm">{{ $name }}</span>
        <x-icons.chevron-right
            class="ml-auto {{ Str::startsWith($this->currentRouteName, $routename) || $dropdown == $name ? 'rotate-90' : '' }} "
            h=16 w=16 />
    </a>
    <ul
        class="pl-7 mt-2 {{ Str::startsWith($this->currentRouteName, $routename) || $dropdown == $name ? 'block' : 'hidden' }} ">
        {{ $slot }}
    </ul>
</li>
