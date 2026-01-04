<div
    class="flex flex-col min-h-[calc(100vh-4rem)] pb-3 pl-6 pr-6 bg-white dark:bg-gray-600 border border-gray-300 dark:border-gray-100 rounded-md shadow-md shadow-black/5">
    <div class="container flex-grow mx-auto">
        <div class="flex flex-col items-center justify-between my-4 sm:flex-row">
            <h3 class="mb-4 text-2xl font-bold text-gray-800 dark:text-gray-200 sm:mb-0">Lista de Tarifas</h3>
            <div class="flex flex-wrap gap-2 mt-4 sm:mt-0">
                <button wire:click="clearFilters"
                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600 dark:hover:bg-gray-600">
                    <x-ui-icon name="x-mark" class="w-4 h-4 mr-2" />
                    Limpar
                </button>
                <button wire:click="openFilterModal"
                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600 dark:hover:bg-gray-600">
                    <x-ui-icon name="adjustments-horizontal" class="w-4 h-4 mr-2" />
                    Filtros
                </button>
                <x-buttons.group btnCreate="rate-create" />
            </div>
        </div>

        {{-- Summary Cards --}}
        <div class="grid grid-cols-1 gap-4 mb-6 md:grid-cols-2 lg:grid-cols-4">
            {{-- Total Tarifas --}}
            <div class="relative overflow-hidden bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg shadow-lg">
                <div class="p-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-blue-100">Total de Tarifas</p>
                            <p class="text-3xl font-bold text-white">{{ number_format($stats->total, 0, ',', '.') }}</p>
                        </div>
                        <div class="p-3 bg-white bg-opacity-30 rounded-lg">
                            <x-ui-icon name="currency-dollar" class="w-8 h-8 text-white" />
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tarifas Ativas --}}
            <div class="relative overflow-hidden bg-gradient-to-br from-green-500 to-green-600 rounded-lg shadow-lg">
                <div class="p-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-green-100">Tarifas Ativas</p>
                            <p class="text-3xl font-bold text-white">{{ number_format($stats->ativos, 0, ',', '.') }}</p>
                        </div>
                        <div class="p-3 bg-white bg-opacity-30 rounded-lg">
                            <x-ui-icon name="check-circle" class="w-8 h-8 text-white" />
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tarifas Inativas --}}
            <div class="relative overflow-hidden bg-gradient-to-br from-red-500 to-red-600 rounded-lg shadow-lg">
                <div class="p-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-red-100">Tarifas Inativas</p>
                            <p class="text-3xl font-bold text-white">{{ number_format($stats->inativos, 0, ',', '.') }}</p>
                        </div>
                        <div class="p-3 bg-white bg-opacity-30 rounded-lg">
                            <x-ui-icon name="x-circle" class="w-8 h-8 text-white" />
                        </div>
                    </div>
                </div>
            </div>

            {{-- Operadoras com Tarifas --}}
            <div class="relative overflow-hidden bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg shadow-lg">
                <div class="p-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-purple-100">Operadoras com Tarifas</p>
                            <p class="text-3xl font-bold text-white">{{ number_format($stats->carriers, 0, ',', '.') }}</p>
                        </div>
                        <div class="p-3 bg-white bg-opacity-30 rounded-lg">
                            <x-ui-icon name="building-office-2" class="w-8 h-8 text-white" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Filter Modal --}}
        <x-ui-modal wire="filterModal" size="xl">
            <x-slot:title>
                <span class="text-xl font-bold">Filtros Avançados</span>
            </x-slot:title>

            <div class="space-y-4">
                <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                    {{-- Status Filter --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Status</label>
                        <select wire:model.live="filterStatus"
                            class="w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-cyan-500">
                            <option value="">Todos</option>
                            <option value="1">Ativos</option>
                            <option value="0">Inativos</option>
                        </select>
                    </div>

                    {{-- Tarifa Filter --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Tipo de Tarifa</label>
                        <select wire:model.live="filterTarifa"
                            class="w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-cyan-500">
                            <option value="">Todas</option>
                            @foreach($tarifas as $tarifa)
                                <option value="{{ $tarifa }}">{{ $tarifa }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Carrier Filter --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Operadora</label>
                        <select wire:model.live="filterCarrier"
                            class="w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-cyan-500">
                            <option value="">Todas</option>
                            @foreach($carriers as $carrier)
                                <option value="{{ $carrier['value'] }}">{{ $carrier['label'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <x-slot:footer>
                <div class="flex justify-end gap-2">
                    <x-ui-button color="stone" wire:click="$set('filterModal', false)">
                        Fechar
                    </x-ui-button>
                    <x-ui-button color="red" wire:click="clearFilters">
                        Limpar Filtros
                    </x-ui-button>
                </div>
            </x-slot:footer>
        </x-ui-modal>

        <div class="overflow-x-auto bg-white shadow-md dark:bg-gray-800 rounded-lg">
            <x-tables.table>

                <x-slot name=header>
                    <x-tables.th label="Status" />
                    <x-tables.th label="Prefixo" column="prefixo" :direction="$direction" :sort="$sort" />
                    <x-tables.th label="Tarifa" column="tarifa" :direction="$direction" :sort="$sort" />
                    <x-tables.th label="Operadora" column="carrier_id" :direction="$direction" :sort="$sort" />
                    <x-tables.th label="Descrição" column="descricao" :direction="$direction" :sort="$sort" />
                    <x-tables.th label="Cadência" />
                    <x-tables.th label="Compra" column="compra" :direction="$direction" :sort="$sort" />
                    <x-tables.th label="Venda" column="venda" :direction="$direction" :sort="$sort" />
                    <x-tables.th label="Margem" />
                    <x-tables.th label="Ações" />
                </x-slot>

                <x-slot name=body>
                    @forelse ($rates as $rate)
                        <x-tables.tr>
                            <x-tables.td class="py-3">
                                @if($rate->ativo)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100">
                                        <x-ui-icon name="check-circle" class="w-3 h-3 mr-1" />
                                        Ativo
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">
                                        <x-ui-icon name="x-circle" class="w-3 h-3 mr-1" />
                                        Inativo
                                    </span>
                                @endif
                            </x-tables.td>
                            <x-tables.td class="py-3">
                                <span class="font-mono font-semibold text-gray-900 dark:text-gray-100">{{ $rate->prefixo }}</span>
                            </x-tables.td>
                            <x-tables.td class="py-3">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    {{ $rate->tarifa === 'Fixo' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200' : '' }}
                                    {{ $rate->tarifa === 'Movel' ? 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200' : '' }}
                                    {{ $rate->tarifa === 'Internacional' ? 'bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200' : '' }}
                                    {{ !in_array($rate->tarifa, ['Fixo', 'Movel', 'Internacional']) ? 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300' : '' }}">
                                    {{ $rate->tarifa }}
                                </span>
                            </x-tables.td>
                            <x-tables.td class="py-3">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-medium bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200">
                                    <x-ui-icon name="building-office-2" class="w-3 h-3 mr-1" />
                                    {{ $rate->carrier->operadora }}
                                </span>
                            </x-tables.td>
                            <x-tables.td class="py-3">
                                <span class="text-sm text-gray-700 dark:text-gray-300">{{ $rate->descricao ?: '-' }}</span>
                            </x-tables.td>
                            <x-tables.td class="py-3">
                                <div class="flex items-center gap-1 text-xs text-gray-600 dark:text-gray-400 font-mono">
                                    <span class="px-1.5 py-0.5 bg-gray-100 dark:bg-gray-700 rounded">{{ $rate->tempoinicial }}s</span>
                                    <span>/</span>
                                    <span class="px-1.5 py-0.5 bg-gray-100 dark:bg-gray-700 rounded">{{ $rate->tempominimo }}s</span>
                                    <span>/</span>
                                    <span class="px-1.5 py-0.5 bg-gray-100 dark:bg-gray-700 rounded">{{ $rate->incremento }}s</span>
                                </div>
                            </x-tables.td>
                            <x-tables.td class="py-3">
                                <span class="inline-flex items-center px-2 py-1 rounded-md text-sm font-semibold bg-red-50 text-red-700 dark:bg-red-900 dark:text-red-200">
                                    R$ {{ number_format($rate->compra, 4, ',', '.') }}
                                </span>
                            </x-tables.td>
                            <x-tables.td class="py-3">
                                <span class="inline-flex items-center px-2 py-1 rounded-md text-sm font-semibold bg-green-50 text-green-700 dark:bg-green-900 dark:text-green-200">
                                    R$ {{ number_format($rate->venda, 4, ',', '.') }}
                                </span>
                            </x-tables.td>
                            <x-tables.td class="py-3">
                                @php
                                    $margem = $rate->compra > 0 ? (($rate->venda - $rate->compra) / $rate->compra) * 100 : 0;
                                    $margemColor = $margem >= 30 ? 'green' : ($margem >= 15 ? 'yellow' : 'red');
                                @endphp
                                <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-semibold
                                    {{ $margemColor === 'green' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : '' }}
                                    {{ $margemColor === 'yellow' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200' : '' }}
                                    {{ $margemColor === 'red' ? 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' : '' }}">
                                    {{ number_format($margem, 1, ',', '.') }}%
                                </span>
                            </x-tables.td>
                            <x-tables.td class="py-3">
                                <div class="flex items-center gap-3">
                                    <span x-on:click="$dispatch('rate-update', {{ $rate }})"
                                        wire:key='update-{{ $rate->id }}'
                                        class="inline-flex items-center font-medium text-yellow-500 transition cursor-pointer hover:text-yellow-700 dark:text-yellow-400 dark:hover:text-yellow-300">
                                        <x-ui-icon name="pencil-square" class="w-5 h-5 m-0" />
                                        <span class="ml-1">Editar</span>
                                    </span>

                                    <span x-on:click="$dispatch('rate-delete', {{ $rate }})"
                                        wire:key='delete-{{ $rate->id }}'
                                        class="inline-flex items-center font-medium text-red-500 transition cursor-pointer hover:text-red-700 dark:text-red-400 dark:hover:text-red-300">
                                        <x-ui-icon name="trash" class="w-5 h-5 m-0" />
                                        <span class="ml-1">Excluir</span>
                                    </span>
                                </div>
                            </x-tables.td>
                        </x-tables.tr>

                    @empty
                        <tr>
                            <td colspan="10" class="px-6 py-16 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <x-ui-icon name="magnifying-glass" class="w-16 h-16 text-gray-300 dark:text-gray-600 mb-4" />
                                    <p class="text-lg font-medium text-gray-500 dark:text-gray-400">Nenhuma tarifa encontrada</p>
                                    <p class="text-sm text-gray-400 dark:text-gray-500 mt-2">Tente ajustar os filtros ou a busca</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </x-slot>
            </x-tables.table>

        </div>
    </div>
    {{ $rates->links('vendor.livewire.paginate') }}
    <livewire:rates.create />
    <livewire:rates.update />
    <livewire:rates.delete />
</div>
