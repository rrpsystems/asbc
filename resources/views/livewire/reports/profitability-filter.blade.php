<div>
    <x-ui-modal wire="filterModal" title="Selecionar Período" size="2xl">

        <div class="grid grid-cols-2 gap-4">
            <!-- Mês -->
            <div>
                <x-ui-label>Mês</x-ui-label>
                <x-ui-select.native wire="mes" :options="[
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
                <x-ui-select.native wire="ano" :options="[
                    ['label' => '2023', 'value' => 2023],
                    ['label' => '2024', 'value' => 2024],
                    ['label' => '2025', 'value' => 2025],
                    ['label' => '2026', 'value' => 2026],
                ]" select="label:label|value:value" />
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
