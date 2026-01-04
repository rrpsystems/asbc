<div class="flex flex-col min-h-[calc(100vh-4rem)] pb-3 pl-6 pr-6 bg-white dark:bg-gray-600 border border-gray-300 dark:border-gray-100 rounded-md shadow-md shadow-black/5">
    <div x-init="$dispatch('bradcrumb', { menu: ['Clientes', '{{ $customer->nomefantasia ?? $customer->razaosocial }}', 'Produtos'] })"></div>

    <div class="container flex-grow mx-auto">
        <div class="flex flex-col items-center justify-between my-4 sm:flex-row">
            <div class="flex items-center gap-3 mb-4 sm:mb-0">
                <a href="{{ route('customers.products.list') }}" class="p-2 text-gray-600 hover:text-gray-800 dark:text-gray-300 dark:hover:text-gray-100" title="Voltar">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>
                <h3 class="text-2xl font-bold text-gray-800 dark:text-gray-200">
                    Produtos e Serviços Recorrentes
                </h3>
            </div>
            <button wire:click="openCreate" class="px-4 py-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700">
                <svg class="inline-block w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Adicionar Produto
            </button>
        </div>

        <!-- Info do Cliente -->
        <div class="p-4 mb-6 bg-blue-50 dark:bg-blue-900 border-l-4 border-blue-500 rounded">
            <p class="text-sm text-blue-700 dark:text-blue-300">
                <strong>Cliente:</strong> {{ $customer->nomefantasia ?? $customer->razaosocial }}
            </p>
        </div>

        <!-- Resumo -->
        @if($produtos->isNotEmpty())
            <div class="grid grid-cols-1 gap-4 mb-6 md:grid-cols-4">
                <div class="p-4 bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900 dark:to-blue-800 rounded-lg shadow">
                    <p class="text-xs font-medium text-blue-600 dark:text-blue-300">Total Produtos Ativos</p>
                    <p class="text-2xl font-bold text-blue-700 dark:text-blue-200">
                        {{ $produtos->where('ativo', true)->count() }}
                    </p>
                </div>
                <div class="p-4 bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900 dark:to-green-800 rounded-lg shadow">
                    <p class="text-xs font-medium text-green-600 dark:text-green-300">Receita Mensal</p>
                    <p class="text-2xl font-bold text-green-700 dark:text-green-200">
                        R$ {{ number_format($produtos->where('ativo', true)->sum('receita_total'), 2, ',', '.') }}
                    </p>
                </div>
                <div class="p-4 bg-gradient-to-br from-orange-50 to-orange-100 dark:from-orange-900 dark:to-orange-800 rounded-lg shadow">
                    <p class="text-xs font-medium text-orange-600 dark:text-orange-300">Custo Mensal</p>
                    <p class="text-2xl font-bold text-orange-700 dark:text-orange-200">
                        R$ {{ number_format($produtos->where('ativo', true)->sum('custo_total'), 2, ',', '.') }}
                    </p>
                </div>
                <div class="p-4 bg-gradient-to-br from-purple-50 to-purple-100 dark:from-purple-900 dark:to-purple-800 rounded-lg shadow">
                    <p class="text-xs font-medium text-purple-600 dark:text-purple-300">Lucro Mensal</p>
                    <p class="text-2xl font-bold text-purple-700 dark:text-purple-200">
                        R$ {{ number_format($produtos->where('ativo', true)->sum('lucro'), 2, ',', '.') }}
                    </p>
                </div>
            </div>
        @endif

        <!-- Tabela de Produtos -->
        <div class="p-6 bg-white dark:bg-gray-800 rounded-lg shadow-lg">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b-2 border-gray-300 dark:border-gray-600">
                            <th class="px-4 py-3 text-left text-gray-700 dark:text-gray-300">Status</th>
                            <th class="px-4 py-3 text-left text-gray-700 dark:text-gray-300">Produto</th>
                            <th class="px-4 py-3 text-left text-gray-700 dark:text-gray-300">Descrição</th>
                            <th class="px-4 py-3 text-right text-gray-700 dark:text-gray-300">Qtd</th>
                            <th class="px-4 py-3 text-right text-gray-700 dark:text-gray-300">Custo Unit.</th>
                            <th class="px-4 py-3 text-right text-gray-700 dark:text-gray-300">Venda Unit.</th>
                            <th class="px-4 py-3 text-right text-gray-700 dark:text-gray-300">Receita Total</th>
                            <th class="px-4 py-3 text-right text-gray-700 dark:text-gray-300">Lucro</th>
                            <th class="px-4 py-3 text-center text-gray-700 dark:text-gray-300">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($produtos as $produto)
                            <tr class="border-b border-gray-100 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 {{ !$produto->ativo ? 'opacity-50' : '' }}">
                                <td class="px-4 py-3">
                                    <span class="px-2 py-1 text-xs font-semibold rounded {{ $produto->ativo ? 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100' : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300' }}">
                                        {{ $produto->ativo ? 'Ativo' : 'Inativo' }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center">
                                        <x-ui-icon :name="$produto->tipo_produto->icon()" class="w-5 h-5 mr-2 text-blue-600 dark:text-blue-400" />
                                        <span class="font-medium text-gray-900 dark:text-gray-100">{{ $produto->tipo_produto->label() }}</span>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-gray-700 dark:text-gray-300">{{ $produto->descricao ?: '-' }}</td>
                                <td class="px-4 py-3 text-right text-gray-700 dark:text-gray-300">{{ $produto->quantidade }}</td>
                                <td class="px-4 py-3 text-right text-orange-600 dark:text-orange-400">R$ {{ number_format($produto->valor_custo_unitario, 2, ',', '.') }}</td>
                                <td class="px-4 py-3 text-right text-blue-600 dark:text-blue-400">R$ {{ number_format($produto->valor_venda_unitario, 2, ',', '.') }}</td>
                                <td class="px-4 py-3 text-right font-semibold text-green-600 dark:text-green-400">R$ {{ number_format($produto->receita_total, 2, ',', '.') }}</td>
                                <td class="px-4 py-3 text-right font-semibold {{ $produto->lucro >= 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                    R$ {{ number_format($produto->lucro, 2, ',', '.') }}
                                    <div class="text-xs text-gray-500">{{ number_format($produto->margem, 1) }}%</div>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center justify-center gap-2">
                                        <button wire:click="edit({{ $produto->id }})" class="p-1 text-blue-600 hover:text-blue-800 dark:text-blue-400" title="Editar">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </button>
                                        <button wire:click="toggleAtivo({{ $produto->id }})" class="p-1 text-yellow-600 hover:text-yellow-800 dark:text-yellow-400" title="{{ $produto->ativo ? 'Desativar' : 'Ativar' }}">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                            </svg>
                                        </button>
                                        <button wire:click="delete({{ $produto->id }})" wire:confirm="Tem certeza que deseja remover este produto?" class="p-1 text-red-600 hover:text-red-800 dark:text-red-400" title="Excluir">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="px-4 py-12 text-center text-gray-500 dark:text-gray-400">
                                    <svg class="w-16 h-16 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                    </svg>
                                    <p class="text-lg">Nenhum produto cadastrado</p>
                                    <p class="mt-2 text-sm">Clique em "Adicionar Produto" para começar</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Create -->
    <x-ui-modal title="Adicionar Produto" size="2xl" wire="modalCreate" persistent>
        @include('livewire.customers.products.form')

        <x-slot:footer>
            <div class="flex justify-end gap-3">
                <button wire:click="$set('modalCreate', false)" class="px-4 py-2 text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 dark:bg-gray-700 dark:text-gray-300">
                    Cancelar
                </button>
                <button wire:click="create" class="px-4 py-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700">
                    Salvar
                </button>
            </div>
        </x-slot:footer>
    </x-ui-modal>

    <!-- Modal Update -->
    <x-ui-modal title="Editar Produto" size="2xl" wire="modalUpdate" persistent>
        @include('livewire.customers.products.form')

        <x-slot:footer>
            <div class="flex justify-end gap-3">
                <button wire:click="$set('modalUpdate', false)" class="px-4 py-2 text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 dark:bg-gray-700 dark:text-gray-300">
                    Cancelar
                </button>
                <button wire:click="update" class="px-4 py-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700">
                    Atualizar
                </button>
            </div>
        </x-slot:footer>
    </x-ui-modal>
</div>
