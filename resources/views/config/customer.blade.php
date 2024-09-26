<x-app-layout>
    <div x-init="$dispatch('bradcrumb', { menu: ['Config', 'Clientes'] })"></div>

    <livewire:customers.index />

</x-app-layout>
