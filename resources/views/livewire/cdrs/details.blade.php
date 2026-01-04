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
