<div class="space-y-3">
    <div class="grid grid-cols-3 gap-3">

        <div class="col-span-2">
            <x-ui-input label="Cotrato" icon="document-text" wire:model.debounce.250ms='contrato' />
        </div>

        <div class="col-span-1 pt-8 pl-3">
            <x-ui-toggle color="green" label="Ativo" position="left" wire:model.debounce.250ms='ativo' />
        </div>

        <div class="col-span-3">
            <x-ui-input label="Operadora" icon="signal" wire:model.debounce.250ms='operadora' />
        </div>

        <div class="col-span-1">
            <x-ui-input label="Canais" icon="arrows-right-left" wire:model.debounce.250ms='canais' />
        </div>

        <div class="col-span-2">
            <x-ui-date label="Data Inicial" format="DD/MM/YYYY" wire:model.debounce.250ms='data_inicio' />
        </div>

    </div>

    <!-- Configurações de Conexão SIP/SBC -->
    <div class="pt-4 mt-4 border-t border-gray-200 dark:border-gray-700">
        <h4 class="mb-3 text-sm font-bold text-gray-700 dark:text-gray-300">Configurações SIP/SBC</h4>

        <div class="grid grid-cols-3 gap-3">
            <div class="col-span-2">
                <x-ui-input label="Proxy (Endereço SBC)" icon="server" wire:model.debounce.250ms='proxy' hint="Ex: sbc.rrpsystems.com.br" />
            </div>

            <div class="col-span-1">
                <x-ui-input label="Porta" icon="bolt" wire:model.debounce.250ms='porta' hint="Ex: 5060, 5099" />
            </div>
        </div>
    </div>

    <!-- Configurações de Plano e Custos -->
    <div class="pt-4 mt-4 border-t border-gray-200 dark:border-gray-700">
        <h4 class="mb-3 text-sm font-bold text-gray-700 dark:text-gray-300">Plano e Custos Mensais</h4>

        <div class="grid grid-cols-3 gap-3">
            <div class="col-span-1">
                <x-ui-input label="Valor Plano Mensal (R$)" icon="currency-dollar" wire:model.debounce.250ms='valor_plano_mensal' hint="Custo fixo mensal" />
            </div>

            <div class="col-span-1">
                <x-ui-input label="DIDs Inclusos" icon="phone" wire:model.debounce.250ms='dids_inclusos' hint="Quantidade no plano" />
            </div>

            <div class="col-span-1 pt-8 pl-3">
                <x-ui-toggle color="green" label="Franquia Compartilhada" position="left" wire:model.debounce.250ms='franquia_compartilhada' />
            </div>
        </div>
    </div>

    <!-- Franquia em Valor (R$) -->
    <div class="pt-4 mt-4 border-t border-gray-200 dark:border-gray-700">
        <h4 class="mb-3 text-sm font-bold text-gray-700 dark:text-gray-300">Franquia em Valor (R$)</h4>

        <div class="grid grid-cols-3 gap-3">
            <div class="col-span-1">
                <x-ui-input label="Valor Fixo (R$)" icon="currency-dollar" wire:model.debounce.250ms='franquia_valor_fixo' hint="Ex: 100,00" />
            </div>

            <div class="col-span-1">
                <x-ui-input label="Valor Móvel (R$)" icon="currency-dollar" wire:model.debounce.250ms='franquia_valor_movel' hint="Ex: 50,00" />
            </div>

            <div class="col-span-1">
                <x-ui-input label="Valor Nacional (R$)" icon="currency-dollar" wire:model.debounce.250ms='franquia_valor_nacional' hint="Ex: 150,00" />
            </div>
        </div>

        <div class="p-3 mt-3 text-sm rounded-lg bg-blue-50 dark:bg-blue-900 text-blue-700 dark:text-blue-200">
            <strong>💡 Como funciona:</strong> A franquia é em valor (R$), não em minutos.
            Por exemplo: R$ 100,00 para gastar em ligações fixas, onde cada minuto custa R$ 0,10.
            Se a franquia for compartilhada, preencha apenas "Valor Nacional".
        </div>
    </div>
</div>
