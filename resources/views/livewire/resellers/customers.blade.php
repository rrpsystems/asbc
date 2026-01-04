<div class="p-6 space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Meus Clientes</h2>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ $reseller->nome }}</p>
        </div>
    </div>

    <!-- Estatísticas -->
    <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
        <div class="p-4 bg-white dark:bg-gray-800 rounded-lg shadow-sm">
            <div class="flex items-center">
                <div class="p-3 bg-blue-100 dark:bg-blue-900 rounded-lg">
                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Total</p>
                    <p class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ $stats['total'] }}</p>
                </div>
            </div>
        </div>

        <div class="p-4 bg-white dark:bg-gray-800 rounded-lg shadow-sm">
            <div class="flex items-center">
                <div class="p-3 bg-green-100 dark:bg-green-900 rounded-lg">
                    <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Ativos</p>
                    <p class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $stats['ativos'] }}</p>
                </div>
            </div>
        </div>

        <div class="p-4 bg-white dark:bg-gray-800 rounded-lg shadow-sm">
            <div class="flex items-center">
                <div class="p-3 bg-red-100 dark:bg-red-900 rounded-lg">
                    <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Inativos</p>
                    <p class="text-2xl font-bold text-red-600 dark:text-red-400">{{ $stats['inativos'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtros e Busca -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-4">
        <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
            <!-- Busca -->
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Buscar</label>
                <input
                    type="text"
                    wire:model.live.debounce.300ms="search"
                    placeholder="Buscar por razão social, CNPJ ou email..."
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-100"
                >
            </div>

            <!-- Filtro Status -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Status</label>
                <select
                    wire:model.live="filterAtivo"
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-100"
                >
                    <option value="all">Todos</option>
                    <option value="active">Apenas Ativos</option>
                    <option value="inactive">Apenas Inativos</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Tabela de Clientes -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="py-3 px-4 text-left">
                            <button wire:click="sortBy('id')" class="flex items-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase hover:text-gray-700 dark:hover:text-gray-200">
                                Contrato
                                @if($sort === 'id')
                                    <svg class="w-4 h-4 ml-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                @endif
                            </button>
                        </th>
                        <th class="py-3 px-4 text-left">
                            <button wire:click="sortBy('razaosocial')" class="flex items-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase hover:text-gray-700 dark:hover:text-gray-200">
                                Razão Social
                                @if($sort === 'razaosocial')
                                    <svg class="w-4 h-4 ml-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                @endif
                            </button>
                        </th>
                        <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">CNPJ</th>
                        <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Email</th>
                        <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Telefone</th>
                        <th class="py-3 px-4 text-left">
                            <button wire:click="sortBy('ativo')" class="flex items-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase hover:text-gray-700 dark:hover:text-gray-200">
                                Status
                                @if($sort === 'ativo')
                                    <svg class="w-4 h-4 ml-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                @endif
                            </button>
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($customers as $customer)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="py-3 px-4 text-gray-800 dark:text-gray-100 font-medium">
                                {{ $customer->id }}
                            </td>
                            <td class="py-3 px-4">
                                <div class="text-gray-800 dark:text-gray-100 font-medium">{{ $customer->razaosocial }}</div>
                                @if($customer->nomefantasia)
                                    <div class="text-xs text-gray-500 dark:text-gray-400">{{ $customer->nomefantasia }}</div>
                                @endif
                            </td>
                            <td class="py-3 px-4 text-gray-600 dark:text-gray-400">
                                {{ preg_replace('/^(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})$/', '$1.$2.$3/$4-$5', $customer->cnpj) }}
                            </td>
                            <td class="py-3 px-4 text-gray-600 dark:text-gray-400">
                                {{ $customer->email ?? '-' }}
                            </td>
                            <td class="py-3 px-4 text-gray-600 dark:text-gray-400">
                                {{ $customer->telefone ?? '-' }}
                            </td>
                            <td class="py-3 px-4">
                                @if($customer->ativo)
                                    <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                        Ativo
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                        Inativo
                                    </span>
                                @endif

                                @if($customer->bloqueio_entrada || $customer->bloqueio_saida)
                                    <span class="inline-flex items-center px-2 py-1 ml-1 rounded-md text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                                        Bloqueado
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-gray-500 dark:text-gray-400">
                                <svg class="w-12 h-12 mx-auto mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                </svg>
                                <p>Nenhum cliente encontrado</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Paginação -->
        @if($customers->hasPages())
            <div class="px-4 py-3 border-t border-gray-200 dark:border-gray-700">
                {{ $customers->links() }}
            </div>
        @endif
    </div>
</div>
