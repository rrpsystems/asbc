<x-app-layout>
    <div x-init="$dispatch('bradcrumb', { menu: ['Alertas', 'Central de Alertas'] })"></div>

    <livewire:alerts.index />

</x-app-layout>
