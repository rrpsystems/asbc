<div class="space-y-3 min-h-72">
    <div class="grid grid-cols-3 gap-3">

        <div class="col-span-2">
            <x-ui-input label="Prefixo" icon="dialpad" wire:model='prefixo' />
        </div>

        <div class="col-span-1 pt-8 pl-3">
            <x-ui-toggle color="green" label="Ativo" position="left" wire:model='ativo' />
        </div>

        <div class="col-span-3">
            <x-ui-input label="Descrição *" icon="building-broadcast-tower" wire:model='descricao' />
        </div>

        <div class="flex justify-between col-span-3 gap-3">
            <div class="w-full">
                <x-ui-select.styled label="Tarifa *" :options=$tarifas select="label:label|value:value" searchable
                    wire:model.live='tarifa_id' />
            </div>
            <div class="w-full">
                <x-ui-select.styled label="Operadora *" :options=$carriers select="label:label|value:value" searchable
                    wire:model.live='carrier_id' />
            </div>
        </div>

        <div class="flex justify-between col-span-3 gap-3">
            <x-ui-input label="Venda *" icon="businessplan" wire:model='venda' />
            <x-ui-input label="Conexão *" icon="currency-dollar-canadian" wire:model='vconexao' />
            <x-ui-input label="Compra *" icon="paywall" wire:model='compra' />
        </div>

        <div class="relative flex items-center justify-center col-span-3">
            <div class="flex items-center w-full">
                <div class="flex-grow border-t border-gray-500"></div>
                <span class="mx-4 text-gray-500">Cadencia</span>
                <div class="flex-grow border-t border-gray-500"></div>
            </div>
        </div>

        <div class="col-span-1">
            <x-ui-input label="Tempo Inicial *" icon="phone-off" wire:model='tempoinicial' />
        </div>
        <div class="col-span-1">
            <x-ui-input label="Tempo Minimo *" icon="phone-outgoing" wire:model='tempominimo' />
        </div>
        <div class="col-span-1">
            <x-ui-input label="Incremento *" icon="replace" wire:model='incremento' />
        </div>


    </div>
</div>
