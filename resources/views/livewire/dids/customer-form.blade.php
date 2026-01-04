<div class="space-y-4">
    <!-- Grid para Número DID e Quantidade/Valor -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <!-- Número DID -->
        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                Número DID {{ $editingDidId ? '' : 'Inicial' }} <span class="text-red-500">*</span>
            </label>
            <input type="text" wire:model.live="did"
                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200"
                   placeholder="Ex: 1140001234" maxlength="10">
            @error('did') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
            @if(!$editingDidId)
                <p class="mt-1 text-xs text-gray-500">Informe o primeiro número. Os próximos serão criados sequencialmente.</p>
            @endif
        </div>

        <!-- Quantidade (apenas no create) -->
        @if(!$editingDidId)
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                Quantidade <span class="text-red-500">*</span>
            </label>
            <input type="number" wire:model="quantidade" min="1" max="30"
                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200"
                   placeholder="1">
            @error('quantidade') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
            <p class="mt-1 text-xs text-gray-500">Máximo 30 DIDs por vez</p>
        </div>
        @endif

        <!-- Valor Mensal -->
        <div class="{{ !$editingDidId ? '' : 'md:col-span-2' }}">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                Valor Mensal
            </label>
            <div class="relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500">R$</span>
                <input type="number" wire:model="valor_mensal" step="0.01" min="0"
                       class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200"
                       placeholder="0,00">
            </div>
            @error('valor_mensal') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
        </div>
    </div>

    <!-- Operadora -->
    <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
            Operadora <span class="text-red-500">*</span>
        </label>
        <select wire:model="carrier_id"
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
            <option value="">Selecione uma operadora</option>
            @foreach($carriers as $carrier)
                <option value="{{ $carrier->id }}">{{ $carrier->operadora }}</option>
            @endforeach
        </select>
        @error('carrier_id') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
    </div>

    <!-- Descrição -->
    <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
            Descrição
        </label>
        <input type="text" wire:model="descricao"
               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200"
               placeholder="Ex: Linha principal, Suporte, etc">
        @error('descricao') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
    </div>

    <!-- Separador de Configurações SBC -->
    <div class="relative flex items-center justify-center py-2">
        <div class="flex items-center w-full">
            <div class="flex-grow border-t border-gray-300 dark:border-gray-600"></div>
            <span class="mx-4 text-sm text-gray-500 dark:text-gray-400">🌐 Configurações SBC</span>
            <div class="flex-grow border-t border-gray-300 dark:border-gray-600"></div>
        </div>
    </div>

    <!-- Aviso sobre herança do cliente -->
    @if($customer)
        <div class="p-3 text-sm rounded-lg bg-blue-50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-300">
            <strong>💡 Configuração Ativa:</strong><br>
            @if($proxy || $porta)
                <span class="text-green-700 dark:text-green-400">✓ Este DID usa configuração específica</span>
            @else
                @if($customer->proxy_padrao && $customer->porta_padrao)
                    <span>Este DID herdará as configurações do cliente:</span><br>
                    <strong>Proxy:</strong> {{ $customer->proxy_padrao }}<br>
                    <strong>Porta:</strong> {{ $customer->porta_padrao }}
                @else
                    <span class="text-orange-600 dark:text-orange-400">⚠️ Cliente não possui configurações padrão. Configure abaixo:</span>
                @endif
            @endif
        </div>
    @endif

    <!-- Campos de Proxy e Porta -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                Proxy (Endereço SBC)
                @if(!$customer || !$customer->proxy_padrao)
                    <span class="text-red-500">*</span>
                @endif
            </label>
            <input type="text" wire:model.live="proxy"
                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200"
                   placeholder="Ex: sbc.exemplo.com.br">
            @error('proxy') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
            @if($customer && $customer->proxy_padrao)
                <p class="mt-1 text-xs text-gray-500">Deixe vazio para herdar: {{ $customer->proxy_padrao }}</p>
            @endif
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                Porta
                @if(!$customer || !$customer->porta_padrao)
                    <span class="text-red-500">*</span>
                @endif
            </label>
            <input type="number" wire:model.live="porta" min="1" max="65535"
                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200"
                   placeholder="5060">
            @error('porta') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
            @if($customer && $customer->porta_padrao)
                <p class="mt-1 text-xs text-gray-500">Deixe vazio para herdar: {{ $customer->porta_padrao }}</p>
            @endif
        </div>
    </div>

    <!-- Preview do Dial String -->
    @php
        $didLimpo = preg_replace('/\D/', '', $did ?? '');
        $proxyAtivo = $proxy ?? ($customer?->proxy_padrao ?? '');
        $portaAtiva = $porta ?? ($customer?->porta_padrao ?? '');
        $dialString = 'SIP:' . $didLimpo . '@' . $proxyAtivo . ':' . $portaAtiva;
    @endphp
    <div class="p-3 bg-gray-50 dark:bg-gray-700 rounded-lg border border-gray-200 dark:border-gray-600">
        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Instrução de Encaminhamento:</p>
        <code class="text-sm font-mono text-blue-600 dark:text-blue-400">
            {{ $dialString }}
        </code>
    </div>

    <!-- Data de Ativação e Status lado a lado -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <!-- Data de Ativação -->
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                Data de Ativação
            </label>
            <input type="date" wire:model="data_ativacao"
                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
            @error('data_ativacao') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
        </div>

        <!-- Status Ativo -->
        <div class="flex items-end pb-2">
            <x-ui-toggle label="DID Ativo" wire:model="ativo" />
        </div>
    </div>
</div>
