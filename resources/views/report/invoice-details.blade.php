<x-app-layout>
    <div x-init="$dispatch('bradcrumb', { menu: ['Relatórios', 'Faturas', 'Detalhado'] })"></div>

    <livewire:invoices.details :invoiceId="$invoiceId" />

</x-app-layout>
