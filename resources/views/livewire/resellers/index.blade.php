<div class="flex flex-col min-h-[calc(100vh-4rem)] pb-3 pl-6 pr-6 bg-white dark:bg-gray-600 border border-gray-300 dark:border-gray-100 rounded-md shadow-md shadow-black/5">
    <div x-init="$dispatch('bradcrumb', { menu: ['Configurações', 'Revendas'] })"></div>

    <div class="container flex-grow mx-auto">
        <!-- Header -->
        <div class="flex flex-col items-center justify-between my-4 sm:flex-row">
            <h3 class="mb-4 text-2xl font-bold text-gray-800 dark:text-gray-200 sm:mb-0">
                Gestão de Revendas
            </h3>
            <a href="{{ route('config.reseller.create') }}" class="px-4 py-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700">
                <svg class="inline-block w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Nova Revenda
            </a>
        </div>

        <!-- Estatísticas -->
        <div class="grid grid-cols-1 gap-4 mb-6 md:grid-cols-4">
            <div class="p-4 bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900 dark:to-blue-800 rounded-lg shadow">
                <p class="text-xs font-medium text-blue-600 dark:text-blue-300">Total de Revendas</p>
                <p class="text-2xl font-bold text-blue-700 dark:text-blue-200">{{ $stats['total'] }}</p>
            </div>
            <div class="p-4 bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900 dark:to-green-800 rounded-lg shadow">
                <p class="text-xs font-medium text-green-600 dark:text-green-300">Revendas Ativas</p>
                <p class="text-2xl font-bold text-green-700 dark:text-green-200">{{ $stats['ativos'] }}</p>
            </div>
            <div class="p-4 bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 rounded-lg shadow">
                <p class="text-xs font-medium text-gray-600 dark:text-gray-300">Revendas Inativas</p>
                <p class="text-2xl font-bold text-gray-700 dark:text-gray-200">{{ $stats['inativos'] }}</p>
            </div>
            <div class="p-4 bg-gradient-to-br from-purple-50 to-purple-100 dark:from-purple-900 dark:to-purple-800 rounded-lg shadow">
                <p class="text-xs font-medium text-purple-600 dark:text-purple-300">Total de Clientes</p>
                <p class="text-2xl font-bold text-purple-700 dark:text-purple-200">{{ $stats['total_clientes'] }}</p>
            </div>
        </div>

        <!-- Filtros -->
        <div class="flex flex-col gap-4 p-4 mb-6 bg-white dark:bg-gray-800 rounded-lg shadow sm:flex-row">
            <div class="flex-1">
                <x-ui-input
                    wire:model.live="search"
                    placeholder="Buscar por nome, e-mail, CNPJ..."
                    icon="magnifying-glass"
                />
            </div>
            <div class="w-full sm:w-48">
                <select wire:model.live="filterAtivo" class="w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-sm px-3 py-2">
                    <option value="all">Todos os Status</option>
                    <option value="ativo">Apenas Ativos</option>
                    <option value="inativo">Apenas Inativos</option>
                </select>
            </div>
        </div>

        <!-- Tabela -->
        <div class="p-6 bg-white dark:bg-gray-800 rounded-lg shadow-lg">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b-2 border-gray-300 dark:border-gray-600">
                            <th class="px-4 py-3 text-left text-gray-700 dark:text-gray-300">Status</th>
                            <th class="px-4 py-3 text-left text-gray-700 dark:text-gray-300">Revenda</th>
                            <th class="px-4 py-3 text-left text-gray-700 dark:text-gray-300">Contato</th>
                            <th class="px-4 py-3 text-center text-gray-700 dark:text-gray-300">Clientes</th>
                            <th class="px-4 py-3 text-center text-gray-700 dark:text-gray-300">Markups</th>
                            <th class="px-4 py-3 text-center text-gray-700 dark:text-gray-300">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($resellers as $reseller)
                            <tr class="border-b border-gray-100 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 {{ !$reseller->ativo ? 'opacity-50' : '' }}">
                                <!-- Status -->
                                <td class="px-4 py-3">
                                    <span class="px-2 py-1 text-xs font-semibold rounded {{ $reseller->ativo ? 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100' : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300' }}">
                                        {{ $reseller->ativo ? 'Ativo' : 'Inativo' }}
                                    </span>
                                </td>

                                <!-- Revenda -->
                                <td class="px-4 py-3">
                                    <div>
                                        <p class="font-medium text-gray-900 dark:text-gray-100">{{ $reseller->nome }}</p>
                                        @if($reseller->razao_social)
                                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $reseller->razao_social }}</p>
                                        @endif
                                        @if($reseller->cnpj)
                                            <p class="text-xs text-gray-500 dark:text-gray-400">CNPJ: {{ $reseller->cnpj }}</p>
                                        @endif
                                    </div>
                                </td>

                                <!-- Contato -->
                                <td class="px-4 py-3">
                                    <p class="text-sm text-gray-700 dark:text-gray-300">{{ $reseller->email }}</p>
                                    @if($reseller->telefone)
                                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $reseller->telefone }}</p>
                                    @endif
                                </td>

                                <!-- Clientes -->
                                <td class="px-4 py-3 text-center">
                                    <div class="text-sm">
                                        <span class="font-semibold text-blue-600 dark:text-blue-400">{{ $reseller->active_customers_count }}</span>
                                        <span class="text-gray-500 dark:text-gray-400">/ {{ $reseller->customers_count }}</span>
                                    </div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">ativos / total</p>
                                </td>

                                <!-- Markups -->
                                <td class="px-4 py-3">
                                    <div class="text-xs space-y-1">
                                        <div class="flex justify-between">
                                            <span class="text-gray-600 dark:text-gray-400">Chamadas:</span>
                                            <span class="font-semibold text-blue-600 dark:text-blue-400">{{ number_format($reseller->markup_chamadas, 1) }}%</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-600 dark:text-gray-400">Produtos:</span>
                                            <span class="font-semibold text-green-600 dark:text-green-400">{{ number_format($reseller->markup_produtos, 1) }}%</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-600 dark:text-gray-400">Planos:</span>
                                            <span class="font-semibold text-purple-600 dark:text-purple-400">{{ number_format($reseller->markup_planos, 1) }}%</span>
                                        </div>
                                    </div>
                                </td>

                                <!-- Ações -->
                                <td class="px-4 py-3">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('config.reseller.update', $reseller->id) }}" class="p-1 text-blue-600 hover:text-blue-800 dark:text-blue-400" title="Editar">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </a>
                                        <button wire:click="toggleAtivo({{ $reseller->id }})" class="p-1 text-yellow-600 hover:text-yellow-800 dark:text-yellow-400" title="{{ $reseller->ativo ? 'Desativar' : 'Ativar' }}">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                            </svg>
                                        </button>
                                        <button wire:click="delete({{ $reseller->id }})" wire:confirm="Tem certeza que deseja excluir esta revenda?" class="p-1 text-red-600 hover:text-red-800 dark:text-red-400" title="Excluir">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-12 text-center text-gray-500 dark:text-gray-400">
                                    <svg class="w-16 h-16 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                    </svg>
                                    <p class="text-lg">Nenhuma revenda encontrada</p>
                                    <p class="mt-2 text-sm">Clique em "Nova Revenda" para começar</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Paginação -->
            <div class="mt-4">
                {{ $resellers->links() }}
            </div>
        </div>
    </div>
</div>
