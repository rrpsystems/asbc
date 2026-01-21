<div
    class="flex flex-col min-h-[calc(100vh-4rem)] pb-3 pl-6 pr-6 bg-white dark:bg-gray-600 border border-gray-300 dark:border-gray-100 rounded-md shadow-md shadow-black/5">
    <div class="container flex-grow mx-auto">
        <!-- Header -->
        <div class="flex flex-col items-center justify-between my-4 sm:flex-row">
            <div>
                <h3 class="mb-2 text-2xl font-bold text-gray-800 dark:text-gray-200">Análise de Qualidade (ASR/ACD)
                </h3>
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    Período: {{ date('d/m/Y', strtotime($data_inicial)) }} até
                    {{ date('d/m/Y', strtotime($data_final)) }}
                </p>
            </div>

            <div class="flex gap-2 mt-4 sm:mt-0">
                <button wire:click="exportExcel"
                    class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-white transition-all duration-200 bg-green-600 rounded-lg shadow-sm hover:bg-green-700 hover:shadow-md">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                    Exportar Excel
                </button>

                <x-ui-button icon="funnel" wire:click="openFilter" color="purple" position="left">Filtros</x-ui-button>
            </div>
        </div>

        <!-- Group By Tabs -->
        <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
            <nav class="flex -mb-px space-x-8">
                <button wire:click="$set('group_by', 'customer')"
                    class="py-4 px-1 border-b-2 font-medium text-sm {{ $group_by === 'customer' ? 'border-purple-500 text-purple-600 dark:text-purple-400' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400' }}">
                    Por Cliente
                </button>
                <button wire:click="$set('group_by', 'carrier')"
                    class="py-4 px-1 border-b-2 font-medium text-sm {{ $group_by === 'carrier' ? 'border-purple-500 text-purple-600 dark:text-purple-400' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400' }}">
                    Por Operadora
                </button>
                <button wire:click="$set('group_by', 'daily')"
                    class="py-4 px-1 border-b-2 font-medium text-sm {{ $group_by === 'daily' ? 'border-purple-500 text-purple-600 dark:text-purple-400' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400' }}">
                    Por Dia
                </button>
            </nav>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 gap-4 mb-6 md:grid-cols-2 lg:grid-cols-4">
            <!-- Total Chamadas -->
            <div class="p-4 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg shadow-md">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-blue-100">Total de Chamadas</p>
                        <p class="mt-1 text-2xl font-bold text-white">
                            {{ number_format($totals->total_chamadas ?? 0, 0, ',', '.') }}
                        </p>
                    </div>
                    <div class="p-3 bg-white/20 rounded-full">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- ASR -->
            <div class="p-4 bg-gradient-to-br from-green-500 to-green-600 rounded-lg shadow-md">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-green-100">ASR (Taxa Atendimento)</p>
                        <p class="mt-1 text-2xl font-bold text-white">
                            {{ number_format($totals->asr ?? 0, 2, ',', '.') }}%
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

            <!-- ACD -->
            <div class="p-4 bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg shadow-md">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-purple-100">ACD (Duração Média)</p>
                        <p class="mt-1 text-2xl font-bold text-white">
                            {{ gmdate('i:s', $totals->acd ?? 0) }} min
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

            <!-- Atendidas -->
            <div class="p-4 bg-gradient-to-br from-cyan-500 to-cyan-600 rounded-lg shadow-md">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-cyan-100">Chamadas Atendidas</p>
                        <p class="mt-1 text-2xl font-bold text-white">
                            {{ number_format($totals->chamadas_atendidas ?? 0, 0, ',', '.') }}
                        </p>
                    </div>
                    <div class="p-3 bg-white/20 rounded-full">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto bg-white shadow-md dark:bg-gray-800">
            <x-tables.table>
                <x-slot name="header">
                    <x-tables.th
                        label="{{ $group_by === 'customer' ? 'Cliente' : ($group_by === 'carrier' ? 'Operadora' : 'Data') }}"
                        column="nome" :direction="$direction" :sort="$sort" />
                    <x-tables.th label="Total Chamadas" column="total_chamadas" :direction="$direction" :sort="$sort" />
                    <x-tables.th label="Atendidas" column="chamadas_atendidas" :direction="$direction" :sort="$sort" />
                    <x-tables.th label="Não Atendidas" column="chamadas_nao_atendidas" :direction="$direction"
                        :sort="$sort" />
                    <x-tables.th label="ASR %" column="asr" :direction="$direction" :sort="$sort" />
                    <x-tables.th label="ACD" column="acd" :direction="$direction" :sort="$sort" />
                    <x-tables.th label="Duração Total" column="total_duracao" :direction="$direction" :sort="$sort" />
                </x-slot>

                <x-slot name="body">
                    @forelse ($data as $item)
                        <x-tables.tr>
                            <x-tables.td class="py-2">
                                @if ($group_by === 'daily')
                                    {{ date('d/m/Y', strtotime($item->data)) }}
                                @else
                                    {{ \Illuminate\Support\Str::limit($item->nome, 35) }}
                                @endif
                            </x-tables.td>

                            <x-tables.td class="py-2">
                                <span class="font-medium text-gray-900 dark:text-gray-100">
                                    {{ number_format($item->total_chamadas, 0, ',', '.') }}
                                </span>
                            </x-tables.td>

                            <x-tables.td class="py-2">
                                <span class="text-green-600 dark:text-green-400">
                                    {{ number_format($item->chamadas_atendidas, 0, ',', '.') }}
                                </span>
                            </x-tables.td>

                            <x-tables.td class="py-2">
                                <span class="text-red-600 dark:text-red-400">
                                    {{ number_format($item->chamadas_nao_atendidas, 0, ',', '.') }}
                                </span>
                            </x-tables.td>

                            <x-tables.td class="py-2">
                                <div class="flex items-center gap-2">
                                    <span
                                        class="font-bold {{ $item->asr >= 50 ? 'text-green-600' : ($item->asr >= 30 ? 'text-yellow-600' : 'text-red-600') }}">
                                        {{ number_format($item->asr, 2, ',', '.') }}%
                                    </span>
                                    @if ($item->asr >= 50)
                                        <span class="text-xs text-green-600">●</span>
                                    @elseif($item->asr >= 30)
                                        <span class="text-xs text-yellow-600">●</span>
                                    @else
                                        <span class="text-xs text-red-600">●</span>
                                    @endif
                                </div>
                            </x-tables.td>

                            <x-tables.td class="py-2">
                                <span class="font-medium text-purple-600 dark:text-purple-400">
                                    {{ gmdate('i:s', $item->acd ?? 0) }} min
                                </span>
                            </x-tables.td>

                            <x-tables.td class="py-2">
                                {{ number_format(($item->total_duracao ?? 0) / 60, 0) }} min
                            </x-tables.td>
                        </x-tables.tr>
                    @empty
                        <x-tables.tr>
                            <x-tables.td colspan="7" class="py-8 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                        </path>
                                    </svg>
                                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Nenhum dado encontrado
                                        para este período</p>
                                </div>
                            </x-tables.td>
                        </x-tables.tr>
                    @endforelse
                </x-slot>
            </x-tables.table>
        </div>

        <!-- Análise de Códigos SIP e Q.850 -->
        <div class="grid grid-cols-1 gap-4 mt-6 lg:grid-cols-3">
            <!-- Códigos SIP mais frequentes -->
            <div class="p-4 bg-white shadow-md dark:bg-gray-800 rounded-lg">
                <h4 class="mb-4 text-lg font-semibold text-gray-800 dark:text-gray-200">
                    Top 10 Códigos SIP
                </h4>
                <div class="space-y-3">
                    @forelse($sipAnalysis as $sip)
                        <div class="flex items-center justify-between p-2 rounded bg-gray-50 dark:bg-gray-700">
                            <div class="flex-1">
                                <div class="flex items-center gap-2">
                                    <span class="px-2 py-1 text-xs font-mono font-bold rounded
                                        {{ $sip->sip_code == '200' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' :
                                           (in_array($sip->sip_code, ['486', '487']) ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200' :
                                           'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200') }}">
                                        {{ $sip->sip_code }}
                                    </span>
                                    <span class="text-sm text-gray-700 dark:text-gray-300">
                                        {{ \Illuminate\Support\Str::limit($sip->sip_reason ?? 'N/A', 20) }}
                                    </span>
                                </div>
                                <div class="mt-1 w-full bg-gray-200 rounded-full h-2 dark:bg-gray-600">
                                    <div class="h-2 rounded-full {{ $sip->sip_code == '200' ? 'bg-green-600' : 'bg-red-600' }}"
                                         style="width: {{ $sip->percentage }}%"></div>
                                </div>
                            </div>
                            <div class="ml-3 text-right">
                                <div class="text-sm font-bold text-gray-900 dark:text-gray-100">
                                    {{ number_format($sip->total, 0, ',', '.') }}
                                </div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ number_format($sip->percentage, 1) }}%
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-center text-gray-500 dark:text-gray-400">
                            Nenhum dado SIP disponível
                        </p>
                    @endforelse
                </div>
            </div>

            <!-- Códigos Q.850 mais frequentes -->
            <div class="p-4 bg-white shadow-md dark:bg-gray-800 rounded-lg">
                <h4 class="mb-4 text-lg font-semibold text-gray-800 dark:text-gray-200">
                    Top 10 Causas Q.850
                </h4>
                <div class="space-y-3">
                    @forelse($q850Analysis as $q850)
                        <div class="flex items-center justify-between p-2 rounded bg-gray-50 dark:bg-gray-700">
                            <div class="flex-1">
                                <div class="flex items-center gap-2">
                                    <span class="px-2 py-1 text-xs font-mono font-bold rounded
                                        {{ $q850->q850_cause == '16' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' :
                                           (in_array($q850->q850_cause, ['17', '19']) ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200' :
                                           'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200') }}">
                                        {{ $q850->q850_cause }}
                                    </span>
                                    <span class="text-sm text-gray-700 dark:text-gray-300">
                                        {{ \Illuminate\Support\Str::limit($q850->q850_description ?? 'N/A', 18) }}
                                    </span>
                                </div>
                                <div class="mt-1 w-full bg-gray-200 rounded-full h-2 dark:bg-gray-600">
                                    <div class="h-2 rounded-full {{ $q850->q850_cause == '16' ? 'bg-green-600' : 'bg-orange-600' }}"
                                         style="width: {{ $q850->percentage }}%"></div>
                                </div>
                            </div>
                            <div class="ml-3 text-right">
                                <div class="text-sm font-bold text-gray-900 dark:text-gray-100">
                                    {{ number_format($q850->total, 0, ',', '.') }}
                                </div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ number_format($q850->percentage, 1) }}%
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-center text-gray-500 dark:text-gray-400">
                            Nenhum dado Q.850 disponível
                        </p>
                    @endforelse
                </div>
            </div>

            <!-- Tipos de Falha -->
            <div class="p-4 bg-white shadow-md dark:bg-gray-800 rounded-lg">
                <h4 class="mb-4 text-lg font-semibold text-gray-800 dark:text-gray-200">
                    Tipos de Falha
                </h4>
                <div class="space-y-3">
                    @forelse($failureTypeAnalysis as $failure)
                        <div class="flex items-center justify-between p-2 rounded bg-gray-50 dark:bg-gray-700">
                            <div class="flex-1">
                                <div class="flex items-center gap-2">
                                    @php
                                        $failureColors = [
                                            'REDIRECT' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200',
                                            'CLIENT_ERROR' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
                                            'SERVER_ERROR' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
                                            'GLOBAL_FAILURE' => 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200',
                                        ];
                                        $failureLabels = [
                                            'REDIRECT' => 'Redirecionamento',
                                            'CLIENT_ERROR' => 'Erro Cliente',
                                            'SERVER_ERROR' => 'Erro Servidor',
                                            'GLOBAL_FAILURE' => 'Falha Global',
                                        ];
                                    @endphp
                                    <span class="px-2 py-1 text-xs font-semibold rounded {{ $failureColors[$failure->failure_type] ?? 'bg-gray-100 text-gray-800' }}">
                                        {{ $failureLabels[$failure->failure_type] ?? $failure->failure_type }}
                                    </span>
                                </div>
                                <div class="mt-2 w-full bg-gray-200 rounded-full h-2 dark:bg-gray-600">
                                    @php
                                        $barColors = [
                                            'REDIRECT' => 'bg-blue-600',
                                            'CLIENT_ERROR' => 'bg-yellow-600',
                                            'SERVER_ERROR' => 'bg-red-600',
                                            'GLOBAL_FAILURE' => 'bg-purple-600',
                                        ];
                                    @endphp
                                    <div class="h-2 rounded-full {{ $barColors[$failure->failure_type] ?? 'bg-gray-600' }}"
                                         style="width: {{ $failure->percentage }}%"></div>
                                </div>
                            </div>
                            <div class="ml-3 text-right">
                                <div class="text-sm font-bold text-gray-900 dark:text-gray-100">
                                    {{ number_format($failure->total, 0, ',', '.') }}
                                </div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ number_format($failure->percentage, 1) }}%
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-center text-gray-500 dark:text-gray-400">
                            Nenhum dado de falha disponível
                        </p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Legend -->
        <div class="p-4 mt-6 bg-gray-50 rounded-lg dark:bg-gray-800">
            <p class="mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Legenda ASR:</p>
            <div class="flex flex-wrap gap-4 text-sm">
                <div class="flex items-center gap-2">
                    <span class="inline-block w-3 h-3 bg-green-500 rounded-full"></span>
                    <span class="text-gray-600 dark:text-gray-400">Excelente (≥ 50%)</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="inline-block w-3 h-3 bg-yellow-500 rounded-full"></span>
                    <span class="text-gray-600 dark:text-gray-400">Aceitável (30-50%)</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="inline-block w-3 h-3 bg-red-500 rounded-full"></span>
                    <span class="text-gray-600 dark:text-gray-400">Crítico (< 30%)</span>
                </div>
            </div>
            <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                ASR = (Chamadas Atendidas / Total de Chamadas) × 100 | ACD = Duração Média das Chamadas Atendidas
            </p>
        </div>
    </div>

    {{ $data->links('vendor.livewire.paginate') }}

    @include('livewire.reports.quality-analysis-filter')
</div>
