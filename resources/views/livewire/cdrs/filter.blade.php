<div>
    <x-ui-modal size="4xl" wire="filterModal" persistent>
        <x-slot:title>
            <div class="flex items-center justify-between">
                <span class="text-xl font-bold">Filtros CDR</span>
                <x-ui-button color="pink" sm wire:click="resetFilter">
                    <x-slot:left>
                        <x-ui-icon icon="arrow-path" class="w-4 h-4" />
                    </x-slot:left>
                    Limpar Filtros
                </x-ui-button>
            </div>
        </x-slot:title>

        <div class="p-4">

            <div class="space-y-3 min-h-72">
                <div class="grid grid-cols-4 gap-3">

                    <div class="flex col-span-4 gap-3">
                        <div class="w-3/6">
                            <x-ui-date label="Data Inicial" wire:model='data_inicial' format="DD/MM/YYYY"
                                :max-date="now()" />
                        </div>
                        <div class="w-3/6">
                            <x-ui-date label="Data Final" wire:model='data_final' format="DD/MM/YYYY"
                                :max-date="now()" />
                        </div>
                    </div>

                    <div class="flex col-span-4 gap-3">
                        <div class="w-full">
                            <x-ui-select.styled label="Tarifa" wire:model="tarifa" :options="$tarifas"
                                select="label:label|value:value" searchable multiple />
                        </div>
                    </div>

                    <div class="col-span-4">
                        <div class="w-full">
                            <x-ui-select.styled label="Cliente" wire:model="customer" :options="$customers"
                                select="label:label|value:value" searchable multiple />
                        </div>
                    </div>
                    <div class="col-span-4">
                        <div class="w-full">
                            <x-ui-select.styled label="DID" wire:model="did" :options="$dids"
                                select="label:label|value:value" searchable multiple />
                        </div>
                    </div>
                    <div class="col-span-4">
                        <div class="w-full">
                            <x-ui-select.styled label="Operadora" wire:model="carrier" :options="$carriers"
                                select="label:label|value:value" searchable multiple />
                        </div>
                    </div>

                    <div class="flex col-span-4 gap-3">
                        <div class="w-3/6">
                            <x-ui-input label="Numero" icon="phone" wire:model='numero' />
                        </div>
                        <div class="col-span-1">
                            <x-ui-input label="Ramal" icon="phone" wire:model='ramal' />
                        </div>
                    </div>

                    <div class="col-span-4">
                        <div class="w-full">
                            <x-ui-select.styled label="Status" wire:model="stat" :options="$status"
                                select="label:label|value:value" searchable multiple />
                        </div>
                    </div>
                    <div class="col-span-4">
                        <div class="w-full">
                            <x-ui-select.styled label="Desligamento" wire:model="desligamento" :options="$desligamentos"
                                select="label:label|value:value" searchable multiple />
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <x-slot:footer>
            <div class="flex items-center justify-between w-full gap-3">
                <x-ui-button color="secondary" wire:click="closeFilterModal" class="px-4 py-2">
                    Cancelar
                </x-ui-button>

                <x-ui-button color="primary" wire:click="filter" class="px-4 py-2">
                    <x-slot:left>
                        <x-ui-icon icon="magnifying-glass" class="w-4 h-4" />
                    </x-slot:left>
                    Aplicar Filtros
                </x-ui-button>
            </div>
        </x-slot:footer>

    </x-ui-modal>
</div>
