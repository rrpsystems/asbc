<div>
    <x-ui-modal wire="detailsModal" title="Detalhes da Detecção de Fraude" size="6xl">

        @if ($fraudDetails)
            <!-- Header do Cliente -->
            <div class="p-4 mb-4 bg-gray-50 rounded-lg dark:bg-gray-800">
                <div class="flex items-center justify-between">
                    <div>
                        <h4 class="text-lg font-bold text-gray-900 dark:text-gray-100">
                            {{ $fraudDetails['customer']->razaosocial }}
                        </h4>
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            {{ $fraudDetails['customer']->nomefantasia }}
                        </p>
                    </div>
                    <div>
                        @php
                            $severity = $fraudDetails['summary']['highest_severity'];
                            if ($severity === 'critical') {
                                $bgColor = 'bg-red-100 dark:bg-red-900/30';
                                $textColor = 'text-red-800 dark:text-red-400';
                                $label = 'Crítico';
                            } elseif ($severity === 'high') {
                                $bgColor = 'bg-orange-100 dark:bg-orange-900/30';
                                $textColor = 'text-orange-800 dark:text-orange-400';
                                $label = 'Alto';
                            } elseif ($severity === 'medium') {
                                $bgColor = 'bg-yellow-100 dark:bg-yellow-900/30';
                                $textColor = 'text-yellow-800 dark:text-yellow-400';
                                $label = 'Médio';
                            } else {
                                $bgColor = 'bg-green-100 dark:bg-green-900/30';
                                $textColor = 'text-green-800 dark:text-green-400';
                                $label = 'Baixo';
                            }
                        @endphp
                        <span
                            class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full {{ $bgColor }} {{ $textColor }}">
                            {{ $label }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Resumo -->
            <div class="mb-4">
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    <strong>{{ $fraudDetails['summary']['total_patterns'] }}</strong> padrão(ões) suspeito(s)
                    detectado(s) no período analisado.
                </p>
            </div>

            <!-- Padrões Detectados -->
            @if (count($fraudDetails['patterns']) > 0)
                <div class="space-y-4">
                    @foreach ($fraudDetails['patterns'] as $pattern)
                        <div class="p-4 border border-gray-200 rounded-lg dark:border-gray-700">
                            <div class="flex items-center justify-between mb-3">
                                <h5 class="text-md font-semibold text-gray-900 dark:text-gray-100">
                                    {{ $pattern['label'] }}
                                </h5>
                                @php
                                    if ($pattern['severity'] === 'critical') {
                                        $badgeColor = 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400';
                                    } elseif ($pattern['severity'] === 'high') {
                                        $badgeColor =
                                            'bg-orange-100 text-orange-800 dark:bg-orange-900/30 dark:text-orange-400';
                                    } elseif ($pattern['severity'] === 'medium') {
                                        $badgeColor =
                                            'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400';
                                    } else {
                                        $badgeColor =
                                            'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400';
                                    }
                                @endphp
                                <span
                                    class="inline-flex items-center px-2 py-1 text-xs font-semibold rounded-full {{ $badgeColor }}">
                                    {{ ucfirst($pattern['severity']) }}
                                </span>
                            </div>

                            <!-- Detalhes específicos do padrão -->
                            <div class="overflow-x-auto">
                                @if ($pattern['type'] === 'call_peak')
                                    <table
                                        class="min-w-full text-sm divide-y divide-gray-200 dark:divide-gray-700">
                                        <thead class="bg-gray-50 dark:bg-gray-800">
                                            <tr>
                                                <th
                                                    class="px-3 py-2 text-xs font-medium text-left text-gray-500 dark:text-gray-400">
                                                    Hora</th>
                                                <th
                                                    class="px-3 py-2 text-xs font-medium text-left text-gray-500 dark:text-gray-400">
                                                    Total de Chamadas</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                            @foreach ($pattern['data'] as $item)
                                                <tr>
                                                    <td class="px-3 py-2 text-gray-900 dark:text-gray-100">
                                                        {{ \Carbon\Carbon::parse($item->hora)->format('d/m/Y H:00') }}
                                                    </td>
                                                    <td class="px-3 py-2 font-bold text-red-600 dark:text-red-400">
                                                        {{ number_format($item->total_chamadas, 0, ',', '.') }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @elseif($pattern['type'] === 'premium_numbers')
                                    <table
                                        class="min-w-full text-sm divide-y divide-gray-200 dark:divide-gray-700">
                                        <thead class="bg-gray-50 dark:bg-gray-800">
                                            <tr>
                                                <th
                                                    class="px-3 py-2 text-xs font-medium text-left text-gray-500 dark:text-gray-400">
                                                    Número</th>
                                                <th
                                                    class="px-3 py-2 text-xs font-medium text-left text-gray-500 dark:text-gray-400">
                                                    Total</th>
                                                <th
                                                    class="px-3 py-2 text-xs font-medium text-left text-gray-500 dark:text-gray-400">
                                                    Duração</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                            @foreach ($pattern['data'] as $item)
                                                <tr>
                                                    <td class="px-3 py-2 font-mono text-gray-900 dark:text-gray-100">
                                                        {{ $item->dst }}
                                                    </td>
                                                    <td class="px-3 py-2 font-bold text-purple-600 dark:text-purple-400">
                                                        {{ number_format($item->total, 0, ',', '.') }}
                                                    </td>
                                                    <td class="px-3 py-2 text-gray-900 dark:text-gray-100">
                                                        {{ number_format($item->duracao_total / 60, 0) }} min
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @elseif($pattern['type'] === 'international')
                                    <table
                                        class="min-w-full text-sm divide-y divide-gray-200 dark:divide-gray-700">
                                        <thead class="bg-gray-50 dark:bg-gray-800">
                                            <tr>
                                                <th
                                                    class="px-3 py-2 text-xs font-medium text-left text-gray-500 dark:text-gray-400">
                                                    Número</th>
                                                <th
                                                    class="px-3 py-2 text-xs font-medium text-left text-gray-500 dark:text-gray-400">
                                                    Total</th>
                                                <th
                                                    class="px-3 py-2 text-xs font-medium text-left text-gray-500 dark:text-gray-400">
                                                    Duração</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                            @foreach ($pattern['data'] as $item)
                                                <tr>
                                                    <td class="px-3 py-2 font-mono text-gray-900 dark:text-gray-100">
                                                        {{ $item->dst }}
                                                    </td>
                                                    <td class="px-3 py-2 font-bold text-blue-600 dark:text-blue-400">
                                                        {{ number_format($item->total, 0, ',', '.') }}
                                                    </td>
                                                    <td class="px-3 py-2 text-gray-900 dark:text-gray-100">
                                                        {{ number_format($item->duracao_total / 60, 0) }} min
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @elseif($pattern['type'] === 'short_calls')
                                    <table
                                        class="min-w-full text-sm divide-y divide-gray-200 dark:divide-gray-700">
                                        <thead class="bg-gray-50 dark:bg-gray-800">
                                            <tr>
                                                <th
                                                    class="px-3 py-2 text-xs font-medium text-left text-gray-500 dark:text-gray-400">
                                                    Dia</th>
                                                <th
                                                    class="px-3 py-2 text-xs font-medium text-left text-gray-500 dark:text-gray-400">
                                                    Chamadas < 5s</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                            @foreach ($pattern['data'] as $item)
                                                <tr>
                                                    <td class="px-3 py-2 text-gray-900 dark:text-gray-100">
                                                        {{ \Carbon\Carbon::parse($item->dia)->format('d/m/Y') }}
                                                    </td>
                                                    <td class="px-3 py-2 font-bold text-orange-600 dark:text-orange-400">
                                                        {{ number_format($item->total, 0, ',', '.') }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @elseif($pattern['type'] === 'simultaneous')
                                    <table
                                        class="min-w-full text-sm divide-y divide-gray-200 dark:divide-gray-700">
                                        <thead class="bg-gray-50 dark:bg-gray-800">
                                            <tr>
                                                <th
                                                    class="px-3 py-2 text-xs font-medium text-left text-gray-500 dark:text-gray-400">
                                                    Minuto</th>
                                                <th
                                                    class="px-3 py-2 text-xs font-medium text-left text-gray-500 dark:text-gray-400">
                                                    Simultâneas</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                            @foreach ($pattern['data'] as $item)
                                                <tr>
                                                    <td class="px-3 py-2 text-gray-900 dark:text-gray-100">
                                                        {{ \Carbon\Carbon::parse($item->minuto)->format('d/m/Y H:i') }}
                                                    </td>
                                                    <td class="px-3 py-2 font-bold text-red-600 dark:text-red-400">
                                                        {{ number_format($item->simultaneas, 0, ',', '.') }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="py-8 text-center">
                    <p class="text-sm text-gray-500">Nenhum padrão suspeito detectado para este cliente.</p>
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
