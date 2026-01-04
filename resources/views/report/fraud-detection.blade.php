<x-app-layout>
    <div x-init="$dispatch('bradcrumb', { menu: ['Relatórios', 'Detecção de Fraude'] })"></div>

    <livewire:reports.fraud-detection />

</x-app-layout>
