<div
    class="flex flex-col min-h-[calc(100vh-4rem)] pb-3 pl-6 pr-6 bg-white dark:bg-gray-600 border border-gray-300 dark:border-gray-100 rounded-md shadow-md shadow-black/5">
    <div class="container flex-grow mx-auto">
        <div class="flex flex-col items-center justify-between my-4 sm:flex-row">
            <h3 class="mb-4 text-2xl font-bold text-gray-800 dark:text-gray-200 sm:mb-0">Faturas</h3>
        </div>
        <div class="overflow-x-auto bg-white shadow-md dark:bg-gray-800 rounded-lg">
            <x-tables.table>

                <x-slot name=header>
                    <x-tables.th label="Fatura" column="id" :direction="$direction" :sort="$sort" />
                    <x-tables.th label="Competência" />
                    <x-tables.th label="Vencimento" />
                    <x-tables.th label="Cliente" column="razaosocial" :direction="$direction" :sort="$sort" />
                    <x-tables.th label="Plano (R$)" />
                    <x-tables.th label="Excedente (R$)" />
                    <x-tables.th label="Total (R$)" column="custo_total" :direction="$direction" :sort="$sort" />
                    <x-tables.th label="Minutos" column="minutos_total" :direction="$direction" :sort="$sort" />
                    <x-tables.th label="Status" />
                    <x-tables.th label="Detalhes" />
                </x-slot>

                <x-slot name=body>
                    @forelse ($invoices as $invoice)
                        <x-tables.tr>
                            <x-tables.td class="py-2 font-semibold">#{{ str_pad($invoice->id, 5, '0', STR_PAD_LEFT) }}</x-tables.td>
                            <x-tables.td class="py-2">{{ str_pad($invoice->mes, 2, '0', STR_PAD_LEFT) }}/{{ $invoice->ano }}</x-tables.td>
                            <x-tables.td class="py-2">{{ $invoice->dataVencimento($invoice->customer->vencimento . '/' . $invoice->mes . '/' . $invoice->ano) }}</x-tables.td>
                            <x-tables.td class="py-2">{{ Str::limit($invoice->customer->razaosocial, 20) }}</x-tables.td>
                            <x-tables.td class="py-2 text-blue-600 dark:text-blue-400">{{ number_format($invoice->valor_plano, 2, ',', '.') }}</x-tables.td>
                            <x-tables.td class="py-2 {{ $invoice->custo_excedente > 0 ? 'text-orange-600 dark:text-orange-400 font-semibold' : '' }}">
                                {{ number_format($invoice->custo_excedente, 2, ',', '.') }}
                            </x-tables.td>
                            <x-tables.td class="py-2 font-bold text-green-600 dark:text-green-400">{{ number_format($invoice->custo_total, 2, ',', '.') }}</x-tables.td>
                            <x-tables.td class="py-2">
                                <span class="text-sm">{{ round($invoice->minutos_total / 60, 0, PHP_ROUND_HALF_UP) }} min</span>
                                @if($invoice->minutos_excedentes > 0)
                                    <span class="block text-xs text-orange-500">(+{{ round($invoice->minutos_excedentes / 60, 0, PHP_ROUND_HALF_UP) }} exc.)</span>
                                @endif
                            </x-tables.td>
                            <x-tables.td class="py-2">
                                @if($invoice->fechado)
                                    <span class="px-2 py-1 text-xs font-semibold text-green-800 bg-green-100 rounded-full dark:bg-green-900 dark:text-green-200">Fechada</span>
                                @else
                                    <span class="px-2 py-1 text-xs font-semibold text-yellow-800 bg-yellow-100 rounded-full dark:bg-yellow-900 dark:text-yellow-200">Aberta</span>
                                @endif
                            </x-tables.td>
                            <x-tables.td class="py-2" wire:click="openDetails({{ $invoice->id }})" wire:key='{{ $invoice->uniqueid }}'>
                                <x-ui-icon name="eye-check" class="cursor-pointer hover:text-gray-100 dark:hover:text-blue-500" />
                            </x-tables.td>
                        </x-tables.tr>

                    @empty
                        <x-empty-state
                            colspan="10"
                            icon="document-text"
                            message="Nenhuma fatura encontrada"
                            hint="As faturas serão geradas automaticamente no fechamento do mês"
                        />
                    @endforelse
                </x-slot>
            </x-tables.table>

        </div>
    </div>
    {{ $invoices->links('vendor.livewire.paginate') }}
    {{-- <livewire:invoices.details /> --}}
</div>
