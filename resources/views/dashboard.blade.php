<x-app-layout>
    <div x-init="$dispatch('bradcrumb', { menu: ['Dashboard', 'Resumo'] })"></div>

    <livewire:dashboard.index />

</x-app-layout>
