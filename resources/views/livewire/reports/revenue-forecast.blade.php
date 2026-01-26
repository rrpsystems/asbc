<div
    class="flex flex-col min-h-[calc(100vh-4rem)] pb-3 pl-6 pr-6 bg-white dark:bg-gray-600 border border-gray-300 dark:border-gray-100 rounded-md shadow-md shadow-black/5">
    <div class="container flex-grow mx-auto">
        <!-- Header -->
        <div class="flex flex-col items-center justify-between my-4 sm:flex-row">
            <div>
                <h3 class="mb-2 text-2xl font-bold text-gray-800 dark:text-gray-200">Previsão de Faturamento</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    {{ str_pad($mes, 2, '0', STR_PAD_LEFT) }}/{{ $ano }} - Dia {{ $diaAtual }} de
                    {{ $diasNoMes }} ({{ number_format($percentualMesDecorrido, 1, ',', '.') }}% decorrido)
                </p>
            </div>
        </div>

        <!-- Progress Bar -->
        <div class="mb-6">
            <div class="flex items-center justify-between mb-2">
                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Progresso do Mês</span>
                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                    {{ number_format($percentualMesDecorrido, 1, ',', '.') }}%
                </span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-4 dark:bg-gray-700">
                <div class="bg-gradient-to-r from-blue-500 to-blue-600 h-4 rounded-full transition-all duration-500"
                    style="width: {{ min($percentualMesDecorrido, 100) }}%"></div>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 gap-4 mb-6 md:grid-cols-2 lg:grid-cols-4">
            <!-- Receita Atual -->
            <div class="p-4 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg shadow-md">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-blue-100">Receita Atual</p>
                        <p class="mt-1 text-2xl font-bold text-white">
                            R$ {{ number_format($totals->receita_atual, 2, ',', '.') }}
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

            <!-- Receita Projetada -->
            <div class="p-4 bg-gradient-to-br from-green-500 to-green-600 rounded-lg shadow-md">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-green-100">Projeção Fim do Mês</p>
                        <p class="mt-1 text-2xl font-bold text-white">
                            R$ {{ number_format($totals->receita_projetada, 2, ',', '.') }}
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

            <!-- Minutos Projetados -->
            <div class="p-4 bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg shadow-md">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-purple-100">Minutos Projetados</p>
                        <p class="mt-1 text-2xl font-bold text-white">
                            {{ number_format($totals->minutos_projetados, 0, ',', '.') }} min
                        </p>
                    </div>
                    <div class="p-3 bg-white/20 rounded-full">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Clientes em Risco -->
            <div class="p-4 bg-gradient-to-br from-red-500 to-red-600 rounded-lg shadow-md">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-red-100">Clientes em Risco</p>
                        <p class="mt-1 text-2xl font-bold text-white">
                            {{ $totals->clientes_risco }}
                        </p>
                        <p class="text-xs text-red-100">Previsão estouro franquia</p>
                    </div>
                    <div class="p-3 bg-white/20 rounded-full">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
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
                            Cliente
                        </th>
                        <th
                            class="px-4 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-400">
                            Receita Atual
                        </th>
                        <th
                            class="px-4 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-400">
                            Projeção
                        </th>
                        <th
                            class="px-4 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-400">
                            Variação
                        </th>
                        <th
                            class="px-4 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-400">
                            Minutos (Atual/Projetado)
                        </th>
                        <th
                            class="px-4 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-400">
                            Uso Franquia Projetado
                        </th>
                        <th
                            class="px-4 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-400">
                            Ações
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-900 dark:divide-gray-700">
                    @forelse ($forecasts as $item)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800">
                            <td class="px-4 py-3 text-sm font-medium text-gray-900 dark:text-gray-100">
                                {{ \Illuminate\Support\Str::limit($item->razaosocial, 30) }}
                            </td>

                            <td class="px-4 py-3 text-sm text-blue-600 dark:text-blue-400">
                                R$ {{ number_format($item->receita_atual, 2, ',', '.') }}
                            </td>

                            <td class="px-4 py-3 text-sm font-semibold text-green-600 dark:text-green-400">
                                R$ {{ number_format($item->receita_projetada, 2, ',', '.') }}
                            </td>

                            <td class="px-4 py-3 text-sm">
                                @php
                                    $variacao = $item->receita_atual > 0 ? (($item->receita_projetada - $item->receita_atual) / $item->receita_atual) * 100 : 0;
                                @endphp
                                <span
                                    class="inline-flex items-center px-2 py-1 text-xs font-semibold rounded-full {{ $variacao > 0 ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300' }}">
                                    {{ $variacao > 0 ? '+' : '' }}{{ number_format($variacao, 1, ',', '.') }}%
                                </span>
                            </td>

                            <td class="px-4 py-3 text-sm text-gray-900 dark:text-gray-100">
                                {{ number_format($item->minutos_total, 0, ',', '.') }} min /
                                <span class="font-medium text-purple-600 dark:text-purple-400">
                                    {{ number_format($item->minutos_projetados, 0, ',', '.') }} min
                                </span>
                            </td>

                            <td class="px-4 py-3 text-sm">
                                <div class="flex items-center gap-2">
                                    <span
                                        class="font-bold {{ $item->previsao_uso_franquia >= 100 ? 'text-red-600' : ($item->previsao_uso_franquia >= 80 ? 'text-yellow-600' : 'text-green-600') }}">
                                        {{ number_format($item->previsao_uso_franquia, 1, ',', '.') }}%
                                    </span>
                                    @if ($item->previsao_uso_franquia >= 100)
                                        <svg class="w-4 h-4 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    @elseif($item->previsao_uso_franquia >= 80)
                                        <span class="text-xs text-yellow-600">⚠</span>
                                    @endif
                                </div>
                            </td>

                            <td class="px-4 py-3 text-sm">
                                <button wire:click="openDetails({{ $item->customer_id }})"
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
                            <td colspan="7" class="px-4 py-8 text-sm text-center text-gray-500">
                                Nenhum dado encontrado para este período
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Legend -->
        <div class="p-4 mt-4 bg-gray-50 rounded-lg dark:bg-gray-800">
            <p class="mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Como funciona a projeção:</p>
            <p class="text-xs text-gray-600 dark:text-gray-400">
                A projeção é calculada com base no consumo médio diário até o momento. Por exemplo: se em 10 dias o
                cliente consumiu R$ 1.000, a projeção para 30 dias será R$ 3.000 (R$ 1.000 ÷ 10 × 30).
            </p>
            <div class="flex flex-wrap gap-4 mt-2 text-sm">
                <div class="flex items-center gap-2">
                    <span class="inline-block w-3 h-3 bg-green-500 rounded-full"></span>
                    <span class="text-gray-600 dark:text-gray-400">Normal (< 80% franquia)</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="inline-block w-3 h-3 bg-yellow-500 rounded-full"></span>
                    <span class="text-gray-600 dark:text-gray-400">Atenção (80-100% franquia)</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="inline-block w-3 h-3 bg-red-500 rounded-full"></span>
                    <span class="text-gray-600 dark:text-gray-400">Risco (> 100% franquia)</span>
                </div>
            </div>
        </div>
    </div>

    @include('livewire.reports.revenue-forecast-details')
</div>
