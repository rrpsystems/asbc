<div>
    <x-ui-modal wire="filterModal" title="Filtrar Período" size="2xl">

        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
            <!-- Data Início -->
            <div>
                <x-ui-label>Data Início</x-ui-label>
                <x-ui-input type="date" wire:model="dateStart" />
            </div>

            <!-- Data Fim -->
            <div>
                <x-ui-label>Data Fim</x-ui-label>
                <x-ui-input type="date" wire:model="dateEnd" />
            </div>
        </div>

        <x-slot:footer>
            <div class="flex justify-end gap-2">
                <x-ui-button wire:click="closeFilterModal" text="Cancelar" color="white" />
                <x-ui-button wire:click="filter" text="Aplicar Filtro" color="primary" />
            </div>
        </x-slot:footer>

    </x-ui-modal>
</div>
