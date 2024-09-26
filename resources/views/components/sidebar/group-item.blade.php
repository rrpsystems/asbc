@props(['name' => 'default', 'routename' => 'dashboard', 'dropdown'])

<li class="mb-4  {{ $this->currentRouteName == $routename ? 'active' : '' }}">
    <a {{ $attributes }} wire:navigate
        class="text-gray-300 text-sm flex items-center hover:text-gray-100 before:contents-[''] before:w-1 before:h-1 before:rounded-full before:bg-gray-300 before:mr-3">
        {{ $name }}
    </a>
</li>
