<div
    class="flex flex-col min-h-[calc(100vh-4rem)] pb-3 pl-6 pr-6 bg-white dark:bg-gray-600 border border-gray-300 dark:border-gray-100 rounded-md shadow-md shadow-black/5">
    <div class="container flex-grow mx-auto">
        <!-- Header -->
        <div class="flex flex-col items-center justify-between my-4 sm:flex-row">
            <div>
                <h3 class="mb-2 text-2xl font-bold text-gray-800 dark:text-gray-200">Detecção de Fraude</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    Período: {{ \Carbon\Carbon::parse($dateStart)->format('d/m/Y') }} a
                    {{ \Carbon\Carbon::parse($dateEnd)->format('d/m/Y') }}
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
        <div class="grid grid-cols-1 gap-4 mb-6 md:grid-cols-2 lg:grid-cols-5">
            <!-- Alto Risco -->
            <div class="p-4 bg-gradient-to-br from-red-500 to-red-600 rounded-lg shadow-md">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-red-100">Alto Risco</p>
                        <p class="mt-1 text-2xl font-bold text-white">
                            {{ $stats->high_risk }}
                        </p>
                        <p class="text-xs text-red-100">≥ 70 pontos</p>
                    </div>
                    <div class="p-3 bg-white/20 rounded-full">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Médio Risco -->
            <div class="p-4 bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-lg shadow-md">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-yellow-100">Médio Risco</p>
                        <p class="mt-1 text-2xl font-bold text-white">
                            {{ $stats->medium_risk }}
                        </p>
                        <p class="text-xs text-yellow-100">40-69 pontos</p>
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

            <!-- Baixo Risco -->
            <div class="p-4 bg-gradient-to-br from-green-500 to-green-600 rounded-lg shadow-md">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-green-100">Baixo Risco</p>
                        <p class="mt-1 text-2xl font-bold text-white">
                            {{ $stats->low_risk }}
                        </p>
                        <p class="text-xs text-green-100">< 40 pontos</p>
                    </div>
                    <div class="p-3 bg-white/20 rounded-full">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Números Premium -->
            <div class="p-4 bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg shadow-md">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-purple-100">Números Premium</p>
                        <p class="mt-1 text-2xl font-bold text-white">
                            {{ number_format($stats->total_premium, 0, ',', '.') }}
                        </p>
                        <p class="text-xs text-purple-100">0900/0300</p>
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

            <!-- Internacionais -->
            <div class="p-4 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg shadow-md">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-blue-100">Internacionais</p>
                        <p class="mt-1 text-2xl font-bold text-white">
                            {{ number_format($stats->total_international, 0, ',', '.') }}
                        </p>
                        <p class="text-xs text-blue-100">Código 00</p>
                    </div>
                    <div class="p-3 bg-white/20 rounded-full">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
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
                            class="px-4 py-3 text-xs font-medium tracking-wider text-center text-gray-500 uppercase dark:text-gray-400">
                            Score de Risco
                        </th>
                        <th
                            class="px-4 py-3 text-xs font-medium tracking-wider text-center text-gray-500 uppercase dark:text-gray-400">
                            Total Chamadas
                        </th>
                        <th
                            class="px-4 py-3 text-xs font-medium tracking-wider text-center text-gray-500 uppercase dark:text-gray-400">
                            Premium
                        </th>
                        <th
                            class="px-4 py-3 text-xs font-medium tracking-wider text-center text-gray-500 uppercase dark:text-gray-400">
                            Internacional
                        </th>
                        <th
                            class="px-4 py-3 text-xs font-medium tracking-wider text-center text-gray-500 uppercase dark:text-gray-400">
                            Curtas
                        </th>
                        <th
                            class="px-4 py-3 text-xs font-medium tracking-wider text-center text-gray-500 uppercase dark:text-gray-400">
                            Ações
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-900 dark:divide-gray-700">
                    @forelse ($fraudAnalysis as $item)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800">
                            <td class="px-4 py-3 text-sm font-medium text-gray-900 dark:text-gray-100">
                                {{ \Illuminate\Support\Str::limit($item->razaosocial, 30) }}
                            </td>

                            <td class="px-4 py-3 text-sm text-center">
                                @php
                                    $riskScore = round($item->risk_score);
                                    if ($riskScore >= 70) {
                                        $bgColor = 'bg-red-100 dark:bg-red-900/30';
                                        $textColor = 'text-red-800 dark:text-red-400';
                                        $label = 'Alto';
                                    } elseif ($riskScore >= 40) {
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
                                    {{ $riskScore }} - {{ $label }}
                                </span>
                            </td>

                            <td class="px-4 py-3 text-sm text-center text-gray-900 dark:text-gray-100">
                                {{ number_format($item->total_chamadas, 0, ',', '.') }}
                            </td>

                            <td class="px-4 py-3 text-sm text-center">
                                @if ($item->premium_calls > 0)
                                    <span class="font-bold text-purple-600 dark:text-purple-400">
                                        {{ number_format($item->premium_calls, 0, ',', '.') }}
                                    </span>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>

                            <td class="px-4 py-3 text-sm text-center">
                                @if ($item->international_calls > 0)
                                    <span class="font-bold text-blue-600 dark:text-blue-400">
                                        {{ number_format($item->international_calls, 0, ',', '.') }}
                                    </span>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>

                            <td class="px-4 py-3 text-sm text-center">
                                @if ($item->short_calls > 0)
                                    <span class="font-bold text-orange-600 dark:text-orange-400">
                                        {{ number_format($item->short_calls, 0, ',', '.') }}
                                    </span>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>

                            <td class="px-4 py-3 text-sm text-center">
                                <button wire:click="openDetails({{ $item->id }})"
                                    class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M10 21h7a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v11m0 5l4.879-4.879m0 0a3 3 0 104.243-4.242 3 3 0 00-4.243 4.242z">
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

        <!-- Pagination -->
        <div class="mt-4">
            {{ $fraudAnalysis->links('vendor.livewire.paginate') }}
        </div>

        <!-- Legend -->
        <div class="p-4 mt-4 bg-gray-50 rounded-lg dark:bg-gray-800">
            <p class="mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Como funciona o Score de Risco:</p>
            <p class="text-xs text-gray-600 dark:text-gray-400 mb-2">
                O score é calculado com base em padrões suspeitos: Números Premium (50%), Chamadas Internacionais
                (30%), Chamadas Curtas (20%).
            </p>
            <div class="flex flex-wrap gap-4 mt-2 text-sm">
                <div class="flex items-center gap-2">
                    <span class="inline-block w-3 h-3 bg-green-500 rounded-full"></span>
                    <span class="text-gray-600 dark:text-gray-400">Baixo Risco (< 40)</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="inline-block w-3 h-3 bg-yellow-500 rounded-full"></span>
                    <span class="text-gray-600 dark:text-gray-400">Médio Risco (40-69)</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="inline-block w-3 h-3 bg-red-500 rounded-full"></span>
                    <span class="text-gray-600 dark:text-gray-400">Alto Risco (≥ 70)</span>
                </div>
            </div>
        </div>
    </div>

    @include('livewire.reports.fraud-detection-filter')
    @include('livewire.reports.fraud-detection-details')
</div>
