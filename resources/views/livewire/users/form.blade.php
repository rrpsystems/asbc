<div class="space-y-3 min-h-72">
    <div class="grid grid-cols-3 gap-3">
        <div class="col-span-2">
            <div class="w-full">
                <x-ui-select.styled label="Acesso *" :options="[
                    ['label' => 'Usuario', 'value' => 'customer'],
                    ['label' => 'Gerente', 'value' => 'manager'],
                    ['label' => 'Administrador', 'value' => 'admin'],
                ]" select="label:label|value:value" searchable
                    wire:model.live='rule' />
            </div>
        </div>
        <div class="col-span-1 pt-8 pl-3">
            <x-ui-toggle color="green" label="Ativo" position="left" wire:model='ativo' />
        </div>
        <div class="col-span-3">
            <x-ui-input label="Nome *" icon="users" wire:model='name' />
        </div>

        <div class="col-span-3">
            <x-ui-input label="email *" icon="mail" wire:model='email' />
        </div>
        <div class="col-span-3">
            <x-ui-password label="Senha *" wire:model='password' />
        </div>
        <div class="col-span-3">
            <x-ui-password label="Confirme a Senha *" wire:model='password_confirmation' />
        </div>

    </div>
</div>
