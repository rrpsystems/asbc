<div
    class="flex flex-col min-h-[calc(100vh-4rem)] pb-3 pl-6 pr-6 bg-white dark:bg-gray-600 border border-gray-300 dark:border-gray-100 rounded-md shadow-md shadow-black/5">
    <div class="container flex-grow mx-auto">
        <div class="flex flex-col items-center justify-between my-4 sm:flex-row">
            <h3 class="mb-4 text-2xl font-bold text-gray-800 dark:text-gray-200 sm:mb-0">Lista de Operadoras</h3>
            <x-buttons.group btnCreate="carrier-create" />
        </div>
        <div class="overflow-x-auto bg-white shadow-md dark:bg-gray-800">
            <x-tables.table>

                <x-slot name=header>
                    <x-tables.th label="Contrato" column="id" :direction="$direction" :sort="$sort" />
                    <x-tables.th label="Operadora" column="operadora" :direction="$direction" :sort="$sort" />
                    <x-tables.th label="Canais" column="canais" :direction="$direction" :sort="$sort" />
                    <x-tables.th label="Data Inicial" column="data_inicio" :direction="$direction" :sort="$sort" />
                    <x-tables.th label="Ativo" column="ativo" :direction="$direction" :sort="$sort" />
                    <x-tables.th label="Ações" />
                </x-slot>

                <x-slot name=body>
                    @forelse ($carriers as $carrier)
                        <x-tables.tr>
                            <x-tables.td class="py-2">{{ $carrier->id }}</x-tables.td>
                            <x-tables.td class="py-2">{{ $carrier->operadora }}</x-tables.td>
                            <x-tables.td class="py-2">{{ $carrier->canais }}</x-tables.td>
                            <x-tables.td class="py-2">{{ date('d/m/Y', strtotime($carrier->data_inicio)) }}
                                <x-tables.td class="py-2">
                                    @if ($carrier->ativo == 0)
                                        <x-ui-badge text="Não" color="red" light xs />
                                    @else
                                        <x-ui-badge text="Sim" color="green" light xs />
                                    @endif
                                </x-tables.td>
                            </x-tables.td>
                            <x-tables.td class="py-0">

                                <span x-on:click="$dispatch('carrier-update', {{ $carrier }})"
                                    wire:key='update-{{ $carrier->id }}'
                                    class="inline-flex items-center font-medium text-yellow-500 transition cursor-pointer hover:text-yellow-700 duration- dark:text-yellow-500">
                                    <x-ui-icon name="edit" class="w-5 h-5 m-0" />
                                    <span class="ml-1">Editar</span>
                                </span>

                                <span x-on:click="$dispatch('carrier-delete', {{ $carrier }})"
                                    wire:key='delete-{{ $carrier->id }}'
                                    class="inline-flex items-center ml-4 font-medium text-red-500 transition cursor-pointer hover:text-red-700 duration- dark:text-red-500">
                                    <x-ui-icon name="trash" class="w-5 h-5 m-0" />
                                    <span class="ml-1">Excluir</span>
                                </span>

                            </x-tables.td>
                        </x-tables.tr>

                    @empty
                        <x-tables.td class="py-2"></x-tables.td>
                        <x-tables.td class="py-2"> Sem Dados</x-tables.td>
                        <x-tables.td class="py-2"></x-tables.td>
                        <x-tables.td class="py-2"></x-tables.td>
                    @endforelse
                </x-slot>
            </x-tables.table>

        </div>
    </div>
    {{ $carriers->links('vendor.livewire.paginate') }}
    <livewire:carriers.create />
    <livewire:carriers.update />
    <livewire:carriers.delete />
</div>
