<div class="space-y-3 min-h-72">
    <div class="grid grid-cols-3 gap-3">

        <div class="col-span-2">
            <x-ui-input label="Prefixo" icon="phone" wire:model='prefixo' />
        </div>

        <div class="col-span-1 pt-8 pl-3">
            <x-ui-toggle color="green" label="Ativo" position="left" wire:model='ativo' />
        </div>

        <div class="col-span-3">
            <x-ui-input label="Descrição *" icon="signal" wire:model='descricao' />
        </div>

        <div class="flex justify-between col-span-3 gap-3">
            <div class="w-full">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Tarifa *</label>
                <select wire:model.live="tarifa_id" class="w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-cyan-500">
                    @foreach($tarifas as $tarifa)
                        <option value="{{ $tarifa['value'] }}">{{ $tarifa['label'] }}</option>
                    @endforeach
                </select>
            </div>
            <div class="w-full">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Operadora *</label>
                <select wire:model.live="carrier_id" class="w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-cyan-500">
                    @foreach($carriers as $carrier)
                        <option value="{{ $carrier['value'] }}">{{ $carrier['label'] }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="flex justify-between col-span-3 gap-3">
            <x-ui-input label="Venda *" icon="currency-dollar" wire:model='venda' />
            <x-ui-input label="Conexão *" icon="currency-dollar" wire:model='vconexao' />
            <x-ui-input label="Compra *" icon="banknotes" wire:model='compra' />
        </div>

        <div class="relative flex items-center justify-center col-span-3">
            <div class="flex items-center w-full">
                <div class="flex-grow border-t border-gray-500"></div>
                <span class="mx-4 text-gray-500">Cadencia</span>
                <div class="flex-grow border-t border-gray-500"></div>
            </div>
        </div>

        <div class="col-span-1">
            <x-ui-input label="Tempo Inicial *" icon="phone-x-mark" wire:model='tempoinicial' />
        </div>
        <div class="col-span-1">
            <x-ui-input label="Tempo Minimo *" icon="phone-arrow-up-right" wire:model='tempominimo' />
        </div>
        <div class="col-span-1">
            <x-ui-input label="Incremento *" icon="arrow-path" wire:model='incremento' />
        </div>


    </div>
</div>
