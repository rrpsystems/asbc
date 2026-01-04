<div
    class="flex flex-col min-h-[calc(100vh-4rem)] pb-3 pl-6 pr-6 bg-white dark:bg-gray-600 border border-gray-300 dark:border-gray-100 rounded-md shadow-md shadow-black/5">
    <div class="container flex-grow mx-auto">
        <!-- Header -->
        <div class="flex flex-col items-center justify-between my-4 sm:flex-row">
            <div>
                <h3 class="mb-2 text-2xl font-bold text-gray-800 dark:text-gray-200">Análise de Rotas e LCR</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    {{ str_pad($mes, 2, '0', STR_PAD_LEFT) }}/{{ $ano }} - Otimização de custos por
                    roteamento
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

                <x-ui-button wire:click="openFilterModal" color="purple" icon="funnel" position="left">Período</x-ui-button>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 gap-4 mb-6 md:grid-cols-2 lg:grid-cols-4">
            <!-- Custo Atual -->
            <div class="p-4 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg shadow-md">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-blue-100">Custo Atual</p>
                        <p class="mt-1 text-2xl font-bold text-white">
                            R$ {{ number_format($stats->total_cost, 2, ',', '.') }}
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

            <!-- Custo com LCR -->
            <div class="p-4 bg-gradient-to-br from-green-500 to-green-600 rounded-lg shadow-md">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-green-100">Custo com LCR</p>
                        <p class="mt-1 text-2xl font-bold text-white">
                            R$ {{ number_format($stats->lcr_cost, 2, ',', '.') }}
                        </p>
                    </div>
                    <div class="p-3 bg-white/20 rounded-full">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Economia Potencial -->
            <div class="p-4 bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-lg shadow-md">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-yellow-100">Economia Potencial</p>
                        <p class="mt-1 text-2xl font-bold text-white">
                            R$ {{ number_format($stats->total_savings, 2, ',', '.') }}
                        </p>
                        <p class="text-xs text-yellow-100">
                            {{ number_format($stats->avg_savings_percent, 1, ',', '.') }}% em média
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

            <!-- Rotas com Economia -->
            <div class="p-4 bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg shadow-md">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-purple-100">Rotas Otimizáveis</p>
                        <p class="mt-1 text-2xl font-bold text-white">
                            {{ $stats->routes_with_savings }}
                        </p>
                    </div>
                    <div class="p-3 bg-white/20 rounded-full">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto bg-white shadow-md dark:bg-gray-800">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-800">
                    <tr>
                        <th
                            class="px-4 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-400">
                            Prefixo
                        </th>
                        <th
                            class="px-4 py-3 text-xs font-medium tracking-wider text-center text-gray-500 uppercase dark:text-gray-400">
                            Chamadas
                        </th>
                        <th
                            class="px-4 py-3 text-xs font-medium tracking-wider text-center text-gray-500 uppercase dark:text-gray-400">
                            Minutos
                        </th>
                        <th
                            class="px-4 py-3 text-xs font-medium tracking-wider text-center text-gray-500 uppercase dark:text-gray-400">
                            Operadoras
                        </th>
                        <th
                            class="px-4 py-3 text-xs font-medium tracking-wider text-right text-gray-500 uppercase dark:text-gray-400">
                            Custo Atual
                        </th>
                        <th
                            class="px-4 py-3 text-xs font-medium tracking-wider text-right text-gray-500 uppercase dark:text-gray-400">
                            Custo LCR
                        </th>
                        <th
                            class="px-4 py-3 text-xs font-medium tracking-wider text-right text-gray-500 uppercase dark:text-gray-400">
                            Economia
                        </th>
                        <th
                            class="px-4 py-3 text-xs font-medium tracking-wider text-center text-gray-500 uppercase dark:text-gray-400">
                            Ações
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-900 dark:divide-gray-700">
                    @forelse ($routeAnalysis as $route)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800">
                            <td class="px-4 py-3 text-sm font-mono font-bold text-gray-900 dark:text-gray-100">
                                {{ $route->prefix }}
                            </td>

                            <td class="px-4 py-3 text-sm text-center text-gray-900 dark:text-gray-100">
                                {{ number_format($route->total_chamadas, 0, ',', '.') }}
                            </td>

                            <td class="px-4 py-3 text-sm text-center text-gray-900 dark:text-gray-100">
                                {{ number_format($route->total_segundos / 60, 0, ',', '.') }}
                            </td>

                            <td class="px-4 py-3 text-sm text-center">
                                @if ($route->operadoras_usadas > 1)
                                    <span
                                        class="inline-flex items-center px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400">
                                        {{ $route->operadoras_usadas }}
                                    </span>
                                @else
                                    <span class="text-gray-900 dark:text-gray-100">
                                        {{ $route->operadoras_usadas }}
                                    </span>
                                @endif
                            </td>

                            <td class="px-4 py-3 text-sm font-semibold text-right text-blue-600 dark:text-blue-400">
                                R$ {{ number_format($route->custo_atual, 2, ',', '.') }}
                            </td>

                            <td class="px-4 py-3 text-sm font-semibold text-right text-green-600 dark:text-green-400">
                                R$ {{ number_format($route->custo_lcr, 2, ',', '.') }}
                            </td>

                            <td class="px-4 py-3 text-sm text-right">
                                @if ($route->economia_potencial > 0)
                                    <div class="flex flex-col items-end">
                                        <span class="font-bold text-green-600 dark:text-green-400">
                                            R$ {{ number_format($route->economia_potencial, 2, ',', '.') }}
                                        </span>
                                        <span
                                            class="text-xs {{ $route->economia_percentual >= 20 ? 'text-green-600' : ($route->economia_percentual >= 10 ? 'text-yellow-600' : 'text-gray-600') }}">
                                            ({{ number_format($route->economia_percentual, 1, ',', '.') }}%)
                                        </span>
                                    </div>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>

                            <td class="px-4 py-3 text-sm text-center">
                                <button wire:click="openDetails('{{ $route->prefix }}')"
                                    class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                        </path>
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-4 py-8 text-sm text-center text-gray-500">
                                Nenhum dado encontrado para este período
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $routeAnalysis->links('vendor.livewire.paginate') }}
        </div>

        <!-- Legend -->
        <div class="p-4 mt-4 bg-gray-50 rounded-lg dark:bg-gray-800">
            <p class="mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">O que é LCR (Least Cost Routing)?</p>
            <p class="text-xs text-gray-600 dark:text-gray-400 mb-2">
                LCR é uma estratégia que seleciona automaticamente a operadora com menor custo para cada prefixo de
                destino. A economia potencial mostra quanto você economizaria se sempre usasse a operadora mais barata
                disponível.
            </p>
            <div class="flex flex-wrap gap-4 mt-2 text-sm">
                <div class="flex items-center gap-2">
                    <span class="inline-block w-3 h-3 bg-green-500 rounded-full"></span>
                    <span class="text-gray-600 dark:text-gray-400">Alta Economia (≥ 20%)</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="inline-block w-3 h-3 bg-yellow-500 rounded-full"></span>
                    <span class="text-gray-600 dark:text-gray-400">Média Economia (10-20%)</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="inline-block w-3 h-3 bg-gray-500 rounded-full"></span>
                    <span class="text-gray-600 dark:text-gray-400">Baixa Economia (< 10%)</span>
                </div>
            </div>
        </div>
    </div>

    @include('livewire.reports.route-analysis-filter')
    @include('livewire.reports.route-analysis-details')
</div>
