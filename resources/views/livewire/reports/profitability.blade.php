<div
    class="flex flex-col min-h-[calc(100vh-4rem)] pb-3 pl-6 pr-6 bg-white dark:bg-gray-600 border border-gray-300 dark:border-gray-100 rounded-md shadow-md shadow-black/5">
    <div class="container flex-grow mx-auto">
        <!-- Header -->
        <div class="flex flex-col items-center justify-between my-4 sm:flex-row">
            <div>
                <h3 class="mb-2 text-2xl font-bold text-gray-800 dark:text-gray-200">Relatório de Rentabilidade</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    Período: {{ str_pad($mes, 2, '0', STR_PAD_LEFT) }}/{{ $ano }}
                </p>
            </div>

            <div class="flex flex-wrap gap-2 mt-4 sm:mt-0">
                <button wire:click="exportExcel"
                    class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-white transition-all duration-200 bg-green-600 rounded-lg shadow-sm hover:bg-green-700 hover:shadow-md">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                    Excel
                </button>

                <button wire:click="exportPdf"
                    class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-white transition-all duration-200 bg-red-600 rounded-lg shadow-sm hover:bg-red-700 hover:shadow-md">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z">
                        </path>
                    </svg>
                    PDF
                </button>

                <button wire:click="clearFilters"
                    class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-gray-700 transition-all duration-200 bg-white border border-gray-300 rounded-lg shadow-sm dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600 hover:shadow-md">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    Limpar
                </button>

                <button wire:click="refresh"
                    class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-white transition-all duration-200 bg-blue-600 rounded-lg shadow-sm hover:bg-blue-700 hover:shadow-md">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                        </path>
                    </svg>
                    Atualizar
                </button>

                <x-ui-button icon="funnel" wire:click="openFilter" color="purple" position="left">Período</x-ui-button>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 gap-4 mb-6 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5">
            <!-- Receita Total -->
            <div class="p-4 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg shadow-md">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-blue-100">Receita Total</p>
                        <p class="mt-1 text-2xl font-bold text-white">
                            R$ {{ number_format($totals->total_receita ?? 0, 2, ',', '.') }}
                        </p>
                    </div>
                    <div class="p-3 bg-white/20 rounded-full">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Custo Total -->
            <div class="p-4 bg-gradient-to-br from-red-500 to-red-600 rounded-lg shadow-md">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-red-100">Custo Total</p>
                        <p class="mt-1 text-2xl font-bold text-white">
                            R$ {{ number_format($totals->total_custo ?? 0, 2, ',', '.') }}
                        </p>
                    </div>
                    <div class="p-3 bg-white/20 rounded-full">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Margem de Lucro -->
            <div class="p-4 bg-gradient-to-br from-green-500 to-green-600 rounded-lg shadow-md">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-green-100">Margem de Lucro</p>
                        <p class="mt-1 text-2xl font-bold text-white">
                            R$ {{ number_format($totals->total_margem ?? 0, 2, ',', '.') }}
                        </p>
                    </div>
                    <div class="p-3 bg-white/20 rounded-full">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Rentabilidade Média -->
            <div class="p-4 bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg shadow-md">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-purple-100">Rentabilidade Média</p>
                        <p class="mt-1 text-2xl font-bold text-white">
                            {{ number_format($totals->percentual_medio ?? 0, 1, ',', '.') }}%
                        </p>
                    </div>
                    <div class="p-3 bg-white/20 rounded-full">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Comparação com Mês Anterior -->
            <div class="p-4 bg-gradient-to-br from-orange-500 to-orange-600 rounded-lg shadow-md">
                @if(isset($mesAnterior) && isset($anoAnterior))
                    <p class="mb-2 text-xs font-medium text-orange-100">
                        vs {{ str_pad($mesAnterior, 2, '0', STR_PAD_LEFT) }}/{{ $anoAnterior }}
                    </p>
                    <div class="space-y-1">
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-orange-100">Receita:</span>
                            <span class="text-xs font-bold {{ isset($variacaoReceita) && $variacaoReceita >= 0 ? 'text-white' : 'text-orange-200' }}">
                                @if(isset($variacaoReceita))
                                    @if($variacaoReceita > 0) ↑ @elseif($variacaoReceita < 0) ↓ @else — @endif
                                    {{ number_format(abs($variacaoReceita), 1, ',', '.') }}%
                                @else
                                    —
                                @endif
                            </span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-orange-100">Custo:</span>
                            <span class="text-xs font-bold {{ isset($variacaoCusto) && $variacaoCusto <= 0 ? 'text-white' : 'text-orange-200' }}">
                                @if(isset($variacaoCusto))
                                    @if($variacaoCusto > 0) ↑ @elseif($variacaoCusto < 0) ↓ @else — @endif
                                    {{ number_format(abs($variacaoCusto), 1, ',', '.') }}%
                                @else
                                    —
                                @endif
                            </span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-orange-100">Margem:</span>
                            <span class="text-xs font-bold {{ isset($variacaoMargem) && $variacaoMargem >= 0 ? 'text-white' : 'text-orange-200' }}">
                                @if(isset($variacaoMargem))
                                    @if($variacaoMargem > 0) ↑ @elseif($variacaoMargem < 0) ↓ @else — @endif
                                    {{ number_format(abs($variacaoMargem), 1, ',', '.') }}%
                                @else
                                    —
                                @endif
                            </span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-orange-100">Rent. %:</span>
                            <span class="text-xs font-bold {{ isset($variacaoRentabilidade) && $variacaoRentabilidade >= 0 ? 'text-white' : 'text-orange-200' }}">
                                @if(isset($variacaoRentabilidade))
                                    @if($variacaoRentabilidade > 0) ↑ @elseif($variacaoRentabilidade < 0) ↓ @else — @endif
                                    {{ number_format(abs($variacaoRentabilidade), 1, ',', '.') }} p.p.
                                @else
                                    —
                                @endif
                            </span>
                        </div>
                    </div>
                @else
                    <div class="flex items-center justify-center h-full">
                        <p class="text-xs text-orange-100">Comparação indisponível</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto bg-white shadow-md dark:bg-gray-800">
            <x-tables.table>
                <x-slot name="header">
                    <x-tables.th label="Cliente" column="razaosocial" :direction="$direction" :sort="$sort" />
                    <x-tables.th label="Receita Total" column="receita_final" :direction="$direction" :sort="$sort" />
                    <x-tables.th label="Custo Total" column="custo_total" :direction="$direction" :sort="$sort" />
                    <x-tables.th label="Produtos/Serviços" column="produtos_receita" :direction="$direction" :sort="$sort" />
                    <x-tables.th label="Margem Lucro" column="margem_lucro" :direction="$direction" :sort="$sort" />
                    <x-tables.th label="Rentabilidade %" column="percentual_rentabilidade" :direction="$direction"
                        :sort="$sort" />
                    <x-tables.th label="Ações" />
                </x-slot>

                <x-slot name="body">
                    @forelse ($profitability as $item)
                        <x-tables.tr>
                            <x-tables.td class="py-2">
                                <div>
                                    <p class="font-medium text-gray-900 dark:text-gray-100">
                                        {{ \Illuminate\Support\Str::limit($item->razaosocial, 30) }}
                                    </p>
                                    @if ($item->nomefantasia && $item->nomefantasia !== $item->razaosocial)
                                        <p class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ \Illuminate\Support\Str::limit($item->nomefantasia, 30) }}
                                        </p>
                                    @endif
                                </div>
                            </x-tables.td>

                            <x-tables.td class="py-2">
                                <span class="font-semibold text-blue-600 dark:text-blue-400">
                                    R$ {{ number_format($item->receita_final, 2, ',', '.') }}
                                </span>
                            </x-tables.td>

                            <x-tables.td class="py-2">
                                <span class="text-red-600 dark:text-red-400">
                                    R$ {{ number_format($item->custo_total, 2, ',', '.') }}
                                </span>
                            </x-tables.td>

                            <x-tables.td class="py-2">
                                R$ {{ number_format($item->produtos_receita ?? 0, 2, ',', '.') }}
                            </x-tables.td>

                            <x-tables.td class="py-2">
                                <span
                                    class="font-semibold {{ $item->margem_lucro >= 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                    R$ {{ number_format($item->margem_lucro, 2, ',', '.') }}
                                </span>
                            </x-tables.td>

                            <x-tables.td class="py-2">
                                <div class="flex items-center gap-2">
                                    <span
                                        class="font-bold {{ $item->percentual_rentabilidade >= 20 ? 'text-green-600' : ($item->percentual_rentabilidade >= 10 ? 'text-yellow-600' : 'text-red-600') }}">
                                        {{ number_format($item->percentual_rentabilidade, 1, ',', '.') }}%
                                    </span>
                                    @if ($item->percentual_rentabilidade >= 20)
                                        <span class="text-xs text-green-600">●</span>
                                    @elseif($item->percentual_rentabilidade >= 10)
                                        <span class="text-xs text-yellow-600">●</span>
                                    @else
                                        <span class="text-xs text-red-600">●</span>
                                    @endif
                                </div>
                            </x-tables.td>

                            <x-tables.td class="py-2">
                                <button wire:click="openDetails({{ $item->customer_id }})"
                                    class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                        </path>
                                    </svg>
                                </button>
                            </x-tables.td>
                        </x-tables.tr>
                    @empty
                        <x-tables.tr>
                            <x-tables.td colspan="7" class="py-8 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                        </path>
                                    </svg>
                                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Nenhum dado encontrado
                                        para este período</p>
                                </div>
                            </x-tables.td>
                        </x-tables.tr>
                    @endforelse
                </x-slot>
            </x-tables.table>
        </div>
    </div>

    {{ $profitability->links('vendor.livewire.paginate') }}

    @include('livewire.reports.profitability-filter')
    @include('livewire.reports.profitability-details')
</div>
