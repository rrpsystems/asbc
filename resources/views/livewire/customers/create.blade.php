{{-- <div wire:poll.1000ms> --}}
<div>
    <x-ui-modal persistent size="4xl" wire="slide">
        <x-slot:title>
            <div class="flex items-center">
                <span class="text-xl font-bold">Novo Cliente</span>
                <x-ui-button.circle icon="magnifying-glass" wire:click='consultCnpj' color="pink" class="ml-2" flat />
            </div>
        </x-slot:title>

        <x-ui-card>
            @include('livewire.customers.form')
        </x-ui-card>

        <x-slot:footer>
            <div class="flex justify-between w-full">
                <x-ui-button color="green" position="left" wire:click="store">
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
