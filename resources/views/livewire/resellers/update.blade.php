<div class="flex flex-col min-h-[calc(100vh-4rem)] pb-3 pl-6 pr-6 bg-white dark:bg-gray-600 border border-gray-300 dark:border-gray-100 rounded-md shadow-md shadow-black/5">
    <div x-init="$dispatch('bradcrumb', { menu: ['Configurações', 'Revendas', 'Editar Revenda'] })"></div>

    <div class="container flex-grow mx-auto">
        <!-- Header -->
        <div class="flex items-center justify-between my-4">
            <h3 class="text-2xl font-bold text-gray-800 dark:text-gray-200">
                Editar Revenda: {{ $reseller->nome }}
            </h3>
            <a href="{{ route('config.reseller') }}" class="px-4 py-2 text-white bg-gray-600 rounded-lg hover:bg-gray-700">
                <svg class="inline-block w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Voltar
            </a>
        </div>

        <!-- Estatísticas da Revenda -->
        <div class="grid grid-cols-1 gap-4 mb-6 md:grid-cols-3">
            <div class="p-4 bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900 dark:to-blue-800 rounded-lg shadow">
                <p class="text-xs font-medium text-blue-600 dark:text-blue-300">Total de Clientes</p>
                <p class="text-2xl font-bold text-blue-700 dark:text-blue-200">{{ $reseller->customers->count() }}</p>
            </div>
            <div class="p-4 bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900 dark:to-green-800 rounded-lg shadow">
                <p class="text-xs font-medium text-green-600 dark:text-green-300">Clientes Ativos</p>
                <p class="text-2xl font-bold text-green-700 dark:text-green-200">{{ $reseller->customers->where('ativo', true)->count() }}</p>
            </div>
            <div class="p-4 bg-gradient-to-br from-purple-50 to-purple-100 dark:from-purple-900 dark:to-purple-800 rounded-lg shadow">
                <p class="text-xs font-medium text-purple-600 dark:text-purple-300">Status</p>
                <p class="text-2xl font-bold text-purple-700 dark:text-purple-200">{{ $reseller->ativo ? 'Ativa' : 'Inativa' }}</p>
            </div>
        </div>

        <!-- Formulário -->
        <form wire:submit.prevent="update">
            <div class="p-6 space-y-6 bg-white dark:bg-gray-800 rounded-lg shadow-lg">

                <!-- Informações Básicas -->
                <div class="border-b border-gray-200 dark:border-gray-700 pb-4">
                    <h4 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-4">Informações Básicas</h4>

                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Nome <span class="text-red-500">*</span>
                            </label>
                            <x-ui-input wire:model="nome" placeholder="Nome da revenda" />
                            @error('nome') <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Razão Social
                            </label>
                            <x-ui-input wire:model="razao_social" placeholder="Razão social completa" />
                            @error('razao_social') <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                CNPJ
                            </label>
                            <x-ui-input wire:model="cnpj" placeholder="00.000.000/0000-00" />
                            @error('cnpj') <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                E-mail <span class="text-red-500">*</span>
                            </label>
                            <x-ui-input wire:model="email" type="email" placeholder="contato@revenda.com.br" />
                            @error('email') <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Telefone
                            </label>
                            <x-ui-input wire:model="telefone" placeholder="(00) 00000-0000" />
                            @error('telefone') <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <!-- Endereço -->
                <div class="border-b border-gray-200 dark:border-gray-700 pb-4">
                    <h4 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-4">Endereço</h4>

                    <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Logradouro</label>
                            <x-ui-input wire:model="endereco" placeholder="Rua, Avenida, etc." />
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Número</label>
                            <x-ui-input wire:model="numero" placeholder="123" />
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Complemento</label>
                            <x-ui-input wire:model="complemento" placeholder="Sala, Andar, etc." />
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Cidade</label>
                            <x-ui-input wire:model="cidade" placeholder="Cidade" />
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">UF</label>
                            <x-ui-input wire:model="uf" placeholder="SP" maxlength="2" />
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">CEP</label>
                            <x-ui-input wire:model="cep" placeholder="00000-000" />
                        </div>
                    </div>
                </div>

                <!-- Markups Percentuais -->
                <div class="border-b border-gray-200 dark:border-gray-700 pb-4">
                    <h4 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-2">Markups Percentuais</h4>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Percentual a ser aplicado sobre o valor de venda</p>

                    <div class="grid grid-cols-1 gap-4 md:grid-cols-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Chamadas (%) <span class="text-red-500">*</span>
                            </label>
                            <x-ui-input wire:model="markup_chamadas" type="number" step="0.01" min="0" max="100" placeholder="0.00" />
                            @error('markup_chamadas') <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Produtos (%) <span class="text-red-500">*</span>
                            </label>
                            <x-ui-input wire:model="markup_produtos" type="number" step="0.01" min="0" max="100" placeholder="0.00" />
                            @error('markup_produtos') <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Planos (%) <span class="text-red-500">*</span>
                            </label>
                            <x-ui-input wire:model="markup_planos" type="number" step="0.01" min="0" max="100" placeholder="0.00" />
                            @error('markup_planos') <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                DIDs (%) <span class="text-red-500">*</span>
                            </label>
                            <x-ui-input wire:model="markup_dids" type="number" step="0.01" min="0" max="100" placeholder="0.00" />
                            @error('markup_dids') <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <!-- Valores Fixos (Opcional) -->
                <div class="border-b border-gray-200 dark:border-gray-700 pb-4">
                    <h4 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-2">Valores Fixos (Opcional)</h4>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Se preenchido, sobrescreve o markup percentual</p>

                    <div class="grid grid-cols-1 gap-4 md:grid-cols-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Valor Fixo Chamada (R$/min)
                            </label>
                            <x-ui-input wire:model="valor_fixo_chamada" type="number" step="0.0001" min="0" placeholder="0.0000" />
                            @error('valor_fixo_chamada') <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Valor Fixo Produto (R$)
                            </label>
                            <x-ui-input wire:model="valor_fixo_produto" type="number" step="0.01" min="0" placeholder="0.00" />
                            @error('valor_fixo_produto') <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Valor Fixo Plano (R$)
                            </label>
                            <x-ui-input wire:model="valor_fixo_plano" type="number" step="0.01" min="0" placeholder="0.00" />
                            @error('valor_fixo_plano') <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Valor Fixo DID (R$)
                            </label>
                            <x-ui-input wire:model="valor_fixo_did" type="number" step="0.01" min="0" placeholder="0.00" />
                            @error('valor_fixo_did') <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <!-- Observações e Status -->
                <div>
                    <h4 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-4">Controle</h4>

                    <div class="grid grid-cols-1 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Observações
                            </label>
                            <textarea
                                wire:model="observacoes"
                                rows="3"
                                class="w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 px-3 py-2 text-sm"
                                placeholder="Informações adicionais sobre a revenda..."
                            ></textarea>
                        </div>

                        <div class="flex items-center">
                            <label class="flex items-center cursor-pointer">
                                <input type="checkbox" wire:model="ativo" class="mr-2 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Revenda ativa</span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Botões -->
                <div class="flex justify-end gap-3 pt-4 border-t border-gray-200 dark:border-gray-700">
                    <a href="{{ route('config.reseller') }}" class="px-4 py-2 text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600">
                        Cancelar
                    </a>
                    <button type="submit" class="px-4 py-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700">
                        <svg class="inline-block w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Atualizar Revenda
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
