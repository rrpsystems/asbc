<div class="flex flex-col min-h-[calc(100vh-4rem)] pb-3 pl-6 pr-6 bg-white dark:bg-gray-600 border border-gray-300 dark:border-gray-100 rounded-md shadow-md shadow-black/5">
    <div x-init="$dispatch('bradcrumb', { menu: ['Clientes', '{{ $customer->nomefantasia ?? $customer->razaosocial }}', 'DIDs'] })"></div>

    <div class="container flex-grow mx-auto">
        <div class="flex flex-col items-center justify-between my-4 sm:flex-row">
            <div class="flex items-center gap-3 mb-4 sm:mb-0">
                <a href="{{ route('config.did') }}" class="p-2 text-gray-600 hover:text-gray-800 dark:text-gray-300 dark:hover:text-gray-100" title="Voltar">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>
                <h3 class="text-2xl font-bold text-gray-800 dark:text-gray-200">
                    Números DIDs do Cliente
                </h3>
            </div>
            <button wire:click="openCreate" class="px-4 py-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700">
                <svg class="inline-block w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Adicionar DID
            </button>
        </div>

        <!-- Info do Cliente -->
        <div class="p-4 mb-6 bg-blue-50 dark:bg-blue-900 border-l-4 border-blue-500 rounded">
            <p class="text-sm text-blue-700 dark:text-blue-300">
                <strong>Cliente:</strong> {{ $customer->nomefantasia ?? $customer->razaosocial }}
            </p>
        </div>

        <!-- Resumo -->
        @if($dids->isNotEmpty())
            <div class="grid grid-cols-1 gap-4 mb-6 md:grid-cols-2 lg:grid-cols-4">
                {{-- Total DIDs --}}
                <div class="relative overflow-hidden bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg shadow-lg">
                    <div class="p-5">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-purple-100">Total DIDs</p>
                                <p class="text-3xl font-bold text-white">{{ number_format($dids->count(), 0, ',', '.') }}</p>
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
                                <p class="text-3xl font-bold text-white">{{ number_format($dids->where('ativo', true)->count(), 0, ',', '.') }}</p>
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
                                <p class="text-3xl font-bold text-white">{{ number_format($dids->where('ativo', false)->count(), 0, ',', '.') }}</p>
                            </div>
                            <div class="p-3 bg-white bg-opacity-30 rounded-lg">
                                <x-ui-icon name="x-circle" class="w-8 h-8 text-white" />
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Custo Mensal Total --}}
                <div class="relative overflow-hidden bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg shadow-lg">
                    <div class="p-5">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-blue-100">Custo Mensal Total</p>
                                <p class="text-3xl font-bold text-white">R$ {{ number_format($dids->where('ativo', true)->sum('valor_mensal'), 2, ',', '.') }}</p>
                            </div>
                            <div class="p-3 bg-white bg-opacity-30 rounded-lg">
                                <x-ui-icon name="currency-dollar" class="w-8 h-8 text-white" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Tabela de DIDs -->
        <div class="p-6 bg-white dark:bg-gray-800 rounded-lg shadow-lg">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b-2 border-gray-300 dark:border-gray-600">
                            <th class="px-4 py-3 text-left text-gray-700 dark:text-gray-300">Status</th>
                            <th class="px-4 py-3 text-left text-gray-700 dark:text-gray-300">Número DID</th>
                            <th class="px-4 py-3 text-left text-gray-700 dark:text-gray-300">Operadora</th>
                            <th class="px-4 py-3 text-left text-gray-700 dark:text-gray-300">Descrição</th>
                            <th class="px-4 py-3 text-right text-gray-700 dark:text-gray-300">Valor Mensal</th>
                            <th class="px-4 py-3 text-center text-gray-700 dark:text-gray-300">Data Ativação</th>
                            <th class="px-4 py-3 text-center text-gray-700 dark:text-gray-300">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($dids as $didItem)
                            <tr class="border-b border-gray-100 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 {{ !$didItem->ativo ? 'opacity-50' : '' }}">
                                <td class="px-4 py-3">
                                    <span class="px-2 py-1 text-xs font-semibold rounded {{ $didItem->ativo ? 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100' : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300' }}">
                                        {{ $didItem->ativo ? 'Ativo' : 'Inativo' }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="font-medium text-gray-900 dark:text-gray-100">
                                        {{ preg_replace('/(\d{2})(\d{5})(\d{4})|(\d{2})(\d{4})(\d{4})/', '($1$4) $2$5-$3$6', $didItem->did) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center">
                                        @if($didItem->carrier)
                                            <span class="px-2 py-1 text-xs font-medium rounded bg-indigo-100 text-indigo-800 dark:bg-indigo-800 dark:text-indigo-100">
                                                {{ $didItem->carrier->operadora }}
                                            </span>
                                        @else
                                            <span class="text-xs text-gray-400">Sem operadora</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-gray-700 dark:text-gray-300">{{ $didItem->descricao ?: '-' }}</td>
                                <td class="px-4 py-3 text-right text-orange-600 dark:text-orange-400 font-semibold">
                                    R$ {{ number_format($didItem->valor_mensal ?? 0, 2, ',', '.') }}
                                </td>
                                <td class="px-4 py-3 text-center text-gray-700 dark:text-gray-300">
                                    {{ $didItem->data_ativacao ? $didItem->data_ativacao->format('d/m/Y') : '-' }}
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center justify-center gap-2">
                                        <button wire:click="edit({{ $didItem->id }})" class="p-1 text-blue-600 hover:text-blue-800 dark:text-blue-400" title="Editar">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </button>
                                        <button wire:click="toggleAtivo({{ $didItem->id }})" class="p-1 text-yellow-600 hover:text-yellow-800 dark:text-yellow-400" title="{{ $didItem->ativo ? 'Desativar' : 'Ativar' }}">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                            </svg>
                                        </button>
                                        <button wire:click="delete({{ $didItem->id }})" wire:confirm="Tem certeza que deseja remover este DID?" class="p-1 text-red-600 hover:text-red-800 dark:text-red-400" title="Excluir">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-12 text-center text-gray-500 dark:text-gray-400">
                                    <svg class="w-16 h-16 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path>
                                    </svg>
                                    <p class="text-lg">Nenhum DID cadastrado</p>
                                    <p class="mt-2 text-sm">Clique em "Adicionar DID" para começar</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Create -->
    <x-ui-modal title="Adicionar DID" size="2xl" wire="modalCreate" persistent>
        @include('livewire.dids.customer-form')

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
    <x-ui-modal title="Editar DID" size="2xl" wire="modalUpdate" persistent>
        @include('livewire.dids.customer-form')

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
