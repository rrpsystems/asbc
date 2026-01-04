<div class="flex flex-col min-h-[calc(100vh-4rem)] pb-3 pl-6 pr-6 bg-white dark:bg-gray-600 border border-gray-300 dark:border-gray-100 rounded-md shadow-md shadow-black/5">
    <div x-init="$dispatch('bradcrumb', { menu: ['Relatórios', 'Operadoras'] })"></div>

    <div class="container flex-grow mx-auto">
        <div class="flex flex-col items-center justify-between my-4 sm:flex-row">
            <h3 class="mb-4 text-2xl font-bold text-gray-800 dark:text-gray-200 sm:mb-0">Relatórios de Operadora</h3>
            <div class="flex flex-wrap gap-2">
                <button wire:click="exportExcel" class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-white transition-all duration-200 bg-green-600 rounded-lg shadow-sm hover:bg-green-700 hover:shadow-md">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Excel
                </button>
                <button wire:click="exportPdf" class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-white transition-all duration-200 bg-red-600 rounded-lg shadow-sm hover:bg-red-700 hover:shadow-md">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                    </svg>
                    PDF
                </button>
                <button wire:click="clearFilters" class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-gray-700 transition-all duration-200 bg-white border border-gray-300 rounded-lg shadow-sm dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600 hover:shadow-md">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    Limpar
                </button>
                <button wire:click="refresh" class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-white transition-all duration-200 bg-blue-600 rounded-lg shadow-sm hover:bg-blue-700 hover:shadow-md">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                    Atualizar
                </button>
            </div>
        </div>

        <!-- Filtros -->
        <div class="grid grid-cols-1 gap-4 p-4 mb-4 bg-gray-50 dark:bg-gray-700 rounded-lg md:grid-cols-5">
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-200">Mês</label>
                <select wire:model.live="mes" class="w-full px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-800 dark:border-gray-600 dark:text-gray-200">
                    <option value="">Todos</option>
                    @for($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}">{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}</option>
                    @endfor
                </select>
            </div>
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-200">Ano</label>
                <select wire:model.live="ano" class="w-full px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-800 dark:border-gray-600 dark:text-gray-200">
                    <option value="">Todos</option>
                    @for($y = now()->year; $y >= now()->year - 3; $y--)
                        <option value="{{ $y }}">{{ $y }}</option>
                    @endfor
                </select>
            </div>
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-200">Operadora</label>
                <select wire:model.live="carrier_id" class="w-full px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-800 dark:border-gray-600 dark:text-gray-200">
                    <option value="">Todas</option>
                    @foreach($carriers as $carrier)
                        <option value="{{ $carrier->id }}">{{ $carrier->operadora }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-200">Tipo de Serviço</label>
                <select wire:model.live="tipo_servico" class="w-full px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-800 dark:border-gray-600 dark:text-gray-200">
                    <option value="">Todos</option>
                    @foreach($tiposServico as $tipo)
                        <option value="{{ $tipo }}">{{ $tipo }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-200">Competência</label>
                <div class="px-3 py-2 font-semibold text-blue-600 bg-blue-50 dark:bg-blue-900 dark:text-blue-200 rounded-md">
                    {{ str_pad($mes, 2, '0', STR_PAD_LEFT) }}/{{ $ano }}
                </div>
            </div>
        </div>

        <!-- Cards de Resumo -->
        <div class="grid grid-cols-1 gap-4 mb-6 md:grid-cols-4">
            <div class="p-4 bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900 dark:to-green-800 rounded-lg shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-green-600 dark:text-green-300">Total de Minutos</p>
                        <p class="text-2xl font-bold text-green-700 dark:text-green-200">
                            {{ number_format(ceil(($totals->total_minutos ?? 0) / 60), 0, ',', '.') }} min
                        </p>
                        <p class="text-xs text-green-600 dark:text-green-400">
                            ≈ {{ number_format(($totals->total_minutos ?? 0) / 3600, 2, ',', '.') }} horas
                        </p>
                    </div>
                    <div class="p-3 bg-green-200 dark:bg-green-700 rounded-full">
                        <svg class="w-8 h-8 text-green-700 dark:text-green-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="p-4 bg-gradient-to-br from-red-50 to-red-100 dark:from-red-900 dark:to-red-800 rounded-lg shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-red-600 dark:text-red-300">Custo Total</p>
                        <p class="text-2xl font-bold text-red-700 dark:text-red-200">
                            R$ {{ number_format($totals->total_custo ?? 0, 2, ',', '.') }}
                        </p>
                    </div>
                    <div class="p-3 bg-red-200 dark:bg-red-700 rounded-full">
                        <svg class="w-8 h-8 text-red-700 dark:text-red-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="p-4 bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900 dark:to-blue-800 rounded-lg shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-blue-600 dark:text-blue-300">Custo Médio/Min</p>
                        <p class="text-2xl font-bold text-blue-700 dark:text-blue-200">
                            R$ {{ number_format($totals->custo_medio_minuto ?? 0, 4, ',', '.') }}
                        </p>
                    </div>
                    <div class="p-3 bg-blue-200 dark:bg-blue-700 rounded-full">
                        <svg class="w-8 h-8 text-blue-700 dark:text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="p-4 bg-gradient-to-br from-purple-50 to-purple-100 dark:from-purple-900 dark:to-purple-800 rounded-lg shadow">
                <div class="flex items-center justify-between">
                    <div class="w-full">
                        <p class="mb-2 text-sm font-medium text-purple-600 dark:text-purple-300">Variação vs. Mês Anterior</p>
                        @if($mesAnterior && $anoAnterior)
                            <div class="space-y-2">
                                <div class="flex items-center justify-between">
                                    <span class="text-xs text-purple-600 dark:text-purple-400">Minutos:</span>
                                    <span class="flex items-center text-sm font-bold {{ $variacaoMinutos >= 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                        @if($variacaoMinutos > 0) ↑ @elseif($variacaoMinutos < 0) ↓ @else — @endif
                                        {{ number_format(abs($variacaoMinutos), 1, ',', '.') }}%
                                    </span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-xs text-purple-600 dark:text-purple-400">Custo:</span>
                                    <span class="flex items-center text-sm font-bold {{ $variacaoCusto >= 0 ? 'text-red-600 dark:text-red-400' : 'text-green-600 dark:text-green-400' }}">
                                        @if($variacaoCusto > 0) ↑ @elseif($variacaoCusto < 0) ↓ @else — @endif
                                        {{ number_format(abs($variacaoCusto), 1, ',', '.') }}%
                                    </span>
                                </div>
                            </div>
                            <p class="mt-2 text-xs text-purple-500 dark:text-purple-400">
                                Comparado com {{ str_pad($mesAnterior, 2, '0', STR_PAD_LEFT) }}/{{ $anoAnterior }}
                            </p>
                        @else
                            <div class="flex items-center justify-center h-16">
                                <p class="text-xs text-purple-500 dark:text-purple-400 text-center">
                                    Selecione mês e ano<br>para ver a variação
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto bg-white shadow-md dark:bg-gray-800 rounded-lg">
            <x-tables.table>
                <x-slot name="header">
                    <x-tables.th label="Operadora" column="carrier_id" :direction="$direction" :sort="$sort" />
                    <x-tables.th label="Tipo Serviço" column="tipo_servico" :direction="$direction" :sort="$sort" />
                    <x-tables.th label="Competência" />
                    <x-tables.th label="Minutos Utilizados" column="minutos_utilizados" :direction="$direction" :sort="$sort" />
                    <x-tables.th label="Custo Total (R$)" column="custo_total" :direction="$direction" :sort="$sort" />
                    <x-tables.th label="Custo/Min (R$)" />
                </x-slot>

                <x-slot name="body">
                    @forelse ($reports as $report)
                        <x-tables.tr>
                            <x-tables.td class="py-2 font-semibold">
                                {{ $report->carrier->operadora ?? 'N/A' }}
                            </x-tables.td>
                            <x-tables.td class="py-2">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full
                                    @if($report->tipo_servico == 'Fixo') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200
                                    @elseif($report->tipo_servico == 'Movel') bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200
                                    @elseif($report->tipo_servico == 'Internacional') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                                    @else bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200
                                    @endif">
                                    {{ $report->tipo_servico }}
                                </span>
                            </x-tables.td>
                            <x-tables.td class="py-2">
                                {{ str_pad($report->mes, 2, '0', STR_PAD_LEFT) }}/{{ $report->ano }}
                            </x-tables.td>
                            <x-tables.td class="py-2">
                                <span class="text-sm">{{ number_format(ceil($report->minutos_utilizados / 60), 0, ',', '.') }} min</span>
                                <span class="block text-xs text-gray-500">({{ number_format($report->minutos_utilizados / 3600, 2, ',', '.') }} h)</span>
                            </x-tables.td>
                            <x-tables.td class="py-2 font-bold text-green-600 dark:text-green-400">
                                {{ number_format($report->custo_total, 2, ',', '.') }}
                            </x-tables.td>
                            <x-tables.td class="py-2 text-sm text-gray-600 dark:text-gray-400">
                                @if($report->minutos_utilizados > 0)
                                    {{ number_format(($report->custo_total / ceil($report->minutos_utilizados / 60)), 4, ',', '.') }}
                                @else
                                    0,0000
                                @endif
                            </x-tables.td>
                        </x-tables.tr>
                    @empty
                        <x-tables.tr>
                            <x-tables.td colspan="6" class="py-4 text-center text-gray-500">
                                Nenhum relatório encontrado para esta competência
                            </x-tables.td>
                        </x-tables.tr>
                    @endforelse
                </x-slot>
            </x-tables.table>
        </div>
    </div>

    {{ $reports->links('vendor.livewire.paginate') }}
</div>
