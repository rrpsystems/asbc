<x-app-layout>
    <div x-init="$dispatch('bradcrumb', { menu: ['Relatórios', 'Rentabilidade'] })"></div>

    <livewire:reports.profitability />

</x-app-layout>
