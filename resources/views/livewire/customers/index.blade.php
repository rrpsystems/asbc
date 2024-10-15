<div
    class="flex flex-col min-h-[calc(100vh-4rem)] pb-3 pl-6 pr-6 bg-white dark:bg-gray-600 border border-gray-300 dark:border-gray-100 rounded-md shadow-md shadow-black/5">
    <div class="container flex-grow mx-auto">
        <div class="flex flex-col items-center justify-between my-4 sm:flex-row">
            <h3 class="mb-4 text-2xl font-bold text-gray-800 dark:text-gray-200 sm:mb-0">Lista de Clientes</h3>
            <x-buttons.group btnCreate="customer-create" />
        </div>
        <div class="overflow-x-auto bg-white shadow-md dark:bg-gray-800">
            <x-tables.table>

                <x-slot name=header>
                    <x-tables.th label="Contrato" column="id" :direction="$direction" :sort="$sort" />
                    <x-tables.th label="Cliente" column="razaosocial" :direction="$direction" :sort="$sort" />
                    <x-tables.th label="CNPJ" column="cnpj" :direction="$direction" :sort="$sort" />
                    <x-tables.th label="Valor" column="valor_plano" :direction="$direction" :sort="$sort" />
                    <x-tables.th label="Canais" column="canais" :direction="$direction" :sort="$sort" />
                    <x-tables.th label="Minutos" column="franquia_minutos" :direction="$direction" :sort="$sort" />
                    <x-tables.th label="Ações" />
                </x-slot>

                <x-slot name=body>
                    @forelse ($customers as $customer)
                        <x-tables.tr>
                            <x-tables.td class="py-2">{{ $customer->id }}</x-tables.td>
                            <x-tables.td class="py-2">{{ Str::limit($customer->razaosocial, 25) }}</x-tables.td>
                            <x-tables.td
                                class="py-2">{{ preg_replace('/^(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})$/', '$1.$2.$3/$4-$5', $customer->cnpj) }}</x-tables.td>
                            <x-tables.td
                                class="py-2">{{ number_format($customer->valor_plano, 2, ',', '.') }}</x-tables.td>
                            <x-tables.td class="py-2">{{ $customer->canais }}</x-tables.td>
                            <x-tables.td class="py-2">{{ number_format($customer->franquia_minutos, 0, ',', '.') }}
                            </x-tables.td>
                            <x-tables.td class="py-0">

                                <span x-on:click="$dispatch('customer-update', {{ $customer }})"
                                    wire:key='update-{{ $customer->id }}'
                                    class="inline-flex items-center font-medium text-yellow-500 transition cursor-pointer hover:text-yellow-700 duration- dark:text-yellow-500">
                                    <x-ui-icon name="edit" class="w-5 h-5 m-0" />
                                    <span class="ml-1">Editar</span>
                                </span>

                                <span x-on:click="$dispatch('customer-delete', {{ $customer }})"
                                    wire:key='delete-{{ $customer->id }}'
                                    class="inline-flex items-center ml-4 font-medium text-red-500 transition cursor-pointer hover:text-red-700 duration- dark:text-red-500">
                                    <x-ui-icon name="trash" class="w-5 h-5 m-0" />
                                    <span class="ml-1">Excluir</span>
                                </span>

                            </x-tables.td>
                        </x-tables.tr>

                    @empty
                        Sem Dados
                    @endforelse
                </x-slot>
            </x-tables.table>

        </div>
    </div>
    {{ $customers->links('vendor.livewire.paginate') }}
    <livewire:customers.create />
    <livewire:customers.update />
    <livewire:customers.delete />
</div>
