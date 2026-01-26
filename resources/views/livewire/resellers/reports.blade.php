<div class="p-6 space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between flex-wrap gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Relatórios de Comissão</h2>
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

    <!-- Tipo de Relatório -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-4">
        <div class="flex flex-wrap gap-2">
            <button
                wire:click="$set('reportType', 'summary')"
                class="px-4 py-2 text-sm font-medium rounded-lg transition-colors {{ $reportType === 'summary' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600' }}"
            >
                Resumo Geral
            </button>
            <button
                wire:click="$set('reportType', 'by_customer')"
                class="px-4 py-2 text-sm font-medium rounded-lg transition-colors {{ $reportType === 'by_customer' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600' }}"
            >
                Por Cliente
            </button>
            <button
                wire:click="$set('reportType', 'by_date')"
                class="px-4 py-2 text-sm font-medium rounded-lg transition-colors {{ $reportType === 'by_date' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600' }}"
            >
                Por Data
            </button>
        </div>
    </div>

    @if($reportType === 'summary')
        <!-- Resumo Geral -->
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
            <!-- Chamadas -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                    </svg>
                    Chamadas
                </h3>
                <div class="space-y-3">
                    <div class="flex justify-between items-center pb-2 border-b border-gray-200 dark:border-gray-700">
                        <span class="text-sm text-gray-600 dark:text-gray-400">Total</span>
                        <span class="text-sm font-semibold text-gray-800 dark:text-gray-100">{{ number_format($summary['chamadas']['total'], 0, '.', '.') }}</span>
                    </div>
                    <div class="flex justify-between items-center pb-2 border-b border-gray-200 dark:border-gray-700">
                        <span class="text-sm text-gray-600 dark:text-gray-400">Minutos</span>
                        <span class="text-sm font-semibold text-gray-800 dark:text-gray-100">{{ number_format($summary['chamadas']['minutos'], 0, '.', '.') }}</span>
                    </div>
                    <div class="flex justify-between items-center pb-2 border-b border-gray-200 dark:border-gray-700">
                        <span class="text-sm text-gray-600 dark:text-gray-400">Custo Base</span>
                        <span class="text-sm font-semibold text-red-600 dark:text-red-400">R$ {{ number_format($summary['chamadas']['custo_base'], 2, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between items-center pb-2 border-b border-gray-200 dark:border-gray-700">
                        <span class="text-sm text-gray-600 dark:text-gray-400">Receita Final</span>
                        <span class="text-sm font-semibold text-green-600 dark:text-green-400">R$ {{ number_format($summary['chamadas']['receita_final'], 2, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between items-center pt-2">
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Lucro</span>
                        <span class="text-sm font-bold text-purple-600 dark:text-purple-400">R$ {{ number_format($summary['chamadas']['lucro'], 2, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <!-- Produtos -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                    Produtos
                </h3>
                <div class="space-y-3">
                    <div class="flex justify-between items-center pb-2 border-b border-gray-200 dark:border-gray-700">
                        <span class="text-sm text-gray-600 dark:text-gray-400">Custo Base</span>
                        <span class="text-sm font-semibold text-red-600 dark:text-red-400">R$ {{ number_format($summary['produtos']['custo_base'], 2, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between items-center pb-2 border-b border-gray-200 dark:border-gray-700">
                        <span class="text-sm text-gray-600 dark:text-gray-400">Receita Final</span>
                        <span class="text-sm font-semibold text-green-600 dark:text-green-400">R$ {{ number_format($summary['produtos']['receita_final'], 2, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between items-center pt-2">
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Lucro</span>
                        <span class="text-sm font-bold text-purple-600 dark:text-purple-400">R$ {{ number_format($summary['produtos']['lucro'], 2, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <!-- Total -->
            <div class="bg-gradient-to-br from-purple-500 to-purple-700 rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-semibold text-white mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                    </svg>
                    Total do Mês
                </h3>
                <div class="space-y-3">
                    <div class="flex justify-between items-center pb-2 border-b border-purple-400">
                        <span class="text-sm text-purple-100">A Pagar (Provider)</span>
                        <span class="text-sm font-semibold text-white">R$ {{ number_format($summary['total']['custo_base'], 2, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between items-center pb-2 border-b border-purple-400">
                        <span class="text-sm text-purple-100">A Receber (Clientes)</span>
                        <span class="text-sm font-semibold text-white">R$ {{ number_format($summary['total']['receita_final'], 2, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between items-center pt-2">
                        <span class="text-sm font-medium text-purple-100">Seu Lucro</span>
                        <span class="text-lg font-bold text-white">R$ {{ number_format($summary['total']['lucro'], 2, ',', '.') }}</span>
                    </div>
                    <div class="mt-2 p-2 bg-purple-600 rounded text-center">
                        <span class="text-xs text-purple-100">Margem:</span>
                        <span class="text-sm font-bold text-white ml-1">
                            {{ $summary['total']['custo_base'] > 0 ? number_format(($summary['total']['lucro'] / $summary['total']['custo_base']) * 100, 1, ',', '.') : '0' }}%
                        </span>
                    </div>
                </div>
            </div>
        </div>

    @elseif($reportType === 'by_customer')
        <!-- Relatório por Cliente -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Cliente</th>
                            <th class="py-3 px-4 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Chamadas</th>
                            <th class="py-3 px-4 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Minutos</th>
                            <th class="py-3 px-4 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Custo Base</th>
                            <th class="py-3 px-4 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Receita Final</th>
                            <th class="py-3 px-4 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Lucro</th>
                            <th class="py-3 px-4 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Margem</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($customerData as $customer)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="py-3 px-4">
                                    <div class="flex items-center">
                                        <div>
                                            <div class="text-sm font-medium text-gray-800 dark:text-gray-100">{{ $customer->razaosocial }}</div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400">ID: {{ $customer->id }}</div>
                                        </div>
                                        @if(!$customer->ativo)
                                            <span class="ml-2 px-2 py-1 text-xs bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200 rounded">Inativo</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="py-3 px-4 text-right text-gray-600 dark:text-gray-400">{{ number_format($customer->total_chamadas, 0, '.', '.') }}</td>
                                <td class="py-3 px-4 text-right text-gray-600 dark:text-gray-400">{{ number_format(round($customer->total_segundos / 60), 0, ',', '.') }}</td>
                                <td class="py-3 px-4 text-right text-red-600 dark:text-red-400 font-semibold">R$ {{ number_format($customer->total_custo_base, 2, ',', '.') }}</td>
                                <td class="py-3 px-4 text-right text-green-600 dark:text-green-400 font-semibold">R$ {{ number_format($customer->total_receita_final, 2, ',', '.') }}</td>
                                <td class="py-3 px-4 text-right text-purple-600 dark:text-purple-400 font-bold">R$ {{ number_format($customer->total_lucro, 2, ',', '.') }}</td>
                                <td class="py-3 px-4 text-right text-gray-700 dark:text-gray-300">
                                    {{ $customer->total_custo_base > 0 ? number_format(($customer->total_lucro / $customer->total_custo_base) * 100, 1, ',', '.') : '0' }}%
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-8 text-center text-gray-500 dark:text-gray-400">
                                    Nenhum dado disponível para este período
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    @elseif($reportType === 'by_date')
        <!-- Relatório por Data -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Data</th>
                            <th class="py-3 px-4 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Chamadas</th>
                            <th class="py-3 px-4 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Minutos</th>
                            <th class="py-3 px-4 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Custo Base</th>
                            <th class="py-3 px-4 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Receita Final</th>
                            <th class="py-3 px-4 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Lucro</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($dailyData as $day)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="py-3 px-4 text-gray-800 dark:text-gray-100 font-medium">
                                    {{ \Carbon\Carbon::parse($day->data)->format('d/m/Y') }}
                                    <span class="text-xs text-gray-500 dark:text-gray-400 ml-1">
                                        ({{ \Carbon\Carbon::parse($day->data)->dayName }})
                                    </span>
                                </td>
                                <td class="py-3 px-4 text-right text-gray-600 dark:text-gray-400">{{ number_format($day->total_chamadas, 0, '.', '.') }}</td>
                                <td class="py-3 px-4 text-right text-gray-600 dark:text-gray-400">{{ number_format($day->minutos, 0, '.', '.') }}</td>
                                <td class="py-3 px-4 text-right text-red-600 dark:text-red-400 font-semibold">R$ {{ number_format($day->custo_base, 2, ',', '.') }}</td>
                                <td class="py-3 px-4 text-right text-green-600 dark:text-green-400 font-semibold">R$ {{ number_format($day->receita_final, 2, ',', '.') }}</td>
                                <td class="py-3 px-4 text-right text-purple-600 dark:text-purple-400 font-bold">R$ {{ number_format($day->lucro, 2, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-8 text-center text-gray-500 dark:text-gray-400">
                                    Nenhum dado disponível para este período
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>
