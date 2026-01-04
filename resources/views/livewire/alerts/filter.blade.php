<div>
    <x-ui-modal wire="filterModal" title="Filtros de Alertas" size="4xl">

        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
            <!-- Severidade -->
            <div>
                <x-ui-label>Severidade</x-ui-label>
                <x-ui-select.native wire:model="selectedSeverity" :options="$severities" select="label:label|value:value"
                    multiple />
            </div>

            <!-- Tipo -->
            <div>
                <x-ui-label>Tipo de Alerta</x-ui-label>
                <x-ui-select.native wire:model="selectedType" :options="$types" select="label:label|value:value"
                    multiple />
            </div>

            <!-- Mostrar Resolvidos -->
            <div class="md:col-span-2">
                <x-ui-checkbox wire:model="showResolved" label="Mostrar alertas resolvidos" />
            </div>
        </div>

        <x-slot:footer>
            <div class="flex justify-end gap-2">
                <x-ui-button wire:click="closeFilterModal" text="Cancelar" color="white" />
                <x-ui-button wire:click="filter" text="Aplicar Filtros" color="primary" />
            </div>
        </x-slot:footer>

    </x-ui-modal>
</div>
