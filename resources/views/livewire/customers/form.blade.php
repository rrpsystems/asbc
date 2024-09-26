<div class="space-y-3 min-h-72">
    <div class="grid grid-cols-4 gap-3">

        <div class="col-span-3">
            <x-ui-input label="Razão Social *" icon="building" wire:model='razaosocial' />
        </div>
        <div class="col-span-1 pt-8 pl-3">
            <x-ui-toggle color="green" label="Ativo" position="left" wire:model='ativo' />
        </div>


        <div class="col-span-2">
            @isset($customer->id)
                <x-ui-input label="Cotrato *" icon="report" disabled wire:model='contrato' />
            @else
                <x-ui-input label="Cotrato *" icon="report" wire:model='contrato' />
            @endisset
        </div>

        <div class="col-span-2">
            <x-ui-input size="xs" label="CNPJ *" icon="certificate" wire:model='cnpj' />
        </div>


        <div class="col-span-4">
            <x-ui-input label="Endereço *" icon="map-2" wire:model='endereco' />
        </div>

        <div class="col-span-2">
            <x-ui-input label="Numero *" icon="mailbox" wire:model='numero' />
        </div>
        <div class="col-span-2">
            <x-ui-input label="Complemento" icon="mailbox" wire:model='complemento' />
        </div>

        <div class="flex justify-between col-span-3 gap-3">
            <x-ui-input label="CEP *" icon="world-code" wire:model='cep' />
            <x-ui-input label="Cidade *" icon="hierarchy-3" wire:model='cidade' />
        </div>
        <div class="col-span-1">
            <x-ui-input label="UF *" icon="social" wire:model='uf' />
        </div>

        <div class="flex col-span-4 gap-3">
            <div class="w-3/5"> <!-- 60% -->
                <x-ui-input label="Email" icon="mail" wire:model='email' />
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

        <div class="flex col-span-4 gap-3">
            <div class="w-3/6"> <!-- 40% -->
                <x-ui-input label="Franquia *" icon="phone-outgoing" wire:model='franquia_minutos' />
            </div>
            <div class="w-3/6"> <!-- 60% -->
                <x-ui-input label="Valor *" icon="businessplan" wire:model='valor_plano' />
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


    </div>
</div>
