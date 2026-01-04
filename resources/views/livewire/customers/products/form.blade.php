<div class="space-y-4">
    <!-- Tipo de Produto -->
    <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Tipo de Produto *</label>
        <select wire:model="tipo_produto" class="w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-cyan-500">
            <option value="">Selecione o tipo de produto</option>
            @foreach($tiposProduto as $tipo)
                <option value="{{ $tipo['value'] }}">{{ $tipo['label'] }}</option>
            @endforeach
        </select>
        @error('tipo_produto') <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span> @enderror
    </div>

    <!-- Descrição -->
    <div>
        <x-ui-input
            label="Descrição"
            wire:model="descricao"
            placeholder="Ex: PABX Cloud - Plano Premium"
            hint="Informação adicional sobre o produto"
        />
    </div>

    <!-- Quantidade e Status -->
    <div class="grid grid-cols-2 gap-4">
        <div>
            <x-ui-number
                label="Quantidade *"
                wire:model="quantidade"
                min="1"
            />
            @error('quantidade') <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span> @enderror
        </div>
        <div class="flex items-center pt-6">
            <x-ui-toggle
                label="Ativo"
                wire:model="ativo"
                lg
            />
        </div>
    </div>

    <!-- Valores -->
    <div class="grid grid-cols-2 gap-4">
        <div>
            <x-ui-input
                label="Valor Custo Unitário (R$) *"
                wire:model="valor_custo_unitario"
                placeholder="0,00"
                hint="Quanto você paga por unidade"
                type="number"
                step="0.01"
            >
                <x-slot:prefix>
                    <x-ui-icon name="currency-dollar" class="w-5 h-5 text-gray-400" />
                </x-slot:prefix>
            </x-ui-input>
            @error('valor_custo_unitario') <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span> @enderror
        </div>
        <div>
            <x-ui-input
                label="Valor Venda Unitário (R$) *"
                wire:model="valor_venda_unitario"
                placeholder="0,00"
                hint="Quanto cobra do cliente"
                type="number"
                step="0.01"
            >
                <x-slot:prefix>
                    <x-ui-icon name="currency-dollar" class="w-5 h-5 text-gray-400" />
                </x-slot:prefix>
            </x-ui-input>
            @error('valor_venda_unitario') <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span> @enderror
        </div>
    </div>

    <!-- Resumo de Valores -->
    @if($quantidade > 0 && ($valor_custo_unitario > 0 || $valor_venda_unitario > 0))
        <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
            <h4 class="mb-2 text-sm font-semibold text-gray-700 dark:text-gray-300">Resumo Mensal</h4>
            <div class="grid grid-cols-3 gap-4 text-sm">
                <div>
                    <p class="text-gray-600 dark:text-gray-400">Custo Total</p>
                    <p class="font-bold text-orange-600 dark:text-orange-400">
                        R$ {{ number_format($quantidade * $valor_custo_unitario, 2, ',', '.') }}
                    </p>
                </div>
                <div>
                    <p class="text-gray-600 dark:text-gray-400">Receita Total</p>
                    <p class="font-bold text-green-600 dark:text-green-400">
                        R$ {{ number_format($quantidade * $valor_venda_unitario, 2, ',', '.') }}
                    </p>
                </div>
                <div>
                    <p class="text-gray-600 dark:text-gray-400">Lucro</p>
                    <p class="font-bold {{ ($quantidade * $valor_venda_unitario) - ($quantidade * $valor_custo_unitario) >= 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                        R$ {{ number_format(($quantidade * $valor_venda_unitario) - ($quantidade * $valor_custo_unitario), 2, ',', '.') }}
                    </p>
                </div>
            </div>
        </div>
    @endif

    <!-- Data de Ativação -->
    <div>
        <x-ui-input
            label="Data de Ativação"
            wire:model="data_ativacao"
            type="date"
        />
    </div>
</div>
