<div class="flex flex-col min-h-[calc(100vh-4rem)] pb-3 pl-6 pr-6 bg-white dark:bg-gray-600 border border-gray-300 dark:border-gray-100 rounded-md shadow-md shadow-black/5">
    <div x-init="$dispatch('bradcrumb', { menu: ['Configurações', 'DIDs'] })"></div>

    <div class="container flex-grow mx-auto">
        <div class="flex flex-col items-center justify-between my-4 sm:flex-row">
            <h3 class="mb-4 text-2xl font-bold text-gray-800 dark:text-gray-200 sm:mb-0">
                Gestão de DIDs por Cliente
            </h3>
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
            </div>
        </div>

        {{-- Summary Cards --}}
        <div class="grid grid-cols-1 gap-4 mb-6 md:grid-cols-2 lg:grid-cols-4">
            {{-- Total Clientes --}}
            <div class="relative overflow-hidden bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg shadow-lg">
                <div class="p-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-blue-100">Clientes Ativos</p>
                            <p class="text-3xl font-bold text-white">{{ number_format($stats->total_clientes, 0, ',', '.') }}</p>
                        </div>
                        <div class="p-3 bg-white bg-opacity-30 rounded-lg">
                            <x-ui-icon name="user-group" class="w-8 h-8 text-white" />
                        </div>
                    </div>
                </div>
            </div>

            {{-- Total DIDs --}}
            <div class="relative overflow-hidden bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg shadow-lg">
                <div class="p-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-purple-100">Total de DIDs</p>
                            <p class="text-3xl font-bold text-white">{{ number_format($stats->total_dids, 0, ',', '.') }}</p>
                        </div>
                        <div class="p-3 bg-white bg-opacity-30 rounded-lg">
                            <x-ui-icon name="hashtag" class="w-8 h-8 text-white" />
                        </div>
                    </div>
                </div>
            </div>

            {{-- DIDs Ativos --}}
            <div class="relative overflow-hidden bg-gradient-to-br from-green-500 to-green-600 rounded-lg shadow-lg">
                <div class="p-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-green-100">DIDs Ativos</p>
                            <p class="text-3xl font-bold text-white">{{ number_format($stats->dids_ativos, 0, ',', '.') }}</p>
                        </div>
                        <div class="p-3 bg-white bg-opacity-30 rounded-lg">
                            <x-ui-icon name="check-circle" class="w-8 h-8 text-white" />
                        </div>
                    </div>
                </div>
            </div>

            {{-- DIDs Inativos --}}
            <div class="relative overflow-hidden bg-gradient-to-br from-red-500 to-red-600 rounded-lg shadow-lg">
                <div class="p-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-red-100">DIDs Inativos</p>
                            <p class="text-3xl font-bold text-white">{{ number_format($stats->dids_inativos, 0, ',', '.') }}</p>
                        </div>
                        <div class="p-3 bg-white bg-opacity-30 rounded-lg">
                            <x-ui-icon name="x-circle" class="w-8 h-8 text-white" />
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
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    {{-- Status Filter --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Status do Cliente</label>
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

        <!-- Search -->
        <div class="mb-6">
            <input type="text" wire:model.live.debounce.300ms="search"
                   placeholder="Buscar cliente por nome, razão social ou CNPJ..."
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
        </div>

        <!-- Tabela de Clientes -->
        <div class="overflow-x-auto bg-white shadow-md dark:bg-gray-800 rounded-lg">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b-2 border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700">
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Cliente</th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Cidade/UF</th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Total DIDs</th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">DIDs Ativos</th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">DIDs Inativos</th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($customers as $customer)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-150">
                            <td class="px-6 py-4">
                                <div class="flex flex-col">
                                    <p class="font-semibold text-gray-900 dark:text-gray-100">
                                        {{ $customer->nomefantasia ?? $customer->razaosocial }}
                                    </p>
                                    @if($customer->nomefantasia && $customer->razaosocial != $customer->nomefantasia)
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $customer->razaosocial }}</p>
                                    @endif
                                    @if($customer->cnpj)
                                        <p class="text-xs text-gray-500 dark:text-gray-400 font-mono mt-1">
                                            {{ preg_replace('/^(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})$/', '$1.$2.$3/$4-$5', $customer->cnpj) }}
                                        </p>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="text-sm">
                                    <div class="font-medium text-gray-900 dark:text-gray-100">{{ $customer->cidade ?? '-' }}</div>
                                    <div class="text-gray-500 dark:text-gray-400 text-xs">{{ $customer->uf ?? '-' }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200">
                                    <x-ui-icon name="hashtag" class="w-3 h-3 mr-1" />
                                    {{ $customer->dids_count }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                    <x-ui-icon name="check-circle" class="w-3 h-3 mr-1" />
                                    {{ $customer->dids_ativos_count }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                @php
                                    $didsInativos = $customer->dids_count - $customer->dids_ativos_count;
                                @endphp
                                @if($didsInativos > 0)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                        <x-ui-icon name="x-circle" class="w-3 h-3 mr-1" />
                                        {{ $didsInativos }}
                                    </span>
                                @else
                                    <span class="text-gray-400 dark:text-gray-500 text-sm">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                <a href="{{ route('customers.dids', $customer->id) }}"
                                   class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-gradient-to-r from-blue-600 to-blue-700 rounded-lg hover:from-blue-700 hover:to-blue-800 shadow-sm hover:shadow-md transition-all duration-150">
                                    <x-ui-icon name="cog-6-tooth" class="w-4 h-4 mr-2" />
                                    Gerenciar DIDs
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-16 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <x-ui-icon name="magnifying-glass" class="w-16 h-16 text-gray-300 dark:text-gray-600 mb-4" />
                                    <p class="text-lg font-medium text-gray-500 dark:text-gray-400">Nenhum cliente encontrado</p>
                                    <p class="text-sm text-gray-400 dark:text-gray-500 mt-2">Tente ajustar os filtros ou a busca</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $customers->links('vendor.livewire.paginate') }}
        </div>
    </div>
</div>
