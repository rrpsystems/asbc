<x-app-layout>
    <div x-init="$dispatch('bradcrumb', { menu: ['Relatórios', 'Análise de Qualidade'] })"></div>

    <livewire:reports.quality-analysis />

</x-app-layout>
