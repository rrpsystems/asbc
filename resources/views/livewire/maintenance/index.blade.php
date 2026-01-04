<div
    class="flex flex-col min-h-[calc(100vh-4rem)] pb-3 pl-6 pr-6 bg-white dark:bg-gray-600 border border-gray-300 dark:border-gray-100 rounded-md shadow-md shadow-black/5">
    <div class="container flex-grow mx-auto">
        <!-- Header -->
        <div class="flex flex-col items-center justify-between my-4 sm:flex-row">
            <h3 class="mb-4 text-2xl font-bold text-gray-800 dark:text-gray-200 sm:mb-0">Manutenção do Sistema</h3>
            <div class="flex gap-2">
                <button wire:click="loadStats"
                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-white transition-all duration-200 bg-purple-600 rounded-lg shadow-sm hover:bg-purple-700">
                    <x-ui-icon name="arrow-path" class="w-4 h-4 mr-2" />
                    Atualizar
                </button>
            </div>
        </div>

        <!-- Summary Cards - Estatísticas Gerais -->
        <div class="mb-6">
            <h4 class="mb-3 text-lg font-semibold text-gray-700 dark:text-gray-300">📊 Estatísticas de CDRs</h4>
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-4">
                <!-- Total CDRs -->
                <div class="relative overflow-hidden bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg shadow-lg">
                    <div class="p-5">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-blue-100">Total de CDRs</p>
                                <p class="text-3xl font-bold text-white">{{ number_format($stats['total_cdrs'] ?? 0, 0, ',', '.') }}</p>
                            </div>
                            <div class="p-3 bg-white bg-opacity-30 rounded-lg">
                                <x-ui-icon name="phone" class="w-8 h-8 text-white" />
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tarifados -->
                <div class="relative overflow-hidden bg-gradient-to-br from-green-500 to-green-600 rounded-lg shadow-lg">
                    <div class="p-5">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-green-100">Tarifados</p>
                                <p class="text-3xl font-bold text-white">{{ number_format($stats['tarifados'] ?? 0, 0, ',', '.') }}</p>
                            </div>
                            <div class="p-3 bg-white bg-opacity-30 rounded-lg">
                                <x-ui-icon name="check-circle" class="w-8 h-8 text-white" />
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pendentes -->
                <a href="{{ route('report.cdr', ['stat' => ['Pendente']]) }}"
                   class="relative block overflow-hidden transition-transform duration-200 bg-gradient-to-br from-orange-500 to-orange-600 rounded-lg shadow-lg hover:scale-105 hover:shadow-xl">
                    <div class="p-5">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-orange-100">Pendentes</p>
                                <p class="text-3xl font-bold text-white">{{ number_format($stats['pendentes'] ?? 0, 0, ',', '.') }}</p>
                                <p class="mt-1 text-xs text-orange-100 opacity-75">👁️ Clique para ver detalhes</p>
                            </div>
                            <div class="p-3 bg-white bg-opacity-30 rounded-lg">
                                <x-ui-icon name="clock" class="w-8 h-8 text-white" />
                            </div>
                        </div>
                    </div>
                </a>

                <!-- Com Erro -->
                <a href="{{ route('report.cdr', ['stat' => ['Erro_Tarifa', 'Tarifa_Nao_Encontrada', 'Dados_Invalidos', 'Erro_Permanente']]) }}"
                   class="relative block overflow-hidden transition-transform duration-200 bg-gradient-to-br from-red-500 to-red-600 rounded-lg shadow-lg hover:scale-105 hover:shadow-xl">
                    <div class="p-5">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-red-100">Com Erro</p>
                                <p class="text-3xl font-bold text-white">
                                    {{ number_format(($stats['erro_tarifa'] ?? 0) + ($stats['tarifa_nao_encontrada'] ?? 0) + ($stats['dados_invalidos'] ?? 0) + ($stats['erro_permanente'] ?? 0), 0, ',', '.') }}
                                </p>
                                <p class="mt-1 text-xs text-red-100 opacity-75">👁️ Clique para ver detalhes</p>
                            </div>
                            <div class="p-3 bg-white bg-opacity-30 rounded-lg">
                                <x-ui-icon name="exclamation-circle" class="w-8 h-8 text-white" />
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <!-- Cards de Detalhes de Erro -->
        <div class="grid grid-cols-1 gap-4 mb-6 md:grid-cols-2 lg:grid-cols-4">
            <a href="{{ route('report.cdr', ['stat' => ['Erro_Tarifa']]) }}"
               class="block p-4 transition-all duration-200 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-700 dark:border-gray-600 hover:shadow-md hover:border-red-300 dark:hover:border-red-600 hover:scale-105">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400">Erro Tarifa</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($stats['erro_tarifa'] ?? 0, 0, ',', '.') }}</p>
                        <p class="mt-1 text-xs text-gray-400 dark:text-gray-500">👁️ Ver CDRs</p>
                    </div>
                    <x-ui-icon name="x-circle" class="w-6 h-6 text-red-500" />
                </div>
            </a>

            <a href="{{ route('report.cdr', ['stat' => ['Tarifa_Nao_Encontrada']]) }}"
               class="block p-4 transition-all duration-200 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-700 dark:border-gray-600 hover:shadow-md hover:border-yellow-300 dark:hover:border-yellow-600 hover:scale-105">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400">Tarifa Não Encontrada</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($stats['tarifa_nao_encontrada'] ?? 0, 0, ',', '.') }}</p>
                        <p class="mt-1 text-xs text-gray-400 dark:text-gray-500">👁️ Ver CDRs</p>
                    </div>
                    <x-ui-icon name="question-mark-circle" class="w-6 h-6 text-yellow-500" />
                </div>
            </a>

            <a href="{{ route('report.cdr', ['stat' => ['Dados_Invalidos']]) }}"
               class="block p-4 transition-all duration-200 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-700 dark:border-gray-600 hover:shadow-md hover:border-orange-300 dark:hover:border-orange-600 hover:scale-105">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400">Dados Inválidos</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($stats['dados_invalidos'] ?? 0, 0, ',', '.') }}</p>
                        <p class="mt-1 text-xs text-gray-400 dark:text-gray-500">👁️ Ver CDRs</p>
                    </div>
                    <x-ui-icon name="exclamation-triangle" class="w-6 h-6 text-orange-500" />
                </div>
            </a>

            <a href="{{ route('report.cdr', ['stat' => ['Erro_Permanente']]) }}"
               class="block p-4 transition-all duration-200 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-700 dark:border-gray-600 hover:shadow-md hover:border-red-300 dark:hover:border-red-700 hover:scale-105">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400">Erro Permanente</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($stats['erro_permanente'] ?? 0, 0, ',', '.') }}</p>
                        <p class="mt-1 text-xs text-gray-400 dark:text-gray-500">👁️ Ver CDRs</p>
                    </div>
                    <x-ui-icon name="no-symbol" class="w-6 h-6 text-red-700" />
                </div>
            </a>
        </div>

        <!-- Informações do Sistema -->
        <div class="grid grid-cols-1 gap-4 mb-6 md:grid-cols-3">
            <!-- Último Tarifado -->
            <div class="p-4 bg-white border-l-4 border-green-500 rounded-lg shadow-md dark:bg-gray-700">
                <h5 class="mb-2 text-sm font-semibold text-gray-700 dark:text-gray-300">✅ Último CDR Tarifado</h5>
                @if($stats['ultimo_tarifado'])
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        <strong>ID:</strong> #{{ $stats['ultimo_tarifado']->id }}<br>
                        <strong>Número:</strong> {{ $stats['ultimo_tarifado']->numero }}<br>
                        <strong>Valor:</strong> R$ {{ number_format($stats['ultimo_tarifado']->valor_venda ?? 0, 2, ',', '.') }}<br>
                        <strong>Data:</strong> {{ $stats['ultimo_tarifado']->updated_at?->format('d/m/Y H:i:s') }}
                    </p>
                @else
                    <p class="text-sm text-gray-500">Nenhum CDR tarifado</p>
                @endif
            </div>

            <!-- Último CDR -->
            <div class="p-4 bg-white border-l-4 border-blue-500 rounded-lg shadow-md dark:bg-gray-700">
                <h5 class="mb-2 text-sm font-semibold text-gray-700 dark:text-gray-300">📞 Último CDR no Banco</h5>
                @if($stats['ultimo_cdr'])
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        <strong>ID:</strong> #{{ $stats['ultimo_cdr']->id }}<br>
                        <strong>Número:</strong> {{ $stats['ultimo_cdr']->numero }}<br>
                        <strong>Status:</strong> <span class="px-2 py-1 text-xs rounded {{ $stats['ultimo_cdr']->status === 'Tarifada' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">{{ $stats['ultimo_cdr']->status }}</span><br>
                        <strong>Data:</strong> {{ \Carbon\Carbon::parse($stats['ultimo_cdr']->calldate)?->format('d/m/Y H:i:s') }}
                    </p>
                @else
                    <p class="text-sm text-gray-500">Nenhum CDR no banco</p>
                @endif
            </div>

            <!-- Info da Fila -->
            <div class="p-4 bg-white border-l-4 border-purple-500 rounded-lg shadow-md dark:bg-gray-700">
                <h5 class="mb-2 text-sm font-semibold text-gray-700 dark:text-gray-300">⚙️ Fila de Processamento</h5>
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    <strong>Jobs Pendentes:</strong> {{ $queueStats['jobs_pendentes'] }}<br>
                    <strong>Jobs Falhados:</strong> {{ $queueStats['jobs_falhados'] }}<br>
                    <strong>Cache Driver:</strong> {{ $cacheStats['driver'] ?? 'N/A' }}<br>
                    <strong>Total Rates:</strong> {{ number_format($stats['total_rates'] ?? 0, 0, ',', '.') }}
                </p>
            </div>
        </div>

        <!-- Ações de Tarifação -->
        <div class="p-6 mb-6 bg-white rounded-lg shadow-md dark:bg-gray-800">
            <h4 class="mb-4 text-lg font-semibold text-gray-700 dark:text-gray-300">🔧 Ações de Tarifação</h4>
            <div class="grid grid-cols-1 gap-3 md:grid-cols-3 lg:grid-cols-5">
                <!-- Tarifar Agora -->
                <button wire:click="tarifar" wire:loading.attr="disabled"
                    class="flex flex-col items-center justify-center p-4 transition-all duration-200 border-2 border-purple-300 rounded-lg hover:bg-purple-50 dark:border-purple-700 dark:hover:bg-purple-900/20">
                    <x-ui-icon name="play" class="w-8 h-8 mb-2 text-purple-600 dark:text-purple-400" />
                    <span class="text-sm font-semibold text-gray-800 dark:text-gray-200">Tarifar Agora</span>
                    <span class="text-xs text-gray-500 dark:text-gray-400">Processa até 1000 CDRs pendentes</span>
                    <span wire:loading wire:target="tarifar" class="mt-1 text-xs text-purple-600">Processando...</span>
                </button>

                <!-- Reprocessar -->
                <button wire:click="openReprocessModal" wire:loading.attr="disabled"
                    class="flex flex-col items-center justify-center p-4 transition-all duration-200 border-2 border-blue-300 rounded-lg hover:bg-blue-50 dark:border-blue-700 dark:hover:bg-blue-900/20">
                    <x-ui-icon name="arrow-path" class="w-8 h-8 mb-2 text-blue-600 dark:text-blue-400" />
                    <span class="text-sm font-semibold text-gray-800 dark:text-gray-200">Reprocessar</span>
                    <span class="text-xs text-gray-500 dark:text-gray-400">Com filtros e opções</span>
                </button>

                <!-- Limpar Cache -->
                <button wire:click="limparCacheRates" wire:loading.attr="disabled"
                    wire:confirm="Tem certeza? Isso vai limpar todo o cache de rates."
                    class="flex flex-col items-center justify-center p-4 transition-all duration-200 border-2 border-orange-300 rounded-lg hover:bg-orange-50 dark:border-orange-700 dark:hover:bg-orange-900/20">
                    <x-ui-icon name="trash" class="w-8 h-8 mb-2 text-orange-600 dark:text-orange-400" />
                    <span class="text-sm font-semibold text-gray-800 dark:text-gray-200">Limpar Cache</span>
                    <span class="text-xs text-gray-500 dark:text-gray-400">Remove cache de rates</span>
                    <span wire:loading wire:target="limparCacheRates" class="mt-1 text-xs text-orange-600">Limpando...</span>
                </button>

                <!-- Retry Jobs Falhados -->
                @if($queueStats['jobs_falhados'] > 0)
                <button wire:click="retryJobsFalhados" wire:loading.attr="disabled"
                    wire:confirm="Reprocessar todos os {{ $queueStats['jobs_falhados'] }} jobs falhados?"
                    class="flex flex-col items-center justify-center p-4 transition-all duration-200 border-2 border-yellow-300 rounded-lg hover:bg-yellow-50 dark:border-yellow-700 dark:hover:bg-yellow-900/20">
                    <x-ui-icon name="arrow-path-rounded-square" class="w-8 h-8 mb-2 text-yellow-600 dark:text-yellow-400" />
                    <span class="text-sm font-semibold text-gray-800 dark:text-gray-200">Retry Falhados</span>
                    <span class="text-xs text-gray-500 dark:text-gray-400">{{ $queueStats['jobs_falhados'] }} jobs</span>
                    <span wire:loading wire:target="retryJobsFalhados" class="mt-1 text-xs text-yellow-600">Reenfileirando...</span>
                </button>

                <!-- Limpar Jobs Falhados -->
                <button wire:click="limparJobsFalhados" wire:loading.attr="disabled"
                    wire:confirm="Tem certeza? Isso vai remover TODOS os jobs falhados permanentemente."
                    class="flex flex-col items-center justify-center p-4 transition-all duration-200 border-2 border-red-300 rounded-lg hover:bg-red-50 dark:border-red-700 dark:hover:bg-red-900/20">
                    <x-ui-icon name="x-circle" class="w-8 h-8 mb-2 text-red-600 dark:text-red-400" />
                    <span class="text-sm font-semibold text-gray-800 dark:text-gray-200">Limpar Falhados</span>
                    <span class="text-xs text-gray-500 dark:text-gray-400">Remove jobs falhados</span>
                    <span wire:loading wire:target="limparJobsFalhados" class="mt-1 text-xs text-red-600">Removendo...</span>
                </button>
                @endif
            </div>
        </div>

        <!-- Resumos Mensais e Batches -->
        <div class="p-6 mb-6 bg-white rounded-lg shadow-md dark:bg-gray-800">
            <h4 class="mb-4 text-lg font-semibold text-gray-700 dark:text-gray-300">💰 Resumos Mensais de Receita</h4>

            <!-- Stats de Revenue -->
            <div class="grid grid-cols-1 gap-4 mb-4 md:grid-cols-3">
                <div class="p-4 bg-gradient-to-br from-teal-500 to-teal-600 rounded-lg shadow">
                    <p class="text-sm font-medium text-teal-100">Total de Resumos</p>
                    <p class="text-3xl font-bold text-white">{{ number_format($revenueStats['total_resumos'] ?? 0, 0, ',', '.') }}</p>
                </div>

                <div class="p-4 bg-gradient-to-br from-cyan-500 to-cyan-600 rounded-lg shadow">
                    <p class="text-sm font-medium text-cyan-100">Resumos Mês Atual</p>
                    <p class="text-3xl font-bold text-white">{{ number_format($revenueStats['mes_atual'] ?? 0, 0, ',', '.') }}</p>
                </div>

                <div class="p-4 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-lg shadow">
                    <p class="text-sm font-medium text-indigo-100">Batches Pendentes</p>
                    <p class="text-3xl font-bold text-white">{{ number_format($batchStats['total_batches'] ?? 0, 0, ',', '.') }}</p>
                    @if(($batchStats['total_cdrs'] ?? 0) > 0)
                        <p class="text-xs text-indigo-100 mt-1">{{ number_format($batchStats['total_cdrs'], 0, ',', '.') }} CDRs aguardando</p>
                    @endif
                </div>
            </div>

            <!-- Último Resumo Atualizado -->
            @if($revenueStats['ultimo_resumo'] ?? null)
            <div class="p-4 mb-4 bg-white border-l-4 border-teal-500 rounded-lg shadow-md dark:bg-gray-700">
                <h5 class="mb-2 text-sm font-semibold text-gray-700 dark:text-gray-300">📊 Último Resumo Atualizado</h5>
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    <strong>Cliente:</strong> {{ $revenueStats['ultimo_resumo']->customer->nomefantasia ?? 'N/A' }}<br>
                    <strong>Período:</strong> {{ $revenueStats['ultimo_resumo']->mes }}/{{ $revenueStats['ultimo_resumo']->ano }}<br>
                    <strong>Custo Total:</strong> R$ {{ number_format($revenueStats['ultimo_resumo']->custo_total ?? 0, 2, ',', '.') }}<br>
                    <strong>Última Atualização:</strong> {{ $revenueStats['ultimo_resumo']->updated_at?->format('d/m/Y H:i:s') }}
                </p>
            </div>
            @endif

            <!-- Detalhes dos Batches Pendentes -->
            @if(!empty($batchStats['batches']))
            <div class="p-4 mb-4 border border-indigo-200 rounded-lg bg-indigo-50 dark:bg-indigo-900/20 dark:border-indigo-700">
                <h5 class="mb-3 text-sm font-semibold text-indigo-800 dark:text-indigo-300">⏳ Batches Aguardando Processamento</h5>
                <div class="overflow-x-auto">
                    <table class="min-w-full text-xs">
                        <thead>
                            <tr class="text-left border-b border-indigo-200 dark:border-indigo-700">
                                <th class="pb-2 font-medium text-indigo-700 dark:text-indigo-400">Cliente ID</th>
                                <th class="pb-2 font-medium text-indigo-700 dark:text-indigo-400">Mês/Ano</th>
                                <th class="pb-2 font-medium text-indigo-700 dark:text-indigo-400 text-right">CDRs no Batch</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($batchStats['batches'] as $batch)
                            <tr class="border-b border-indigo-100 dark:border-indigo-800">
                                <td class="py-2 text-indigo-900 dark:text-indigo-100">#{{ $batch['customer_id'] }}</td>
                                <td class="py-2 text-indigo-900 dark:text-indigo-100">{{ $batch['mes'] }}/{{ $batch['ano'] }}</td>
                                <td class="py-2 text-right text-indigo-900 dark:text-indigo-100">{{ $batch['cdrs_count'] }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif

            <!-- Ação de Flush de Batches -->
            <div class="flex flex-col items-start gap-2 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Processar Batches Pendentes</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Processa todos os batches acumulados de resumo mensal</p>
                </div>
                <button wire:click="flushBatches" wire:loading.attr="disabled"
                    @if(($batchStats['total_batches'] ?? 0) > 0) wire:confirm="Processar {{ $batchStats['total_batches'] }} batch(es) pendente(s)?" @endif
                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-white transition-all duration-200 rounded-lg shadow-sm
                    {{ ($batchStats['total_batches'] ?? 0) > 0 ? 'bg-indigo-600 hover:bg-indigo-700' : 'bg-gray-400 cursor-not-allowed' }}"
                    {{ ($batchStats['total_batches'] ?? 0) === 0 ? 'disabled' : '' }}>
                    <x-ui-icon name="play" class="w-4 h-4 mr-2" />
                    <span wire:loading.remove wire:target="flushBatches">
                        Processar Batches {{ ($batchStats['total_batches'] ?? 0) > 0 ? '(' . $batchStats['total_batches'] . ')' : '' }}
                    </span>
                    <span wire:loading wire:target="flushBatches">Processando...</span>
                </button>
            </div>
        </div>

        <!-- Reprocessamento de Receitas Mensais -->
        <div class="p-6 mb-6 bg-white rounded-lg shadow-md dark:bg-gray-800">
            <h4 class="mb-4 text-lg font-semibold text-gray-700 dark:text-gray-300">🔄 Reprocessamento de Receitas</h4>

            <!-- Info Box -->
            <div class="p-4 mb-4 border-l-4 border-purple-500 rounded-lg bg-purple-50 dark:bg-purple-900/20">
                <h5 class="mb-2 text-sm font-semibold text-purple-800 dark:text-purple-300">ℹ️  Quando Reprocessar?</h5>
                <ul class="text-sm text-purple-700 dark:text-purple-400 list-disc list-inside space-y-1">
                    <li>Após ajustar tarifas de clientes ou operadoras</li>
                    <li>Após corrigir dados inconsistentes em CDRs</li>
                    <li>Quando houver divergências nos resumos mensais</li>
                    <li>Para recalcular franquias e excedentes</li>
                </ul>
                <p class="mt-2 text-xs text-purple-600 dark:text-purple-500">
                    <strong>⚡ Otimizado:</strong> Usa batch processing (100 CDRs por job), atomic updates e distributed locks para máxima performance e confiabilidade.
                </p>
            </div>

            <!-- Ações -->
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <!-- Reprocessar Receitas (Batch Mode) -->
                <div class="flex flex-col items-start gap-2 p-4 border border-purple-200 rounded-lg bg-purple-50/50 dark:bg-purple-900/10 dark:border-purple-700">
                    <div>
                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Reprocessar Resumos Mensais</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            Recalcula resumos de receita usando batch processing otimizado
                        </p>
                    </div>
                    <button wire:click="openRevenueReprocessModal" wire:loading.attr="disabled"
                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-white transition-all duration-200 bg-purple-600 rounded-lg shadow-sm hover:bg-purple-700">
                        <x-ui-icon name="arrow-path" class="w-4 h-4 mr-2" />
                        <span wire:loading.remove wire:target="openRevenueReprocessModal">Reprocessar Receitas</span>
                        <span wire:loading wire:target="openRevenueReprocessModal">Carregando...</span>
                    </button>
                </div>

                <!-- Atualizar Receita de Produtos -->
                <div class="flex flex-col items-start gap-2 p-4 border border-indigo-200 rounded-lg bg-indigo-50/50 dark:bg-indigo-900/10 dark:border-indigo-700">
                    <div>
                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Atualizar Receita de Produtos</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            Atualiza receita de produtos recorrentes para o mês atual
                        </p>
                    </div>
                    <button wire:click="atualizarReceitaProdutos" wire:loading.attr="disabled"
                        wire:confirm="Atualizar receita de produtos para {{ now()->month }}/{{ now()->year }}?"
                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-white transition-all duration-200 bg-indigo-600 rounded-lg shadow-sm hover:bg-indigo-700">
                        <x-ui-icon name="shopping-cart" class="w-4 h-4 mr-2" />
                        <span wire:loading.remove wire:target="atualizarReceitaProdutos">Atualizar Produtos</span>
                        <span wire:loading wire:target="atualizarReceitaProdutos">Atualizando...</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Fechamento e Reabertura de Faturas -->
        <div class="p-6 mb-6 bg-white rounded-lg shadow-md dark:bg-gray-800">
            <h4 class="mb-4 text-lg font-semibold text-gray-700 dark:text-gray-300">🔒 Fechamento de Faturamento</h4>

            <!-- Info Box -->
            <div class="p-4 mb-4 border-l-4 border-red-500 rounded-lg bg-red-50 dark:bg-red-900/20">
                <h5 class="mb-2 text-sm font-semibold text-red-800 dark:text-red-300">⚠️ Operação Crítica</h5>
                <ul class="text-sm text-red-700 dark:text-red-400 list-disc list-inside space-y-1">
                    <li><strong>Fechar Faturamento:</strong> Marca faturas como "fechadas" para evitar alterações</li>
                    <li><strong>Reabrir Faturamento:</strong> Permite correções em faturas já fechadas</li>
                    <li>Ambas operações são auditadas com user ID e timestamp</li>
                    <li>Reabertura requer motivo obrigatório</li>
                </ul>
                <p class="mt-2 text-xs text-red-600 dark:text-red-500">
                    <strong>💡 Fluxo normal:</strong> Dia 3 de cada mês → Fechar faturamento do mês anterior
                </p>
            </div>

            <!-- Ações -->
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <!-- Fechar Faturamento -->
                <div class="flex flex-col items-start gap-2 p-4 border border-green-200 rounded-lg bg-green-50/50 dark:bg-green-900/10 dark:border-green-700">
                    <div>
                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Fechar Faturamento</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            Fecha faturas de clientes e relatórios de operadoras (mês anterior por padrão)
                        </p>
                    </div>
                    <button wire:click="openFecharFaturasModal" wire:loading.attr="disabled"
                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-white transition-all duration-200 bg-green-600 rounded-lg shadow-sm hover:bg-green-700">
                        <x-ui-icon name="lock-closed" class="w-4 h-4 mr-2" />
                        <span wire:loading.remove wire:target="openFecharFaturasModal">Fechar Faturamento</span>
                        <span wire:loading wire:target="openFecharFaturasModal">Carregando...</span>
                    </button>
                </div>

                <!-- Reabrir Faturamento -->
                <div class="flex flex-col items-start gap-2 p-4 border border-red-200 rounded-lg bg-red-50/50 dark:bg-red-900/10 dark:border-red-700">
                    <div>
                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Reabrir Faturamento</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            Reabre faturas fechadas para permitir correções (requer motivo)
                        </p>
                    </div>
                    <button wire:click="openReabrirFaturasModal" wire:loading.attr="disabled"
                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-white transition-all duration-200 bg-red-600 rounded-lg shadow-sm hover:bg-red-700">
                        <x-ui-icon name="lock-open" class="w-4 h-4 mr-2" />
                        <span wire:loading.remove wire:target="openReabrirFaturasModal">Reabrir Faturamento</span>
                        <span wire:loading wire:target="openReabrirFaturasModal">Carregando...</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Relatórios de Operadora -->
        <div class="p-6 mb-6 bg-white rounded-lg shadow-md dark:bg-gray-800">
            <h4 class="mb-4 text-lg font-semibold text-gray-700 dark:text-gray-300">📡 Relatórios de Operadora</h4>

            <!-- Stats de Operadora -->
            <div class="grid grid-cols-1 gap-4 mb-4 md:grid-cols-3">
                <div class="p-4 bg-gradient-to-br from-orange-500 to-orange-600 rounded-lg shadow">
                    <p class="text-sm font-medium text-orange-100">Total de Relatórios</p>
                    <p class="text-3xl font-bold text-white">{{ number_format($carrierStats['total_relatorios'] ?? 0, 0, ',', '.') }}</p>
                </div>

                <div class="p-4 bg-gradient-to-br from-amber-500 to-amber-600 rounded-lg shadow">
                    <p class="text-sm font-medium text-amber-100">Relatórios Mês Atual</p>
                    <p class="text-3xl font-bold text-white">{{ number_format($carrierStats['mes_atual'] ?? 0, 0, ',', '.') }}</p>
                </div>

                <div class="p-4 bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-lg shadow">
                    <p class="text-sm font-medium text-yellow-100">Último Processamento</p>
                    <p class="text-2xl font-bold text-white">{{ $carrierStats['ultimo_mes'] ?? 'N/A' }}</p>
                    @if($carrierStats['ultimo_relatorio'] ?? null)
                        <p class="text-xs text-yellow-100 mt-1">{{ $carrierStats['ultimo_relatorio']->updated_at?->format('d/m/Y H:i') }}</p>
                    @endif
                </div>
            </div>

            <!-- Info Box -->
            <div class="p-4 mb-4 bg-white border-l-4 border-orange-500 rounded-lg shadow-md dark:bg-gray-700">
                <h5 class="mb-2 text-sm font-semibold text-gray-700 dark:text-gray-300">ℹ️ Sobre os Relatórios</h5>
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    Os relatórios de operadora consolidam os custos de chamadas por carrier e tipo de serviço (Fixo, Móvel, Internacional).
                    <br>São usados para marcar meses como "fechados" após faturamento.
                    <br><br>
                    <strong>Processamento automático:</strong> Dia 1 de cada mês às 6h (processa mês anterior)
                </p>
            </div>

            <!-- Ações -->
            <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                <!-- Gerar Relatórios Mês Atual -->
                <div class="flex flex-col p-4 border border-gray-200 rounded-lg dark:border-gray-700">
                    <div class="mb-3">
                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Gerar Relatórios - Mês Atual</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            Processa relatórios de {{ now()->format('m/Y') }}
                        </p>
                    </div>
                    <button wire:click="gerarRelatoriosOperadora" wire:loading.attr="disabled"
                        wire:confirm="Gerar relatórios de operadora para {{ now()->format('m/Y') }}?"
                        class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white transition-all duration-200 bg-orange-600 rounded-lg shadow-sm hover:bg-orange-700">
                        <x-ui-icon name="document-text" class="w-4 h-4 mr-2" />
                        <span wire:loading.remove wire:target="gerarRelatoriosOperadora">
                            Gerar Relatórios
                        </span>
                        <span wire:loading wire:target="gerarRelatoriosOperadora">Gerando...</span>
                    </button>
                </div>

                <!-- Gerar Relatórios Customizado -->
                <div class="flex flex-col p-4 border-2 border-orange-300 rounded-lg bg-orange-50 dark:bg-orange-900/10 dark:border-orange-700">
                    <div class="mb-3">
                        <p class="text-sm font-medium text-orange-700 dark:text-orange-300">✨ Gerar Relatórios - Customizado</p>
                        <p class="text-xs text-orange-600 dark:text-orange-400">
                            Escolha mês/ano e operadora específica
                        </p>
                    </div>
                    <button wire:click="openGerarRelatorioOperadoraModal"
                        class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white transition-all duration-200 bg-orange-500 rounded-lg shadow-sm hover:bg-orange-600">
                        <x-ui-icon name="calendar" class="w-4 h-4 mr-2" />
                        Escolher Período
                    </button>
                </div>

                <!-- Processar Mês Anterior -->
                <div class="flex flex-col p-4 border border-gray-200 rounded-lg dark:border-gray-700">
                    <div class="mb-3">
                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Processar Mês Anterior</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            Processa relatórios de {{ now()->subMonth()->format('m/Y') }} (automático)
                        </p>
                    </div>
                    <button wire:click="processarRelatoriosMesAnterior" wire:loading.attr="disabled"
                        wire:confirm="Processar relatórios de {{ now()->subMonth()->format('m/Y') }}?"
                        class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white transition-all duration-200 bg-amber-600 rounded-lg shadow-sm hover:bg-amber-700">
                        <x-ui-icon name="clock" class="w-4 h-4 mr-2" />
                        <span wire:loading.remove wire:target="processarRelatoriosMesAnterior">
                            Processar Mês Anterior
                        </span>
                        <span wire:loading wire:target="processarRelatoriosMesAnterior">Processando...</span>
                    </button>
                </div>
            </div>

            <!-- Link para Relatórios Completos -->
            <div class="flex items-center justify-center p-3 mt-4 border-t border-gray-200 dark:border-gray-700">
                <a href="/report/carrier" target="_blank"
                    class="inline-flex items-center text-sm font-medium text-orange-600 transition-colors hover:text-orange-700 dark:text-orange-400 dark:hover:text-orange-300">
                    <x-ui-icon name="chart-bar" class="w-4 h-4 mr-2" />
                    Ver Relatórios Completos de Operadoras
                    <x-ui-icon name="arrow-top-right-on-square" class="w-4 h-4 ml-2" />
                </a>
            </div>
        </div>

        <!-- Dicas -->
        <div class="p-4 mb-6 border-l-4 border-blue-500 rounded-lg bg-blue-50 dark:bg-blue-900/20">
            <h5 class="mb-2 font-semibold text-blue-800 dark:text-blue-300">💡 Dicas</h5>
            <ul class="space-y-1 text-sm text-blue-700 dark:text-blue-400">
                <li>• Para processar os jobs, execute: <code class="px-2 py-1 bg-blue-100 rounded dark:bg-blue-900">php artisan queue:work redis</code></li>
                <li>• Para monitorar tarifação: <code class="px-2 py-1 bg-blue-100 rounded dark:bg-blue-900">tail -f storage/logs/laravel.log | grep Tariff</code></li>
                <li>• Para monitorar batches: <code class="px-2 py-1 bg-blue-100 rounded dark:bg-blue-900">tail -f storage/logs/laravel.log | grep Revenue</code></li>
                <li>• Para gerar relatórios de operadora manual: <code class="px-2 py-1 bg-blue-100 rounded dark:bg-blue-900">php artisan operadora:gerar-relatorio 12 2025</code></li>
                <li>• Use "Reprocessar" para CDRs específicos ou com filtro de status</li>
                <li>• Batches são processados automaticamente a cada 10 minutos ou ao atingir 100 CDRs</li>
                <li>• Relatórios de operadora são gerados automaticamente no dia 1 de cada mês às 6h</li>
                <li>• Limpe o cache apenas se houver problemas com tarifas desatualizadas</li>
            </ul>
        </div>
    </div>

    <!-- Modal de Reprocessamento -->
    <x-ui-modal wire="reprocessModal" size="lg" persistent>
        <x-slot:title>
            Reprocessar Tarifação
        </x-slot:title>

        <div class="space-y-4">
            <!-- Informação sobre método de lote -->
            <div class="p-3 bg-blue-50 border border-blue-200 rounded-lg dark:bg-blue-900/20 dark:border-blue-800">
                <div class="flex items-start gap-2">
                    <x-ui-icon name="information-circle" class="w-5 h-5 text-blue-600 dark:text-blue-400 flex-shrink-0 mt-0.5" />
                    <div class="text-sm text-blue-800 dark:text-blue-300">
                        <strong>Processamento em Lote:</strong> Para múltiplos CDRs, o sistema criará jobs de lote (1000 CDRs por job) ao invés de jobs individuais, evitando sobrecarga na fila.
                    </div>
                </div>
            </div>

            <!-- CDR Específico -->
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                    CDR Específico (Opcional)
                </label>
                <input wire:model="specificCdrId" type="number" placeholder="Digite o ID do CDR"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                <p class="mt-1 text-xs text-gray-500">Deixe vazio para processar múltiplos CDRs em lote</p>
            </div>

            <hr class="dark:border-gray-600">

            <!-- Filtro por Status -->
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                    Filtrar por Status
                </label>
                <select wire:model.live="reprocessStatus"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    <option value="">Todos não tarifados</option>
                    <option value="Erro_Tarifa">Erro Tarifa ({{ $stats['erro_tarifa'] ?? 0 }})</option>
                    <option value="Tarifa_Nao_Encontrada">Tarifa Não Encontrada ({{ $stats['tarifa_nao_encontrada'] ?? 0 }})</option>
                    <option value="Dados_Invalidos">Dados Inválidos ({{ $stats['dados_invalidos'] ?? 0 }})</option>
                    <option value="Erro_Permanente">Erro Permanente ({{ $stats['erro_permanente'] ?? 0 }})</option>
                    <option value="Tarifada" class="bg-orange-50 dark:bg-orange-900 font-semibold">⚠️ Tarifada - Retarifar ({{ $stats['tarifada'] ?? 0 }})</option>
                </select>

                @if($reprocessStatus === 'Tarifada')
                <div class="mt-3 p-4 bg-orange-50 border-l-4 border-orange-500 dark:bg-orange-900/20 dark:border-orange-400">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-orange-500 dark:text-orange-400 mt-0.5 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        <div>
                            <h4 class="text-sm font-semibold text-orange-800 dark:text-orange-300">ATENÇÃO: Retarifação</h4>
                            <p class="mt-1 text-sm text-orange-700 dark:text-orange-400">
                                Esta opção irá <strong>RESETAR e RETARIFAR</strong> chamadas que já foram tarifadas com sucesso:
                            </p>
                            <ul class="mt-2 text-xs text-orange-600 dark:text-orange-400 list-disc list-inside space-y-1">
                                <li>Os valores atuais de venda/compra serão <strong>PERDIDOS</strong></li>
                                <li>Vínculo com faturas será <strong>REMOVIDO</strong></li>
                                <li>As chamadas serão reprocessadas com as <strong>rates ATUAIS</strong></li>
                                <li>Use apenas se tiver <strong>CERTEZA</strong> que precisa recalcular</li>
                            </ul>
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <!-- Filtros Adicionais -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Período -->
                <div class="md:col-span-2">
                    <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                        Período (Opcional)
                    </label>
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="block mb-1 text-xs text-gray-600 dark:text-gray-400">Data Inicial</label>
                            <input wire:model="reprocessDataInicial" type="date"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        </div>
                        <div>
                            <label class="block mb-1 text-xs text-gray-600 dark:text-gray-400">Data Final</label>
                            <input wire:model="reprocessDataFinal" type="date"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        </div>
                    </div>
                    <p class="mt-1 text-xs text-gray-500">Deixe vazio para processar todas as datas</p>
                </div>

                <!-- Carrier -->
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                        Operadora (Opcional)
                    </label>
                    <select wire:model="reprocessCarrierId"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        <option value="">Todas as operadoras</option>
                        @foreach(\App\Models\Carrier::orderBy('operadora')->get() as $carrier)
                            <option value="{{ $carrier->id }}">{{ $carrier->operadora }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Customer -->
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                        Cliente (Opcional)
                    </label>
                    <select wire:model="reprocessCustomerId"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        <option value="">Todos os clientes</option>
                        @foreach(\App\Models\Customer::orderBy('nomefantasia')->get() as $customer)
                            <option value="{{ $customer->id }}">{{ $customer->nomefantasia ?? $customer->razaosocial }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Limite -->
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                    Quantidade Máxima
                </label>
                <input wire:model="reprocessLimit" type="number" min="1" max="10000"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                <p class="mt-1 text-xs text-gray-500">Limite de CDRs a processar (máximo 10.000)</p>
            </div>
        </div>

        <x-slot:footer>
            <div class="flex justify-end gap-2">
                <button wire:click="reprocessModal = false" type="button"
                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600">
                    Cancelar
                </button>
                <button wire:click="reprocessar" type="button"
                    class="px-4 py-2 text-sm font-medium text-white bg-purple-600 rounded-lg hover:bg-purple-700">
                    Reprocessar
                </button>
            </div>
        </x-slot:footer>
    </x-ui-modal>

    <!-- Modal: Reprocessamento de Receitas -->
    <x-ui-modal wire="revenueReprocessModal" title="Reprocessar Resumos Mensais de Receita" size="2xl">
        <x-slot:description>
            Recalcula os resumos mensais de receita usando batch processing otimizado.
            <br>
            <strong class="text-purple-600">⚡ 99% mais rápido</strong> que o método anterior e livre de race conditions.
        </x-slot:description>

        <div class="space-y-4">
            <!-- Info de Performance -->
            <div class="p-3 border-l-4 border-green-500 rounded bg-green-50 dark:bg-green-900/20">
                <p class="text-xs text-green-700 dark:text-green-400">
                    <strong>✅ Vantagens:</strong> Batch processing (100 CDRs/job), Distributed locks, Atomic updates, Processamento assíncrono
                </p>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <!-- Mês -->
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                        Mês *
                    </label>
                    <select wire:model.live="revenueReprocessMes"
                        class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        @for($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}">{{ str_pad($i, 2, '0', STR_PAD_LEFT) }} - {{ \Carbon\Carbon::create()->month($i)->locale('pt_BR')->monthName }}</option>
                        @endfor
                    </select>
                </div>

                <!-- Ano -->
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                        Ano *
                    </label>
                    <input type="number" wire:model.live="revenueReprocessAno" min="2020" max="2100"
                        class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                        placeholder="2025">
                </div>
            </div>

            <!-- Modo Lote -->
            <div class="p-4 border rounded-lg bg-gray-50 dark:bg-gray-800">
                <div class="flex items-center gap-3 mb-3">
                    <input type="checkbox" wire:model.live="revenueReprocessModeLote" id="revenueReprocessModeLote"
                        class="w-4 h-4 text-purple-600 bg-gray-100 border-gray-300 rounded focus:ring-purple-500 dark:focus:ring-purple-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                    <label for="revenueReprocessModeLote" class="text-sm font-medium text-gray-700 dark:text-gray-300">
                        Processar em Lote (múltiplos meses)
                    </label>
                </div>

                @if($revenueReprocessModeLote)
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                        Número de Meses (a partir do mês/ano selecionado)
                    </label>
                    <input type="number" wire:model.live="revenueReprocessNumMeses" min="1" max="24"
                        class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                        placeholder="12">
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                        Processará {{ $revenueReprocessNumMeses }} mês(es) consecutivos a partir de {{ str_pad($revenueReprocessMes, 2, '0', STR_PAD_LEFT) }}/{{ $revenueReprocessAno }}
                    </p>
                </div>
                @endif
            </div>

            <div class="grid grid-cols-2 gap-4">
                <!-- Customer ID (Opcional) -->
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                        Cliente ID (Opcional)
                    </label>
                    <input type="number" wire:model.live="revenueReprocessCustomerId" min="1"
                        class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                        placeholder="Deixe vazio para todos">
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                        Se preenchido, reprocessa apenas este cliente
                    </p>
                </div>

                <!-- Batch Size -->
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                        Batch Size
                    </label>
                    <input type="number" wire:model="revenueReprocessBatchSize" min="10" max="500"
                        class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                        placeholder="100">
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                        Quantidade de CDRs por job (padrão: 100)
                    </p>
                </div>
            </div>

            <!-- Preview -->
            @if($this->revenueReprocessPreview && isset($this->revenueReprocessPreview['periodos']))
            <div class="p-4 border-l-4 border-purple-500 rounded bg-purple-50 dark:bg-purple-900/20">
                <h5 class="mb-2 text-sm font-semibold text-purple-800 dark:text-purple-300">
                    📊 Preview do Reprocessamento
                    @if($revenueReprocessModeLote && isset($this->revenueReprocessPreview['periodos']))
                        - {{ count($this->revenueReprocessPreview['periodos']) }} Mês(es)
                    @else
                        - {{ str_pad($revenueReprocessMes, 2, '0', STR_PAD_LEFT) }}/{{ $revenueReprocessAno }}
                    @endif
                </h5>
                <div class="text-sm">
                    <p class="text-purple-700 dark:text-purple-400">
                        <strong>Total de Faturas:</strong> {{ number_format($this->revenueReprocessPreview['totalFaturas'] ?? 0, 0, ',', '.') }}
                    </p>
                    @if($revenueReprocessCustomerId)
                    <p class="mt-1 text-xs text-purple-600 dark:text-purple-400">
                        Filtrando apenas cliente ID: {{ $revenueReprocessCustomerId }}
                    </p>
                    @endif
                </div>

                @if($revenueReprocessModeLote && isset($this->revenueReprocessPreview['periodos']))
                <div class="mt-3 pt-3 border-t border-purple-200 dark:border-purple-700">
                    <p class="mb-2 text-xs font-semibold text-purple-800 dark:text-purple-300">
                        Períodos que serão reprocessados:
                    </p>
                    <div class="flex flex-wrap gap-2">
                        @foreach($this->revenueReprocessPreview['periodos'] as $periodo)
                            <span class="px-2 py-1 text-xs font-medium rounded
                                {{ $periodo['faturas'] > 0
                                    ? 'text-purple-700 bg-purple-100 dark:bg-purple-800 dark:text-purple-200'
                                    : 'text-gray-500 bg-gray-100 dark:bg-gray-700 dark:text-gray-400' }}">
                                {{ $periodo['label'] }}
                                @if($periodo['faturas'] > 0)
                                    ({{ $periodo['faturas'] }})
                                @else
                                    (0)
                                @endif
                            </span>
                        @endforeach
                    </div>
                </div>
                @endif

                @if(($this->revenueReprocessPreview['totalFaturas'] ?? 0) === 0)
                <p class="mt-2 text-xs text-orange-600 dark:text-orange-400 font-semibold">
                    ⚠️ Nenhuma fatura encontrada
                    @if($revenueReprocessModeLote)
                        para os períodos selecionados.
                    @else
                        para {{ str_pad($revenueReprocessMes, 2, '0', STR_PAD_LEFT) }}/{{ $revenueReprocessAno }}.
                    @endif
                    @if($revenueReprocessCustomerId)
                        <br>Verifique se o cliente ID {{ $revenueReprocessCustomerId }} possui faturas nesses períodos.
                    @else
                        <br>Selecione outro mês/ano acima para reprocessar períodos com faturas existentes.
                    @endif
                </p>
                @endif
            </div>
            @endif

            <!-- Warning -->
            <div class="p-3 border-l-4 border-yellow-500 rounded bg-yellow-50 dark:bg-yellow-900/20">
                <p class="text-xs text-yellow-700 dark:text-yellow-400">
                    <strong>⚠️ Atenção:</strong> Os valores dos resumos mensais serão resetados e recalculados do zero
                    @if($revenueReprocessModeLote)
                        <strong>em {{ $revenueReprocessNumMeses }} mês(es)</strong>
                    @endif.
                    Os jobs serão despachados para a fila e processados em background.
                </p>
            </div>
        </div>

        <x-slot:footer>
            <div class="flex justify-end gap-3">
                <button wire:click="$set('revenueReprocessModal', false)" type="button"
                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-600">
                    Cancelar
                </button>
                <button wire:click="reprocessarReceitas" wire:loading.attr="disabled" type="button"
                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-purple-600 rounded-lg hover:bg-purple-700 disabled:opacity-50">
                    <x-ui-icon name="arrow-path" class="w-4 h-4 mr-2" />
                    <span wire:loading.remove wire:target="reprocessarReceitas">Reprocessar</span>
                    <span wire:loading wire:target="reprocessarReceitas">Processando...</span>
                </button>
            </div>
        </x-slot:footer>
    </x-ui-modal>

    <!-- Modal: Fechar Faturamento -->
    <x-ui-modal wire="fecharFaturasModal" title="Fechar Faturamento Mensal" size="2xl">
        <x-slot:description>
            Fecha faturas de clientes e relatórios de operadoras, marcando-as como "fechadas" para evitar alterações acidentais.
        </x-slot:description>

        <div class="space-y-4">
            <div class="grid grid-cols-2 gap-4">
                <!-- Mês -->
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                        Mês *
                    </label>
                    <select wire:model.live="fecharFaturasMes"
                        class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        @for($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}">{{ str_pad($i, 2, '0', STR_PAD_LEFT) }} - {{ \Carbon\Carbon::create()->month($i)->locale('pt_BR')->monthName }}</option>
                        @endfor
                    </select>
                </div>

                <!-- Ano -->
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                        Ano *
                    </label>
                    <input type="number" wire:model.live="fecharFaturasAno" min="2020" max="2100"
                        class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                        placeholder="2025">
                </div>
            </div>

            <!-- Modo Lote -->
            <div class="p-4 border rounded-lg bg-gray-50 dark:bg-gray-800">
                <div class="flex items-center gap-3 mb-3">
                    <input type="checkbox" wire:model.live="fecharFaturasModeLote" id="fecharFaturasModeLote"
                        class="w-4 h-4 text-green-600 bg-gray-100 border-gray-300 rounded focus:ring-green-500 dark:focus:ring-green-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                    <label for="fecharFaturasModeLote" class="text-sm font-medium text-gray-700 dark:text-gray-300">
                        Processar em Lote (múltiplos meses)
                    </label>
                </div>

                @if($fecharFaturasModeLote)
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                        Número de Meses (a partir do mês/ano selecionado)
                    </label>
                    <input type="number" wire:model.live="fecharFaturasNumMeses" min="1" max="24"
                        class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                        placeholder="12">
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                        Processará {{ $fecharFaturasNumMeses }} mês(es) retroativamente a partir de {{ str_pad($fecharFaturasMes, 2, '0', STR_PAD_LEFT) }}/{{ $fecharFaturasAno }}
                    </p>
                </div>
                @endif
            </div>

            <!-- Preview -->
            @if(!empty($fecharFaturasPreview))
            <div class="p-4 border-l-4 border-blue-500 rounded bg-blue-50 dark:bg-blue-900/20">
                <h5 class="mb-2 text-sm font-semibold text-blue-800 dark:text-blue-300">
                    📊 Preview do Fechamento
                    @if($fecharFaturasModeLote && isset($fecharFaturasPreview['periodos']))
                        - {{ $fecharFaturasPreview['periodos'] }} Mês(es)
                    @else
                        - {{ str_pad($fecharFaturasMes, 2, '0', STR_PAD_LEFT) }}/{{ $fecharFaturasAno }}
                    @endif
                </h5>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="text-blue-700 dark:text-blue-400">
                            <strong>Faturas de Clientes:</strong> {{ number_format($fecharFaturasPreview['faturas_clientes'] ?? 0, 0, ',', '.') }}
                        </p>
                    </div>
                    <div>
                        <p class="text-blue-700 dark:text-blue-400">
                            <strong>Relatórios de Operadoras:</strong> {{ number_format($fecharFaturasPreview['relatorios_operadoras'] ?? 0, 0, ',', '.') }}
                        </p>
                    </div>
                </div>

                @if($fecharFaturasModeLote && isset($fecharFaturasPreview['meses']))
                <div class="mt-3 pt-3 border-t border-blue-200 dark:border-blue-700">
                    <p class="mb-2 text-xs font-semibold text-blue-800 dark:text-blue-300">
                        Períodos que serão fechados:
                    </p>
                    <div class="flex flex-wrap gap-2">
                        @foreach($fecharFaturasPreview['meses'] as $periodo)
                            <span class="px-2 py-1 text-xs font-medium text-blue-700 bg-blue-100 rounded dark:bg-blue-800 dark:text-blue-200">
                                {{ $periodo['label'] }}
                            </span>
                        @endforeach
                    </div>
                </div>
                @endif

                @if(($fecharFaturasPreview['faturas_clientes'] ?? 0) === 0 && ($fecharFaturasPreview['relatorios_operadoras'] ?? 0) === 0)
                <p class="mt-2 text-xs text-orange-600 dark:text-orange-400 font-semibold">
                    ⚠️ Nenhuma fatura em aberto encontrada
                    @if($fecharFaturasModeLote)
                        para os períodos selecionados.
                    @else
                        para {{ str_pad($fecharFaturasMes, 2, '0', STR_PAD_LEFT) }}/{{ $fecharFaturasAno }}.
                    @endif
                    <br>Selecione outro mês/ano acima para fechar faturas de períodos diferentes.
                </p>
                @endif
            </div>
            @endif

            <!-- Info -->
            <div class="p-3 border-l-4 border-green-500 rounded bg-green-50 dark:bg-green-900/20">
                <p class="text-xs text-green-700 dark:text-green-400">
                    <strong>ℹ️ O que será feito:</strong><br>
                    1. Atualiza receita de produtos recorrentes<br>
                    2. Marca faturas como "fechadas" (não permite mais alterações)<br>
                    3. Registra quem e quando fechou (auditoria)
                </p>
            </div>

            <!-- Warning -->
            <div class="p-3 border-l-4 border-yellow-500 rounded bg-yellow-50 dark:bg-yellow-900/20">
                <p class="text-xs text-yellow-700 dark:text-yellow-400">
                    <strong>⚠️ Atenção:</strong> Após fechar, as faturas não poderão ser alteradas sem reabrir primeiro.
                </p>
            </div>
        </div>

        <x-slot:footer>
            <div class="flex justify-end gap-3">
                <button wire:click="$set('fecharFaturasModal', false)" type="button"
                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-600">
                    Cancelar
                </button>
                <button wire:click="fecharFaturas" wire:loading.attr="disabled" type="button"
                    @if(($fecharFaturasPreview['faturas_clientes'] ?? 0) > 0 || ($fecharFaturasPreview['relatorios_operadoras'] ?? 0) > 0)
                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700 disabled:opacity-50"
                    @else
                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-gray-400 rounded-lg cursor-not-allowed disabled:opacity-50"
                        disabled
                    @endif>
                    <x-ui-icon name="lock-closed" class="w-4 h-4 mr-2" />
                    <span wire:loading.remove wire:target="fecharFaturas">Fechar Faturamento</span>
                    <span wire:loading wire:target="fecharFaturas">Fechando...</span>
                </button>
            </div>
        </x-slot:footer>
    </x-ui-modal>

    <!-- Modal: Reabrir Faturamento -->
    <x-ui-modal wire="reabrirFaturasModal" title="Reabrir Faturamento Fechado" size="2xl">
        <x-slot:description>
            <span class="text-red-600 font-semibold">⚠️ OPERAÇÃO CRÍTICA:</span> Reabre faturas fechadas para permitir correções. Requer motivo obrigatório para auditoria.
        </x-slot:description>

        <div class="space-y-4">
            <div class="grid grid-cols-2 gap-4">
                <!-- Mês -->
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                        Mês *
                    </label>
                    <select wire:model="reabrirFaturasMes"
                        class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-red-500 focus:border-red-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        @for($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}">{{ str_pad($i, 2, '0', STR_PAD_LEFT) }} - {{ \Carbon\Carbon::create()->month($i)->locale('pt_BR')->monthName }}</option>
                        @endfor
                    </select>
                </div>

                <!-- Ano -->
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                        Ano *
                    </label>
                    <input type="number" wire:model="reabrirFaturasAno" min="2020" max="2100"
                        class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-red-500 focus:border-red-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                        placeholder="2025">
                </div>
            </div>

            <!-- Modo Lote -->
            <div class="p-4 border rounded-lg bg-gray-50 dark:bg-gray-800">
                <div class="flex items-center gap-3 mb-3">
                    <input type="checkbox" wire:model.live="reabrirFaturasModeLote" id="reabrirFaturasModeLote"
                        class="w-4 h-4 text-red-600 bg-gray-100 border-gray-300 rounded focus:ring-red-500 dark:focus:ring-red-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                    <label for="reabrirFaturasModeLote" class="text-sm font-medium text-gray-700 dark:text-gray-300">
                        Processar em Lote (múltiplos meses)
                    </label>
                </div>

                @if($reabrirFaturasModeLote)
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                        Número de Meses (a partir do mês/ano selecionado)
                    </label>
                    <input type="number" wire:model.live="reabrirFaturasNumMeses" min="1" max="24"
                        class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-red-500 focus:border-red-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                        placeholder="12">
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                        Processará {{ $reabrirFaturasNumMeses }} mês(es) retroativamente a partir de {{ str_pad($reabrirFaturasMes, 2, '0', STR_PAD_LEFT) }}/{{ $reabrirFaturasAno }}
                    </p>
                </div>
                @endif
            </div>

            <!-- Tipo -->
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                    O que reabrir? *
                </label>
                <select wire:model="reabrirFaturasTipo"
                    class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-red-500 focus:border-red-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    <option value="ambos">Ambos (Clientes + Operadoras)</option>
                    <option value="cliente">Apenas Faturas de Clientes</option>
                    <option value="operadora">Apenas Relatórios de Operadoras</option>
                </select>
            </div>

            <!-- Motivo (OBRIGATÓRIO) -->
            <div>
                <label class="block mb-2 text-sm font-medium text-red-700 dark:text-red-400">
                    Motivo da Reabertura * (Obrigatório para Auditoria)
                </label>
                <textarea wire:model="reabrirFaturasMotivo" rows="3"
                    class="w-full px-3 py-2 text-sm border border-red-300 rounded-lg focus:ring-red-500 focus:border-red-500 dark:bg-gray-700 dark:border-red-600 dark:text-white"
                    placeholder="Ex: Corrigir erro de tarifação na operadora X, ajustar valor de plano do cliente Y, etc."></textarea>
                <p class="mt-1 text-xs text-red-600 dark:text-red-500">
                    Este campo é obrigatório e será registrado nos logs com seu nome e horário.
                </p>
            </div>

            <!-- Warning FORTE -->
            <div class="p-4 border-2 border-red-500 rounded bg-red-50 dark:bg-red-900/30">
                <h5 class="mb-2 text-sm font-bold text-red-800 dark:text-red-300">🚨 ATENÇÃO - OPERAÇÃO IRREVERSÍVEL</h5>
                <ul class="text-xs text-red-700 dark:text-red-400 list-disc list-inside space-y-1">
                    <li>Faturas fechadas serão reabertas e poderão ser alteradas
                        @if($reabrirFaturasModeLote)
                            <strong>({{ $reabrirFaturasNumMeses }} mês(es))</strong>
                        @endif
                    </li>
                    <li>Você ({{ auth()->user()->name ?? 'Usuário' }}) será registrado como responsável</li>
                    <li>O motivo será permanentemente logado para auditoria</li>
                    <li>Esta ação não pode ser desfeita automaticamente</li>
                </ul>
            </div>
        </div>

        <x-slot:footer>
            <div class="flex justify-end gap-3">
                <button wire:click="$set('reabrirFaturasModal', false)" type="button"
                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-600">
                    Cancelar
                </button>
                <button wire:click="reabrirFaturas" wire:loading.attr="disabled" type="button"
                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 disabled:opacity-50">
                    <x-ui-icon name="lock-open" class="w-4 h-4 mr-2" />
                    <span wire:loading.remove wire:target="reabrirFaturas">Reabrir Faturamento</span>
                    <span wire:loading wire:target="reabrirFaturas">Reabrindo...</span>
                </button>
            </div>
        </x-slot:footer>
    </x-ui-modal>

    <!-- Modal: Gerar Relatórios de Operadora Customizado -->
    <x-ui-modal wire="gerarRelatorioOperadoraModal" title="Gerar Relatórios de Operadora" size="2xl">
        <x-slot:description>
            Gera relatórios consolidados de custos por operadora para um período específico.
        </x-slot:description>

        <div class="space-y-4">
            <!-- Seletores de Mês e Ano -->
            <div class="grid grid-cols-2 gap-4">
                <!-- Mês -->
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                        Mês <span class="text-red-500">*</span>
                    </label>
                    <select wire:model="gerarRelatorioMes"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-orange-500">
                        @for($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}">
                                {{ str_pad($i, 2, '0', STR_PAD_LEFT) }} - {{ \Carbon\Carbon::create()->month($i)->locale('pt_BR')->monthName }}
                            </option>
                        @endfor
                    </select>
                </div>

                <!-- Ano -->
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                        Ano <span class="text-red-500">*</span>
                    </label>
                    <input type="number" wire:model="gerarRelatorioAno"
                        min="2020" max="2100" step="1"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-orange-500"
                        placeholder="2025">
                </div>
            </div>

            <!-- Carrier ID (Opcional) -->
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                    ID da Operadora (Opcional)
                </label>
                <input type="number" wire:model="gerarRelatorioCarrierId"
                    min="1" step="1"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-orange-500"
                    placeholder="Deixe vazio para processar todas as operadoras">
                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                    Se preenchido, gera relatório apenas para esta operadora específica.
                </p>
            </div>

            <!-- Info Box -->
            <div class="p-4 border-l-4 border-yellow-500 rounded-lg bg-yellow-50 dark:bg-yellow-900/20">
                <h5 class="mb-2 text-sm font-semibold text-yellow-800 dark:text-yellow-300">⚡ O que será feito:</h5>
                <ul class="space-y-1 text-sm text-yellow-700 dark:text-yellow-400">
                    <li>1. Consolida custos de CDRs por operadora</li>
                    <li>2. Agrupa por tipo de serviço (Fixo, Móvel, Internacional)</li>
                    <li>3. Salva em CarrierUsage para o mês/ano especificado</li>
                    <li>4. Permite marcar mês como "fechado" posteriormente</li>
                </ul>
            </div>

            <!-- Vantagens -->
            <div class="p-4 border-l-4 border-green-500 rounded-lg bg-green-50 dark:bg-green-900/20">
                <h5 class="mb-2 text-sm font-semibold text-green-800 dark:text-green-300">✅ Quando usar:</h5>
                <ul class="space-y-1 text-sm text-green-700 dark:text-green-400">
                    <li>• Reprocessar relatórios de meses anteriores</li>
                    <li>• Gerar relatórios para períodos específicos</li>
                    <li>• Processar apenas uma operadora específica</li>
                    <li>• Correção de dados após ajustes de tarifas</li>
                </ul>
            </div>
        </div>

        <x-slot:footer>
            <div class="flex justify-end gap-3">
                <button wire:click="$set('gerarRelatorioOperadoraModal', false)"
                    class="px-4 py-2 text-sm font-medium text-gray-700 transition-colors bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-600">
                    Cancelar
                </button>
                <button wire:click="gerarRelatoriosOperadoraCustomizado" wire:loading.attr="disabled"
                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-white transition-colors bg-orange-600 rounded-lg hover:bg-orange-700">
                    <x-ui-icon name="document-text" class="w-4 h-4 mr-2" />
                    <span wire:loading.remove wire:target="gerarRelatoriosOperadoraCustomizado">
                        Gerar Relatórios
                    </span>
                    <span wire:loading wire:target="gerarRelatoriosOperadoraCustomizado">
                        Gerando...
                    </span>
                </button>
            </div>
        </x-slot:footer>
    </x-ui-modal>
</div>
