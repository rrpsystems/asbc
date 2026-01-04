<div class="p-6">
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Configurações de Markup</h2>
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            Configure os percentuais e valores que serão aplicados sobre seus produtos e serviços
        </p>
    </div>

    <!-- Info da Revenda -->
    <div class="mb-6 p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg">
        <div class="flex items-start">
            <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
            </svg>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-blue-800 dark:text-blue-300">{{ $reseller->nome }}</h3>
                <div class="mt-2 text-sm text-blue-700 dark:text-blue-400">
                    <p><strong>Importante:</strong> As alterações nos markups serão aplicadas apenas para novas chamadas e faturas. Valores já processados não serão alterados.</p>
                </div>
            </div>
        </div>
    </div>

    <form wire:submit.prevent="save">
        <div class="grid grid-cols-1 gap-6">

            <!-- Markups Percentuais -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Markups Percentuais</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                    Percentual a ser aplicado sobre o valor base de cada serviço
                </p>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <!-- Chamadas -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Chamadas (%)
                            <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input
                                type="number"
                                wire:model="markup_chamadas"
                                step="0.01"
                                min="0"
                                max="1000"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-100"
                                placeholder="0.00"
                            >
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <span class="text-gray-500 dark:text-gray-400">%</span>
                            </div>
                        </div>
                        @error('markup_chamadas')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                        @if($markup_chamadas > 0)
                            <p class="mt-1 text-xs text-green-600 dark:text-green-400">
                                Exemplo: R$ 0,10 → R$ {{ number_format(0.10 * (1 + $markup_chamadas/100), 4, ',', '.') }}
                            </p>
                        @endif
                    </div>

                    <!-- Produtos -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Produtos (%)
                            <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input
                                type="number"
                                wire:model="markup_produtos"
                                step="0.01"
                                min="0"
                                max="1000"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-100"
                                placeholder="0.00"
                            >
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <span class="text-gray-500 dark:text-gray-400">%</span>
                            </div>
                        </div>
                        @error('markup_produtos')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                        @if($markup_produtos > 0)
                            <p class="mt-1 text-xs text-green-600 dark:text-green-400">
                                Exemplo: R$ 50,00 → R$ {{ number_format(50 * (1 + $markup_produtos/100), 2, ',', '.') }}
                            </p>
                        @endif
                    </div>

                    <!-- Planos -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Planos (%)
                            <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input
                                type="number"
                                wire:model="markup_planos"
                                step="0.01"
                                min="0"
                                max="1000"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-100"
                                placeholder="0.00"
                            >
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <span class="text-gray-500 dark:text-gray-400">%</span>
                            </div>
                        </div>
                        @error('markup_planos')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                        @if($markup_planos > 0)
                            <p class="mt-1 text-xs text-green-600 dark:text-green-400">
                                Exemplo: R$ 100,00 → R$ {{ number_format(100 * (1 + $markup_planos/100), 2, ',', '.') }}
                            </p>
                        @endif
                    </div>

                    <!-- DIDs -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            DIDs (%)
                            <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input
                                type="number"
                                wire:model="markup_dids"
                                step="0.01"
                                min="0"
                                max="1000"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-100"
                                placeholder="0.00"
                            >
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <span class="text-gray-500 dark:text-gray-400">%</span>
                            </div>
                        </div>
                        @error('markup_dids')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                        @if($markup_dids > 0)
                            <p class="mt-1 text-xs text-green-600 dark:text-green-400">
                                Exemplo: R$ 15,00 → R$ {{ number_format(15 * (1 + $markup_dids/100), 2, ',', '.') }}
                            </p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Valores Fixos (Opcional) -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Valores Fixos (Opcional)</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                    Se preenchido, ignora o markup percentual e aplica o valor fixo configurado
                </p>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <!-- Chamadas -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Chamadas (R$ por minuto)
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <span class="text-gray-500 dark:text-gray-400">R$</span>
                            </div>
                            <input
                                type="number"
                                wire:model="valor_fixo_chamadas"
                                step="0.0001"
                                min="0"
                                class="w-full pl-10 pr-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-100"
                                placeholder="0.0000"
                            >
                        </div>
                        @error('valor_fixo_chamadas')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Produtos -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Produtos (R$)
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <span class="text-gray-500 dark:text-gray-400">R$</span>
                            </div>
                            <input
                                type="number"
                                wire:model="valor_fixo_produtos"
                                step="0.01"
                                min="0"
                                class="w-full pl-10 pr-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-100"
                                placeholder="0.00"
                            >
                        </div>
                        @error('valor_fixo_produtos')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Planos -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Planos (R$)
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <span class="text-gray-500 dark:text-gray-400">R$</span>
                            </div>
                            <input
                                type="number"
                                wire:model="valor_fixo_planos"
                                step="0.01"
                                min="0"
                                class="w-full pl-10 pr-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-100"
                                placeholder="0.00"
                            >
                        </div>
                        @error('valor_fixo_planos')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- DIDs -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            DIDs (R$)
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <span class="text-gray-500 dark:text-gray-400">R$</span>
                            </div>
                            <input
                                type="number"
                                wire:model="valor_fixo_dids"
                                step="0.01"
                                min="0"
                                class="w-full pl-10 pr-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-100"
                                placeholder="0.00"
                            >
                        </div>
                        @error('valor_fixo_dids')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-4 p-3 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg">
                    <p class="text-xs text-yellow-800 dark:text-yellow-300">
                        <strong>Atenção:</strong> Se o valor fixo estiver preenchido, ele terá prioridade sobre o markup percentual.
                    </p>
                </div>
            </div>

            <!-- Botões de Ação -->
            <div class="flex justify-end space-x-3">
                <button
                    type="button"
                    wire:click="mount"
                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-600"
                >
                    Cancelar
                </button>
                <button
                    type="submit"
                    class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700"
                >
                    Salvar Configurações
                </button>
            </div>
        </div>
    </form>
</div>
