<div wire:poll.3000ms
    class="flex flex-col min-h-[calc(100vh-4rem)] pb-3 pl-6 pr-6 bg-white dark:bg-gray-600 border border-gray-300 dark:border-gray-100 rounded-md shadow-md shadow-black/5">
    <div class="container flex-grow mx-auto">
        <div class="flex flex-col items-center justify-between my-4 sm:flex-row">
            <h3 class="mb-4 text-2xl font-bold text-gray-800 dark:text-gray-200 sm:mb-0">Faturas</h3>
        </div>
        <div class="overflow-x-auto bg-white shadow-md dark:bg-gray-800">
            <x-tables.table>

                <x-slot name=header>
                    <x-tables.th label="Fatura" column="id" :direction="$direction" :sort="$sort" />
                    <x-tables.th label="Competencia" />
                    <x-tables.th label="Vencimento" />
                    <x-tables.th label="Cliente" column="razaosocial" :direction="$direction" :sort="$sort" />
                    <x-tables.th label="Valor" column="custo_total" :direction="$direction" :sort="$sort" />
                    <x-tables.th label="Minutos" column="minutos_total" :direction="$direction" :sort="$sort" />
                    <x-tables.th label="Detalhes" />
                </x-slot>

                <x-slot name=body>
                    @forelse ($invoices as $invoice)
                        <x-tables.tr>
                            <x-tables.td class="py-2">#{{ str_pad($invoice->id, 5, '0', STR_PAD_LEFT) }}</x-tables.td>
                            <x-tables.td
                                class="py-2">{{ str_pad($invoice->mes, 2, '0', STR_PAD_LEFT) }}/{{ $invoice->ano }}</x-tables.td>
                            <x-tables.td
                                class="py-2">{{ $invoice->dataVencimento($invoice->customer->vencimento . '/' . $invoice->mes . '/' . $invoice->ano) }}</x-tables.td>
                            <x-tables.td
                                class="py-2">{{ Str::limit($invoice->customer->razaosocial, 20) }}</x-tables.td>
                            <x-tables.td
                                class="py-2">{{ number_format($invoice->custo_total, 2, ',', '.') }}</x-tables.td>
                            <x-tables.td
                                class="py-2">{{ round($invoice->minutos_total / 60, 0, PHP_ROUND_HALF_UP) }}</x-tables.td>
                            <x-tables.td class="py-0">

                                <span x-on:click="$dispatch('invoice-update', {{ $invoice }})"
                                    wire:key='update-{{ $invoice->id }}'
                                    class="inline-flex items-center font-medium text-yellow-500 transition cursor-pointer hover:text-yellow-700 duration- dark:text-yellow-500">
                                    <x-ui-icon name="edit" class="w-5 h-5 m-0" />
                                    <span class="ml-1">Editar</span>
                                </span>

                                <span x-on:click="$dispatch('invoice-delete', {{ $invoice }})"
                                    wire:key='delete-{{ $invoice->id }}'
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
    {{ $invoices->links('vendor.livewire.paginate') }}
    <livewire:invoices.details />
</div>
