<div class="space-y-3 min-h-72">
    <div class="grid grid-cols-4 gap-3">

        <div class="col-span-3">
            <x-ui-input label="Razão Social *" icon="building-office" wire:model='razaosocial' />
        </div>
        <div class="col-span-1 pt-8 pl-3">
            <x-ui-toggle color="green" label="Ativo" position="left" wire:model='ativo' />
        </div>


        <div class="col-span-2">
            @isset($customer->id)
                <x-ui-input label="Cotrato *" icon="document-text" disabled wire:model='contrato' />
            @else
                <x-ui-input label="Cotrato *" icon="document-text" wire:model='contrato' />
            @endisset
        </div>

        <div class="col-span-2">
            <x-ui-input size="xs" label="CNPJ *" icon="identification" wire:model='cnpj' />
        </div>


        <div class="col-span-4">
            <x-ui-input label="Endereço *" icon="map" wire:model='endereco' />
        </div>

        <div class="col-span-2">
            <x-ui-input label="Numero *" icon="home" wire:model='numero' />
        </div>
        <div class="col-span-2">
            <x-ui-input label="Complemento" icon="home" wire:model='complemento' />
        </div>

        <div class="flex justify-between col-span-3 gap-3">
            <x-ui-input label="CEP *" icon="map-pin" wire:model='cep' />
            <x-ui-input label="Cidade *" icon="building-office" wire:model='cidade' />
        </div>
        <div class="col-span-1">
            <x-ui-input label="UF *" icon="flag" wire:model='uf' />
        </div>

        <div class="flex col-span-4 gap-3">
            <div class="w-3/5"> <!-- 60% -->
                <x-ui-input label="Email" icon="envelope" wire:model='email' />
            </div>
            <div class="w-2/5"> <!-- 40% -->
                <x-ui-input label="Telefone" icon="phone" wire:model='telefone' />
            </div>
        </div>


        <div class="relative flex items-center justify-center col-span-4">
            <div class="flex items-center w-full">
                <div class="flex-grow border-t border-gray-500"></div>
                <span class="mx-4 text-gray-500">Sistema</span>
                <div class="flex-grow border-t border-gray-500"></div>
            </div>
        </div>

        <div class="col-span-4">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                Revenda
            </label>
            <select wire:model="reseller_id"
                class="w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 px-3 py-2 text-sm">
                <option value="">Nenhuma (Cliente direto)</option>
                @foreach($resellers as $reseller)
                    <option value="{{ $reseller->id }}">{{ $reseller->nome }} @if($reseller->razao_social) - {{ $reseller->razao_social }} @endif</option>
                @endforeach
            </select>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                Se selecionada, os markups da revenda serão aplicados aos valores de venda
            </p>
        </div>

        <div class="flex col-span-4 gap-3">
            <div class="w-3/6"> <!-- 40% -->
                <x-ui-input label="Franquia *" icon="phone-arrow-up-right" wire:model='franquia_minutos' />
            </div>
            <div class="w-3/6"> <!-- 60% -->
                <x-ui-input label="Valor *" icon="currency-dollar" wire:model='valor_plano' />
            </div>
        </div>

        <div class="flex col-span-4 gap-3">
            <div class="w-3/5"> <!-- 40% -->
                <x-ui-date label="Data Inicial *" format="DD/MM/YYYY" wire:model='data_inicio' />
            </div>
            <div class="w-2/5"> <!-- 60% -->
                <x-ui-number label="Vencimento *" min="1" max="30" wire:model='vencimento' />
            </div>
        </div>

        <div class="flex col-span-4 gap-3">
            <div class="w-3/5"> <!-- 40% -->
                <x-ui-password label="Senha Web *" wire:model='password' />
            </div>
            <div class="w-2/5"> <!-- 60% -->
                <x-ui-number label="Canais *" min="1" max="30" wire:model='canais' />
            </div>
        </div>

        <!-- Configurações SBC Padrão -->
        <div class="relative flex items-center justify-center col-span-4 mt-4">
            <div class="flex items-center w-full">
                <div class="flex-grow border-t border-gray-500"></div>
                <span class="mx-4 text-gray-500">🌐 Configurações SBC (Padrão)</span>
                <div class="flex-grow border-t border-gray-500"></div>
            </div>
        </div>

        <div class="col-span-4 p-3 text-sm rounded-lg bg-blue-50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-300">
            <strong>💡 Informação:</strong> Configure aqui o proxy/porta padrão deste cliente.
            Todos os DIDs herdarão essas configurações, mas podem ser sobrescritas individualmente se necessário.
        </div>

        <div class="col-span-3">
            <x-ui-input label="Proxy Padrão (Endereço SBC)" icon="server" wire:model='proxy_padrao'
                hint="Ex: sbc.rrpsystems.com.br" />
        </div>

        <div class="col-span-1">
            <x-ui-input label="Porta Padrão" icon="bolt" wire:model='porta_padrao'
                hint="Ex: 5060, 5099" />
        </div>

        <!-- Separador de Bloqueios -->
        <div class="relative flex items-center justify-center col-span-4 mt-4">
            <div class="flex items-center w-full">
                <div class="flex-grow border-t border-gray-500"></div>
                <span class="mx-4 text-gray-500">🚫 Controle de Bloqueios</span>
                <div class="flex-grow border-t border-gray-500"></div>
            </div>
        </div>

        <div class="col-span-4 p-3 text-sm rounded-lg bg-orange-50 dark:bg-orange-900/20 text-orange-700 dark:text-orange-300">
            <strong>⚠️ Atenção:</strong> Os bloqueios aplicados aqui afetarão <strong>todos os DIDs</strong> deste cliente.
            O SBC consultará esses campos para permitir ou bloquear chamadas.
        </div>

        <div class="col-span-2 pt-8 pl-3">
            <x-ui-toggle color="red" label="Bloquear Entrada (Operadora → PABX)" position="left" wire:model='bloqueio_entrada' />
        </div>

        <div class="col-span-2 pt-8 pl-3">
            <x-ui-toggle color="red" label="Bloquear Saída (PABX → Operadora)" position="left" wire:model='bloqueio_saida' />
        </div>

        <div class="col-span-4">
            <x-ui-textarea label="Motivo do Bloqueio" icon="exclamation-circle" wire:model='motivo_bloqueio'
                hint="Ex: Inadimplência, Solicitação do cliente, Manutenção" rows="2" />
        </div>

    </div>
</div>
