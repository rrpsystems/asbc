<div>
    <x-ui-modal wire="filterModal" title="Filtrar Período" size="2xl">

        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
            <!-- Mês -->
            <div>
                <x-ui-label>Mês</x-ui-label>
                <x-ui-select.native wire:model="mes" :options="[
                    ['label' => 'Janeiro', 'value' => 1],
                    ['label' => 'Fevereiro', 'value' => 2],
                    ['label' => 'Março', 'value' => 3],
                    ['label' => 'Abril', 'value' => 4],
                    ['label' => 'Maio', 'value' => 5],
                    ['label' => 'Junho', 'value' => 6],
                    ['label' => 'Julho', 'value' => 7],
                    ['label' => 'Agosto', 'value' => 8],
                    ['label' => 'Setembro', 'value' => 9],
                    ['label' => 'Outubro', 'value' => 10],
                    ['label' => 'Novembro', 'value' => 11],
                    ['label' => 'Dezembro', 'value' => 12],
                ]" select="label:label|value:value" />
            </div>

            <!-- Ano -->
            <div>
                <x-ui-label>Ano</x-ui-label>
                <x-ui-input type="number" wire:model="ano" min="2020" max="2030" />
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
