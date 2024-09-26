<div class="space-y-3 min-h-72">
    <div class="grid grid-cols-3 gap-3">

        <div class="col-span-1">
            <x-ui-number centralized min="1" max="30" label="Quantidade *" icon="phone-off"
                wire:model='quantidade' />
        </div>
        <div class="col-span-1">
        </div>
        <div class="col-span-1">
        </div>


        <div class="col-span-2">
            <x-ui-input label="Numero" icon="dialpad" wire:model.live='did' />
        </div>

        <div class="col-span-1 pt-8 pl-3">
            <x-ui-toggle color="green" label="Ativo" position="left" wire:model='ativo' />
        </div>

        <div class="col-span-3">
            <div class="w-full">
                <x-ui-select.styled label="Cliente *" :options=$customers select="label:label|value:value" searchable
                    wire:model.live='customer_id' />
            </div>
        </div>
        <div class="col-span-3">
            <div class="w-full">
                <x-ui-select.styled label="Operadora *" :options=$carriers select="label:label|value:value" searchable
                    wire:model.live='carrier_id' />
            </div>
        </div>

        <div class="relative flex items-center justify-center col-span-3">
            <div class="flex items-center w-full">
                <div class="flex-grow border-t border-gray-500"></div>
                <span class="mx-4 text-gray-500">Configurações</span>
                <div class="flex-grow border-t border-gray-500"></div>
            </div>
        </div>

        <div class="col-span-3">
            <x-ui-input label="Tronco *" icon="route" wire:model.live='encaminhamento' />
        </div>

        <div class="col-span-3">
            <span class="text-sm text-gray-500 text-nowrap">
                PJSIP/{{ preg_replace('/\D/', '', $did ?? '') }}{{'@'. $encaminhamento ?? '' }}
            </span>
        </div>
    </div>
</div>
