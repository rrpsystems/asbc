<div class="p-6 space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Dashboard Revenda</h2>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ $reseller->nome }}</p>
        </div>
        <div class="flex items-center space-x-2">
            <button
                wire:click="changeMonth('prev')"
                class="p-2 text-gray-600 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-600"
            >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </button>
            <div class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600">
                {{ \Carbon\Carbon::createFromDate($year, $month, 1)->format('F Y') }}
            </div>
            <button
                wire:click="changeMonth('next')"
                class="p-2 text-gray-600 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-600"
            >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </button>
        </div>
    </div>

    <!-- Resumo Geral -->
    <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-4">
        <!-- Total Clientes -->
        <div class="p-4 bg-white dark:bg-gray-800 rounded-lg shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Total Clientes</p>
                    <p class="mt-1 text-2xl font-bold text-gray-800 dark:text-gray-100">{{ $totalClientes }}</p>
                    <p class="mt-1 text-xs text-green-600 dark:text-green-400">{{ $clientesAtivos }} ativos</p>
                </div>
                <div class="p-3 bg-blue-100 dark:bg-blue-900 rounded-lg">
                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total a Pagar -->
        <div class="p-4 bg-white dark:bg-gray-800 rounded-lg shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">A Pagar (Provider)</p>
                    <p class="mt-1 text-2xl font-bold text-red-600 dark:text-red-400">R$ {{ number_format($totalAPagar, 2, ',', '.') }}</p>
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Valor base</p>
                </div>
                <div class="p-3 bg-red-100 dark:bg-red-900 rounded-lg">
                    <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total a Receber -->
        <div class="p-4 bg-white dark:bg-gray-800 rounded-lg shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">A Receber (Clientes)</p>
                    <p class="mt-1 text-2xl font-bold text-green-600 dark:text-green-400">R$ {{ number_format($totalAReceber, 2, ',', '.') }}</p>
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Valor com markup</p>
                </div>
                <div class="p-3 bg-green-100 dark:bg-green-900 rounded-lg">
                    <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Lucro do Mês -->
        <div class="p-4 bg-gradient-to-br from-purple-500 to-purple-700 rounded-lg shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-purple-100 uppercase">Seu Lucro</p>
                    <p class="mt-1 text-2xl font-bold text-white">R$ {{ number_format($lucroTotal, 2, ',', '.') }}</p>
                    <p class="mt-1 text-xs text-purple-200">
                        Margem: {{ $totalAPagar > 0 ? number_format(($lucroTotal / $totalAPagar) * 100, 1, ',', '.') : '0' }}%
                    </p>
                </div>
                <div class="p-3 bg-purple-600 rounded-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Detalhamento do Mês -->
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
        <!-- Chamadas -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Chamadas do Mês</h3>

            <div class="space-y-3">
                <div class="flex justify-between items-center pb-3 border-b border-gray-200 dark:border-gray-700">
                    <span class="text-sm text-gray-600 dark:text-gray-400">Total de Chamadas</span>
                    <span class="text-sm font-semibold text-gray-800 dark:text-gray-100">{{ number_format($chamadas_mes, 0, '.', '.') }}</span>
                </div>

                <div class="flex justify-between items-center pb-3 border-b border-gray-200 dark:border-gray-700">
                    <span class="text-sm text-gray-600 dark:text-gray-400">Total de Minutos</span>
                    <span class="text-sm font-semibold text-gray-800 dark:text-gray-100">{{ number_format($minutos_mes, 0, '.', '.') }} min</span>
                </div>

                <div class="flex justify-between items-center pb-3 border-b border-gray-200 dark:border-gray-700">
                    <span class="text-sm text-gray-600 dark:text-gray-400">Custo Base</span>
                    <span class="text-sm font-semibold text-red-600 dark:text-red-400">R$ {{ number_format($receita_chamadas_base, 2, ',', '.') }}</span>
                </div>

                <div class="flex justify-between items-center pb-3 border-b border-gray-200 dark:border-gray-700">
                    <span class="text-sm text-gray-600 dark:text-gray-400">Receita Final</span>
                    <span class="text-sm font-semibold text-green-600 dark:text-green-400">R$ {{ number_format($receita_chamadas_final, 2, ',', '.') }}</span>
                </div>

                <div class="flex justify-between items-center pt-2">
                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Lucro em Chamadas</span>
                    <span class="text-sm font-bold text-purple-600 dark:text-purple-400">R$ {{ number_format($receita_chamadas_final - $receita_chamadas_base, 2, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <!-- Produtos e Serviços -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Produtos e Serviços</h3>

            <div class="space-y-3">
                <div class="flex justify-between items-center pb-3 border-b border-gray-200 dark:border-gray-700">
                    <span class="text-sm text-gray-600 dark:text-gray-400">Markup Configurado</span>
                    <span class="text-sm font-semibold text-gray-800 dark:text-gray-100">
                        @if($reseller->valor_fixo_produtos)
                            R$ {{ number_format($reseller->valor_fixo_produtos, 2, ',', '.') }} (fixo)
                        @else
                            {{ number_format($reseller->markup_produtos, 2, ',', '.') }}%
                        @endif
                    </span>
                </div>

                <div class="flex justify-between items-center pb-3 border-b border-gray-200 dark:border-gray-700">
                    <span class="text-sm text-gray-600 dark:text-gray-400">Custo Base</span>
                    <span class="text-sm font-semibold text-red-600 dark:text-red-400">R$ {{ number_format($receita_produtos_base, 2, ',', '.') }}</span>
                </div>

                <div class="flex justify-between items-center pb-3 border-b border-gray-200 dark:border-gray-700">
                    <span class="text-sm text-gray-600 dark:text-gray-400">Receita Final</span>
                    <span class="text-sm font-semibold text-green-600 dark:text-green-400">R$ {{ number_format($receita_produtos_final, 2, ',', '.') }}</span>
                </div>

                <div class="flex justify-between items-center pt-2">
                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Lucro em Produtos</span>
                    <span class="text-sm font-bold text-purple-600 dark:text-purple-400">R$ {{ number_format($receita_produtos_final - $receita_produtos_base, 2, ',', '.') }}</span>
                </div>
            </div>

            <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                <a href="{{ route('reseller.settings') }}" class="text-sm text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300">
                    Configurar Markups →
                </a>
            </div>
        </div>
    </div>

    <!-- Top Clientes -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Top 5 Clientes do Mês</h3>

        @if($topClientes->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-200 dark:border-gray-700">
                            <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Cliente</th>
                            <th class="py-3 px-4 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Chamadas</th>
                            <th class="py-3 px-4 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Receita</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($topClientes as $cliente)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="py-3 px-4 text-gray-800 dark:text-gray-100">
                                    {{ $cliente->razaosocial }}
                                </td>
                                <td class="py-3 px-4 text-right text-gray-600 dark:text-gray-400">
                                    {{ number_format($cliente->total_chamadas, 0, '.', '.') }}
                                </td>
                                <td class="py-3 px-4 text-right font-semibold text-green-600 dark:text-green-400">
                                    R$ {{ number_format($cliente->receita_total ?? 0, 2, ',', '.') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                <svg class="w-12 h-12 mx-auto mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <p>Nenhum dado disponível para este período</p>
            </div>
        @endif
    </div>
</div>
