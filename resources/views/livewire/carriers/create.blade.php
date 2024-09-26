<div>
    <x-ui-slide persistent size="md" id="carrier-create" wire>

        <x-slot:title>
            <span class="text-2xl font-bold">
                Nova Operadora
            </span>
        </x-slot:title>

        <x-ui-card>
            @include('livewire.carriers.form')
        </x-ui-card>

        <x-slot:footer class="justify-between">
            <x-ui-button color="green" position="left" wire:click="store">
                <x-slot:left>
                    <x-ui-icon icon="device-floppy" />
                </x-slot:left>
                Salvar
            </x-ui-button>

            <x-ui-button color="stone" position="left" wire:click="cancel">
                <x-slot:left>
                    <x-ui-icon icon="arrow-forward" />
                </x-slot:left>
                Voltar
            </x-ui-button>
        </x-slot:footer>

    </x-ui-slide>
</div>
