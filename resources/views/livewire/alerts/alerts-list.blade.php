<div
    class="flex flex-col min-h-[calc(100vh-4rem)] pb-3 pl-6 pr-6 bg-white dark:bg-gray-600 border border-gray-300 dark:border-gray-100 rounded-md shadow-md shadow-black/5">
    <div class="container flex-grow mx-auto">
        <!-- Header -->
        <div class="flex flex-col items-center justify-between my-4 sm:flex-row">
            <div>
                <h3 class="mb-2 text-2xl font-bold text-gray-800 dark:text-gray-200">Central de Alertas</h3>

                <!-- Stats Cards -->
                <div class="flex flex-wrap gap-2 mt-3">
                    <div class="flex items-center gap-2 px-3 py-1 bg-red-100 rounded-lg dark:bg-red-900/30">
                        <svg class="w-4 h-4 text-red-600 dark:text-red-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-sm font-semibold text-red-800 dark:text-red-300">Crítico: {{ $stats['critical'] }}</span>
                    </div>

                    <div class="flex items-center gap-2 px-3 py-1 bg-orange-100 rounded-lg dark:bg-orange-900/30">
                        <svg class="w-4 h-4 text-orange-600 dark:text-orange-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-sm font-semibold text-orange-800 dark:text-orange-300">Alto: {{ $stats['high'] }}</span>
                    </div>

                    <div class="flex items-center gap-2 px-3 py-1 bg-yellow-100 rounded-lg dark:bg-yellow-900/30">
                        <svg class="w-4 h-4 text-yellow-600 dark:text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-sm font-semibold text-yellow-800 dark:text-yellow-300">Médio: {{ $stats['medium'] }}</span>
                    </div>

                    <div class="flex items-center gap-2 px-3 py-1 bg-blue-100 rounded-lg dark:bg-blue-900/30">
                        <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-sm font-semibold text-blue-800 dark:text-blue-300">Baixo: {{ $stats['low'] }}</span>
                    </div>
                </div>
            </div>

            <div class="flex gap-2 mt-4 sm:mt-0">
                <button wire:click="markAllAsRead"
                    class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-white transition-all duration-200 bg-purple-600 rounded-lg shadow-sm hover:bg-purple-700 hover:shadow-md">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Marcar Todos como Lidos
                </button>

                <x-ui-button icon="funnel" wire:click="openFilter" color="purple" position="left">Filtros</x-ui-button>

                <button wire:click="resetFilter"
                    class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-gray-700 transition-all duration-200 bg-white border border-gray-300 rounded-lg shadow-sm hover:bg-gray-50 dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                        </path>
                    </svg>
                    Limpar
                </button>
            </div>
        </div>

        <!-- Alerts Table -->
        <div class="overflow-x-auto bg-white shadow-md dark:bg-gray-800 rounded-lg">
            <x-tables.table>
                <x-slot name="header">
                    <x-tables.th label="Severidade" column="severity" :direction="$direction" :sort="$sort" />
                    <x-tables.th label="Tipo" column="type" :direction="$direction" :sort="$sort" />
                    <x-tables.th label="Título" column="title" :direction="$direction" :sort="$sort" />
                    <x-tables.th label="Cliente/Operadora" />
                    <x-tables.th label="Data" column="created_at" :direction="$direction" :sort="$sort" />
                    <x-tables.th label="Status" />
                    <x-tables.th label="Ações" />
                </x-slot>

                <x-slot name="body">
                    @forelse ($alerts as $alert)
                        <x-tables.tr class="{{ !$alert->isRead() ? 'bg-blue-50 dark:bg-blue-900/10' : '' }}">
                            <!-- Severity Badge -->
                            <x-tables.td class="py-2">
                                @if ($alert->severity === 'critical')
                                    <span
                                        class="inline-flex items-center px-2 py-1 text-xs font-semibold text-red-800 bg-red-100 rounded-full dark:bg-red-900/30 dark:text-red-300">
                                        Crítico
                                    </span>
                                @elseif($alert->severity === 'high')
                                    <span
                                        class="inline-flex items-center px-2 py-1 text-xs font-semibold text-orange-800 bg-orange-100 rounded-full dark:bg-orange-900/30 dark:text-orange-300">
                                        Alto
                                    </span>
                                @elseif($alert->severity === 'medium')
                                    <span
                                        class="inline-flex items-center px-2 py-1 text-xs font-semibold text-yellow-800 bg-yellow-100 rounded-full dark:bg-yellow-900/30 dark:text-yellow-300">
                                        Médio
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center px-2 py-1 text-xs font-semibold text-blue-800 bg-blue-100 rounded-full dark:bg-blue-900/30 dark:text-blue-300">
                                        Baixo
                                    </span>
                                @endif
                            </x-tables.td>

                            <!-- Type -->
                            <x-tables.td class="py-2">
                                <span class="text-sm text-gray-600 dark:text-gray-400">
                                    @switch($alert->type)
                                        @case('franchise_exceeded')
                                            Franquia Excedida
                                        @break

                                        @case('franchise_warning')
                                            Aviso Franquia
                                        @break

                                        @case('tarifacao_error')
                                            Erro Tarifação
                                        @break

                                        @case('peak_channels')
                                            Pico de Canais
                                        @break

                                        @case('fraud_detected')
                                            Fraude Detectada
                                        @break

                                        @case('high_cost')
                                            Custo Elevado
                                        @break

                                        @case('carrier_failure')
                                            Falha Operadora
                                        @break

                                        @default
                                            {{ $alert->type }}
                                    @endswitch
                                </span>
                            </x-tables.td>

                            <!-- Title -->
                            <x-tables.td class="py-2">
                                <span class="font-medium text-gray-900 dark:text-gray-100">
                                    {{ $alert->title }}
                                </span>
                            </x-tables.td>

                            <!-- Related Entity -->
                            <x-tables.td class="py-2">
                                @if ($alert->customer)
                                    <span class="text-sm text-gray-600 dark:text-gray-400">
                                        {{ \Illuminate\Support\Str::limit($alert->customer->razaosocial, 25) }}
                                    </span>
                                @elseif($alert->carrier)
                                    <span class="text-sm text-gray-600 dark:text-gray-400">
                                        {{ $alert->carrier->operadora }}
                                    </span>
                                @else
                                    <span class="text-sm text-gray-400 dark:text-gray-500">-</span>
                                @endif
                            </x-tables.td>

                            <!-- Date -->
                            <x-tables.td class="py-2">
                                <span class="text-sm text-gray-600 dark:text-gray-400">
                                    {{ $alert->created_at->format('d/m/Y H:i') }}
                                </span>
                            </x-tables.td>

                            <!-- Status -->
                            <x-tables.td class="py-2">
                                @if ($alert->isResolved())
                                    <span
                                        class="inline-flex items-center px-2 py-1 text-xs font-medium text-green-800 bg-green-100 rounded-full dark:bg-green-900/30 dark:text-green-300">
                                        Resolvido
                                    </span>
                                @elseif($alert->isRead())
                                    <span
                                        class="inline-flex items-center px-2 py-1 text-xs font-medium text-gray-800 bg-gray-100 rounded-full dark:bg-gray-700 dark:text-gray-300">
                                        Lido
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center px-2 py-1 text-xs font-medium text-blue-800 bg-blue-100 rounded-full dark:bg-blue-900/30 dark:text-blue-300">
                                        Novo
                                    </span>
                                @endif
                            </x-tables.td>

                            <!-- Actions -->
                            <x-tables.td class="py-2">
                                <button wire:click="openDetails({{ $alert->id }})"
                                    class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                        </path>
                                    </svg>
                                </button>
                            </x-tables.td>
                        </x-tables.tr>
                    @empty
                        <x-empty-state
                            colspan="7"
                            icon="bell-alert"
                            message="Nenhum alerta encontrado"
                            hint="Os alertas serão exibidos aqui quando eventos importantes ocorrerem"
                        />
                    @endforelse
                </x-slot>
            </x-tables.table>
        </div>
    </div>

    {{ $alerts->links('vendor.livewire.paginate') }}

    @include('livewire.alerts.filter')
    @include('livewire.alerts.details')
</div>
