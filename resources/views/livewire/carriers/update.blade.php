<div>
    <x-ui-modal persistent size="4xl" wire="modal">

        <x-slot:title>
            <span class="text-2xl font-bold">
                Editar Operadora - {{ $carrier->operadora ?? '' }}
            </span>
        </x-slot:title>

        <div class="space-y-4">
            @include('livewire.carriers.form')
        </div>

        <x-slot:footer>
            <div class="flex justify-end gap-3">
                <x-ui-button color="stone" wire:click="cancel">
                    Cancelar
                </x-ui-button>

                <x-ui-button color="green" wire:click="update">
                    <x-slot:left>
                        <x-ui-icon icon="check" />
                    </x-slot:left>
                    Salvar
                </x-ui-button>
            </div>
        </x-slot:footer>

    </x-ui-modal>
</div>
