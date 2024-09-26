@props(['name' => 'default', 'routename' => 'dashboard'])

<li class="mb-1 group  {{ $this->currentRouteName == $routename ? 'active' : '' }}">
    <a {{ $attributes }} wire:navigate
        class="flex items-center py-2 px-4 text-gray-300 hover:bg-gray-950 hover:text-gray-100 rounded-md
         group-[.active]:bg-gray-800 group-[.active]:text-white ">
        {{ $slot }}
        <span class="text-sm">{{ $name }}</span>
    </a>
</li>
