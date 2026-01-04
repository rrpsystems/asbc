<x-app-layout>
    <div x-init="$dispatch('bradcrumb', { menu: ['Relatórios', 'Análise de Rotas e LCR'] })"></div>

    <livewire:reports.route-analysis />

</x-app-layout>
