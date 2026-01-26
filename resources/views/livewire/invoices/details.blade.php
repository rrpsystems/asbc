<div>
    <!-- Invoice -->
    <div class="max-w-[85rem] px-4 sm:px-6 lg:px-8 mx-auto my-4 sm:my-10">
        <!-- Header com botão voltar e ações -->
        <div class="flex flex-col items-center justify-between mb-6 sm:flex-row">
            <div class="flex items-center gap-4 mb-4 sm:mb-0">
                <a href="{{ route('customers.invoices', $invoice->customer_id) }}"
                   class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-600">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Voltar
                </a>
                <h3 class="text-2xl font-bold text-gray-800 dark:text-gray-200">
                    Fatura #{{ str_pad($invoiceId, 5, '0', STR_PAD_LEFT) }}
                </h3>
            </div>
            <div class="flex flex-wrap gap-2">
                <!-- Botão Toggle Detalhamento -->
                <button wire:click="toggleDetailed"
                        class="inline-flex items-center px-3 py-2 text-sm font-medium {{ $showDetailed ? 'text-white bg-purple-600 hover:bg-purple-700' : 'text-gray-700 bg-white border border-gray-300 hover:bg-gray-50 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-600' }} rounded-lg transition-colors">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        @if($showDetailed)
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                        @else
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                        @endif
                    </svg>
                    {{ $showDetailed ? 'Ver Resumo' : 'Ver Detalhamento' }}
                </button>

                <!-- Botão Excel -->
                <button wire:click="exportExcel"
                        class="inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-green-600 border border-transparent rounded-lg hover:bg-green-700 transition-colors">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Excel
                </button>

                <!-- Botão PDF -->
                <button wire:click="{{ $showDetailed ? 'exportPdfDetailed' : 'exportPdfSummary' }}"
                        class="inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-red-600 border border-transparent rounded-lg hover:bg-red-700 transition-colors">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                    </svg>
                    PDF
                </button>

                <!-- Botão Imprimir -->
                <a href="#" x-on:click="printDiv()"
                   class="inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-lg hover:bg-blue-700 transition-colors">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                    </svg>
                    Imprimir
                </a>
            </div>
        </div>

        <div class="mx-auto sm:w-11/12 lg:w-3/4">
            <!-- Card -->
            <div class="flex flex-col p-4 bg-white shadow-md sm:p-10 rounded-xl dark:bg-neutral-800">
                <!-- Grid -->
                <div class="flex justify-between">
                    <div>
                        <img class="object-cover w-36 h-36" src="{{ asset('img/logo_1.png') }}" alt="logo">
                        <h1 class="mt-2 text-lg font-semibold text-blue-600 md:text-xl dark:text-white">RRP Systems Ltda.</h1>
                    </div>
                    <!-- Col -->

                    <div class="text-end">
                        <h2 class="text-2xl font-semibold text-gray-800 md:text-3xl dark:text-neutral-200">Fatura</h2>
                        <span class="block mt-1 text-gray-500 dark:text-neutral-500">#{{ str_pad($invoiceId, 5, '0', STR_PAD_LEFT) }}</span>

                        <address class="mt-4 not-italic text-gray-800 dark:text-neutral-200">
                            Av. Pedro Lessa, 3076 - Conj. 71<br>
                            Santos/SP<br>
                        </address>
                    </div>
                    <!-- Col -->
                </div>
                <!-- End Grid -->

                <!-- Grid -->
                <div class="grid gap-3 mt-8 sm:grid-cols-2">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-neutral-200">Faturado para:</h3>
                        <h3 class="font-semibold text-gray-800 text-md dark:text-neutral-200">
                            {{ $invoice->customer->razaosocial ?? '' }}</h3>
                        <address class="mt-2 not-italic text-gray-500 dark:text-neutral-500">
                            {{ $invoice->customer->endereco ?? '' }}, {{ $invoice->customer->numero ?? '' }}
                            {{ $invoice->customer->complemento ? '- ' . $invoice->customer->complemento : '' }}<br>
                            {{ $invoice->customer->cidade ?? '' }}/{{ $invoice->customer->uf ?? '' }} -
                            {{ preg_replace('/^(\d{5})(\d{3})$/', '$1-$2', $invoice->customer->cep ?? '') }}<br>
                        </address>
                    </div>
                    <!-- Col -->

                    <div class="space-y-2 sm:text-end">
                        <!-- Grid -->
                        <div class="grid grid-cols-2 gap-3 sm:grid-cols-1 sm:gap-2">
                            <dl class="grid sm:grid-cols-5 gap-x-3">
                                <dt class="col-span-3 font-semibold text-gray-800 dark:text-neutral-200">
                                    Competencia:
                                </dt>
                                <dd class="col-span-2 text-gray-500 dark:text-neutral-500">
                                    {{ str_pad($invoice->mes, 2, '0', STR_PAD_LEFT) }}/{{ $invoice->ano }}</dd>
                            </dl>
                            <dl class="grid sm:grid-cols-5 gap-x-3">
                                <dt class="col-span-3 font-semibold text-gray-800 dark:text-neutral-200">Vencimento:
                                </dt>
                                <dd class="col-span-2 text-gray-500 dark:text-neutral-500">
                                    {{ $invoice->dataVencimento($invoice->customer->vencimento . '/' . $invoice->mes . '/' . $invoice->ano) }}
                                </dd>
                            </dl>
                        </div>
                        <!-- End Grid -->
                    </div>
                    <!-- Col -->
                </div>
                <!-- End Grid -->


                <!-- Table - Informações Contratadas -->
                <div class="mt-6">
                    <div class="p-4 space-y-2 border border-gray-200 rounded-lg dark:border-neutral-700">
                        <p class="text-sm font-bold text-gray-800 dark:text-neutral-200">PLANO CONTRATADO</p>
                        <div class="border-b border-gray-200 dark:border-neutral-700"></div>

                        <div class="grid grid-cols-3 gap-4">
                            <div>
                                <p class="text-xs font-medium text-gray-800 dark:text-neutral-200">NÚMERO(s)</p>
                                <p class="text-xs font-medium text-gray-500 dark:text-neutral-500 mt-1">
                                    {{ count($dids) ?? 0 }}
                                </p>
                            </div>
                            <div>
                                <p class="text-xs font-medium text-gray-800 dark:text-neutral-200">VALOR PLANO (R$)</p>
                                <p class="text-xs font-medium text-gray-500 dark:text-neutral-500 mt-1">
                                    {{ number_format($invoice->valor_plano, 2, ',', '.') }}
                                </p>
                            </div>
                            <div>
                                <p class="text-xs font-medium text-gray-800 dark:text-neutral-200">FRANQUIA (MINUTOS)</p>
                                <p class="text-xs font-medium text-gray-500 dark:text-neutral-500 mt-1">
                                    {{ number_format(ceil($invoice->franquia_minutos / 60), 0, ',', '.') }}
                                </p>
                            </div>
                        </div>

                        <div class="border-b border-gray-200 dark:border-neutral-700"></div>
                        <p class="text-xs font-medium text-gray-800 dark:text-neutral-200">SEU(s) NÚMERO(s)</p>

                        <div class="grid grid-cols-8">
                            @foreach ($dids as $did)
                                <div class="text-xs font-medium text-gray-500 dark:text-neutral-500">
                                    {{ preg_replace('/(\d{2})(\d{5})(\d{4})|(\d{2})(\d{4})(\d{4})/', '($1$4) $2$5-$3$6', $did->did) }}
                                    @if (!$loop->last),@endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <!-- End Table -->

                <!-- Resumo Consolidado (sempre visível) -->
                <div class="mt-6">
                    <div class="p-4 space-y-2 border border-gray-200 rounded-lg dark:border-neutral-700">
                        <p class="text-sm font-bold text-gray-800 dark:text-neutral-200">RESUMO DE UTILIZAÇÃO</p>
                        <div class="border-b border-gray-200 dark:border-neutral-700"></div>

                        <div class="grid grid-cols-4 gap-2 font-semibold text-xs text-gray-800 dark:text-neutral-200">
                            <div>TIPO</div>
                            <div class="text-center">QUANTIDADE</div>
                            <div class="text-center">MINUTOS</div>
                            <div class="text-right">VALOR TOTAL</div>
                        </div>

                        <div class="border-b border-gray-200 dark:border-neutral-700"></div>

                        @php
                            $totalChamadas = 0;
                            $totalMinutos = 0;
                            $totalValor = 0;
                        @endphp

                        @foreach ($callsSummary as $summary)
                            @php
                                $totalChamadas += $summary->quantidade;
                                $totalMinutos += $summary->total_segundos;
                                $totalValor += $summary->valor_total;
                            @endphp
                            <div class="grid grid-cols-4 gap-2 text-xs text-gray-700 dark:text-gray-300">
                                <div class="font-medium">{{ $summary->tarifa }}</div>
                                <div class="text-center">{{ number_format($summary->quantidade, 0, '.', '.') }}</div>
                                <div class="text-center">{{ number_format(ceil($summary->total_segundos / 60), 0, ',', '.') }}</div>
                                <div class="text-right">R$ {{ number_format($summary->valor_total, 2, ',', '.') }}</div>
                            </div>
                        @endforeach

                        <!-- Excedente Total -->
                        <div class="grid grid-cols-4 gap-2 text-xs text-orange-600 dark:text-orange-400">
                            <div class="font-medium">Excedente Total</div>
                            <div class="text-center">{{ number_format($excedenteQtd, 0, '.', '.') }}</div>
                            <div class="text-center">{{ number_format(ceil($excedenteSegundos / 60), 0, ',', '.') }}</div>
                            <div class="text-right">R$ {{ number_format($invoice->custo_excedente, 2, ',', '.') }}</div>
                        </div>

                        <div class="border-t-2 border-gray-300 dark:border-neutral-600 pt-2 mt-2">
                            <div class="grid grid-cols-4 gap-2 text-xs font-bold text-gray-900 dark:text-neutral-100">
                                <div>TOTAL</div>
                                <div class="text-center">{{ number_format($totalChamadas, 0, '.', '.') }}</div>
                                <div class="text-center">{{ number_format(ceil($totalMinutos / 60), 0, ',', '.') }}</div>
                                <div class="text-right">R$ {{ number_format($totalValor, 2, ',', '.') }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Detalhamento Completo (condicional) -->
                @if($showDetailed)
                <div class="mt-4 mb-2">
                    <p class="text-xs font-medium text-gray-600 dark:text-gray-400 italic">
                        Detalhamento completo de todas as chamadas
                    </p>
                </div>

                @foreach ($calls as $tarifa => $data)
                    <div class="mt-6">
                        <div class="p-4 space-y-2 border border-gray-200 rounded-lg dark:border-neutral-700">
                            <p class="text-xs font-medium text-gray-800 dark:text-neutral-200">{{ $tarifa }}</p>
                            <div class="border-b border-gray-200 sm:block dark:border-neutral-700"></div>
                            <div class="grid grid-cols-8">
                                <div>
                                    <p class="text-xs text-gray-800 dark:text-neutral-200">DATA</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-800 dark:text-neutral-200">HORA</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-800 dark:text-neutral-200">DURAÇÃO</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-800 dark:text-neutral-200">TIPO</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-800 dark:text-neutral-200">ORIGEM</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-800 dark:text-neutral-200">RAMAL</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-800 dark:text-neutral-200">TELEFONE</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-800 dark:text-neutral-200">VALOR</p>
                                </div>
                            </div>

                            <div class="border-b border-gray-200 sm:block dark:border-neutral-700"></div>
                            @foreach ($data as $call)
                                <div class="grid grid-cols-8">
                                    <div class="text-xs font-medium text-gray-500 text-start dark:text-neutral-500">
                                        {{ date('d/m/Y', strtotime($call->calldate)) }}</div>
                                    <div class="text-xs font-medium text-gray-500 text-start dark:text-neutral-500">
                                        {{ date('H:i', strtotime($call->calldate)) }}</div>
                                    <div class="text-xs font-medium text-gray-500 text-start dark:text-neutral-500">
                                        {{ \Carbon\Carbon::createFromFormat('U', $call->tempo_cobrado ?? '0')->format('H\hi\ms\s') }}
                                    </div>
                                    <div class="text-xs font-medium text-gray-500 text-start dark:text-neutral-500">
                                        {{ $call->tarifa }}</div>
                                    <div class="text-xs font-medium text-gray-500 text-start dark:text-neutral-500">
                                        {{ $call->did_id }}</div>
                                    <div class="text-xs font-medium text-gray-500 text-start dark:text-neutral-500">
                                        {{ $call->ramal }}</div>
                                    <div class="text-xs font-medium text-gray-500 text-start dark:text-neutral-500">
                                        {{ $call->numero }}
                                    </div>
                                    <div class="text-xs font-medium text-gray-500 text-start dark:text-neutral-500">
                                        {{ strtoupper($call->cobrada) == 'S' ? number_format($call->valor_venda, 2, ',', '.') : number_format(0, 2, ',', '.') }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
                @endif

                <!-- End Table -->

                <!-- Flex -->
                <div class="flex mt-8 sm:justify-end">
                    <div class="w-full max-w-2xl space-y-2 sm:text-end">
                        <!-- Grid -->
                        <div class="grid grid-cols-2 gap-3 sm:grid-cols-1 sm:gap-2">
                            <dl class="grid sm:grid-cols-5 gap-x-3">
                                <dt class="col-span-3 font-semibold text-gray-800 dark:text-neutral-200">Valor Plano:</dt>
                                <dd class="col-span-2 text-blue-600 dark:text-blue-400">R$ {{ number_format($invoice->valor_plano, 2, ',', '.') }}</dd>
                            </dl>

                            @if($invoice->excedente_fixo > 0)
                            <dl class="grid sm:grid-cols-5 gap-x-3">
                                <dt class="col-span-3 font-semibold text-gray-800 dark:text-neutral-200">Excedente Fixo:</dt>
                                <dd class="col-span-2 text-orange-600 dark:text-orange-400">R$ {{ number_format($invoice->excedente_fixo, 2, ',', '.') }}</dd>
                            </dl>
                            @endif

                            @if($invoice->excedente_movel > 0)
                            <dl class="grid sm:grid-cols-5 gap-x-3">
                                <dt class="col-span-3 font-semibold text-gray-800 dark:text-neutral-200">Excedente Móvel:</dt>
                                <dd class="col-span-2 text-orange-600 dark:text-orange-400">R$ {{ number_format($invoice->excedente_movel, 2, ',', '.') }}</dd>
                            </dl>
                            @endif

                            @if($invoice->excedente_internacional > 0)
                            <dl class="grid sm:grid-cols-5 gap-x-3">
                                <dt class="col-span-3 font-semibold text-gray-800 dark:text-neutral-200">Excedente Internacional:</dt>
                                <dd class="col-span-2 text-orange-600 dark:text-orange-400">R$ {{ number_format($invoice->excedente_internacional, 2, ',', '.') }}</dd>
                            </dl>
                            @endif

                            @if($invoice->custo_excedente > 0)
                            <div class="border-t border-gray-200 dark:border-neutral-700 my-2"></div>
                            <dl class="grid sm:grid-cols-5 gap-x-3">
                                <dt class="col-span-3 font-semibold text-gray-800 dark:text-neutral-200">Subtotal Excedente:</dt>
                                <dd class="col-span-2 text-orange-600 dark:text-orange-400 font-semibold">R$ {{ number_format($invoice->custo_excedente, 2, ',', '.') }}</dd>
                            </dl>
                            @endif

                            <div class="border-t-2 border-gray-300 dark:border-neutral-600 my-2"></div>
                            <dl class="grid sm:grid-cols-5 gap-x-3">
                                <dt class="col-span-3 text-lg font-bold text-gray-800 dark:text-neutral-200">Total da Fatura:</dt>
                                <dd class="col-span-2 text-lg font-bold text-green-600 dark:text-green-400">R$ {{ number_format($invoice->custo_total, 2, ',', '.') }}</dd>
                            </dl>
                        </div>
                        <!-- End Grid -->
                    </div>
                </div>
                <!-- End Flex -->

                <div class="mt-8 sm:mt-12">
                    <div class="mt-2">
                        <p class="block text-sm font-medium text-gray-800 dark:text-neutral-200">
                            contato@rrpsystems.com.br</p>
                        <p class="block text-sm font-medium text-gray-800 dark:text-neutral-200">+55 (13) 2191-2121
                        </p>
                    </div>
                </div>

                <p class="mt-5 text-sm text-gray-500 dark:text-neutral-500">© {{ date('Y') }} RRP Systems Ltda.</p>
            </div>
            <!-- End Card -->

        </div>

    </div>

    <!-- End Invoice -->
</div>
