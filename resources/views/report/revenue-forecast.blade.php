<x-app-layout>
    <div x-init="$dispatch('bradcrumb', { menu: ['Relatórios', 'Previsão de Faturamento'] })"></div>

    <livewire:reports.revenue-forecast />

</x-app-layout>
