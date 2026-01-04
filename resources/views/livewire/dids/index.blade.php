<div
    class="flex flex-col min-h-[calc(100vh-4rem)] pb-3 pl-6 pr-6 bg-white dark:bg-gray-600 border border-gray-300 dark:border-gray-100 rounded-md shadow-md shadow-black/5">
    <div class="container flex-grow mx-auto">
        <div class="flex flex-col items-center justify-between my-4 sm:flex-row">
            <h3 class="mb-4 text-2xl font-bold text-gray-800 dark:text-gray-200 sm:mb-0">Lista de DIDs</h3>
            <x-buttons.group btnCreate="did-create" />
        </div>
        <div class="overflow-x-auto bg-white shadow-md dark:bg-gray-800 rounded-lg">
            <x-tables.table>

                <x-slot name=header>
                    <x-tables.th label="#" column="id" :direction="$direction" :sort="$sort" />
                    <x-tables.th label="Numero" column="did" :direction="$direction" :sort="$sort" />
                    <x-tables.th label="Cliente" column="customer_id" :direction="$direction" :sort="$sort" />
                    <x-tables.th label="Operadora" column="carrier_id" :direction="$direction" :sort="$sort" />
                    <x-tables.th label="Encantamento" column="encaminhamento" :direction="$direction" :sort="$sort" />
                    <x-tables.th label="Ativo" column="ativo" :direction="$direction" :sort="$sort" />
                    <x-tables.th label="Ações" />
                </x-slot>

                <x-slot name=body>
                    @forelse ($dids as $did)
                        <x-tables.tr>
                            <x-tables.td class="py-2">{{ $did->id }}</x-tables.td>
                            <x-tables.td
                                class="py-2">{{ preg_replace('/(\d{2})(\d{4})(\d{4})/', '($1$4) $2$5-$3$6', $did->did) }}</x-tables.td>
                            <x-tables.td class="py-2">{{ $did->customer->razaosocial ?? '' }}</x-tables.td>
                            <x-tables.td class="py-2">{{ $did->carrier->operadora ?? '' }}</x-tables.td>
                            <x-tables.td
                                class="py-2">{{ preg_replace('/(\d{2})(\d{4})(\d{4})/', '($1$4) $2$5-$3$6', $did->encaminhamento) }}</x-tables.td>
                            <x-tables.td class="py-2">
                                @if ($did->ativo == 0)
                                    <x-ui-badge text="Não" color="red" light xs />
                                @else
                                    <x-ui-badge text="Sim" color="green" light xs />
                                @endif
                            </x-tables.td>
                            <x-tables.td class="py-0">

                                <span x-on:click="$dispatch('did-update', {{ $did }})"
                                    wire:key='update-{{ $did->id }}'
                                    class="inline-flex items-center font-medium text-yellow-500 transition cursor-pointer hover:text-yellow-700 duration- dark:text-yellow-500">
                                    <x-ui-icon name="pencil-square" class="w-5 h-5 m-0" />
                                    <span class="ml-1">Editar</span>
                                </span>

                                <span x-on:click="$dispatch('did-delete', {{ $did }})"
                                    wire:key='delete-{{ $did->id }}'
                                    class="inline-flex items-center ml-4 font-medium text-red-500 transition cursor-pointer hover:text-red-700 duration- dark:text-red-500">
                                    <x-ui-icon name="trash" class="w-5 h-5 m-0" />
                                    <span class="ml-1">Excluir</span>
                                </span>

                            </x-tables.td>
                        </x-tables.tr>

                    @empty
                        <x-empty-state
                            colspan="7"
                            icon="hashtag"
                            message="Nenhum DID encontrado"
                            hint="Cadastre um novo DID para começar"
                        />
                    @endforelse
                </x-slot>
            </x-tables.table>

        </div>
    </div>
    {{ $dids->links('vendor.livewire.paginate') }}
    <livewire:dids.create />
    <livewire:dids.update />
    <livewire:dids.delete />
</div>
