<x-app-layout>
    <div x-init="$dispatch('bradcrumb', { menu: ['Relatórios', 'Log CDR'] })"></div>

    <livewire:cdrs.index />

</x-app-layout>
