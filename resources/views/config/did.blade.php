<x-app-layout>
    <div x-init="$dispatch('bradcrumb', { menu: ['Config', 'DIDs'] })"></div>

    <livewire:dids.index />

</x-app-layout>
