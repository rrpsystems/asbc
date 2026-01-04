{{-- <div wire:poll.1000ms> --}}
<div>
    <x-ui-modal persistent size="2xl" wire="slide">
        <x-slot:title>
            <span class="text-xl font-bold">Novo DID</span>
        </x-slot:title>

        <x-ui-card>
            @include('livewire.dids.form')
        </x-ui-card>

        <x-slot:footer>
            <div class="flex justify-between w-full">
                <x-ui-button color="green" position="left" wire:click="create">
                    <x-slot:left>
                        <x-ui-icon icon="check" />
                    </x-slot:left>
                    Salvar
                </x-ui-button>

                <x-ui-button color="stone" position="left" wire:click="cancel">
                    <x-slot:left>
                        <x-ui-icon icon="arrow-left" />
                    </x-slot:left>
                    Voltar
                </x-ui-button>
            </div>
        </x-slot:footer>
    </x-ui-modal>
</div>
