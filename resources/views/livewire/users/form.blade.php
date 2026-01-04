<div class="space-y-3 min-h-72">
    <div class="grid grid-cols-3 gap-3">
        <div class="col-span-2">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Perfil de Acesso *</label>
            <select wire:model.live="rule" class="w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-cyan-500">
                <option value="">Selecione o perfil</option>
                @foreach($roles as $role)
                    <option value="{{ $role['value'] }}">{{ $role['label'] }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-span-1 pt-8 pl-3">
            <x-ui-toggle color="green" label="Ativo" position="left" wire:model='ativo' />
        </div>
        <div class="col-span-3">
            <x-ui-input label="Nome *" icon="user" wire:model='name' />
        </div>

        <div class="col-span-3">
            <x-ui-input label="E-mail *" icon="envelope" wire:model='email' />
        </div>

        <div class="col-span-3">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Cliente (opcional)</label>
            <select wire:model="customer_id"
                class="w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-cyan-500">
                <option value="">Nenhum cliente vinculado</option>
                @if(isset($customers) && is_array($customers) && count($customers) > 0)
                    @foreach($customers as $customer)
                        <option value="{{ $customer['value'] }}">{{ $customer['label'] }}</option>
                    @endforeach
                @endif
            </select>
            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                Vincule um cliente se este usuário tiver acesso restrito aos dados de um cliente específico.
            </p>
        </div>

        <div class="col-span-3">
            <x-ui-password label="Senha *" wire:model='password' />
        </div>
        <div class="col-span-3">
            <x-ui-password label="Confirme a Senha *" wire:model='password_confirmation' />
        </div>

    </div>
</div>
