<x-ui-modal title="Detalhes da Chamada" size="4xl" persistent wire="detailsModal">
    <div class="space-y-3 min-h-72">
        <div class="grid grid-cols-3 gap-3">

            <div class="col-span-3">
                <strong class="font-semibold text-gray-900 dark:text-white">Cliente:</strong>
                {{ $details->customer->razaosocial ?? '' }}
            </div>

            <div class="col-span-3">
                <strong class="font-semibold text-gray-900 dark:text-white">Operadora:</strong>
                {{ $details->carrier->operadora ?? '' }}
            </div>

            <div class="col-span-1">
                <strong class="font-semibold text-gray-900 dark:text-white"><span
                        class="text-strong">Data:</strong></span>
                {{ date('d/m/Y', strtotime($details->calldate ?? '0')) }}
            </div>

            <div class="col-span-1">
                <strong class="font-semibold text-gray-900 dark:text-white">Hora:</strong>
                {{ date('H:i:s', strtotime($details->calldate ?? '0')) }}
            </div>

            <div class="col-span-1">
            </div>

            <div class="col-span-1">
                <strong class="font-semibold text-gray-900 dark:text-white">DID:</strong> {{ $details->did_id ?? '' }}
            </div>

            <div class="col-span-1">
                <strong class="font-semibold text-gray-900 dark:text-white">Numero:</strong>
                {{ $details->numero ?? '' }}
            </div>

            <div class="col-span-1">
                <strong class="font-semibold text-gray-900 dark:text-white">Ramal:</strong> {{ $details->ramal ?? '' }}
            </div>

            <div class="col-span-1">
                <strong class="font-semibold text-gray-900 dark:text-white">Tipo:</strong> {{ $details->tipo ?? '' }}
            </div>

            <div class="col-span-1">
                <strong class="font-semibold text-gray-900 dark:text-white">Tarifa:</strong>
                {{ $details->tarifa ?? '' }}
            </div>

            <div class="col-span-1">
                <strong class="font-semibold text-gray-900 dark:text-white">Disposição:</strong>
                {{ $details->disposition ?? '' }}
            </div>

            <div class="col-span-1">
                <strong class="font-semibold text-gray-900 dark:text-white">Duração:</strong>
                {{ \Carbon\Carbon::createFromFormat('U', $details->duration ?? '0')->format('H:i:s') }}
            </div>

            <div class="col-span-1">
                <strong class="font-semibold text-gray-900 dark:text-white">Tempo Falado:</strong>
                {{ \Carbon\Carbon::createFromFormat('U', $details->billsec ?? '0')->format('H:i:s') }}
            </div>

            <div class="col-span-1">
                <strong class="font-semibold text-gray-900 dark:text-white">Tempo Cobrado:</strong>
                {{ \Carbon\Carbon::createFromFormat('U', $details->tempo_cobrado ?? '0')->format('H:i:s') }}
            </div>

            <div class="col-span-1">
                <strong class="font-semibold text-gray-900 dark:text-white">Valor Compar:</strong> R$
                {{ number_format($details->valor_compra ?? '0', 2, ',', '.') }}
            </div>

            <div class="col-span-1">
                <strong class="font-semibold text-gray-900 dark:text-white">Valor Venda:</strong> R$
                {{ number_format($details->valor_venda ?? '0', 2, ',', '.') }}
            </div>

            <div class="col-span-1">
                <strong class="font-semibold text-gray-900 dark:text-white">Profit:</strong> R$
                {{ number_format(($details->valor_venda ?? '0') - ($details->valor_compra ?? '0'), 2, ',', '.') }}
            </div>


            <div class="col-span-1">
                <strong class="font-semibold text-gray-900 dark:text-white">Desconexão:</strong>
                {{ $details->desligamento ?? '' }}
            </div>

            <div class="col-span-1">
                <strong class="font-semibold text-gray-900 dark:text-white">Ch. Ocup. Cliente:</strong>
                {{ $details->customer_channels ?? '' }}
            </div>

            <div class="col-span-1">
                <strong class="font-semibold text-gray-900 dark:text-white">Ch. Ocup. Operadora:</strong>
                {{ $details->carrier_channels ?? '' }}
            </div>

            <div class="col-span-1">
                <strong class="font-semibold text-gray-900 dark:text-white">Qualidade TX:</strong>
                {{ $details->mes_tx ?? '' }}
            </div>

            <div class="col-span-1">
                <strong class="font-semibold text-gray-900 dark:text-white">Qualidade RX:</strong>
                {{ $details->mes_rx ?? '' }}
            </div>

            <div class="col-span-1">

            </div>

            <div class="col-span-1">
                <strong class="font-semibold text-gray-900 dark:text-white">IP SRC:</strong>
                {{ $details->ip_src ?? '' }}
            </div>

            <div class="col-span-1">
                <strong class="font-semibold text-gray-900 dark:text-white">IP DST:</strong>
                {{ $details->ip_dst ?? '' }}
            </div>

            <div class="col-span-1">

            </div>

            <div class="col-span-1">
                <strong class="font-semibold text-gray-900 dark:text-white">IP RTP SRC:</strong>
                {{ $details->ip_rtp_src ?? '' }}
            </div>

            <div class="col-span-1">
                <strong class="font-semibold text-gray-900 dark:text-white">IP RTP DST:</strong>
                {{ $details->ip_rtp_dst ?? '' }}
            </div>

            <div class="col-span-1">

            </div>

            <div class="col-span-1">
                <strong class="font-semibold text-gray-900 dark:text-white">Codec Nativo:</strong>
                {{ $details->codec_nativo ?? '' }}
            </div>

            <div class="col-span-1">
                <strong class="font-semibold text-gray-900 dark:text-white">Codec In:</strong>
                {{ $details->codec_in ?? '' }}
            </div>

            <div class="col-span-1">
                <strong class="font-semibold text-gray-900 dark:text-white">Codec Out:</strong>
                {{ $details->codec_out ?? '' }}
            </div>

            <div class="col-span-1">
                <strong class="font-semibold text-gray-900 dark:text-white">Status:</strong>
                {{ $details->status ?? '' }}
            </div>

            <div class="col-span-1">
                <strong class="font-semibold text-gray-900 dark:text-white">Causa ISDN:</strong>
                {{ $details->hangup ?? '' }}
            </div>

            <div class="col-span-1">
            </div>

            <div class="col-span-2">
                <strong class="font-semibold text-gray-900 dark:text-white">Gravação:</strong>
                {{ $details->recordingfile ?? '' }}
            </div>

            <div class="col-span-1">

            </div>

            <!-- Separador para Análise SIP/Q.850 -->
            @if($details && ($details->sip_code || $details->q850_cause || $details->failure_type))
                <div class="col-span-3 mt-4">
                    <div class="flex items-center">
                        <div class="flex-grow border-t border-gray-300 dark:border-gray-600"></div>
                        <span class="px-3 text-sm font-semibold text-gray-700 dark:text-gray-300">Análise de Qualidade</span>
                        <div class="flex-grow border-t border-gray-300 dark:border-gray-600"></div>
                    </div>
                </div>

                <!-- Código SIP -->
                @if($details->sip_code)
                    <div class="col-span-1">
                        <strong class="font-semibold text-gray-900 dark:text-white">Código SIP:</strong>
                        <span class="px-2 py-1 ml-2 text-xs font-mono font-bold rounded
                            {{ $details->sip_code == '200' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' :
                               (in_array($details->sip_code, ['486', '487']) ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200' :
                               'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200') }}">
                            {{ $details->sip_code }}
                        </span>
                    </div>

                    <div class="col-span-2">
                        <strong class="font-semibold text-gray-900 dark:text-white">Descrição SIP:</strong>
                        {{ $details->sip_reason ?? 'N/A' }}
                    </div>
                @endif

                <!-- Causa Q.850 -->
                @if($details->q850_cause)
                    <div class="col-span-1">
                        <strong class="font-semibold text-gray-900 dark:text-white">Causa Q.850:</strong>
                        <span class="px-2 py-1 ml-2 text-xs font-mono font-bold rounded
                            {{ $details->q850_cause == '16' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' :
                               (in_array($details->q850_cause, ['17', '19']) ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200' :
                               'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200') }}">
                            {{ $details->q850_cause }}
                        </span>
                    </div>

                    <div class="col-span-2">
                        <strong class="font-semibold text-gray-900 dark:text-white">Descrição Q.850:</strong>
                        {{ $details->q850_description ?? 'N/A' }}
                    </div>
                @endif

                <!-- Tipo de Falha -->
                @if($details->failure_type)
                    @php
                        $failureColors = [
                            'REDIRECT' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200',
                            'CLIENT_ERROR' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
                            'SERVER_ERROR' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
                            'GLOBAL_FAILURE' => 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200',
                        ];
                        $failureLabels = [
                            'REDIRECT' => 'Redirecionamento (3xx)',
                            'CLIENT_ERROR' => 'Erro do Cliente (4xx)',
                            'SERVER_ERROR' => 'Erro do Servidor (5xx)',
                            'GLOBAL_FAILURE' => 'Falha Global (6xx)',
                        ];
                    @endphp
                    <div class="col-span-3">
                        <strong class="font-semibold text-gray-900 dark:text-white">Tipo de Falha:</strong>
                        <span class="px-2 py-1 ml-2 text-xs font-semibold rounded {{ $failureColors[$details->failure_type] ?? 'bg-gray-100 text-gray-800' }}">
                            {{ $failureLabels[$details->failure_type] ?? $details->failure_type }}
                        </span>
                    </div>
                @endif

                <!-- Reason Header (se disponível) -->
                @if($details->reason_header)
                    <div class="col-span-3">
                        <strong class="font-semibold text-gray-900 dark:text-white">Reason Header:</strong>
                        <code class="block p-2 mt-1 text-xs bg-gray-100 dark:bg-gray-800 rounded">{{ $details->reason_header }}</code>
                    </div>
                @endif
            @endif

        </div>
    </div>

