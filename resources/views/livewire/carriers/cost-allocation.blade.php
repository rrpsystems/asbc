<div class="flex flex-col min-h-[calc(100vh-4rem)] pb-3 pl-6 pr-6 bg-white dark:bg-gray-600 border border-gray-300 dark:border-gray-100 rounded-md shadow-md shadow-black/5">
    <div x-init="$dispatch('bradcrumb', { menu: ['Operadoras', 'Alocação de Custos'] })"></div>

    <div class="container flex-grow mx-auto">
        <div class="flex flex-col items-center justify-between my-4 sm:flex-row">
            <h3 class="mb-4 text-2xl font-bold text-gray-800 dark:text-gray-200 sm:mb-0">Alocação de Custos</h3>
            <div class="flex flex-wrap gap-2">
                <button wire:click="exportExcel" class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-white transition-all duration-200 bg-green-600 rounded-lg shadow-sm hover:bg-green-700 hover:shadow-md">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Excel
                </button>
                <button wire:click="exportPdf" class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-white transition-all duration-200 bg-red-600 rounded-lg shadow-sm hover:bg-red-700 hover:shadow-md">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                    </svg>
                    PDF
                </button>
                <button wire:click="clearFilters" class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-gray-700 transition-all duration-200 bg-white border border-gray-300 rounded-lg shadow-sm dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600 hover:shadow-md">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    Limpar
                </button>
                <button wire:click="refresh" class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-white transition-all duration-200 bg-blue-600 rounded-lg shadow-sm hover:bg-blue-700 hover:shadow-md">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                    Atualizar
                </button>
            </div>
        </div>

        <!-- Filtros -->
        <div class="grid grid-cols-1 gap-4 p-4 mb-6 bg-gray-50 dark:bg-gray-700 rounded-lg md:grid-cols-5">
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-200">Operadora</label>
                <select wire:model.live="carrier_id" class="w-full px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-800 dark:border-gray-600 dark:text-gray-200">
                    <option value="">Selecione...</option>
                    @foreach($carriers as $carrier)
                        <option value="{{ $carrier->id }}">{{ $carrier->operadora }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-200">Mês</label>
                <select wire:model.live="mes" class="w-full px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-800 dark:border-gray-600 dark:text-gray-200">
                    @for($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}">{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}</option>
                    @endfor
                </select>
            </div>
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-200">Ano</label>
                <select wire:model.live="ano" class="w-full px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-800 dark:border-gray-600 dark:text-gray-200">
                    @for($y = now()->year; $y >= now()->year - 3; $y--)
                        <option value="{{ $y }}">{{ $y }}</option>
                    @endfor
                </select>
            </div>
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-200">Tipo de Alocação</label>
                <select wire:model.live="tipo_alocacao" class="w-full px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-800 dark:border-gray-600 dark:text-gray-200">
                    <option value="cliente">Por Cliente</option>
                    <option value="did">Por DID</option>
                </select>
            </div>
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-200">Competência</label>
                <div class="px-3 py-2 font-semibold text-blue-600 bg-blue-50 dark:bg-blue-900 dark:text-blue-200 rounded-md">
                    {{ str_pad($mes, 2, '0', STR_PAD_LEFT) }}/{{ $ano }}
                </div>
            </div>
        </div>

        @if($carrier_id)
            <!-- Cards de Resumo -->
            <div class="grid grid-cols-1 gap-4 mb-6 md:grid-cols-4">
                <div class="p-4 bg-gradient-to-br from-red-50 to-red-100 dark:from-red-900 dark:to-red-800 rounded-lg shadow-lg">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-medium text-red-600 dark:text-red-300">Custo Total</p>
                            <p class="text-2xl font-bold text-red-700 dark:text-red-200">
                                R$ {{ number_format($custoTotal, 2, ',', '.') }}
                            </p>
                        </div>
                        <div class="p-2 bg-red-200 dark:bg-red-700 rounded-full">
                            <svg class="w-6 h-6 text-red-700 dark:text-red-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="p-4 bg-gradient-to-br from-orange-50 to-orange-100 dark:from-orange-900 dark:to-orange-800 rounded-lg shadow-lg">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-medium text-orange-600 dark:text-orange-300">Custo Fixo</p>
                            <p class="text-2xl font-bold text-orange-700 dark:text-orange-200">
                                R$ {{ number_format($custoFixo, 2, ',', '.') }}
                            </p>
                        </div>
                        <div class="p-2 bg-orange-200 dark:bg-orange-700 rounded-full">
                            <svg class="w-6 h-6 text-orange-700 dark:text-orange-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="p-4 bg-gradient-to-br from-yellow-50 to-yellow-100 dark:from-yellow-900 dark:to-yellow-800 rounded-lg shadow-lg">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-medium text-yellow-600 dark:text-yellow-300">Custo Variável</p>
                            <p class="text-2xl font-bold text-yellow-700 dark:text-yellow-200">
                                R$ {{ number_format($custoVariavel, 2, ',', '.') }}
                            </p>
                        </div>
                        <div class="p-2 bg-yellow-200 dark:bg-yellow-700 rounded-full">
                            <svg class="w-6 h-6 text-yellow-700 dark:text-yellow-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="p-4 bg-gradient-to-br from-purple-50 to-purple-100 dark:from-purple-900 dark:to-purple-800 rounded-lg shadow-lg">
                    <div class="flex items-center justify-between">
                        <div class="w-full">
                            <p class="mb-2 text-xs font-medium text-purple-600 dark:text-purple-300">Variação vs. Mês Anterior</p>
                            <div class="space-y-2">
                                <div class="flex items-center justify-between">
                                    <span class="text-xs text-purple-600 dark:text-purple-400">Total:</span>
                                    <span class="flex items-center text-sm font-bold {{ $variacaoCustoTotal >= 0 ? 'text-red-600 dark:text-red-400' : 'text-green-600 dark:text-green-400' }}">
                                        @if($variacaoCustoTotal > 0) ↑ @elseif($variacaoCustoTotal < 0) ↓ @else — @endif
                                        {{ number_format(abs($variacaoCustoTotal), 1, ',', '.') }}%
                                    </span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-xs text-purple-600 dark:text-purple-400">Fixo:</span>
                                    <span class="flex items-center text-sm font-bold {{ $variacaoCustoFixo >= 0 ? 'text-red-600 dark:text-red-400' : 'text-green-600 dark:text-green-400' }}">
                                        @if($variacaoCustoFixo > 0) ↑ @elseif($variacaoCustoFixo < 0) ↓ @else — @endif
                                        {{ number_format(abs($variacaoCustoFixo), 1, ',', '.') }}%
                                    </span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-xs text-purple-600 dark:text-purple-400">Variável:</span>
                                    <span class="flex items-center text-sm font-bold {{ $variacaoCustoVariavel >= 0 ? 'text-red-600 dark:text-red-400' : 'text-green-600 dark:text-green-400' }}">
                                        @if($variacaoCustoVariavel > 0) ↑ @elseif($variacaoCustoVariavel < 0) ↓ @else — @endif
                                        {{ number_format(abs($variacaoCustoVariavel), 1, ',', '.') }}%
                                    </span>
                                </div>
                            </div>
                            <p class="mt-2 text-xs text-purple-500 dark:text-purple-400">
                                Comparado com {{ str_pad($mesAnterior, 2, '0', STR_PAD_LEFT) }}/{{ $anoAnterior }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabela de Alocação -->
            <div class="p-6 bg-white dark:bg-gray-800 rounded-lg shadow-lg">
                <h4 class="mb-4 text-lg font-bold text-gray-800 dark:text-gray-200">
                    Alocação {{ $tipo_alocacao === 'cliente' ? 'por Cliente' : 'por DID' }}
                </h4>

                @if($tipo_alocacao === 'cliente')
                    <!-- Alocação por Cliente -->
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="border-b-2 border-gray-300 dark:border-gray-600">
                                    <th class="px-4 py-3 text-left text-gray-700 dark:text-gray-300">Cliente</th>
                                    <th class="px-4 py-3 text-right text-gray-700 dark:text-gray-300">DIDs</th>
                                    <th class="px-4 py-3 text-right text-gray-700 dark:text-gray-300">% DIDs</th>
                                    <th class="px-4 py-3 text-right text-gray-700 dark:text-gray-300">Custo Fixo</th>
                                    <th class="px-4 py-3 text-right text-gray-700 dark:text-gray-300">Custo Variável</th>
                                    <th class="px-4 py-3 text-right text-gray-700 dark:text-gray-300">Custo Total</th>
                                    <th class="px-4 py-3 text-right text-gray-700 dark:text-gray-300">Receita</th>
                                    <th class="px-4 py-3 text-right text-gray-700 dark:text-gray-300">Lucro</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $totalDids = 0;
                                    $totalCustoFixo = 0;
                                    $totalCustoVariavel = 0;
                                    $totalCustoGeral = 0;
                                    $totalReceita = 0;
                                    $totalLucro = 0;
                                @endphp
                                @forelse($alocacoes as $item)
                                    @php
                                        $totalDids += $item['quantidade_dids'];
                                        $totalCustoFixo += $item['custo_fixo_rateado'];
                                        $totalCustoVariavel += $item['custo_variavel'];
                                        $totalCustoGeral += $item['custo_total'];
                                        $totalReceita += $item['receita'];
                                        $totalLucro += $item['lucro'];
                                    @endphp
                                    <tr class="border-b border-gray-100 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
                                        <td class="px-4 py-3 font-medium text-gray-900 dark:text-gray-100">{{ $item['nome'] }}</td>
                                        <td class="px-4 py-3 text-right text-gray-700 dark:text-gray-300">{{ $item['quantidade_dids'] }}</td>
                                        <td class="px-4 py-3 text-right text-blue-600 dark:text-blue-400" title="Percentual baseado em quantidade de DIDs">{{ number_format($item['percentual'], 2, ',', '.') }}%</td>
                                        <td class="px-4 py-3 text-right text-orange-600 dark:text-orange-400">R$ {{ number_format($item['custo_fixo_rateado'], 2, ',', '.') }}</td>
                                        <td class="px-4 py-3 text-right text-yellow-600 dark:text-yellow-400">R$ {{ number_format($item['custo_variavel'], 2, ',', '.') }}</td>
                                        <td class="px-4 py-3 text-right font-semibold text-red-600 dark:text-red-400">R$ {{ number_format($item['custo_total'], 2, ',', '.') }}</td>
                                        <td class="px-4 py-3 text-right text-blue-600 dark:text-blue-400">R$ {{ number_format($item['receita'], 2, ',', '.') }}</td>
                                        <td class="px-4 py-3 text-right font-bold {{ $item['lucro'] >= 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                            R$ {{ number_format($item['lucro'], 2, ',', '.') }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="px-4 py-8 text-center text-gray-500 dark:text-gray-400">
                                            Nenhum dado encontrado para o período selecionado
                                        </td>
                                    </tr>
                                @endforelse

                                @if($alocacoes->isNotEmpty())
                                    <tr class="border-t-2 border-gray-400 dark:border-gray-500 bg-gray-100 dark:bg-gray-700 font-bold">
                                        <td class="px-4 py-3 text-gray-900 dark:text-gray-100">TOTAL</td>
                                        <td class="px-4 py-3 text-right text-gray-900 dark:text-gray-100">{{ $totalDids }}</td>
                                        <td class="px-4 py-3 text-right text-blue-700 dark:text-blue-300">100,00%</td>
                                        <td class="px-4 py-3 text-right text-orange-700 dark:text-orange-300">R$ {{ number_format($totalCustoFixo, 2, ',', '.') }}</td>
                                        <td class="px-4 py-3 text-right text-yellow-700 dark:text-yellow-300">R$ {{ number_format($totalCustoVariavel, 2, ',', '.') }}</td>
                                        <td class="px-4 py-3 text-right text-red-700 dark:text-red-300">R$ {{ number_format($totalCustoGeral, 2, ',', '.') }}</td>
                                        <td class="px-4 py-3 text-right text-blue-700 dark:text-blue-300">R$ {{ number_format($totalReceita, 2, ',', '.') }}</td>
                                        <td class="px-4 py-3 text-right {{ $totalLucro >= 0 ? 'text-green-700 dark:text-green-300' : 'text-red-700 dark:text-red-300' }}">
                                            R$ {{ number_format($totalLucro, 2, ',', '.') }}
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                @else
                    <!-- Alocação por DID -->
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="border-b-2 border-gray-300 dark:border-gray-600">
                                    <th class="px-4 py-3 text-left text-gray-700 dark:text-gray-300">DID</th>
                                    <th class="px-4 py-3 text-left text-gray-700 dark:text-gray-300">Cliente</th>
                                    <th class="px-4 py-3 text-right text-gray-700 dark:text-gray-300">
                                        <div>Custo Contratado</div>
                                        <div class="text-xs font-normal text-gray-500 dark:text-gray-400">(Base do Plano)</div>
                                    </th>
                                    <th class="px-4 py-3 text-right text-gray-700 dark:text-gray-300">
                                        <div>Custo Real/Ativo</div>
                                        <div class="text-xs font-normal text-gray-500 dark:text-gray-400">(c/ Ociosos)</div>
                                    </th>
                                    <th class="px-4 py-3 text-right text-gray-700 dark:text-gray-300">
                                        <div>Custo Variável</div>
                                        <div class="text-xs font-normal text-gray-500 dark:text-gray-400">(Ociosos + Excedente)</div>
                                    </th>
                                    <th class="px-4 py-3 text-right text-gray-700 dark:text-gray-300">Custo Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $totalCustoContratado = 0;
                                    $totalCustoRealAtivo = 0;
                                    $totalCustoVariavelDid = 0;
                                    $totalCustoTotalDid = 0;
                                    $countDids = 0;
                                @endphp
                                @forelse($alocacoes as $item)
                                    @php
                                        $totalCustoContratado += $item['custo_contratado'];
                                        $totalCustoRealAtivo += $item['custo_real_ativo'];
                                        $totalCustoVariavelDid += $item['custo_variavel'];
                                        $totalCustoTotalDid += $item['custo_total'];
                                        $countDids++;
                                    @endphp
                                    <tr class="border-b border-gray-100 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
                                        <td class="px-4 py-3 font-medium text-gray-900 dark:text-gray-100">{{ $item['did'] }}</td>
                                        <td class="px-4 py-3 text-gray-700 dark:text-gray-300">{{ $item['customer_nome'] }}</td>
                                        <td class="px-4 py-3 text-right text-blue-600 dark:text-blue-400" title="Valor do plano ÷ DIDs contratados">
                                            R$ {{ number_format($item['custo_contratado'], 2, ',', '.') }}
                                        </td>
                                        <td class="px-4 py-3 text-right text-orange-600 dark:text-orange-400 font-semibold" title="Valor do plano ÷ DIDs ativos (mostra impacto dos ociosos)">
                                            R$ {{ number_format($item['custo_real_ativo'], 2, ',', '.') }}
                                        </td>
                                        <td class="px-4 py-3 text-right">
                                            <div class="text-yellow-600 dark:text-yellow-400">
                                                R$ {{ number_format($item['custo_variavel'], 2, ',', '.') }}
                                            </div>
                                            @if($item['custo_ociosos'] > 0 || $item['custo_variavel_excedente'] > 0)
                                                <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                                    @if($item['custo_ociosos'] > 0)
                                                        Ociosos: R$ {{ number_format($item['custo_ociosos'], 2, ',', '.') }}
                                                    @endif
                                                    @if($item['custo_variavel_excedente'] > 0)
                                                        <br>Excedente: R$ {{ number_format($item['custo_variavel_excedente'], 2, ',', '.') }}
                                                    @endif
                                                </div>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 text-right font-bold text-red-600 dark:text-red-400">
                                            R$ {{ number_format($item['custo_total'], 2, ',', '.') }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-4 py-8 text-center text-gray-500 dark:text-gray-400">
                                            Nenhum dado encontrado para o período selecionado
                                        </td>
                                    </tr>
                                @endforelse

                                @if($alocacoes->isNotEmpty())
                                    <tr class="border-t-2 border-gray-400 dark:border-gray-500 bg-gray-100 dark:bg-gray-700 font-bold">
                                        <td class="px-4 py-3 text-gray-900 dark:text-gray-100">TOTAL ({{ $countDids }} DIDs)</td>
                                        <td class="px-4 py-3"></td>
                                        <td class="px-4 py-3 text-right text-blue-700 dark:text-blue-300">R$ {{ number_format($totalCustoContratado, 2, ',', '.') }}</td>
                                        <td class="px-4 py-3 text-right text-orange-700 dark:text-orange-300">R$ {{ number_format($totalCustoRealAtivo, 2, ',', '.') }}</td>
                                        <td class="px-4 py-3 text-right text-yellow-700 dark:text-yellow-300">R$ {{ number_format($totalCustoVariavelDid, 2, ',', '.') }}</td>
                                        <td class="px-4 py-3 text-right text-red-700 dark:text-red-300">R$ {{ number_format($totalCustoTotalDid, 2, ',', '.') }}</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

            <!-- Explicação da Metodologia -->
            <div class="mt-6 p-4 bg-blue-50 dark:bg-blue-900 border-l-4 border-blue-500 rounded">
                <h5 class="font-bold text-blue-800 dark:text-blue-200 mb-2">📊 Metodologia de Cálculo</h5>
                <div class="text-sm text-blue-700 dark:text-blue-300 space-y-1">
                    @if($tipo_alocacao === 'cliente')
                        <p>• <strong>Custo Fixo por Cliente:</strong> (Valor do Plano ÷ Total de DIDs Ativos) × Quantidade de DIDs do Cliente</p>
                        <p class="ml-4 text-xs">Exemplo: (R$ 2.000 ÷ 109 DIDs ativos) × 10 DIDs do cliente = R$ 183,49</p>
                        <p>• <strong>Custo Variável:</strong> Soma dos custos variáveis (ociosos + excedente franquia) de todos os DIDs do cliente</p>
                        <p>• <strong>% DIDs:</strong> Percentual calculado com base na quantidade de DIDs, não nos minutos</p>
                        <p>• <strong>Lucro:</strong> Receita faturada ao cliente - Custo Total alocado</p>
                        <p class="mt-2 pt-2 border-t border-blue-300 dark:border-blue-700">
                            <strong>💡 Nota:</strong> A franquia é da operadora (compartilhada), não individual por cliente
                        </p>
                    @else
                        <p>• <strong>Custo Contratado:</strong> Valor do plano ÷ DIDs do contrato (Ex: R$ 2.000 ÷ 200 = R$ 10,00/DID)</p>
                        <p>• <strong>Custo Real/Ativo:</strong> Valor do plano ÷ DIDs ativos no sistema (Ex: R$ 2.000 ÷ 109 = R$ 18,35/DID)</p>
                        <p>• <strong>DIDs Ociosos:</strong> DIDs contratados mas não cadastrados. Custo é rateado entre os DIDs ativos</p>
                        <p>• <strong>Custo Variável:</strong> Soma de (Ociosos rateados + Excedente proporcional de franquia)</p>
                        <p>• <strong>Custo Total:</strong> Custo Contratado + Custo Variável (mostra o custo real por DID ativo)</p>
                        <p class="mt-2 pt-2 border-t border-blue-300 dark:border-blue-700">
                            <strong>💡 Insight:</strong> Se o Custo Real/Ativo está muito acima do Contratado, considere cadastrar mais DIDs ou renegociar o plano
                        </p>
                    @endif
                </div>
            </div>
        @else
            <div class="p-8 text-center bg-gray-50 dark:bg-gray-700 rounded-lg">
                <svg class="w-16 h-16 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <p class="text-lg text-gray-600 dark:text-gray-400">Selecione uma operadora para visualizar a alocação de custos</p>
            </div>
        @endif
    </div>
</div>
