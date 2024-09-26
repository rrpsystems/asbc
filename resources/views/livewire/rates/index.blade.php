<div
    class="flex flex-col min-h-[calc(100vh-4rem)] pb-3 pl-6 pr-6 bg-white dark:bg-gray-600 border border-gray-300 dark:border-gray-100 rounded-md shadow-md shadow-black/5">
    <div class="container flex-grow mx-auto">
        <div class="flex flex-col items-center justify-between my-4 sm:flex-row">
            <h3 class="mb-4 text-2xl font-bold text-gray-800 dark:text-gray-200 sm:mb-0">Lista de Tarifas</h3>
            <x-buttons.group btnCreate="rate-create" />
        </div>
        <div class="overflow-x-auto bg-white shadow-md dark:bg-gray-800">
            <x-tables.table>

                <x-slot name=header>
                    <x-tables.th label="Prefixo" column="prefixo" :direction="$direction" :sort="$sort" />
                    <x-tables.th label="Tarifa" column="tarifa" :direction="$direction" :sort="$sort" />
                    <x-tables.th label="Operadora" column="carrier_id" :direction="$direction" :sort="$sort" />
                    <x-tables.th label="Descricão" column="descricao" :direction="$direction" :sort="$sort" />
                    <x-tables.th label="Cadencia" />
                    <x-tables.th label="Compra" column="compra" :direction="$direction" :sort="$sort" />
                    <x-tables.th label="Venda" column="venda" :direction="$direction" :sort="$sort" />
                    <x-tables.th label="Ações" />
                </x-slot>

                <x-slot name=body>
                    @forelse ($rates as $rate)
                        <x-tables.tr>
                            <x-tables.td class="py-2">{{ $rate->prefixo }}</x-tables.td>
                            <x-tables.td class="py-2">{{ $rate->tarifa }}</x-tables.td>
                            <x-tables.td class="py-2">{{ $rate->carrier->operadora }}</x-tables.td>
                            <x-tables.td class="py-2">{{ $rate->descricao }}</x-tables.td>
                            <x-tables.td class="py-2">{{ $rate->tempoinicial }} / {{ $rate->tempominimo }} /
                                {{ $rate->incremento }}</x-tables.td>

                            <x-tables.td class="py-2">{{ $rate->compra }}</x-tables.td>
                            <x-tables.td class="py-2">{{ $rate->venda }}</x-tables.td>

                            <x-tables.td class="py-0">

                                <span x-on:click="$dispatch('rate-update', {{ $rate }})"
                                    wire:key='update-{{ $rate->id }}'
                                    class="inline-flex items-center font-medium text-yellow-500 transition cursor-pointer hover:text-yellow-700 duration- dark:text-yellow-500">
                                    <x-ui-icon name="edit" class="w-5 h-5 m-0" />
                                    <span class="ml-1">Editar</span>
                                </span>

                                <span x-on:click="$dispatch('rate-delete', {{ $rate }})"
                                    wire:key='delete-{{ $rate->id }}'
                                    class="inline-flex items-center ml-4 font-medium text-red-500 transition cursor-pointer hover:text-red-700 duration- dark:text-red-500">
                                    <x-ui-icon name="trash" class="w-5 h-5 m-0" />
                                    <span class="ml-1">Excluir</span>
                                </span>

                            </x-tables.td>
                        </x-tables.tr>

                    @empty
                        <x-tables.td class="py-2"></x-tables.td>
                        <x-tables.td class="py-2"></x-tables.td>
                        <x-tables.td class="py-2"></x-tables.td>
                        <x-tables.td class="py-2"> Sem Dados</x-tables.td>
                        <x-tables.td class="py-2"></x-tables.td>
                        <x-tables.td class="py-2"></x-tables.td>
                        <x-tables.td class="py-2"></x-tables.td>
                    @endforelse
                </x-slot>
            </x-tables.table>

        </div>
    </div>
    {{ $rates->links('vendor.livewire.paginate') }}
    <livewire:rates.create />
    <livewire:rates.update />
    <livewire:rates.delete />
</div>