</x-ui-modal>


{{-- <div class="space-y-3 min-h-72">
    <div class="grid grid-cols-3 gap-3">

        <div class="col-span-1">
            <x-ui-number centralized min="1" max="30" label="Quantidade *" icon="phone-x-mark"
                wire:model='quantidade' />
        </div>
        <div class="col-span-1">
        </div>
        <div class="col-span-1">
        </div>


        <div class="col-span-2">
            <x-ui-input label="Numero" icon="phone" wire:model.live='did' />
        </div>

        <div class="col-span-1 pt-8 pl-3">
            <x-ui-toggle color="green" label="Ativo" position="left" wire:model='ativo' />
        </div>

        <div class="col-span-3">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Cliente *</label>
            <select wire:model.live="customer_id" class="w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-cyan-500">
                @foreach($customers as $customer)
                    <option value="{{ $customer['value'] }}">{{ $customer['label'] }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-span-3">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Operadora *</label>
            <select wire:model.live="carrier_id" class="w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-cyan-500">
                @foreach($carriers as $carrier)
                    <option value="{{ $carrier['value'] }}">{{ $carrier['label'] }}</option>
                @endforeach
            </select>
        </div>

        <div class="relative flex items-center justify-center col-span-3">
            <div class="flex items-center w-full">
                <div class="flex-grow border-t border-gray-500"></div>
                <span class="mx-4 text-gray-500">Configurações</span>
                <div class="flex-grow border-t border-gray-500"></div>
            </div>
        </div>

        <div class="col-span-3">
            <x-ui-input label="Tronco-Chave *" icon="arrow-trending-up" wire:model.live='encaminhamento' />
        </div>

        <div class="col-span-3">
            <span class="text-sm text-gray-500 text-nowrap">
                PJSIP/{{ preg_replace('/\D/', '', $encaminhamento ?? '') }}/sip:{{ preg_replace('/\D/', '', $did ?? '') }}{{ $ipvoip ?? '' }}
            </span>
        </div>
    </div>
</div> --}}
