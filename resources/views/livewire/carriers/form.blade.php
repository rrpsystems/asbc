<div class="space-y-3 min-h-72">
    <div class="grid grid-cols-3 gap-3">

        <div class="col-span-2">
            <x-ui-input label="Cotrato" icon="report" wire:model.debounce.250ms='contrato' />
        </div>

        <div class="col-span-1 pt-8 pl-3">
            <x-ui-toggle color="green" label="Ativo" position="left" wire:model.debounce.250ms='ativo' />
        </div>

        <div class="col-span-3">
            <x-ui-input label="Operadora" icon="building-broadcast-tower" wire:model.debounce.250ms='operadora' />
        </div>

        <div class="col-span-1">
            <x-ui-input label="Canais" icon="arrows-exchange" wire:model.debounce.250ms='canais' />
        </div>

        <div class="col-span-2">
            <x-ui-date label="Data Inicial" format="DD/MM/YYYY" wire:model.debounce.250ms='data_inicio' />
        </div>

    </div>
</div>
