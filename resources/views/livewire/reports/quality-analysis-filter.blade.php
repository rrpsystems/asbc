<div>
    <x-ui-modal wire="filterModal" title="Filtrar Período e Operadora" size="3xl">

        <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
            <!-- Data Inicial -->
            <div>
                <x-ui-label>Data Inicial</x-ui-label>
                <x-ui-input wire="data_inicial" type="date" />
            </div>

            <!-- Data Final -->
            <div>
                <x-ui-label>Data Final</x-ui-label>
                <x-ui-input wire="data_final" type="date" />
            </div>

            <!-- Operadora -->
            <div>
                <x-ui-label>Operadora</x-ui-label>
                <x-ui-select.native wire:model="carrier_id" :options="array_merge(
                    [['label' => 'Todas as Operadoras', 'value' => 'all']],
                    $carriers->map(fn($c) => ['label' => $c->operadora, 'value' => $c->id])->toArray()
                )" select="label:label|value:value" />
            </div>
        </div>

        <x-slot:footer>
            <div class="flex justify-end gap-2">
                <x-ui-button wire:click="closeFilterModal" text="Cancelar" color="white" />
                <x-ui-button wire:click="applyFilter" text="Aplicar" color="primary" />
            </div>
        </x-slot:footer>

    </x-ui-modal>
</div>
