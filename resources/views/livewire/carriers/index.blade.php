<div
    class="flex flex-col min-h-[calc(100vh-4rem)] pb-3 pl-6 pr-6 bg-white dark:bg-gray-600 border border-gray-300 dark:border-gray-100 rounded-md shadow-md shadow-black/5">
    <div class="container flex-grow mx-auto">
        <div class="flex flex-col items-center justify-between my-4 sm:flex-row">
            <h3 class="mb-4 text-2xl font-bold text-gray-800 dark:text-gray-200 sm:mb-0">Lista de Operadoras</h3>
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
                <x-buttons.group btnCreate="carrier-create" />
            </div>
        </div>

        {{-- Summary Cards --}}
        <div class="grid grid-cols-1 gap-4 mb-6 md:grid-cols-2 lg:grid-cols-4">
            {{-- Total Operadoras --}}
            <div class="relative overflow-hidden bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg shadow-lg">
                <div class="p-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-blue-100">Total de Operadoras</p>
                            <p class="text-3xl font-bold text-white">{{ number_format($stats->total, 0, ',', '.') }}</p>
                        </div>
                        <div class="p-3 bg-white bg-opacity-30 rounded-lg">
                            <x-ui-icon name="building-office-2" class="w-8 h-8 text-white" />
                        </div>
                    </div>
                </div>
            </div>

            {{-- Operadoras Ativas --}}
            <div class="relative overflow-hidden bg-gradient-to-br from-green-500 to-green-600 rounded-lg shadow-lg">
                <div class="p-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-green-100">Operadoras Ativas</p>
                            <p class="text-3xl font-bold text-white">{{ number_format($stats->ativos, 0, ',', '.') }}</p>
                        </div>
                        <div class="p-3 bg-white bg-opacity-30 rounded-lg">
                            <x-ui-icon name="check-circle" class="w-8 h-8 text-white" />
                        </div>
                    </div>
                </div>
            </div>

            {{-- Operadoras Inativas --}}
            <div class="relative overflow-hidden bg-gradient-to-br from-red-500 to-red-600 rounded-lg shadow-lg">
                <div class="p-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-red-100">Operadoras Inativas</p>
                            <p class="text-3xl font-bold text-white">{{ number_format($stats->inativos, 0, ',', '.') }}</p>
                        </div>
                        <div class="p-3 bg-white bg-opacity-30 rounded-lg">
                            <x-ui-icon name="x-circle" class="w-8 h-8 text-white" />
                        </div>
                    </div>
                </div>
            </div>

            {{-- Total de Canais --}}
            <div class="relative overflow-hidden bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg shadow-lg">
                <div class="p-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-purple-100">Total de Canais Ativos</p>
                            <p class="text-3xl font-bold text-white">{{ number_format($stats->canais_total, 0, ',', '.') }}</p>
                        </div>
                        <div class="p-3 bg-white bg-opacity-30 rounded-lg">
                            <x-ui-icon name="signal" class="w-8 h-8 text-white" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Search -->
        <div class="mb-6">
            <input type="text" wire:model.live.debounce.300ms="search"
                   placeholder="Ramal, Nome, Email"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
        </div>

        {{-- Filter Modal --}}
        <x-ui-modal wire="filterModal" size="xl">
            <x-slot:title>
                <span class="text-xl font-bold">Filtros Avançados</span>
            </x-slot:title>

            <div class="space-y-4">
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
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

                    {{-- Franquia Compartilhada Filter --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Franquia Compartilhada</label>
                        <select wire:model.live="filterFranquiaCompartilhada"
                            class="w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-cyan-500">
                            <option value="">Todos</option>
                            <option value="1">Sim</option>
                            <option value="0">Não</option>
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
                    <x-tables.th label="Contrato" column="id" :direction="$direction" :sort="$sort" />
                    <x-tables.th label="Operadora" column="operadora" :direction="$direction" :sort="$sort" />
                    <x-tables.th label="Proxy/Porta" />
                    <x-tables.th label="Canais" column="canais" :direction="$direction" :sort="$sort" />
                    <x-tables.th label="Valor Mensal" column="valor_plano_mensal" :direction="$direction" :sort="$sort" />
                    <x-tables.th label="Data Inicial" column="data_inicio" :direction="$direction" :sort="$sort" />
                    <x-tables.th label="Status" column="ativo" :direction="$direction" :sort="$sort" />
                    <x-tables.th label="Ações" />
                </x-slot>

                <x-slot name=body>
                    @forelse ($carriers as $carrier)
                        <x-tables.tr>
                            <x-tables.td class="py-2">
                                <span class="font-semibold text-gray-700 dark:text-gray-300">{{ $carrier->id }}</span>
                            </x-tables.td>
                            <x-tables.td class="py-2">
                                <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                    {{ $carrier->operadora }}
                                </div>
                            </x-tables.td>
                            <x-tables.td class="py-2">
                                <div class="text-sm">
                                    <div class="font-mono text-gray-900 dark:text-gray-100">{{ $carrier->proxy }}</div>
                                    <div class="text-gray-500 dark:text-gray-400">Porta: {{ $carrier->porta }}</div>
                                </div>
                            </x-tables.td>
                            <x-tables.td class="py-2">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                    {{ $carrier->canais }} canais
                                </span>
                            </x-tables.td>
                            <x-tables.td class="py-2">
                                <div class="text-sm">
                                    <div class="font-semibold text-green-600 dark:text-green-400">
                                        R$ {{ number_format($carrier->valor_plano_mensal, 2, ',', '.') }}
                                    </div>
                                    @if($carrier->franquia_compartilhada)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200">
                                            <x-ui-icon name="share" class="w-3 h-3 mr-1" />
                                            Franquia Compartilhada
                                        </span>
                                    @endif
                                </div>
                            </x-tables.td>
                            <x-tables.td class="py-2">
                                <span class="text-sm text-gray-700 dark:text-gray-300">
                                    {{ date('d/m/Y', strtotime($carrier->data_inicio)) }}
                                </span>
                            </x-tables.td>
                            <x-tables.td class="py-2">
                                @if($carrier->ativo)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                        <x-ui-icon name="check-circle" class="w-3 h-3 mr-1" />
                                        Ativo
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                        <x-ui-icon name="x-circle" class="w-3 h-3 mr-1" />
                                        Inativo
                                    </span>
                                @endif
                            </x-tables.td>
                            <x-tables.td class="py-0">

                                <span x-on:click="$dispatch('carrier-update', {{ $carrier }})"
                                    wire:key='update-{{ $carrier->id }}'
                                    class="inline-flex items-center font-medium text-yellow-500 transition cursor-pointer hover:text-yellow-700 duration- dark:text-yellow-500">
                                    <x-ui-icon name="pencil-square" class="w-5 h-5 m-0" />
                                    <span class="ml-1">Editar</span>
                                </span>

                                <span x-on:click="$dispatch('carrier-delete', {{ $carrier }})"
                                    wire:key='delete-{{ $carrier->id }}'
                                    class="inline-flex items-center ml-4 font-medium text-red-500 transition cursor-pointer hover:text-red-700 duration- dark:text-red-500">
                                    <x-ui-icon name="trash" class="w-5 h-5 m-0" />
                                    <span class="ml-1">Excluir</span>
                                </span>

                            </x-tables.td>
                        </x-tables.tr>

                    @empty
                        <x-empty-state
                            colspan="8"
                            icon="building-office-2"
                            message="Nenhuma operadora encontrada"
                            hint="Tente ajustar os filtros ou cadastrar uma nova operadora"
                        />
                    @endforelse
                </x-slot>
            </x-tables.table>

        </div>
    </div>
    {{ $carriers->links('vendor.livewire.paginate') }}
    <livewire:carriers.create />
    <livewire:carriers.update />
    <livewire:carriers.delete />
</div>
