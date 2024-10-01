<div wire:poll.3000ms
    class="flex flex-col min-h-[calc(100vh-4rem)] pb-3 pl-6 pr-6 bg-white dark:bg-gray-600 border border-gray-300 dark:border-gray-100 rounded-md shadow-md shadow-black/5">
    <div class="container flex-grow mx-auto">
        <div class="flex flex-col items-center justify-between my-4 sm:flex-row">
            <h3 class="mb-4 text-2xl font-bold text-gray-800 dark:text-gray-200 sm:mb-0">Lista de cdrs</h3>
            <x-ui-button icon="filter" wire:click="openFilter" color="purple" position="left">Filtros</x-ui-button>
            {{-- <x-buttons.group btnCreate="cdr-create" /> --}}
        </div>
        <div class="overflow-x-auto bg-white shadow-md dark:bg-gray-800">
            <x-tables.table>

                <x-slot name=header>
                    <x-tables.th label="Data/Hora" column="id" :direction="$direction" :sort="$sort" />
                    <x-tables.th label="DID" column="did_id" :direction="$direction" :sort="$sort" />
                    <x-tables.th label="Cliente" column="customer_id" :direction="$direction" :sort="$sort" />
                    <x-tables.th label="Numero" column="numero" :direction="$direction" :sort="$sort" />
                    <x-tables.th label="Tarifa" column="tarifa" :direction="$direction" :sort="$sort" />
                    <x-tables.th label="T. Cobra" column="tempo_cobrado" :direction="$direction" :sort="$sort" />
                    <x-tables.th label="V. Compra" column="valor_compra" :direction="$direction" :sort="$sort" />
                    <x-tables.th label="V. Venda" column="valor_venda" :direction="$direction" :sort="$sort" />
                    <x-tables.th label="Ramal" column="ramal" :direction="$direction" :sort="$sort" />
                    <x-tables.th label="Duração" column="billsec" :direction="$direction" :sort="$sort" />
                    <x-tables.th label="Desconexão" column="desligamento" :direction="$direction" :sort="$sort" />
                    <x-tables.th label="status" />
                    <x-tables.th label="Detalhes" />
                </x-slot>

                <x-slot name=body>
                    @forelse ($cdrs as $cdr)
                        <x-tables.tr>
                            <x-tables.td class="py-2">{{ date('d/m/Y H:i', strtotime($cdr->calldate)) }}</x-tables.td>

                            <x-tables.td class="py-2">{{ $cdr->did_id }}</x-tables.td>

                            <x-tables.td
                                class="py-2">{{ Str::limit($cdr->customer->razaosocial ?? $cdr->customer_id, 20) }}</x-tables.td>

                            <x-tables.td class="py-2">{{ $cdr->numero }}</x-tables.td>

                            <x-tables.td class="py-2">{{ $cdr->tarifa }}</x-tables.td>
                            <x-tables.td
                                class="py-2">{{ \Carbon\Carbon::createFromFormat('U', $cdr->tempo_cobrado ?? '0')->format('H:i:s') }}</x-tables.td>
                            <x-tables.td
                                class="py-2">{{ number_format($cdr->valor_compra ?? '0', 3, ',', '.') }}</x-tables.td>
                            <x-tables.td
                                class="py-2">{{ number_format($cdr->valor_venda ?? '0', 3, ',', '.') }}</x-tables.td>

                            <x-tables.td class="py-2">{{ $cdr->ramal }}</x-tables.td>

                            <x-tables.td class="py-2">
                                {{ \Carbon\Carbon::createFromFormat('U', $cdr->billsec ?? '0')->format('H:i:s') }}
                            </x-tables.td>

                            <x-tables.td class="py-2">{{ $cdr->desligamento }}</x-tables.td>

                            <x-tables.td class="py-2">{{ $cdr->status }}</x-tables.td>
                            <x-tables.td class="py-2" wire:click="openDetails({{ $cdr->id }})"
                                wire:key='{{ $cdr->uniqueid }}'>
                                <x-ui-icon name="eye-check"
                                    class="cursor-pointer hover:text-gray-100 dark:hover:text-blue-500" /></x-tables.td>

                        </x-tables.tr>

                    @empty
                        <x-tables.td class="py-2"></x-tables.td>
                        <x-tables.td class="py-2"></x-tables.td>
                        <x-tables.td class="py-2"></x-tables.td>
                        <x-tables.td class="py-2"> Sem Dados</x-tables.td>
                        <x-tables.td class="py-2"></x-tables.td>
                        <x-tables.td class="py-2"></x-tables.td>
                        <x-tables.td class="py-2"></x-tables.td>
                    @endforelse
                </x-slot>
            </x-tables.table>

        </div>
    </div>
    {{ $cdrs->links('vendor.livewire.paginate') }}
    @include('livewire.cdrs.filter')

    @include('livewire.cdrs.details')
</div>
