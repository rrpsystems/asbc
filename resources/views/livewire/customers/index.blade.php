<div
    class="flex flex-col min-h-[calc(100vh-4rem)] pb-3 pl-6 pr-6 bg-white dark:bg-gray-600 border border-gray-300 dark:border-gray-100 rounded-md shadow-md shadow-black/5">
    <div class="container flex-grow mx-auto">
        <div class="flex flex-col items-center justify-between my-4 sm:flex-row">
            <h3 class="mb-4 text-2xl font-bold text-gray-800 dark:text-gray-200 sm:mb-0">Lista de Clientes</h3>
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
                <x-buttons.group btnCreate="customer-create" />
            </div>
        </div>

        {{-- Summary Cards --}}
        <div class="grid grid-cols-1 gap-4 mb-6 md:grid-cols-2 lg:grid-cols-4">
            {{-- Total Clientes --}}
            <div class="relative overflow-hidden bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg shadow-lg">
                <div class="p-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-blue-100">Total de Clientes</p>
                            <p class="text-3xl font-bold text-white">{{ number_format($stats->total, 0, ',', '.') }}</p>
                        </div>
                        <div class="p-3 bg-white bg-opacity-30 rounded-lg">
                            <x-ui-icon name="user-group" class="w-8 h-8 text-white" />
                        </div>
                    </div>
                </div>
            </div>

            {{-- Clientes Ativos --}}
            <div class="relative overflow-hidden bg-gradient-to-br from-green-500 to-green-600 rounded-lg shadow-lg">
                <div class="p-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-green-100">Clientes Ativos</p>
                            <p class="text-3xl font-bold text-white">{{ number_format($stats->ativos, 0, ',', '.') }}</p>
                        </div>
                        <div class="p-3 bg-white bg-opacity-30 rounded-lg">
                            <x-ui-icon name="check-circle" class="w-8 h-8 text-white" />
                        </div>
                    </div>
                </div>
            </div>

            {{-- Clientes Inativos --}}
            <div class="relative overflow-hidden bg-gradient-to-br from-red-500 to-red-600 rounded-lg shadow-lg">
                <div class="p-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-red-100">Clientes Inativos</p>
                            <p class="text-3xl font-bold text-white">{{ number_format($stats->inativos, 0, ',', '.') }}</p>
                        </div>
                        <div class="p-3 bg-white bg-opacity-30 rounded-lg">
                            <x-ui-icon name="x-circle" class="w-8 h-8 text-white" />
                        </div>
                    </div>
                </div>
            </div>

            {{-- Clientes Bloqueados --}}
            <div class="relative overflow-hidden bg-gradient-to-br from-orange-500 to-orange-600 rounded-lg shadow-lg">
                <div class="p-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-orange-100">Clientes Bloqueados</p>
                            <p class="text-3xl font-bold text-white">{{ number_format($stats->bloqueados, 0, ',', '.') }}</p>
                        </div>
                        <div class="p-3 bg-white bg-opacity-30 rounded-lg">
                            <x-ui-icon name="lock-closed" class="w-8 h-8 text-white" />
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

                    {{-- UF Filter --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Estado (UF)</label>
                        <select wire:model.live="filterUf"
                            class="w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-cyan-500">
                            <option value="">Todos os Estados</option>
                            @foreach($ufs as $uf)
                                <option value="{{ $uf }}">{{ $uf }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Bloqueio Filter --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Bloqueio</label>
                        <select wire:model.live="filterBloqueio"
                            class="w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-cyan-500">
                            <option value="">Todos</option>
                            <option value="1">Bloqueados</option>
                            <option value="0">Não Bloqueados</option>
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

        <div class="overflow-x-auto bg-white shadow-md dark:bg-gray-800">
            <x-tables.table>

                <x-slot name=header>
                    <x-tables.th label="Contrato" column="id" :direction="$direction" :sort="$sort" />
                    <x-tables.th label="Cliente" column="razaosocial" :direction="$direction" :sort="$sort" />
                    <x-tables.th label="CNPJ" column="cnpj" :direction="$direction" :sort="$sort" />
                    <x-tables.th label="Revenda" column="reseller_id" :direction="$direction" :sort="$sort" />
                    <x-tables.th label="Cidade/UF" column="cidade" :direction="$direction" :sort="$sort" />
                    <x-tables.th label="Valor" column="valor_plano" :direction="$direction" :sort="$sort" />
                    <x-tables.th label="Canais" column="canais" :direction="$direction" :sort="$sort" />
                    <x-tables.th label="Minutos" column="franquia_minutos" :direction="$direction" :sort="$sort" />
                    <x-tables.th label="Status" column="ativo" :direction="$direction" :sort="$sort" />
                    <x-tables.th label="Ações" />
                </x-slot>

                <x-slot name=body>
                    @forelse ($customers as $customer)
                        <x-tables.tr>
                            <x-tables.td class="py-2">
                                <span class="font-semibold text-gray-700 dark:text-gray-300">{{ $customer->id }}</span>
                            </x-tables.td>
                            <x-tables.td class="py-2">
                                <div class="text-sm">
                                    <div class="font-medium text-gray-900 dark:text-gray-100">
                                        {{ Str::limit($customer->nomefantasia ?? $customer->razaosocial, 30) }}
                                    </div>
                                    @if($customer->nomefantasia && $customer->razaosocial && $customer->nomefantasia !== $customer->razaosocial)
                                        <div class="text-gray-500 dark:text-gray-400">
                                            {{ Str::limit($customer->razaosocial, 30) }}
                                        </div>
                                    @endif
                                </div>
                            </x-tables.td>
                            <x-tables.td class="py-2">
                                <span class="font-mono text-sm">
                                    {{ preg_replace('/^(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})$/', '$1.$2.$3/$4-$5', $customer->cnpj) }}
                                </span>
                            </x-tables.td>
                            <x-tables.td class="py-2">
                                @if($customer->reseller)
                                    <div class="text-sm">
                                        <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                            </svg>
                                            {{ Str::limit($customer->reseller->nome, 20) }}
                                        </span>
                                    </div>
                                @else
                                    <span class="text-xs text-gray-400 dark:text-gray-500">Direto</span>
                                @endif
                            </x-tables.td>
                            <x-tables.td class="py-2">
                                <div class="text-sm">
                                    <div class="text-gray-900 dark:text-gray-100">{{ $customer->cidade }}</div>
                                    <div class="text-gray-500 dark:text-gray-400">{{ $customer->uf }}</div>
                                </div>
                            </x-tables.td>
                            <x-tables.td class="py-2">
                                <span class="font-semibold text-green-600 dark:text-green-400">
                                    R$ {{ number_format($customer->valor_plano, 2, ',', '.') }}
                                </span>
                            </x-tables.td>
                            <x-tables.td class="py-2">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                    {{ $customer->canais }} canais
                                </span>
                            </x-tables.td>
                            <x-tables.td class="py-2">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200">
                                    {{ number_format($customer->franquia_minutos, 0, ',', '.') }} min
                                </span>
                            </x-tables.td>
                            <x-tables.td class="py-2">
                                <div class="flex flex-col gap-1">
                                    @if($customer->ativo)
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

                                    @if($customer->bloqueio_entrada || $customer->bloqueio_saida)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200">
                                            <x-ui-icon name="lock-closed" class="w-3 h-3 mr-1" />
                                            @if($customer->bloqueio_entrada && $customer->bloqueio_saida)
                                                Bloq. Total
                                            @elseif($customer->bloqueio_entrada)
                                                Bloq. Entrada
                                            @else
                                                Bloq. Saída
                                            @endif
                                        </span>
                                    @endif
                                </div>
                            </x-tables.td>
                            <x-tables.td class="py-0">

                                <span x-on:click="$dispatch('customer-update', {{ $customer }})"
                                    wire:key='update-{{ $customer->id }}'
                                    class="inline-flex items-center font-medium text-yellow-500 transition cursor-pointer hover:text-yellow-700 duration- dark:text-yellow-500">
                                    <x-ui-icon name="pencil-square" class="w-5 h-5 m-0" />
                                    <span class="ml-1">Editar</span>
                                </span>

                                <span x-on:click="$dispatch('customer-delete', {{ $customer }})"
                                    wire:key='delete-{{ $customer->id }}'
                                    class="inline-flex items-center ml-4 font-medium text-red-500 transition cursor-pointer hover:text-red-700 duration- dark:text-red-500">
                                    <x-ui-icon name="trash" class="w-5 h-5 m-0" />
                                    <span class="ml-1">Excluir</span>
                                </span>

                            </x-tables.td>
                        </x-tables.tr>

                    @empty
                        <x-empty-state
                            colspan="8"
                            icon="users"
                            message="Nenhum cliente encontrado"
                            hint="Tente ajustar os filtros ou cadastrar um novo cliente"
                        />
                    @endforelse
                </x-slot>
            </x-tables.table>

        </div>
    </div>
    {{ $customers->links('vendor.livewire.paginate') }}
    <livewire:customers.create />
    <livewire:customers.update />
    <livewire:customers.delete />
</div>
