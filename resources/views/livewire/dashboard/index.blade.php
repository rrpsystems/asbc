<div wire:poll.60s
    class="flex flex-col min-h-[calc(100vh-4rem)] pb-3 pl-6 pr-6 bg-white dark:bg-gray-600 border border-gray-300 dark:border-gray-100 rounded-md shadow-md shadow-black/5">
    <div class="container flex-grow mx-auto space-y-6">
        <!-- Header Section -->
        <div class="flex flex-col items-start justify-between my-4 sm:flex-row sm:items-center">
            <div>
                <h3 class="text-2xl font-bold text-gray-800 dark:text-gray-200">Dashboard</h3>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Visão geral do sistema de tarifação - {{ now()->translatedFormat('F Y') }}</p>
            </div>
            <div class="flex items-center gap-3 mt-4 sm:mt-0">
                {{-- Botões de Filtro de Período --}}
                <div class="flex gap-2 p-1 bg-gray-100 dark:bg-gray-700 rounded-lg">
                    <button wire:click="setPeriodo('hoje')"
                            class="px-3 py-1.5 text-xs font-medium rounded-md transition-all duration-200
                                   {{ $periodoFiltro === 'hoje' ? 'bg-blue-600 text-white shadow-md' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600' }}">
                        Hoje
                    </button>
                    <button wire:click="setPeriodo('semana')"
                            class="px-3 py-1.5 text-xs font-medium rounded-md transition-all duration-200
                                   {{ $periodoFiltro === 'semana' ? 'bg-blue-600 text-white shadow-md' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600' }}">
                        Semana
                    </button>
                    <button wire:click="setPeriodo('mes')"
                            class="px-3 py-1.5 text-xs font-medium rounded-md transition-all duration-200
                                   {{ $periodoFiltro === 'mes' ? 'bg-blue-600 text-white shadow-md' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600' }}">
                        Mês
                    </button>
                </div>

                <button wire:click="refresh" class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-white transition-all duration-200 bg-purple-600 rounded-lg shadow-sm hover:bg-purple-700 hover:shadow-md">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                    Atualizar
                </button>
                <span class="text-sm text-gray-600 dark:text-gray-400">Atualização automática: 60s</span>
                <div class="flex items-center gap-2 px-3 py-2 bg-gray-100 dark:bg-gray-700 rounded-lg">
                    <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                    <span class="text-xs font-medium text-gray-700 dark:text-gray-200">Conectado</span>
                </div>
            </div>
        </div>

        {{-- Resumo de Hoje --}}
        <div class="p-4 bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 rounded-lg shadow-lg">
            <div class="p-6 bg-white dark:bg-gray-800 rounded-lg">
                <div class="flex items-center gap-3 mb-4">
                    <div class="flex items-center justify-center w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-lg">
                        <x-ui-icon name="clock" class="w-5 h-5 text-white" />
                    </div>
                    <div>
                        <h4 class="text-lg font-bold text-gray-800 dark:text-gray-200">Resumo de Hoje</h4>
                        <p class="text-xs text-gray-600 dark:text-gray-400">{{ now()->translatedFormat('d \d\e F \d\e Y') }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                    {{-- Hoje: Custo --}}
                    <div class="relative overflow-hidden bg-gradient-to-br from-green-500 to-green-600 rounded-lg shadow-lg p-4">
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-white bg-opacity-30 rounded-lg flex-shrink-0">
                                <x-ui-icon name="currency-dollar" class="w-6 h-6 text-white" />
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs font-medium text-green-100">Custo Hoje</p>
                                <p class="text-xl font-bold text-white truncate">R$ {{ number_format($todayCost, 2, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- Hoje: Chamadas --}}
                    <div class="relative overflow-hidden bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg shadow-lg p-4">
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-white bg-opacity-30 rounded-lg flex-shrink-0">
                                <x-ui-icon name="phone" class="w-6 h-6 text-white" />
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs font-medium text-blue-100">Chamadas Hoje</p>
                                <p class="text-xl font-bold text-white truncate">{{ number_format($todayCalls, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- Hoje: Duração --}}
                    <div class="relative overflow-hidden bg-gradient-to-br from-orange-500 to-orange-600 rounded-lg shadow-lg p-4">
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-white bg-opacity-30 rounded-lg flex-shrink-0">
                                <x-ui-icon name="clock" class="w-6 h-6 text-white" />
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs font-medium text-orange-100">Duração Hoje</p>
                                <p class="text-xl font-bold text-white truncate">{{ number_format($todayDuration / 60, 0) }} min</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Linha 1 - Cards Principais (5 cards) --}}
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-5">

            {{-- Card 1: Custo Total --}}
            <div class="relative overflow-hidden bg-gradient-to-br from-green-500 to-green-600 rounded-lg shadow-lg">
                <div class="p-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-green-100">Custo Total</p>
                            <p class="text-3xl font-bold text-white">R$ {{ number_format($custoTotal, 2, ',', '.') }}</p>
                            <p class="mt-1 text-xs text-green-100 opacity-80">{{ $periodoLabel }}</p>
                        </div>
                        <div class="p-3 bg-white bg-opacity-30 rounded-lg">
                            <x-ui-icon name="currency-dollar" class="w-8 h-8 text-white" />
                        </div>
                    </div>
                </div>
            </div>

            {{-- Card 2: Total de Chamadas --}}
            <div class="relative overflow-hidden bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg shadow-lg">
                <div class="p-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-blue-100">Total de Chamadas</p>
                            <p class="text-3xl font-bold text-white">{{ number_format($data2->sum('max_customer_calls'), 0, ',', '.') }}</p>
                            <p class="mt-1 text-xs text-blue-100 opacity-80">{{ $periodoLabel }}</p>
                        </div>
                        <div class="p-3 bg-white bg-opacity-30 rounded-lg">
                            <x-ui-icon name="phone" class="w-8 h-8 text-white" />
                        </div>
                    </div>
                </div>
            </div>

            {{-- Card 3: Tempo Total --}}
            <div class="relative overflow-hidden bg-gradient-to-br from-cyan-500 to-cyan-600 rounded-lg shadow-lg">
                <div class="p-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-cyan-100">Tempo Total</p>
                            <p class="text-3xl font-bold text-white">{{ number_format($data2->sum('total_billsec') / 60, 0) }} min</p>
                            <p class="mt-1 text-xs text-cyan-100 opacity-80">Duração acumulada</p>
                        </div>
                        <div class="p-3 bg-white bg-opacity-30 rounded-lg">
                            <x-ui-icon name="clock" class="w-8 h-8 text-white" />
                        </div>
                    </div>
                </div>
            </div>

            {{-- Card 4: Pico da Operadora --}}
            <div class="relative overflow-hidden bg-gradient-to-br from-red-500 to-red-600 rounded-lg shadow-lg">
                <div class="p-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-red-100">Pico da Operadora</p>
                            <p class="text-3xl font-bold text-white">{{ $maxChannelsInfo['max'] }}</p>
                            <p class="mt-1 text-xs text-red-100 opacity-80">{{ $maxChannelsInfo['hour'] }}</p>
                        </div>
                        <div class="p-3 bg-white bg-opacity-30 rounded-lg">
                            <x-ui-icon name="bolt" class="w-8 h-8 text-white" />
                        </div>
                    </div>
                </div>
            </div>

            {{-- Card 5: Pico de Chamadas por Hora --}}
            <div class="relative overflow-hidden bg-gradient-to-br from-purple-500 to-indigo-600 rounded-lg shadow-lg">
                <div class="p-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-purple-100">Pico de Chamadas</p>
                            <p class="text-3xl font-bold text-white">{{ $callsPerHour['peak']['calls'] }}</p>
                            <p class="mt-1 text-xs text-purple-100 opacity-80">{{ $callsPerHour['peak']['hour_range'] }}</p>
                            <div class="flex gap-2 mt-2 text-xs text-purple-100">
                                <span>✓ {{ $callsPerHour['peak']['answered'] }}</span>
                                <span>✗ {{ $callsPerHour['peak']['failed'] }}</span>
                            </div>
                        </div>
                        <div class="p-3 bg-white bg-opacity-30 rounded-lg">
                            <x-ui-icon name="chart-bar" class="w-8 h-8 text-white" />
                        </div>
                    </div>
                </div>
            </div>

        </div>

        {{-- Linha 2 - Visualização Chamadas por Tipo --}}
        <div class="grid grid-cols-1 gap-6">
            {{-- Gráfico: Chamadas por Tipo --}}
            <div class="overflow-hidden bg-white shadow-md dark:bg-gray-800 rounded-lg">
                <div class="p-6 border-b bg-gradient-to-r from-orange-500 to-red-600 border-orange-600">
                    <div class="flex items-center justify-between">
                        <div>
                            <h4 class="text-lg font-bold text-white">Distribuição de Chamadas por Tipo ({{ $periodoLabel }})</h4>
                            <p class="mt-1 text-sm text-orange-100">Baseado nas tarifas configuradas na tabela de rates</p>
                        </div>
                        <div class="flex items-center justify-center w-12 h-12 bg-white/20 backdrop-blur-sm rounded-lg">
                            <x-ui-icon name="chart-pie" class="w-6 h-6 text-white" />
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    @php
                        $totalCalls = $callsByType->sum('total');
                        // Mapeamento de cores para cada tipo de tarifa
                        $colors = [
                            'Fixo' => ['bg' => 'bg-blue-500', 'text' => 'text-blue-700', 'bg-light' => 'bg-blue-100', 'dark-bg' => 'dark:bg-blue-900/30', 'dark-text' => 'dark:text-blue-400'],
                            'Movel' => ['bg' => 'bg-green-500', 'text' => 'text-green-700', 'bg-light' => 'bg-green-100', 'dark-bg' => 'dark:bg-green-900/30', 'dark-text' => 'dark:text-green-400'],
                            'Móvel' => ['bg' => 'bg-green-500', 'text' => 'text-green-700', 'bg-light' => 'bg-green-100', 'dark-bg' => 'dark:bg-green-900/30', 'dark-text' => 'dark:text-green-400'],
                            'Internacional' => ['bg' => 'bg-red-500', 'text' => 'text-red-700', 'bg-light' => 'bg-red-100', 'dark-bg' => 'dark:bg-red-900/30', 'dark-text' => 'dark:text-red-400'],
                            'Entrada' => ['bg' => 'bg-teal-500', 'text' => 'text-teal-700', 'bg-light' => 'bg-teal-100', 'dark-bg' => 'dark:bg-teal-900/30', 'dark-text' => 'dark:text-teal-400'],
                            'DDI' => ['bg' => 'bg-orange-500', 'text' => 'text-orange-700', 'bg-light' => 'bg-orange-100', 'dark-bg' => 'dark:bg-orange-900/30', 'dark-text' => 'dark:text-orange-400'],
                            'Premium' => ['bg' => 'bg-purple-500', 'text' => 'text-purple-700', 'bg-light' => 'bg-purple-100', 'dark-bg' => 'dark:bg-purple-900/30', 'dark-text' => 'dark:text-purple-400'],
                            'Celular' => ['bg' => 'bg-lime-500', 'text' => 'text-lime-700', 'bg-light' => 'bg-lime-100', 'dark-bg' => 'dark:bg-lime-900/30', 'dark-text' => 'dark:text-lime-400'],
                            'Local' => ['bg' => 'bg-cyan-500', 'text' => 'text-cyan-700', 'bg-light' => 'bg-cyan-100', 'dark-bg' => 'dark:bg-cyan-900/30', 'dark-text' => 'dark:text-cyan-400'],
                            'Outros' => ['bg' => 'bg-gray-500', 'text' => 'text-gray-700', 'bg-light' => 'bg-gray-100', 'dark-bg' => 'dark:bg-gray-900/30', 'dark-text' => 'dark:text-gray-400'],
                        ];
                    @endphp
                    <div class="space-y-4">
                        @forelse ($callsByType as $type)
                            @php
                                $percentage = $totalCalls > 0 ? ($type->total / $totalCalls * 100) : 0;
                                $color = $colors[$type->tipo] ?? ['bg' => 'bg-gray-500', 'text' => 'text-gray-700', 'bg-light' => 'bg-gray-100', 'dark-bg' => 'dark:bg-gray-900/30', 'dark-text' => 'dark:text-gray-400'];
                            @endphp
                            <div>
                                <div class="flex items-center justify-between mb-2">
                                    <div class="flex items-center gap-2">
                                        <div class="w-3 h-3 rounded-full {{ $color['bg'] }}"></div>
                                        <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">{{ $type->tipo }}</span>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <span class="text-xs font-medium text-gray-500 dark:text-gray-400">
                                            {{ number_format($type->total) }} chamadas
                                        </span>
                                        <span class="inline-flex items-center px-2.5 py-1 text-xs font-bold {{ $color['text'] }} {{ $color['bg-light'] }} rounded-full {{ $color['dark-bg'] }} {{ $color['dark-text'] }}">
                                            {{ number_format($percentage, 1) }}%
                                        </span>
                                    </div>
                                </div>
                                <div class="w-full h-3 overflow-hidden bg-gray-200 rounded-full dark:bg-gray-700">
                                    <div class="h-full {{ $color['bg'] }} rounded-full transition-all duration-500" style="width: {{ $percentage }}%"></div>
                                </div>
                            </div>
                        @empty
                            <div class="py-8 text-center text-gray-500 dark:text-gray-400">
                                Sem dados disponíveis
                            </div>
                        @endforelse

                        @if($callsByType->isNotEmpty())
                            <div class="pt-4 mt-4 border-t border-gray-200 dark:border-gray-700">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm font-bold text-gray-700 dark:text-gray-300">Total</span>
                                    <span class="text-lg font-bold text-gray-900 dark:text-white">{{ number_format($totalCalls) }}</span>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Linha 2.5 - Distribuição de Chamadas por Hora (24h) --}}
        <div class="grid grid-cols-1 gap-6">
            <div class="overflow-hidden bg-white shadow-md dark:bg-gray-800 rounded-lg">
                <div class="p-6 border-b bg-gradient-to-r from-indigo-500 to-purple-600 border-indigo-600">
                    <div class="flex items-center justify-between">
                        <div>
                            <h4 class="text-lg font-bold text-white">Distribuição de Chamadas por Hora ({{ $periodoLabel }})</h4>
                            <p class="mt-1 text-sm text-indigo-100">Pico às {{ $callsPerHour['peak']['hour'] }} com {{ number_format($callsPerHour['peak']['calls']) }} chamadas</p>
                        </div>
                        <div class="flex items-center justify-center w-12 h-12 bg-white/20 backdrop-blur-sm rounded-lg">
                            <x-ui-icon name="clock" class="w-6 h-6 text-white" />
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead>
                                <tr class="bg-gray-50 dark:bg-gray-900/50">
                                    <th class="px-4 py-3 text-xs font-semibold tracking-wider text-left text-gray-700 uppercase dark:text-gray-300">Hora</th>
                                    <th class="px-4 py-3 text-xs font-semibold tracking-wider text-right text-gray-700 uppercase dark:text-gray-300">Total</th>
                                    <th class="px-4 py-3 text-xs font-semibold tracking-wider text-right text-gray-700 uppercase dark:text-gray-300">Atendidas</th>
                                    <th class="px-4 py-3 text-xs font-semibold tracking-wider text-right text-gray-700 uppercase dark:text-gray-300">Falhadas</th>
                                    <th class="px-4 py-3 text-xs font-semibold tracking-wider text-left text-gray-700 uppercase dark:text-gray-300">Distribuição</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                                @php
                                    $maxCalls = $callsPerHour['hourly']->max('total_calls') ?: 1;
                                    $peakHour = $callsPerHour['peak']['hour'];
                                @endphp
                                @for($hour = 0; $hour < 24; $hour++)
                                    @php
                                        $hourData = $callsPerHour['hourly']->firstWhere('hour', $hour);
                                        $totalCalls = $hourData->total_calls ?? 0;
                                        $answeredCalls = $hourData->answered_calls ?? 0;
                                        $failedCalls = $hourData->failed_calls ?? 0;
                                        $percentage = $maxCalls > 0 ? ($totalCalls / $maxCalls * 100) : 0;
                                        $hourFormatted = sprintf('%02d:00', $hour);
                                        $isPeak = ($hourFormatted === $peakHour);
                                    @endphp
                                    <tr class="transition-colors hover:bg-gray-50 dark:hover:bg-gray-700/50 {{ $isPeak ? 'bg-purple-50 dark:bg-purple-900/20' : '' }}">
                                        <td class="px-4 py-3 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            <div class="flex items-center gap-2">
                                                {{ $hourFormatted }}
                                                @if($isPeak)
                                                    <span class="inline-flex items-center px-2 py-0.5 text-xs font-bold text-purple-700 bg-purple-100 rounded-full dark:bg-purple-900/50 dark:text-purple-300">
                                                        🏆 PICO
                                                    </span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 text-sm font-semibold text-right text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ number_format($totalCalls) }}
                                        </td>
                                        <td class="px-4 py-3 text-sm text-right text-green-600 whitespace-nowrap dark:text-green-400">
                                            {{ number_format($answeredCalls) }}
                                        </td>
                                        <td class="px-4 py-3 text-sm text-right text-red-600 whitespace-nowrap dark:text-red-400">
                                            {{ number_format($failedCalls) }}
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            <div class="flex items-center gap-2">
                                                <div class="flex-1 h-6 overflow-hidden bg-gray-200 rounded-full dark:bg-gray-700">
                                                    <div class="h-full {{ $isPeak ? 'bg-gradient-to-r from-purple-500 to-indigo-500' : 'bg-gradient-to-r from-blue-400 to-blue-500' }} rounded-full transition-all duration-300"
                                                         style="width: {{ $percentage }}%">
                                                    </div>
                                                </div>
                                                <span class="text-xs font-medium text-gray-500 dark:text-gray-400 min-w-[3rem] text-right">
                                                    {{ number_format($percentage, 1) }}%
                                                </span>
                                            </div>
                                        </td>
                                    </tr>
                                @endfor
                            </tbody>
                            <tfoot>
                                <tr class="font-bold bg-gray-100 dark:bg-gray-900">
                                    <td class="px-4 py-3 text-sm text-gray-900 dark:text-white">TOTAL</td>
                                    <td class="px-4 py-3 text-sm text-right text-gray-900 dark:text-white">
                                        {{ number_format($callsPerHour['hourly']->sum('total_calls')) }}
                                    </td>
                                    <td class="px-4 py-3 text-sm text-right text-green-600 dark:text-green-400">
                                        {{ number_format($callsPerHour['hourly']->sum('answered_calls')) }}
                                    </td>
                                    <td class="px-4 py-3 text-sm text-right text-red-600 dark:text-red-400">
                                        {{ number_format($callsPerHour['hourly']->sum('failed_calls')) }}
                                    </td>
                                    <td class="px-4 py-3"></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Linha 3 - Rankings Top 10 -->
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">

            <!-- Ranking 1: Top 10 Clientes - Volume de Chamadas -->
            <div class="overflow-hidden transition-all duration-300 bg-white shadow-lg dark:bg-gray-800 rounded-2xl hover:shadow-xl">
                <div class="p-6 border-b bg-gradient-to-r from-purple-500 to-pink-600 border-purple-600">
                    <div class="flex items-center justify-between">
                        <div>
                            <h4 class="text-lg font-bold text-white">🏆 Top 10 - Volume de Chamadas ({{ $periodoLabel }})</h4>
                            <p class="mt-1 text-sm text-purple-100">Clientes com maior volume</p>
                        </div>
                        <div class="flex items-center justify-center w-12 h-12 bg-white/20 backdrop-blur-sm rounded-xl">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b border-gray-200 dark:border-gray-700">
                                    <th class="px-4 py-3 text-xs font-semibold tracking-wider text-left text-gray-700 uppercase dark:text-gray-300">
                                        #
                                    </th>
                                    <th class="px-4 py-3 text-xs font-semibold tracking-wider text-left text-gray-700 uppercase dark:text-gray-300">
                                        Cliente
                                    </th>
                                    <th class="px-4 py-3 text-xs font-semibold tracking-wider text-center text-gray-700 uppercase dark:text-gray-300">
                                        Chamadas
                                    </th>
                                    <th class="px-4 py-3 text-xs font-semibold tracking-wider text-center text-gray-700 uppercase dark:text-gray-300">
                                        Tempo
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($data2->take(10) as $item)
                                    <tr class="transition-colors hover:bg-purple-50 dark:hover:bg-gray-700/50">
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            @if($loop->iteration <= 3)
                                                <span class="inline-flex items-center justify-center w-6 h-6 text-xs font-bold text-white rounded-full
                                                    {{ $loop->iteration == 1 ? 'bg-gradient-to-br from-yellow-400 to-yellow-600' : '' }}
                                                    {{ $loop->iteration == 2 ? 'bg-gradient-to-br from-gray-300 to-gray-500' : '' }}
                                                    {{ $loop->iteration == 3 ? 'bg-gradient-to-br from-orange-400 to-orange-600' : '' }}
                                                ">
                                                    {{ $loop->iteration }}
                                                </span>
                                            @else
                                                <span class="inline-flex items-center justify-center w-6 h-6 text-xs font-semibold text-gray-600 bg-gray-100 rounded-full dark:bg-gray-700 dark:text-gray-400">
                                                    {{ $loop->iteration }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 text-sm text-gray-900 dark:text-gray-300">
                                            <div class="flex items-center gap-2">
                                                <div class="flex items-center justify-center flex-shrink-0 w-8 h-8 bg-purple-100 rounded-lg dark:bg-purple-900/30">
                                                    <span class="text-xs font-bold text-purple-600 dark:text-purple-400">
                                                        {{ $item->customer ? substr($item->customer->razaosocial, 0, 2) : 'N/A' }}
                                                    </span>
                                                </div>
                                                <span class="font-medium truncate max-w-[120px]" title="{{ $item->customer?->razaosocial ?? 'Cliente não identificado' }}">
                                                    {{ $item->customer ? Str::limit($item->customer->razaosocial, 15) : 'Cliente não identificado' }}
                                                </span>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 text-center whitespace-nowrap">
                                            <span class="inline-flex items-center px-2.5 py-1 text-xs font-bold text-purple-700 bg-purple-100 rounded-full dark:bg-purple-900/30 dark:text-purple-400">
                                                {{ number_format($item->max_customer_calls) }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 text-center whitespace-nowrap">
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 text-xs font-semibold text-pink-700 bg-pink-100 rounded-full dark:bg-pink-900/30 dark:text-pink-400">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                {{ number_format($item->total_billsec / 60, 0) }} min
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-4 py-8 text-sm text-center text-gray-500 dark:text-gray-400">
                                            <svg class="w-12 h-12 mx-auto mb-3 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                            </svg>
                                            Sem dados disponíveis
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Ranking 2: Top 10 Destinos -->
            <div class="overflow-hidden transition-all duration-300 bg-white shadow-lg dark:bg-gray-800 rounded-2xl hover:shadow-xl">
                <div class="p-6 border-b bg-gradient-to-r from-blue-500 to-cyan-600 border-blue-600">
                    <div class="flex items-center justify-between">
                        <div>
                            <h4 class="text-lg font-bold text-white">🏆 Top 10 - Destinos ({{ $periodoLabel }})</h4>
                            <p class="mt-1 text-sm text-blue-100">Números mais chamados</p>
                        </div>
                        <div class="flex items-center justify-center w-12 h-12 bg-white/20 backdrop-blur-sm rounded-xl">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b border-gray-200 dark:border-gray-700">
                                    <th class="px-4 py-3 text-xs font-semibold tracking-wider text-left text-gray-700 uppercase dark:text-gray-300">
                                        #
                                    </th>
                                    <th class="px-4 py-3 text-xs font-semibold tracking-wider text-left text-gray-700 uppercase dark:text-gray-300">
                                        Destino
                                    </th>
                                    <th class="px-4 py-3 text-xs font-semibold tracking-wider text-center text-gray-700 uppercase dark:text-gray-300">
                                        Chamadas
                                    </th>
                                    <th class="px-4 py-3 text-xs font-semibold tracking-wider text-center text-gray-700 uppercase dark:text-gray-300">
                                        Tempo
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($topDestinos as $destino)
                                    <tr class="transition-colors hover:bg-blue-50 dark:hover:bg-gray-700/50">
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            @if($loop->iteration <= 3)
                                                <span class="inline-flex items-center justify-center w-6 h-6 text-xs font-bold text-white rounded-full
                                                    {{ $loop->iteration == 1 ? 'bg-gradient-to-br from-yellow-400 to-yellow-600' : '' }}
                                                    {{ $loop->iteration == 2 ? 'bg-gradient-to-br from-gray-300 to-gray-500' : '' }}
                                                    {{ $loop->iteration == 3 ? 'bg-gradient-to-br from-orange-400 to-orange-600' : '' }}
                                                ">
                                                    {{ $loop->iteration }}
                                                </span>
                                            @else
                                                <span class="inline-flex items-center justify-center w-6 h-6 text-xs font-semibold text-gray-600 bg-gray-100 rounded-full dark:bg-gray-700 dark:text-gray-400">
                                                    {{ $loop->iteration }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 text-sm text-gray-900 dark:text-gray-300">
                                            <div class="flex items-center gap-2">
                                                <div class="flex items-center justify-center flex-shrink-0 w-8 h-8 bg-blue-100 rounded-lg dark:bg-blue-900/30">
                                                    <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                                    </svg>
                                                </div>
                                                <span class="font-mono text-xs font-medium">
                                                    {{ $destino->numero }}
                                                </span>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 text-center whitespace-nowrap">
                                            <span class="inline-flex items-center px-2.5 py-1 text-xs font-bold text-blue-700 bg-blue-100 rounded-full dark:bg-blue-900/30 dark:text-blue-400">
                                                {{ number_format($destino->total_calls) }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 text-center whitespace-nowrap">
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 text-xs font-semibold text-cyan-700 bg-cyan-100 rounded-full dark:bg-cyan-900/30 dark:text-cyan-400">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                {{ number_format($destino->total_duration / 60, 0) }} min
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-4 py-8 text-sm text-center text-gray-500 dark:text-gray-400">
                                            <svg class="w-12 h-12 mx-auto mb-3 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                            </svg>
                                            Sem dados disponíveis
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Ranking 3: Top 10 Canais Simultâneos -->
            <div class="overflow-hidden transition-all duration-300 bg-white shadow-lg dark:bg-gray-800 rounded-2xl hover:shadow-xl">
                <div class="p-6 border-b bg-gradient-to-r from-emerald-500 to-green-600 border-emerald-600">
                    <div class="flex items-center justify-between">
                        <div>
                            <h4 class="text-lg font-bold text-white">🏆 Top 10 - Canais Simultâneos ({{ $periodoLabel }})</h4>
                            <p class="mt-1 text-sm text-emerald-100">Clientes com maior uso</p>
                        </div>
                        <div class="flex items-center justify-center w-12 h-12 bg-white/20 backdrop-blur-sm rounded-xl">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b border-gray-200 dark:border-gray-700">
                                    <th class="px-4 py-3 text-xs font-semibold tracking-wider text-left text-gray-700 uppercase dark:text-gray-300">
                                        #
                                    </th>
                                    <th class="px-4 py-3 text-xs font-semibold tracking-wider text-left text-gray-700 uppercase dark:text-gray-300">
                                        Cliente
                                    </th>
                                    <th class="px-4 py-3 text-xs font-semibold tracking-wider text-center text-gray-700 uppercase dark:text-gray-300">
                                        Canais
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($data1->take(10) as $item)
                                    <tr class="transition-colors hover:bg-emerald-50 dark:hover:bg-gray-700/50">
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            @if($loop->iteration <= 3)
                                                <span class="inline-flex items-center justify-center w-6 h-6 text-xs font-bold text-white rounded-full
                                                    {{ $loop->iteration == 1 ? 'bg-gradient-to-br from-yellow-400 to-yellow-600' : '' }}
                                                    {{ $loop->iteration == 2 ? 'bg-gradient-to-br from-gray-300 to-gray-500' : '' }}
                                                    {{ $loop->iteration == 3 ? 'bg-gradient-to-br from-orange-400 to-orange-600' : '' }}
                                                ">
                                                    {{ $loop->iteration }}
                                                </span>
                                            @else
                                                <span class="inline-flex items-center justify-center w-6 h-6 text-xs font-semibold text-gray-600 bg-gray-100 rounded-full dark:bg-gray-700 dark:text-gray-400">
                                                    {{ $loop->iteration }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 text-sm text-gray-900 dark:text-gray-300">
                                            <div class="flex items-center gap-2">
                                                <div class="flex items-center justify-center flex-shrink-0 w-8 h-8 bg-emerald-100 rounded-lg dark:bg-emerald-900/30">
                                                    <span class="text-xs font-bold text-emerald-600 dark:text-emerald-400">
                                                        {{ $item->customer ? substr($item->customer->razaosocial, 0, 2) : 'N/A' }}
                                                    </span>
                                                </div>
                                                <span class="font-medium truncate max-w-[150px]" title="{{ $item->customer?->razaosocial ?? 'Cliente não identificado' }}">
                                                    {{ $item->customer ? Str::limit($item->customer->razaosocial, 20) : 'Cliente não identificado' }}
                                                </span>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 text-center whitespace-nowrap">
                                            <span class="inline-flex items-center px-3 py-1 text-sm font-bold text-emerald-700 bg-emerald-100 rounded-full dark:bg-emerald-900/30 dark:text-emerald-400">
                                                {{ $item->max_customer_channels }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-4 py-8 text-sm text-center text-gray-500 dark:text-gray-400">
                                            <svg class="w-12 h-12 mx-auto mb-3 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                            </svg>
                                            Sem dados disponíveis
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>

        <!-- Linha 4 - Detalhes -->
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">

            <!-- Últimas Chamadas -->
            <div class="overflow-hidden transition-all duration-300 bg-white shadow-lg dark:bg-gray-800 rounded-2xl hover:shadow-xl">
                <div class="p-6 border-b bg-gradient-to-r from-slate-600 to-gray-700 border-slate-600">
                    <div class="flex items-center justify-between">
                        <div>
                            <h4 class="text-lg font-bold text-white">📋 Últimas Chamadas</h4>
                            <p class="mt-1 text-sm text-slate-100">10 chamadas mais recentes do sistema</p>
                        </div>
                        <div class="flex items-center justify-center w-12 h-12 bg-white/20 backdrop-blur-sm rounded-xl">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b border-gray-200 dark:border-gray-700">
                                    <th class="px-4 py-3 text-xs font-semibold tracking-wider text-left text-gray-700 uppercase dark:text-gray-300">
                                        Data/Hora
                                    </th>
                                    <th class="px-4 py-3 text-xs font-semibold tracking-wider text-left text-gray-700 uppercase dark:text-gray-300">
                                        Cliente
                                    </th>
                                    <th class="px-4 py-3 text-xs font-semibold tracking-wider text-left text-gray-700 uppercase dark:text-gray-300">
                                        Destino
                                    </th>
                                    <th class="px-4 py-3 text-xs font-semibold tracking-wider text-center text-gray-700 uppercase dark:text-gray-300">
                                        Duração
                                    </th>
                                    <th class="px-4 py-3 text-xs font-semibold tracking-wider text-center text-gray-700 uppercase dark:text-gray-300">
                                        Status
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($recentCalls as $call)
                                    <tr class="transition-colors hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                        <td class="px-4 py-3 text-xs text-gray-900 whitespace-nowrap dark:text-gray-300">
                                            {{ \Carbon\Carbon::parse($call->calldate)->format('d/m H:i:s') }}
                                        </td>
                                        <td class="px-4 py-3 text-sm text-gray-900 dark:text-gray-300">
                                            <div class="flex items-center gap-2">
                                                <div class="flex items-center justify-center flex-shrink-0 w-6 h-6 bg-slate-100 rounded dark:bg-slate-900/30">
                                                    <span class="text-xs font-bold text-slate-600 dark:text-slate-400">
                                                        {{ substr($call->customer->razaosocial ?? 'N/A', 0, 1) }}
                                                    </span>
                                                </div>
                                                <span class="text-xs truncate max-w-[100px]" title="{{ $call->customer->razaosocial ?? 'N/A' }}">
                                                    {{ Str::limit($call->customer->razaosocial ?? 'N/A', 12) }}
                                                </span>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 text-xs font-mono text-gray-900 dark:text-gray-300">
                                            {{ $call->numero }}
                                        </td>
                                        <td class="px-4 py-3 text-center whitespace-nowrap">
                                            <span class="inline-flex items-center px-2 py-1 text-xs font-semibold text-gray-700 bg-gray-100 rounded dark:bg-gray-700 dark:text-gray-300">
                                                {{ gmdate('i:s', $call->billsec) }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 text-center whitespace-nowrap">
                                            @php
                                                $disposition = trim($call->disposition);
                                                $statusConfig = [
                                                    'Atendida' => ['label' => 'Atendida', 'classes' => 'text-green-700 bg-green-100 dark:bg-green-900/30 dark:text-green-400'],
                                                    'Desconhecido' => ['label' => 'Desconhecido', 'classes' => 'text-purple-700 bg-purple-100 dark:bg-purple-900/30 dark:text-purple-400'],
                                                    'ANSWERED' => ['label' => 'Atendida', 'classes' => 'text-green-700 bg-green-100 dark:bg-green-900/30 dark:text-green-400'],
                                                    'NO ANSWER' => ['label' => 'Não Atendida', 'classes' => 'text-yellow-700 bg-yellow-100 dark:bg-yellow-900/30 dark:text-yellow-400'],
                                                    'BUSY' => ['label' => 'Ocupado', 'classes' => 'text-orange-700 bg-orange-100 dark:bg-orange-900/30 dark:text-orange-400'],
                                                    'FAILED' => ['label' => 'Falha', 'classes' => 'text-red-700 bg-red-100 dark:bg-red-900/30 dark:text-red-400'],
                                                    'CANCELLED' => ['label' => 'Cancelada', 'classes' => 'text-gray-700 bg-gray-100 dark:bg-gray-900/30 dark:text-gray-400'],
                                                    'BLOCKED' => ['label' => 'Bloqueado', 'classes' => 'text-red-700 bg-red-100 dark:bg-red-900/30 dark:text-red-400'],
                                                ];
                                                $status = $statusConfig[$disposition] ?? ['label' => $disposition, 'classes' => 'text-gray-700 bg-gray-100 dark:bg-gray-900/30 dark:text-gray-400'];
                                            @endphp
                                            <span class="inline-flex items-center px-2 py-1 text-xs font-semibold rounded {{ $status['classes'] }}">
                                                {{ $status['label'] }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-4 py-8 text-sm text-center text-gray-500 dark:text-gray-400">
                                            <svg class="w-12 h-12 mx-auto mb-3 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                            </svg>
                                            Sem dados disponíveis
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Horários de Pico por Hora -->
            <div class="overflow-hidden transition-all duration-300 bg-white shadow-lg dark:bg-gray-800 rounded-2xl hover:shadow-xl">
                <div class="p-6 border-b bg-gradient-to-r from-sky-500 to-blue-600 border-sky-600">
                    <div class="flex items-center justify-between">
                        <div>
                            <h4 class="text-lg font-bold text-white">🌡️ Pico por Faixa Horária</h4>
                            <p class="mt-1 text-sm text-sky-100">Máximo de canais simultâneos por hora do dia (este mês)</p>
                        </div>
                        <div class="flex items-center justify-center w-12 h-12 bg-white/20 backdrop-blur-sm rounded-xl">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b border-gray-200 dark:border-gray-700">
                                    <th class="px-4 py-3 text-xs font-semibold tracking-wider text-left text-gray-700 uppercase dark:text-gray-300">
                                        Horário
                                    </th>
                                    <th class="px-4 py-3 text-xs font-semibold tracking-wider text-center text-gray-700 uppercase dark:text-gray-300">
                                        Operadora
                                    </th>
                                    <th class="px-4 py-3 text-xs font-semibold tracking-wider text-center text-gray-700 uppercase dark:text-gray-300">
                                        Clientes
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($data as $item)
                                    <tr class="transition-colors hover:bg-sky-50 dark:hover:bg-gray-700/50">
                                        <td class="px-4 py-3 text-sm text-gray-900 whitespace-nowrap dark:text-gray-300">
                                            <div class="flex items-center gap-2">
                                                <svg class="w-4 h-4 text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                <span class="font-semibold">{{ sprintf('%02d:00', $item->hour_of_day) }}</span>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 text-center whitespace-nowrap">
                                            <span class="inline-flex items-center px-2.5 py-1 text-xs font-semibold text-blue-700 bg-blue-100 rounded-full dark:bg-blue-900/30 dark:text-blue-400">
                                                {{ $item->max_carrier_channels }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 text-center whitespace-nowrap">
                                            <span class="inline-flex items-center px-2.5 py-1 text-xs font-semibold text-emerald-700 bg-emerald-100 rounded-full dark:bg-emerald-900/30 dark:text-emerald-400">
                                                {{ $item->max_customer_channels }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-4 py-8 text-sm text-center text-gray-500 dark:text-gray-400">
                                            <svg class="w-12 h-12 mx-auto mb-3 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                            </svg>
                                            Sem dados disponíveis
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>
