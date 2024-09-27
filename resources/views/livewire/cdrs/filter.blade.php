<div>
    {{-- <div> --}}
    <x-ui-slide persistent size="lg" id="slade-filter" left wire>

        <x-slot:title>
            <span class="text-2xl font-bold">
                <x-ui-button color="pink" sm position="left" wire:click="resetFilter">
                    <x-slot:left>
                        <x-ui-icon icon="recycle" />
                    </x-slot:left>
                    Limpar
                </x-ui-button>
                - Filtros CDR
            </span>
        </x-slot:title>

        <x-ui-card>

            <div class="space-y-3 min-h-72">
                <div class="grid grid-cols-4 gap-3">

                    <div class="flex col-span-4 gap-3">
                        <div class="w-3/6">
                            <x-ui-date label="Data Inicial" wire:model.live='data_inicial' format="DD/MM/YYYY"
                                :max-date="now()" />
                        </div>
                        <div class="w-3/6">
                            <x-ui-date label="Data Final" wire:model.live='data_final' format="DD/MM/YYYY"
                                :max-date="now()" />
                        </div>
                    </div>

                    <div class="flex col-span-4 gap-3">
                        <div class="w-full">
                            <x-ui-select.styled label="Tarifa" :options=$tarifas select="label:label|value:value"
                                searchable wire:model.live='tarifa' multiple />
                        </div>
                    </div>

                    <div class="col-span-4">
                        <div class="w-full">
                            <x-ui-select.styled label="Cliente *" :options=$customers select="label:label|value:value"
                                searchable wire:model.live='customer' multiple />
                        </div>
                    </div>
                    <div class="col-span-4">
                        <div class="w-full">
                            <x-ui-select.styled label="DID" :options=$dids select="label:label|value:value"
                                searchable wire:model.live='did' multiple />
                        </div>
                    </div>
                    <div class="col-span-4">
                        <div class="w-full">
                            <x-ui-select.styled label="Operadora *" :options=$carriers select="label:label|value:value"
                                searchable wire:model.live='carrier' multiple />
                        </div>
                    </div>

                    <div class="flex col-span-4 gap-3">
                        <div class="w-3/6">
                            <x-ui-input label="Numero" icon="dialpad" wire:model.live='numero' />
                        </div>
                        <div class="w-3/6">
                            <x-ui-input label="Ramal" icon="dialpad" wire:model.live='ramal' />
                        </div>
                    </div>

                    <div class="col-span-4">
                        <div class="w-full">
                            <x-ui-select.styled label="Status" :options=$status select="label:label|value:value"
                                searchable wire:model.live='stat' multiple />
                        </div>
                    </div>
                    <div class="col-span-4">
                        <div class="w-full">
                            <x-ui-select.styled label="Desligamento" :options=$desligamentos
                                select="label:label|value:value" searchable wire:model.live='desligamento' multiple />
                        </div>
                    </div>

                </div>
            </div>

        </x-ui-card>

        <x-slot:footer class="justify-between">

            <x-ui-button color="stone" position="left" wire:click="cancel">
                <x-slot:left>
                    <x-ui-icon icon="arrow-forward" />
                </x-slot:left>
                Voltar
            </x-ui-button>

            <x-ui-button color="blue" position="left" wire:click="filter">
                <x-slot:left>
                    <x-ui-icon icon="search" />
                </x-slot:left>
                Filtrar
            </x-ui-button>

        </x-slot:footer>

    </x-ui-slide>
</div>
