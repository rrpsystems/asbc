<x-app-layout>
    <div x-init="$dispatch('bradcrumb', { menu: ['Config', 'Operadoras'] })"></div>

    <livewire:carriers.index />

</x-app-layout>
