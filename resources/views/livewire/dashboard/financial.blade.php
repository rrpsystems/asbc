<div class="flex flex-col min-h-[calc(100vh-4rem)] pb-3 pl-6 pr-6 bg-white dark:bg-gray-600 border border-gray-300 dark:border-gray-100 rounded-md shadow-md shadow-black/5">
    <div x-init="$dispatch('bradcrumb', { menu: ['Dashboard', 'Financeiro'] })"></div>

    <div class="container flex-grow mx-auto">
        <div class="flex flex-col items-center justify-between my-4 sm:flex-row">
            <h3 class="mb-4 text-2xl font-bold text-gray-800 dark:text-gray-200 sm:mb-0">Dashboard Financeiro</h3>
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
        <div class="grid grid-cols-1 gap-4 p-4 mb-6 bg-gray-50 dark:bg-gray-700 rounded-lg md:grid-cols-3">
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-200">Mês</label>
                <select wire:model.live="mes" class="w-full px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-800 dark:border-gray-600 dark:text-gray-200">
                    @for($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}">{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}</option>
                    @endfor
                </select>
            </div>
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-200">Ano</label>
                <select wire:model.live="ano" class="w-full px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-800 dark:border-gray-600 dark:text-gray-200">
                    @for($y = now()->year; $y >= now()->year - 3; $y--)
                        <option value="{{ $y }}">{{ $y }}</option>
                    @endfor
                </select>
            </div>
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-200">Competência</label>
                <div class="px-3 py-2 font-semibold text-blue-600 bg-blue-50 dark:bg-blue-900 dark:text-blue-200 rounded-md">
                    {{ str_pad($mes, 2, '0', STR_PAD_LEFT) }}/{{ $ano }}
                </div>
            </div>
        </div>

        <!-- Cards Principais - KPIs -->
        <div class="grid grid-cols-1 gap-4 mb-6 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6">
            <!-- Lucro -->
            <div class="p-4 bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900 dark:to-green-800 rounded-lg shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-medium text-green-600 dark:text-green-300">Lucro</p>
                        <p class="text-xl font-bold text-green-700 dark:text-green-200">
                            R$ {{ number_format($lucro, 2, ',', '.') }}
                        </p>
                    </div>
                    <div class="p-2 bg-green-200 dark:bg-green-700 rounded-full">
                        <svg class="w-6 h-6 text-green-700 dark:text-green-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Receita -->
            <div class="p-4 bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900 dark:to-blue-800 rounded-lg shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-medium text-blue-600 dark:text-blue-300">Receita</p>
                        <p class="text-xl font-bold text-blue-700 dark:text-blue-200">
                            R$ {{ number_format($receita, 2, ',', '.') }}
                        </p>
                    </div>
                    <div class="p-2 bg-blue-200 dark:bg-blue-700 rounded-full">
                        <svg class="w-6 h-6 text-blue-700 dark:text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Custo -->
            <div class="p-4 bg-gradient-to-br from-red-50 to-red-100 dark:from-red-900 dark:to-red-800 rounded-lg shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-medium text-red-600 dark:text-red-300">Custo</p>
                        <p class="text-xl font-bold text-red-700 dark:text-red-200">
                            R$ {{ number_format($custo, 2, ',', '.') }}
                        </p>
                    </div>
                    <div class="p-2 bg-red-200 dark:bg-red-700 rounded-full">
                        <svg class="w-6 h-6 text-red-700 dark:text-red-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Margem -->
            <div class="p-4 bg-gradient-to-br from-purple-50 to-purple-100 dark:from-purple-900 dark:to-purple-800 rounded-lg shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-medium text-purple-600 dark:text-purple-300">Margem</p>
                        <p class="text-xl font-bold text-purple-700 dark:text-purple-200">
                            {{ number_format($margemLucro, 1, ',', '.') }}%
                        </p>
                    </div>
                    <div class="p-2 bg-purple-200 dark:bg-purple-700 rounded-full">
                        <svg class="w-6 h-6 text-purple-700 dark:text-purple-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Clientes -->
            <div class="p-4 bg-gradient-to-br from-yellow-50 to-yellow-100 dark:from-yellow-900 dark:to-yellow-800 rounded-lg shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-medium text-yellow-600 dark:text-yellow-300">Clientes</p>
                        <p class="text-xl font-bold text-yellow-700 dark:text-yellow-200">
                            {{ $totalClientes }}
                        </p>
                    </div>
                    <div class="p-2 bg-yellow-200 dark:bg-yellow-700 rounded-full">
                        <svg class="w-6 h-6 text-yellow-700 dark:text-yellow-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Ticket Médio -->
            <div class="p-4 bg-gradient-to-br from-indigo-50 to-indigo-100 dark:from-indigo-900 dark:to-indigo-800 rounded-lg shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-medium text-indigo-600 dark:text-indigo-300">Ticket Médio</p>
                        <p class="text-xl font-bold text-indigo-700 dark:text-indigo-200">
                            R$ {{ number_format($ticketMedio, 2, ',', '.') }}
                        </p>
                    </div>
                    <div class="p-2 bg-indigo-200 dark:bg-indigo-700 rounded-full">
                        <svg class="w-6 h-6 text-indigo-700 dark:text-indigo-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detalhamento de Receita e Comparação -->
        <div class="grid grid-cols-1 gap-4 mb-6 md:grid-cols-2 lg:grid-cols-3">
            <!-- Receita de Chamadas -->
            <div class="p-4 bg-gradient-to-br from-cyan-50 to-cyan-100 dark:from-cyan-900 dark:to-cyan-800 rounded-lg shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-medium text-cyan-600 dark:text-cyan-300">Receita de Chamadas</p>
                        <p class="text-lg font-bold text-cyan-700 dark:text-cyan-200">
                            R$ {{ number_format($receitaChamadas, 2, ',', '.') }}
                        </p>
                        <p class="text-xs text-cyan-500 dark:text-cyan-400 mt-1">
                            {{ $receita > 0 ? number_format(($receitaChamadas / $receita) * 100, 1, ',', '.') : 0 }}% do total
                        </p>
                    </div>
                    <div class="p-2 bg-cyan-200 dark:bg-cyan-700 rounded-full">
                        <svg class="w-5 h-5 text-cyan-700 dark:text-cyan-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Receita de Produtos -->
            <div class="p-4 bg-gradient-to-br from-teal-50 to-teal-100 dark:from-teal-900 dark:to-teal-800 rounded-lg shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-medium text-teal-600 dark:text-teal-300">Receita de Produtos/Serviços</p>
                        <p class="text-lg font-bold text-teal-700 dark:text-teal-200">
                            R$ {{ number_format($receitaProdutos, 2, ',', '.') }}
                        </p>
                        <p class="text-xs text-teal-500 dark:text-teal-400 mt-1">
                            {{ $receita > 0 ? number_format(($receitaProdutos / $receita) * 100, 1, ',', '.') : 0 }}% do total
                        </p>
                    </div>
                    <div class="p-2 bg-teal-200 dark:bg-teal-700 rounded-full">
                        <svg class="w-5 h-5 text-teal-700 dark:text-teal-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Comparação com Mês Anterior -->
            <div class="p-4 bg-gradient-to-br from-orange-50 to-orange-100 dark:from-orange-900 dark:to-orange-800 rounded-lg shadow">
                @if(isset($mesAnterior) && isset($anoAnterior))
                    <p class="mb-3 text-xs font-medium text-orange-600 dark:text-orange-300">
                        Variação vs {{ str_pad($mesAnterior, 2, '0', STR_PAD_LEFT) }}/{{ $anoAnterior }}
                    </p>
                    <div class="space-y-2">
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-gray-700 dark:text-gray-300">Receita:</span>
                            <span class="text-sm font-bold {{ isset($variacaoReceita) && $variacaoReceita >= 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                @if(isset($variacaoReceita))
                                    @if($variacaoReceita > 0) ↑ @elseif($variacaoReceita < 0) ↓ @else — @endif
                                    {{ number_format(abs($variacaoReceita), 1, ',', '.') }}%
                                @else
                                    —
                                @endif
                            </span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-gray-700 dark:text-gray-300">Custo:</span>
                            <span class="text-sm font-bold {{ isset($variacaoCusto) && $variacaoCusto >= 0 ? 'text-red-600 dark:text-red-400' : 'text-green-600 dark:text-green-400' }}">
                                @if(isset($variacaoCusto))
                                    @if($variacaoCusto > 0) ↑ @elseif($variacaoCusto < 0) ↓ @else — @endif
                                    {{ number_format(abs($variacaoCusto), 1, ',', '.') }}%
                                @else
                                    —
                                @endif
                            </span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-gray-700 dark:text-gray-300">Lucro:</span>
                            <span class="text-sm font-bold {{ isset($variacaoLucro) && $variacaoLucro >= 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                @if(isset($variacaoLucro))
                                    @if($variacaoLucro > 0) ↑ @elseif($variacaoLucro < 0) ↓ @else — @endif
                                    {{ number_format(abs($variacaoLucro), 1, ',', '.') }}%
                                @else
                                    —
                                @endif
                            </span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-gray-700 dark:text-gray-300">Margem:</span>
                            <span class="text-sm font-bold {{ isset($variacaoMargem) && $variacaoMargem >= 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                @if(isset($variacaoMargem))
                                    @if($variacaoMargem > 0) ↑ @elseif($variacaoMargem < 0) ↓ @else — @endif
                                    {{ number_format(abs($variacaoMargem), 1, ',', '.') }} p.p.
                                @else
                                    —
                                @endif
                            </span>
                        </div>
                    </div>
                @else
                    <p class="text-xs text-gray-500 dark:text-gray-400">Selecione um período para ver a comparação</p>
                @endif
            </div>
        </div>

        <!-- Gráficos e Tabelas -->
        <div class="grid grid-cols-1 gap-6 mb-6 lg:grid-cols-2">
            <!-- Evolução Mensal -->
            <div class="p-6 bg-white dark:bg-gray-800 rounded-lg shadow-lg">
                <h4 class="mb-4 text-lg font-bold text-gray-800 dark:text-gray-200">Evolução (Últimos 6 Meses)</h4>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-gray-200 dark:border-gray-700">
                                <th class="px-2 py-2 text-left text-gray-700 dark:text-gray-300">Mês</th>
                                <th class="px-2 py-2 text-right text-gray-700 dark:text-gray-300">Receita</th>
                                <th class="px-2 py-2 text-right text-gray-700 dark:text-gray-300">Custo</th>
                                <th class="px-2 py-2 text-right text-gray-700 dark:text-gray-300">Lucro</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $totalReceita = 0;
                                $totalCusto = 0;
                                $totalLucro = 0;
                            @endphp
                            @foreach($evolucao as $item)
                                @php
                                    $totalReceita += $item['receita'];
                                    $totalCusto += $item['custo'];
                                    $totalLucro += $item['lucro'];
                                @endphp
                                <tr class="border-b border-gray-100 dark:border-gray-700">
                                    <td class="px-2 py-2 font-medium text-gray-900 dark:text-gray-100">{{ $item['mes'] }}</td>
                                    <td class="px-2 py-2 text-right text-blue-600 dark:text-blue-400">R$ {{ number_format($item['receita'], 2, ',', '.') }}</td>
                                    <td class="px-2 py-2 text-right text-red-600 dark:text-red-400">R$ {{ number_format($item['custo'], 2, ',', '.') }}</td>
                                    <td class="px-2 py-2 text-right font-bold {{ $item['lucro'] >= 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                        R$ {{ number_format($item['lucro'], 2, ',', '.') }}
                                    </td>
                                </tr>
                            @endforeach
                            @if(count($evolucao) > 0)
                                <tr class="border-t-2 border-gray-400 dark:border-gray-500 bg-gray-100 dark:bg-gray-700 font-bold">
                                    <td class="px-2 py-3 text-gray-900 dark:text-gray-100">TOTAL</td>
                                    <td class="px-2 py-3 text-right text-blue-700 dark:text-blue-300">R$ {{ number_format($totalReceita, 2, ',', '.') }}</td>
                                    <td class="px-2 py-3 text-right text-red-700 dark:text-red-300">R$ {{ number_format($totalCusto, 2, ',', '.') }}</td>
                                    <td class="px-2 py-3 text-right {{ $totalLucro >= 0 ? 'text-green-700 dark:text-green-300' : 'text-red-700 dark:text-red-300' }}">
                                        R$ {{ number_format($totalLucro, 2, ',', '.') }}
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Top 5 Clientes -->
            <div class="p-6 bg-white dark:bg-gray-800 rounded-lg shadow-lg">
                <h4 class="mb-4 text-lg font-bold text-gray-800 dark:text-gray-200">Top 5 Clientes</h4>
                <div class="space-y-3">
                    @foreach($topClientes as $cliente)
                        <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <div class="flex-1">
                                <p class="font-semibold text-gray-900 dark:text-gray-100">{{ $cliente->customer->nomefantasia ?? $cliente->customer->razaosocial ?? 'N/A' }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ $cliente->minutos_total ?? 0 }} minutos</p>
                            </div>
                            <div class="text-right">
                                <p class="font-bold text-green-600 dark:text-green-400">R$ {{ number_format($cliente->receita_total_calculada, 2, ',', '.') }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Distribuições -->
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
            <!-- Distribuição por Tipo de Serviço -->
            <div class="p-6 bg-white dark:bg-gray-800 rounded-lg shadow-lg">
                <h4 class="mb-4 text-lg font-bold text-gray-800 dark:text-gray-200">Receita por Tipo de Serviço</h4>
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <div class="w-3 h-3 bg-blue-500 rounded"></div>
                            <span class="text-sm text-gray-700 dark:text-gray-300">Fixo</span>
                        </div>
                        <span class="font-semibold text-gray-900 dark:text-gray-100">R$ {{ number_format($distribuicaoServico->fixo ?? 0, 2, ',', '.') }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <div class="w-3 h-3 bg-purple-500 rounded"></div>
                            <span class="text-sm text-gray-700 dark:text-gray-300">Móvel</span>
                        </div>
                        <span class="font-semibold text-gray-900 dark:text-gray-100">R$ {{ number_format($distribuicaoServico->movel ?? 0, 2, ',', '.') }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <div class="w-3 h-3 bg-red-500 rounded"></div>
                            <span class="text-sm text-gray-700 dark:text-gray-300">Internacional</span>
                        </div>
                        <span class="font-semibold text-gray-900 dark:text-gray-100">R$ {{ number_format($distribuicaoServico->internacional ?? 0, 2, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <!-- Custos por Operadora -->
            <div class="p-6 bg-white dark:bg-gray-800 rounded-lg shadow-lg">
                <h4 class="mb-4 text-lg font-bold text-gray-800 dark:text-gray-200">Custos por Operadora (Real)</h4>
                <div class="text-xs text-gray-500 dark:text-gray-400 mb-3">Custo fixo + variável (acima da franquia)</div>
                <div class="space-y-3">
                    @foreach($custosOperadora as $item)
                        <div class="p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <div class="flex items-center justify-between mb-2">
                                <span class="font-medium text-gray-900 dark:text-gray-100">{{ $item->carrier->operadora ?? 'N/A' }}</span>
                                <span class="font-bold text-red-600 dark:text-red-400">R$ {{ number_format($item->total, 2, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between text-xs text-gray-600 dark:text-gray-400">
                                <span>Fixo: R$ {{ number_format($item->custo_fixo, 2, ',', '.') }}</span>
                                <span>Variável: R$ {{ number_format($item->custo_variavel, 2, ',', '.') }}</span>
                            </div>
                        </div>
                    @endforeach
                    @if($custosOperadora->isEmpty())
                        <div class="p-3 text-center text-gray-500 dark:text-gray-400">
                            Nenhum custo registrado para este período
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
