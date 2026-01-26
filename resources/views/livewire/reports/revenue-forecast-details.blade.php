<div>
    <x-ui-modal wire="detailsModal" title="Detalhes da Previsão" size="4xl">

        @if ($customerDetails)
            <div class="space-y-4">
                <!-- Customer Info -->
                <div class="pb-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                        {{ $customerDetails['customer']->razaosocial }}
                    </h3>
                    @if ($customerDetails['customer']->nomefantasia && $customerDetails['customer']->nomefantasia !== $customerDetails['customer']->razaosocial)
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            {{ $customerDetails['customer']->nomefantasia }}
                        </p>
                    @endif
                </div>

                <!-- Current Month Data -->
                @if ($customerDetails['current'])
                    <div class="grid grid-cols-2 gap-4 md:grid-cols-4">
                        <div class="p-3 bg-blue-50 rounded-lg dark:bg-blue-900/20">
                            <p class="text-xs text-blue-600 dark:text-blue-400">Receita Atual</p>
                            <p class="mt-1 text-lg font-bold text-blue-900 dark:text-blue-300">
                                R$ {{ number_format($customerDetails['current']->custo_total ?? 0, 2, ',', '.') }}
                            </p>
                        </div>

                        <div class="p-3 bg-purple-50 rounded-lg dark:bg-purple-900/20">
                            <p class="text-xs text-purple-600 dark:text-purple-400">Minutos Usados</p>
                            <p class="mt-1 text-lg font-bold text-purple-900 dark:text-purple-300">
                                {{ number_format($customerDetails['current']->minutos_total ?? 0, 0, '.', '.') }} min
                            </p>
                        </div>

                        <div class="p-3 bg-green-50 rounded-lg dark:bg-green-900/20">
                            <p class="text-xs text-green-600 dark:text-green-400">Franquia</p>
                            <p class="mt-1 text-lg font-bold text-green-900 dark:text-green-300">
                                {{ number_format(ceil(($customerDetails['current']->franquia_minutos ?? 0) / 60), 0, '.', '.') }} min
                            </p>
                        </div>

                        <div class="p-3 bg-orange-50 rounded-lg dark:bg-orange-900/20">
                            <p class="text-xs text-orange-600 dark:text-orange-400">Uso Franquia</p>
                            <p class="mt-1 text-lg font-bold text-orange-900 dark:text-orange-300">
                                @php
                                    $usoFranquia = $customerDetails['current']->franquia_minutos > 0
                                        ? ($customerDetails['current']->minutos_usados / ($customerDetails['current']->franquia_minutos / 60)) * 100
                                        : 0;
                                @endphp
                                {{ number_format($usoFranquia, 1, ',', '.') }}%
                            </p>
                        </div>
                    </div>
                @endif

                <!-- Historical Comparison -->
                @if ($customerDetails['history']->count() > 0)
                    <div>
                        <h4 class="mb-3 text-sm font-medium text-gray-700 dark:text-gray-300">Histórico dos Últimos 3 Meses</h4>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-800">
                                    <tr>
                                        <th class="px-4 py-2 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                            Mês/Ano
                                        </th>
                                        <th class="px-4 py-2 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                            Receita
                                        </th>
                                        <th class="px-4 py-2 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                            Minutos
                                        </th>
                                        <th class="px-4 py-2 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                            Uso Franquia
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-900 dark:divide-gray-700">
                                    @foreach ($customerDetails['history'] as $history)
                                        <tr>
                                            <td class="px-4 py-2 text-sm font-medium text-gray-900 dark:text-gray-100">
                                                {{ str_pad($history->mes, 2, '0', STR_PAD_LEFT) }}/{{ $history->ano }}
                                            </td>
                                            <td class="px-4 py-2 text-sm text-gray-900 dark:text-gray-100">
                                                R$ {{ number_format($history->custo_total, 2, ',', '.') }}
                                            </td>
                                            <td class="px-4 py-2 text-sm text-gray-900 dark:text-gray-100">
                                                {{ number_format($history->minutos_total, 0, '.', '.') }} min
                                            </td>
                                            <td class="px-4 py-2 text-sm">
                                                @php
                                                    $uso = $history->franquia_minutos > 0
                                                        ? ($history->minutos_usados / ($history->franquia_minutos / 60)) * 100
                                                        : 0;
                                                @endphp
                                                <span class="font-medium {{ $uso >= 100 ? 'text-red-600' : ($uso >= 80 ? 'text-yellow-600' : 'text-green-600') }}">
                                                    {{ number_format($uso, 1, ',', '.') }}%
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Averages -->
                    <div class="p-4 bg-gray-50 rounded-lg dark:bg-gray-800">
                        <p class="mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Médias dos Últimos 3 Meses:</p>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-xs text-gray-600 dark:text-gray-400">Receita Média</p>
                                <p class="text-lg font-bold text-gray-900 dark:text-gray-100">
                                    R$ {{ number_format($customerDetails['avg_receita'] ?? 0, 2, ',', '.') }}
                                </p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-600 dark:text-gray-400">Minutos Médios</p>
                                <p class="text-lg font-bold text-gray-900 dark:text-gray-100">
                                    {{ number_format($customerDetails['avg_minutos'] ?? 0, 0, '.', '.') }} min
                                </p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <x-slot:footer>
                <div class="flex justify-end">
                    <x-ui-button wire:click="detailsModal = false" text="Fechar" color="white" />
                </div>
            </x-slot:footer>
        @endif

    </x-ui-modal>
</div>
