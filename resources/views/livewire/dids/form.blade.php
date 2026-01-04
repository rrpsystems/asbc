<div class="space-y-3 min-h-72">
    <div class="grid grid-cols-3 gap-3">

        <div class="col-span-1">
            <x-ui-number centralized min="1" max="30" label="Quantidade *" icon="phone-x-mark"
                wire:model='quantidade' />
        </div>
        <div class="col-span-1">
        </div>
        <div class="col-span-1">
        </div>


        <div class="col-span-2">
            <x-ui-input label="Numero" icon="phone" wire:model.live='did' />
        </div>

        <div class="col-span-1 pt-8 pl-3">
            <x-ui-toggle color="green" label="Ativo" position="left" wire:model='ativo' />
        </div>

        <div class="col-span-3">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Cliente *</label>
            <select wire:model.live="customer_id" class="w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-cyan-500">
                @foreach($customers as $customer)
                    <option value="{{ $customer['value'] }}">{{ $customer['label'] }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-span-3">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Operadora *</label>
            <select wire:model.live="carrier_id" class="w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-cyan-500">
                @foreach($carriers as $carrier)
                    <option value="{{ $carrier['value'] }}">{{ $carrier['label'] }}</option>
                @endforeach
            </select>
        </div>

        <div class="relative flex items-center justify-center col-span-3">
            <div class="flex items-center w-full">
                <div class="flex-grow border-t border-gray-500"></div>
                <span class="mx-4 text-gray-500">Configurações</span>
                <div class="flex-grow border-t border-gray-500"></div>
            </div>
        </div>

        <div class="col-span-3">
            <x-ui-input label="Tronco *" icon="arrow-trending-up" wire:model.live='encaminhamento' />
        </div>

        <div class="col-span-3">
            <span class="text-sm text-gray-500 text-nowrap">
                PJSIP/{{ preg_replace('/\D/', '', $did ?? '') }}{{'@'. $encaminhamento ?? '' }}
            </span>
        </div>

        <!-- Configurações SBC Específicas -->
        <div class="relative flex items-center justify-center col-span-3 mt-4">
            <div class="flex items-center w-full">
                <div class="flex-grow border-t border-gray-500"></div>
                <span class="mx-4 text-gray-500">🌐 Configurações SBC (Específicas)</span>
                <div class="flex-grow border-t border-gray-500"></div>
            </div>
        </div>

        @if($customer_id)
            @php
                $customer = \App\Models\Customer::find($customer_id);
            @endphp
            <div class="col-span-3 p-3 text-sm rounded-lg bg-blue-50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-300">
                <strong>💡 Configuração Ativa:</strong><br>
                @if($proxy || $porta)
                    <span class="text-green-700 dark:text-green-400">✓ Este DID usa configuração específica</span>
                @else
                    <span>Este DID herdará as configurações do cliente:</span><br>
                    <strong>Proxy:</strong> {{ $customer?->proxy_padrao ?? 'Não definido' }}<br>
                    <strong>Porta:</strong> {{ $customer?->porta_padrao ?? '5060' }}
                @endif
            </div>
        @endif

        <div class="col-span-3 p-2 text-xs rounded bg-gray-50 dark:bg-gray-800 text-gray-600 dark:text-gray-400">
            <strong>Dica:</strong> Deixe os campos abaixo vazios para usar a configuração padrão do cliente.
            Preencha apenas se este DID precisar de configuração diferente.
        </div>

        <div class="col-span-2">
            <x-ui-input label="Proxy (Endereço SBC)" icon="server" wire:model='proxy'
                hint="Deixe vazio para herdar do cliente" />
        </div>

        <div class="col-span-1">
            <x-ui-input label="Porta" icon="bolt" wire:model='porta'
                hint="Deixe vazio para herdar" />
        </div>
    </div>
</div>
