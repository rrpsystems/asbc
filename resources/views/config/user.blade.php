<x-app-layout>
    <div x-init="$dispatch('bradcrumb', { menu: ['Config', 'Usuarios'] })"></div>

    <livewire:users.index />

</x-app-layout>
