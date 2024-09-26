<x-app-layout>
    <div x-init="$dispatch('bradcrumb', { menu: ['Config', 'Tarifas'] })"></div>

    <livewire:rates.index />

</x-app-layout>
