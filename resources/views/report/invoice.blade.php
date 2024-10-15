<x-app-layout>
    <div x-init="$dispatch('bradcrumb', { menu: ['Relatórios', 'Faturas'] })"></div>

    <livewire:invoices.index />

</x-app-layout>
