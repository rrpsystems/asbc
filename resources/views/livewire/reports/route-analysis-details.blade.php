<div>
    <x-ui-modal wire="detailsModal" title="Detalhes da Rota LCR" size="6xl">

        @if ($routeDetails)
            <!-- Header -->
            <div class="p-4 mb-4 bg-gray-50 rounded-lg dark:bg-gray-800">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h4 class="text-lg font-bold text-gray-900 dark:text-gray-100">
                            Prefixo: <span class="font-mono">{{ $routeDetails['prefix'] }}</span>
                        </h4>
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            Análise de custos e operadoras disponíveis
                        </p>
                    </div>
                </div>

                <!-- Summary Cards -->
                <div class="grid grid-cols-1 gap-4 md:grid-cols-4">
                    <div class="p-3 bg-white rounded-lg dark:bg-gray-700">
                        <p class="text-xs text-gray-600 dark:text-gray-400">Total Minutos</p>
                        <p class="text-lg font-bold text-gray-900 dark:text-gray-100">
                            {{ number_format($routeDetails['summary']['total_minutes'], 0, ',', '.') }}
                        </p>
                    </div>
                    <div class="p-3 bg-white rounded-lg dark:bg-gray-700">
                        <p class="text-xs text-gray-600 dark:text-gray-400">Custo Atual</p>
                        <p class="text-lg font-bold text-blue-600 dark:text-blue-400">
                            R$ {{ number_format($routeDetails['summary']['current_cost'], 2, ',', '.') }}
                        </p>
                    </div>
                    <div class="p-3 bg-white rounded-lg dark:bg-gray-700">
                        <p class="text-xs text-gray-600 dark:text-gray-400">Custo LCR</p>
                        <p class="text-lg font-bold text-green-600 dark:text-green-400">
                            R$ {{ number_format($routeDetails['summary']['lcr_cost'], 2, ',', '.') }}
                        </p>
                    </div>
                    <div class="p-3 bg-white rounded-lg dark:bg-gray-700">
                        <p class="text-xs text-gray-600 dark:text-gray-400">Economia</p>
                        <p class="text-lg font-bold text-yellow-600 dark:text-yellow-400">
                            R$ {{ number_format($routeDetails['summary']['potential_savings'], 2, ',', '.') }}
                        </p>
                        <p class="text-xs text-gray-600 dark:text-gray-400">
                            {{ number_format($routeDetails['summary']['savings_percent'], 1, ',', '.') }}%
                        </p>
                    </div>
                </div>
            </div>

            <!-- Operadoras Disponíveis -->
            <div class="mb-4">
                <h5 class="mb-2 text-md font-semibold text-gray-900 dark:text-gray-100">
                    Operadoras Disponíveis (ordenadas por custo)
                </h5>
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-800">
                            <tr>
                                <th
                                    class="px-4 py-2 text-xs font-medium text-left text-gray-500 dark:text-gray-400">
                                    Operadora</th>
                                <th
                                    class="px-4 py-2 text-xs font-medium text-right text-gray-500 dark:text-gray-400">
                                    Custo/Min Base</th>
                                <th
                                    class="px-4 py-2 text-xs font-medium text-right text-gray-500 dark:text-gray-400">
                                    Custo Efetivo</th>
                                <th
                                    class="px-4 py-2 text-xs font-medium text-center text-gray-500 dark:text-gray-400">
                                    Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-900 dark:divide-gray-700">
                            @foreach ($routeDetails['available_carriers'] as $index => $carrier)
                                <tr
                                    class="{{ $index === 0 ? 'bg-green-50 dark:bg-green-900/20' : '' }}">
                                    <td class="px-4 py-2 font-medium text-gray-900 dark:text-gray-100">
                                        {{ $carrier->nome }}
                                        @if ($index === 0)
                                            <span
                                                class="ml-2 inline-flex items-center px-2 py-0.5 text-xs font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                                Melhor Opção
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-2 text-right text-gray-900 dark:text-gray-100">
                                        R$ {{ number_format($carrier->cost_per_minute, 4, ',', '.') }}
                                    </td>
                                    <td class="px-4 py-2 font-bold text-right text-gray-900 dark:text-gray-100">
                                        R$ {{ number_format($carrier->custo_efetivo, 4, ',', '.') }}
                                    </td>
                                    <td class="px-4 py-2 text-center">
                                        @if ($index === 0)
                                            <span class="text-green-600 dark:text-green-400">★ Menor Custo</span>
                                        @else
                                            @php
                                                $diff =
                                                    (($carrier->custo_efetivo -
                                                        $routeDetails['available_carriers'][0]->custo_efetivo) /
                                                        $routeDetails['available_carriers'][0]->custo_efetivo) *
                                                    100;
                                            @endphp
                                            <span class="text-red-600 dark:text-red-400">
                                                +{{ number_format($diff, 1, ',', '.') }}%
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Uso Atual por Operadora -->
            @if ($routeDetails['current_usage']->count() > 0)
                <div>
                    <h5 class="mb-2 text-md font-semibold text-gray-900 dark:text-gray-100">
                        Uso Atual ({{ str_pad($mes, 2, '0', STR_PAD_LEFT) }}/{{ $ano }})
                    </h5>
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-800">
                                <tr>
                                    <th
                                        class="px-4 py-2 text-xs font-medium text-left text-gray-500 dark:text-gray-400">
                                        Operadora</th>
                                    <th
                                        class="px-4 py-2 text-xs font-medium text-center text-gray-500 dark:text-gray-400">
                                        Chamadas</th>
                                    <th
                                        class="px-4 py-2 text-xs font-medium text-center text-gray-500 dark:text-gray-400">
                                        Minutos</th>
                                    <th
                                        class="px-4 py-2 text-xs font-medium text-right text-gray-500 dark:text-gray-400">
                                        Custo Médio/Min</th>
                                    <th
                                        class="px-4 py-2 text-xs font-medium text-right text-gray-500 dark:text-gray-400">
                                        Custo Total</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-900 dark:divide-gray-700">
                                @foreach ($routeDetails['current_usage'] as $usage)
                                    <tr>
                                        <td class="px-4 py-2 font-medium text-gray-900 dark:text-gray-100">
                                            {{ $usage->nome }}
                                        </td>
                                        <td class="px-4 py-2 text-center text-gray-900 dark:text-gray-100">
                                            {{ number_format($usage->total_chamadas, 0, ',', '.') }}
                                        </td>
                                        <td class="px-4 py-2 text-center text-gray-900 dark:text-gray-100">
                                            {{ number_format($usage->total_segundos / 60, 0, ',', '.') }}
                                        </td>
                                        <td class="px-4 py-2 text-right text-gray-900 dark:text-gray-100">
                                            R$ {{ number_format($usage->custo_medio, 4, ',', '.') }}
                                        </td>
                                        <td class="px-4 py-2 font-bold text-right text-blue-600 dark:text-blue-400">
                                            R$ {{ number_format($usage->custo_total, 2, ',', '.') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

            <!-- Recomendação -->
            @if ($routeDetails['summary']['potential_savings'] > 0)
                <div class="p-4 mt-4 bg-yellow-50 border border-yellow-200 rounded-lg dark:bg-yellow-900/20 dark:border-yellow-800">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 mr-2 text-yellow-600 dark:text-yellow-400" fill="currentColor"
                            viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <div>
                            <h6 class="font-semibold text-yellow-800 dark:text-yellow-400">Recomendação LCR</h6>
                            <p class="text-sm text-yellow-700 dark:text-yellow-300">
                                @if($routeDetails['summary']['best_carrier'])
                                    Roteando as chamadas deste prefixo para
                                    <strong>{{ $routeDetails['summary']['best_carrier']->nome }}</strong>, você economizará
                                    <strong>R$
                                        {{ number_format($routeDetails['summary']['potential_savings'], 2, ',', '.') }}</strong>
                                    ({{ number_format($routeDetails['summary']['savings_percent'], 1, ',', '.') }}%) neste
                                    mês.
                                @else
                                    Nenhuma operadora disponível com tarifa cadastrada para este prefixo.
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            @else
                <div class="p-4 mt-4 bg-green-50 border border-green-200 rounded-lg dark:bg-green-900/20 dark:border-green-800">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 mr-2 text-green-600 dark:text-green-400" fill="currentColor"
                            viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <div>
                            <h6 class="font-semibold text-green-800 dark:text-green-400">Rota Otimizada</h6>
                            <p class="text-sm text-green-700 dark:text-green-300">
                                Você já está usando a melhor operadora disponível para este prefixo. Não há economia
                                adicional possível.
                            </p>
                        </div>
                    </div>
                </div>
            @endif
        @endif

        <x-slot:footer>
            <div class="flex justify-end gap-2">
                <x-ui-button wire:click="$set('detailsModal', false)" text="Fechar" color="white" />
            </div>
        </x-slot:footer>

    </x-ui-modal>
</div>
