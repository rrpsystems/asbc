<div>
    <!-- Invoice -->
    <div class="max-w-[85rem] px-4 sm:px-6 lg:px-8 mx-auto my-4 sm:my-10">
        <div class="mx-auto sm:w-11/12 lg:w-3/4">
            <!-- Card -->
            <div class="flex flex-col p-4 bg-white shadow-md sm:p-10 rounded-xl dark:bg-neutral-800">
                <!-- Grid -->
                <div class="flex justify-between">
                    <div>

                        <img class="object-cover w-36 h-36" src="{{ asset('img/logo_1.png') }}" alt="logo">

                        <h1 class="mt-2 text-lg font-semibold text-blue-600 md:text-xl dark:text-white">RRP Systems
                            Ltda.
                        </h1>
                    </div>
                    <!-- Col -->

                    <div class="text-end">
                        <h2 class="text-2xl font-semibold text-gray-800 md:text-3xl dark:text-neutral-200">Fatura
                        </h2>
                        <span
                            class="block mt-1 text-gray-500 dark:text-neutral-500">#{{ str_pad($invoiceId, 5, '0', STR_PAD_LEFT) }}</span>

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
                            {{ '- ' . $invoice->customer->complemento ?? '' }}<br>
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
                                    {{ $invoice->mes ?? '' }}/{{ $invoice->ano ?? '' }}</dd>
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


                <!-- Table -->
                <div class="mt-6">
                    <div class="p-4 space-y-2 border border-gray-200 rounded-lg dark:border-neutral-700">
                        <div class="grid grid-cols-7">
                            <div>
                                <p class="text-xs font-medium text-gray-800 dark:text-neutral-200">NÚMERO(s)</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-800 dark:text-neutral-200">VALOR (R$)</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-800 dark:text-neutral-200">MINUTOS</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-800 dark:text-neutral-200">FIXO</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-800 dark:text-neutral-200">MOVEL</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-800 dark:text-neutral-200">DDI</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-800 dark:text-neutral-200">EXCEDENTE</p>
                            </div>

                        </div>

                        <div class="border-b border-gray-200 sm:block dark:border-neutral-700"></div>
                        <div class="grid grid-cols-7">
                            <div class="text-xs font-medium text-gray-500 dark:text-neutral-500">
                                {{ count($dids) ?? 0 }}</div>
                            <div class="text-xs font-medium text-gray-500 text-start dark:text-neutral-500">
                                {{ number_format($invoice->valor_plano, 2, ',', '.') }}</div>
                            <div class="text-xs font-medium text-gray-500 text-start dark:text-neutral-500">
                                {{ ceil($invoice->franquia_minutos / 60) ?? 0 }}</div>
                            <div class="text-xs font-medium text-gray-500 text-start dark:text-neutral-500">
                                {{ ceil($invoice->minutos_fixo / 60) ?? 0 }}</div>
                            <div class="text-xs font-medium text-gray-500 text-start dark:text-neutral-500">
                                {{ ceil($invoice->minutos_movel / 60) ?? 0 }}</div>
                            <div class="text-xs font-medium text-gray-500 text-start dark:text-neutral-500">
                                {{ ceil($invoice->minutos_excedentes_internacional / 60) ?? 0 }}</div>
                            <div class="text-xs font-medium text-gray-500 text-start dark:text-neutral-500">
                                {{ ceil($invoice->minutos_excedentes / 60) ?? 0 }}</div>
                        </div>
                        <div class="border-b border-gray-200 sm:block dark:border-neutral-700"></div>
                        <p class="text-xs font-medium text-gray-800 dark:text-neutral-200">SEU(s) NÚMERO(s)</p>

                        <div class="grid grid-cols-8">
                            @foreach ($dids as $did)
                                <div class="text-xs font-medium text-gray-500 dark:text-neutral-500">
                                    {{ preg_replace('/(\d{2})(\d{5})(\d{4})|(\d{2})(\d{4})(\d{4})/', '($1$4) $2$5-$3$6', $did->did) }}
                                    @if (!$loop->last)
                                        ,
                                    @endif
                                </div>
                            @endforeach
                        </div>


                    </div>
                </div>
                <!-- End Table -->

                <!-- Table -->

                @foreach ($calls as $tarifa => $data)
                    <div class="mt-6">
                        <div class="p-4 space-y-2 border border-gray-200 rounded-lg dark:border-neutral-700">
                            <p class="text-xs font-medium text-gray-800 dark:text-neutral-200">{{ $tarifa }}
                            </p>
                            <div class="border-b border-gray-200 sm:block dark:border-neutral-700"></div>
                            <div class="grid grid-cols-8">
                                <div>
                                    <p class="text-xs font-medium text-gray-800 dark:text-neutral-200">DATA</p>
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
                                        {{ date('H\hi\m', strtotime($call->calldate)) }}
                                    </div>
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
                                        {{ $call->numero }}</div>
                                    <div class="text-xs font-medium text-gray-500 text-start dark:text-neutral-500">
                                        {{ $call->cobrada == 's' ? number_format($call->valor_venda, 2, ',', '.') : number_format(0, 2, ',', '.') }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach

                <!-- End Table -->

                <!-- Flex -->
                <div class="flex mt-8 sm:justify-end">
                    <div class="w-full max-w-2xl space-y-2 sm:text-end">
                        <!-- Grid -->
                        <div class="grid grid-cols-2 gap-3 sm:grid-cols-1 sm:gap-2">
                            <dl class="grid sm:grid-cols-5 gap-x-3">
                                <dt class="col-span-3 font-semibold text-gray-800 dark:text-neutral-200">Valor
                                    Plano:
                                </dt>
                                <dd class="col-span-2 text-gray-500 dark:text-neutral-500">R$
                                    {{ number_format($invoice->valor_plano, 2, ',', '.') }}</dd>
                            </dl>
                            <dl class="grid sm:grid-cols-5 gap-x-3">
                                <dt class="col-span-3 font-semibold text-gray-800 dark:text-neutral-200">Excedente
                                    Fixo:
                                </dt>
                                <dd class="col-span-2 text-gray-500 dark:text-neutral-500">R$
                                    {{ number_format($invoice->excedente_fixo, 2, ',', '.') }}</dd>
                            </dl>
                            <dl class="grid sm:grid-cols-5 gap-x-3">
                                <dt class="col-span-3 font-semibold text-gray-800 dark:text-neutral-200">Excedente
                                    Movel:
                                </dt>
                                <dd class="col-span-2 text-gray-500 dark:text-neutral-500">R$
                                    {{ number_format($invoice->excedente_movel, 2, ',', '.') }}</dd>
                            </dl>

                            <dl class="grid sm:grid-cols-5 gap-x-3">
                                <dt class="col-span-3 font-semibold text-gray-800 dark:text-neutral-200">Excedente
                                    Internacional:
                                </dt>
                                <dd class="col-span-2 text-gray-500 dark:text-neutral-500">R$
                                    {{ number_format($invoice->excedente_internacional, 2, ',', '.') }}</dd>
                            </dl>

                            <dl class="grid sm:grid-cols-5 gap-x-3">
                                <dt class="col-span-3 font-semibold text-gray-800 dark:text-neutral-200">Total da
                                    Fatura:</dt>
                                <dd class="col-span-2 text-gray-500 dark:text-neutral-500">
                                    R${{ number_format($invoice->custo_total, 2, ',', '.') }}</dd>
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

                <p class="mt-5 text-sm text-gray-500 dark:text-neutral-500">© 2024 RRP Systems Ltda.</p>
                <!-- Buttons -->
                <div class="flex justify-end mt-6 gap-x-3">

                    <a class="inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-lg gap-x-2 hover:bg-blue-700 focus:outline-none focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none"
                        href="#" x-on:click="printDiv()">
                        <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="6 9 6 2 18 2 18 9" />
                            <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2" />
                            <rect width="12" height="8" x="6" y="14" />
                        </svg>
                        Imprimir
                    </a>
                </div>
                <!-- End Buttons -->
            </div>
            <!-- End Card -->

        </div>

    </div>

    <!-- End Invoice -->
</div>
